<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // Show inbox (all conversations)
    // Helper to get conversations list
    private function getConversations($userId)
    {
        return Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'project'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function($messages) use ($userId) {
                $latestMessage = $messages->first();
                $otherUserId = $latestMessage->sender_id == $userId ? $latestMessage->receiver_id : $latestMessage->sender_id;
                
                return [
                    'other_user' => User::find($otherUserId),
                    'project' => $latestMessage->project,
                    'last_message' => $latestMessage,
                    'unread_count' => $messages->where('receiver_id', $userId)->where('read', false)->count(),
                ];
            });
    }

    // Show inbox (all conversations)
    public function index()
    {
        $conversations = $this->getConversations(auth()->id());
        return view('messages.index', compact('conversations'));
    }

    // Show conversation with specific user about a project
    public function show(Project $project, User $user)
    {
        $userId = auth()->id();
        $conversations = $this->getConversations($userId); // Add this line

        $messages = Message::betweenUsers($userId, $user->id)
            ->where('project_id', $project->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages as read
        Message::where('project_id', $project->id)
            ->where('receiver_id', $userId)
            ->where('sender_id', $user->id)
            ->where('read', false)
            ->update(['read' => true, 'read_at' => now()]);
        
        // Get offers for this conversation
        $offers = \App\Models\Offer::where('project_id', $project->id)
            ->where(function($query) use ($user, $userId) {
                $query->where('buyer_id', $userId)->where('seller_id', $user->id)
                      ->orWhere('buyer_id', $user->id)->where('seller_id', $userId);
            })
            ->latest()
            ->get();
        
        return view('messages.show', compact('project', 'user', 'messages', 'offers', 'conversations'));
    }

    // Send a message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);

        // Can't message yourself
        if ($validated['receiver_id'] == auth()->id()) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        $message = Message::create([
            'project_id' => $validated['project_id'],
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }

    // Make an offer
    public function makeOffer(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'seller_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:500',
        ]);

        $project = \App\Models\Project::findOrFail($validated['project_id']);
        
        $offer = \App\Models\Offer::create([
            'project_id' => $validated['project_id'],
            'buyer_id' => auth()->id(),
            'seller_id' => $validated['seller_id'],
            'amount' => $validated['amount'] * 100, // Convert to cents
            'note' => $validated['note'],
        ]);

        return redirect()->back()->with('success', 'Offer sent!');
    }

    // Accept offer
    public function acceptOffer(\App\Models\Offer $offer)
    {
        if ($offer->seller_id !== auth()->id()) {
            abort(403);
        }

        $offer->accept();
        
        return redirect()->back()->with('success', 'Offer accepted! You can now finalize the sale.');
    }

    // Reject offer
    public function rejectOffer(\App\Models\Offer $offer)
    {
        if ($offer->seller_id !== auth()->id()) {
            abort(403);
        }

        $offer->reject();
        
        return redirect()->back()->with('success', 'Offer rejected.');
    }

    // Get unread message count (for notification badge)
    public function unreadCount()
    {
        return Message::where('receiver_id', auth()->id())
            ->where('read', false)
            ->count();
    }
}
