<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Offers made by the user (Outgoing)
        $sentOffers = Offer::where('buyer_id', $userId)
            ->with(['project', 'seller'])
            ->latest()
            ->get();
            
        // Offers received by the user (Incoming)
        $receivedOffers = Offer::where('seller_id', $userId)
            ->with(['project', 'buyer'])
            ->latest()
            ->get();
            
        return view('offers.index', compact('sentOffers', 'receivedOffers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:500',
        ]);

        $project = Project::findOrFail($request->project_id);
        
        // Prevent offering on own project
        if ($project->user_id === Auth::id()) {
            return back()->with('error', 'You cannot make an offer on your own project.');
        }

        // Create the offer
        $offer = Offer::create([
            'project_id' => $project->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $project->user_id,
            'amount' => $request->amount * 100, // Store in cents
            'note' => $request->note,
            'status' => 'pending',
        ]);

        // Send a message to the seller to notify them (and start/continue conversation)
        // Check if conversation exists, if not create one essentially by sending a message
        $messageContent = "I've made an offer of $" . number_format($request->amount, 2) . " for " . $project->title;
        if ($request->note) {
            $messageContent .= "\n\nNote: " . $request->note;
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $project->user_id,
            'project_id' => $project->id,
            'message' => $messageContent,
        ]);

        return redirect()->back()->with('success', 'Offer sent successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        // specific actions like accept, reject are handled by dedicated methods or we can consolidate here
        // For now preventing generic updates
        return back(); 
    }
    
    public function accept(Offer $offer)
    {
        if ($offer->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $offer->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);
        
        // Notify buyer via message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $offer->buyer_id,
            'project_id' => $offer->project_id,
            'message' => "I've accepted your offer for {$offer->project->title}! You can now proceed to payment.",
        ]);
        
        return back()->with('success', 'Offer accepted!');
    }
    
    public function reject(Offer $offer)
    {
        if ($offer->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $offer->update([
            'status' => 'rejected',
            'responded_at' => now(),
        ]);
        
        return back()->with('success', 'Offer declined.');
    }

    // New Order Flow Methods

    public function checkout(Offer $offer)
    {
        // Ensure user is the buyer and offer is accepted
        if (Auth::id() !== $offer->buyer_id || $offer->status !== 'accepted') {
            abort(403, 'Unauthorized access to checkout.');
        }

        return view('offers.checkout', compact('offer'));
    }

    public function tracking(Offer $offer)
    {
        // Allow both buyer and seller to view tracking
        if (Auth::id() !== $offer->buyer_id && Auth::id() !== $offer->seller_id) {
            abort(403);
        }

        return view('offers.tracking', compact('offer'));
    }

    public function markTransferred(Offer $offer)
    {
        if (Auth::id() !== $offer->seller_id) {
            abort(403);
        }

        $offer->update(['status' => 'transferred']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $offer->buyer_id,
            'project_id' => $offer->project_id,
            'message' => "I have transferred the assets. Please confirm receipt in the tracking page.",
        ]);

        return back()->with('success', 'Assets marked as transferred.');
    }

    public function markReceived(Offer $offer)
    {
        if (Auth::id() !== $offer->buyer_id) {
            abort(403);
        }

        $offer->update(['status' => 'completed']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $offer->seller_id,
            'project_id' => $offer->project_id,
            'message' => "I have confirmed receipt of the assets. The transaction is complete!",
        ]);

        return back()->with('success', 'Transaction completed!');
    }
}
