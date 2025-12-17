<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // Initiate purchase (Buy Now button)
    public function initiateCheckout(Project $project)
    {
        // Check if project is available
        if (!$project->isAvailableForPurchase()) {
            return redirect()->back()->with('error', 'This project is no longer available for purchase.');
        }

        // Can't buy your own project
        if ($project->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot purchase your own project.');
        }

        // Calculate commission
        $fullPrice = $project->asking_price;
        $commission = (int)round($fullPrice * 0.05); // 5%
        $sellerAmount = $fullPrice - $commission;

        // TEST MODE: Auto-approve without Stripe
        if (empty(config('services.stripe.secret')) || config('services.stripe.secret') === 'sk_test_your_secret_key_here') {
            $purchase = Purchase::create([
                'buyer_id' => auth()->id(),
                'seller_id' => $project->user_id,
                'project_id' => $project->id,
                'amount_paid' => $fullPrice,
                'seller_amount' => $sellerAmount,
                'commission_amount' => $commission,
                'status' => 'escrowed',
                'stripe_payment_intent_id' => 'test_pi_' . uniqid(),
                'escrowed_at' => now(),
            ]);

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Payment successful (TEST MODE)! The seller will now transfer the project to you.');
        }

        // REAL MODE: Use Stripe Checkout (to be implemented)
        return redirect()->back()->with('error', 'Real Stripe checkout not yet configured. Please add your Stripe keys.');
    }

    // Show purchase details
    public function show(Purchase $purchase)
    {
        // Authorization
        if ($purchase->buyer_id !== auth()->id() && $purchase->seller_id !== auth()->id()) {
            abort(403);
        }

        return view('purchases.show', compact('purchase'));
    }

    // Buyer confirms receipt
    public function confirmReceipt(Purchase $purchase)
    {
        if ($purchase->buyer_id !== auth()->id()) {
            abort(403);
        }

        if (!$purchase->canBeConfirmedByBuyer()) {
            return redirect()->back()->with('error', 'Cannot confirm this purchase at this time.');
        }

        // Mark as completed
        $purchase->update([
            'status' => 'completed',
            'buyer_confirmed_at' => now(),
            'seller_paid_at' => now(), // In test mode, instant
        ]);

        // Update project status
        $purchase->project->update([
            'status' => 'sold',
            'buyer_id' => auth()->id(),
            'purchased_at' => now(),
        ]);

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Purchase confirmed! The seller has been paid.');
    }

    // Seller updates transfer status
    public function updateTransfer(Request $request, Purchase $purchase)
    {
        if ($purchase->seller_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'transfer_notes' => 'required|string|max:1000',
        ]);

        $purchase->update([
            'status' => 'in_transfer',
            'transfer_notes' => $validated['transfer_notes'],
            'transfer_started_at' => now(),
        ]);

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Transfer status updated. The buyer has been notified.');
    }
}
