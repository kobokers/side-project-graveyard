<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    public function createCheckout(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'type' => 'required|in:listing_fee,featured_upgrade,project_purchase',
            'offer_id' => 'required_if:type,project_purchase|exists:offers,id',
        ]);

        $project = Project::findOrFail($request->project_id);
        
        // Additional validation for project purchase
        if ($request->type === 'project_purchase') {
            $offer = \App\Models\Offer::findOrFail($request->offer_id);
            if ($offer->status !== 'accepted') {
                abort(400, 'Offer must be accepted to proceed with payment.');
            }
            if ($offer->buyer_id !== auth()->id()) {
                abort(403, 'You are not the buyer for this offer.');
            }
        }
        
        // TEST MODE: Auto-approve if Stripe keys not configured
        if (empty(config('services.stripe.secret')) || config('services.stripe.secret') === 'sk_test_your_secret_key_here') {
            // Simulate successful payment
            if ($request->type === 'listing_fee') {
                $project->update(['status' => 'active']);
                
                // Create dummy transaction
                Transaction::create([
                    'user_id' => auth()->id(),
                    'project_id' => $project->id,
                    'amount' => 1000, // $10
                    'type' => 'listing_fee',
                    'stripe_payment_id' => 'test_pi_' . uniqid(),
                    'stripe_session_id' => 'test_cs_' . uniqid(),
                ]);
                
                return redirect()->route('payments.success')
                    ->with('success', 'Payment approved (TEST MODE) - Your project is now live!');
            } elseif ($request->type === 'featured_upgrade') {
                $project->update([
                    'is_featured' => true,
                    'featured_until' => now()->addDays(30)
                ]);
                
                Transaction::create([
                    'user_id' => auth()->id(),
                    'project_id' => $project->id,
                    'amount' => 2500, // $25
                    'type' => 'featured_upgrade',
                    'stripe_payment_id' => 'test_pi_' . uniqid(),
                    'stripe_session_id' => 'test_cs_' . uniqid(),
                ]);
                
                return redirect()->route('payments.success')
                    ->with('success', 'Payment approved (TEST MODE) - Your project is now featured!');
            } elseif ($request->type === 'project_purchase') {
                // Mark project as sold
                $project->update(['status' => 'sold']);
                
                // Mark offer as paid
                $offer->update(['status' => 'paid']);
                
                Transaction::create([
                    'user_id' => auth()->id(),
                    'project_id' => $project->id,
                    'amount' => $offer->amount, // Use offer amount
                    'type' => 'project_purchase',
                    'stripe_payment_id' => 'test_pi_' . uniqid(),
                    'stripe_session_id' => 'test_cs_' . uniqid(),
                ]);
                
                return redirect()->route('payments.success')
                    ->with('success', 'Payment successful (TEST MODE) - You have purchased this project!');
            }
        }

        // REAL MODE: Use actual Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $type = $request->input('type'); // 'listing_fee' or 'featured_upgrade' or 'project_purchase'
        $projectId = $request->input('project_id');

        if ($type === 'listing_fee') {
            $amount = 1000;
            $description = 'Project Listing Fee';
        } elseif ($type === 'featured_upgrade') {
            $amount = 2500;
            $description = 'Featured Listing Upgrade';
        } elseif ($type === 'project_purchase') {
            $offer = \App\Models\Offer::findOrFail($request->offer_id);
            $amount = $offer->amount;
            $description = "Purchase of " . $project->title;
        }

        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $description,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'),
            'metadata' => [
                'user_id' => auth()->id(),
                'project_id' => $projectId,
                'type' => $type,
            ],
        ];

        if ($type === 'project_purchase') {
            $sessionData['metadata']['offer_id'] = $request->offer_id;
        }

        $session = Session::create($sessionData);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($sessionId);

            // The webhook will handle the actual processing
            // This is just a success page
        }

        return view('payments.success');
    }

    public function cancel()
    {
        return view('payments.cancel');
    }

    public function webhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook error'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $userId = $session->metadata->user_id;
            $projectId = $session->metadata->project_id;
            $type = $session->metadata->type;

            // Record transaction
            Transaction::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'amount' => $session->amount_total,
                'type' => $type,
                'stripe_payment_id' => $session->payment_intent,
                'stripe_session_id' => $session->id,
            ]);

            $project = Project::find($projectId);

            if ($type === 'listing_fee') {
                // Activate the project listing
                $project->update(['status' => 'active']);
            } elseif ($type === 'featured_upgrade') {
                // Upgrade to featured
                $featuredUntil = now()->addDays(30);
                $project->update([
                    'is_featured' => true,
                    'featured_until' => $featuredUntil,
                ]);
            } elseif ($type === 'project_purchase') {
                // Mark project as sold
                $project->update(['status' => 'sold']);
                
                // Mark offer as paid
                if (isset($session->metadata->offer_id)) {
                    $offer = \App\Models\Offer::find($session->metadata->offer_id);
                    if ($offer) {
                        $offer->update(['status' => 'paid']);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function upgradeFeatured(Project $project)
    {
        // User must own the project (validation happens in route model binding + dashboard display)
        if ($project->user_id !== auth()->id()) {
            abort(403, 'You do not own this project.');
        }

        return $this->createCheckout(new Request([
            'type' => 'featured_upgrade',
            'project_id' => $project->id,
        ]));
    }
}
