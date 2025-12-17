@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 h-[calc(100vh-5rem)]">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden h-full flex border border-gray-200 dark:border-gray-800">
        <!-- Sidebar (Hidden on mobile when chat is active) -->
        <div class="hidden md:block w-1/3 lg:w-1/4 min-w-[300px] border-r border-gray-200 dark:border-gray-700 flex-shrink-0 h-full">
            @include('messages.sidebar', ['conversations' => $conversations, 'activeUser' => $user])
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col h-full bg-white dark:bg-gray-900 relative">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 z-10 flex flex-col gap-4 shadow-sm">
                <!-- Top Row: User + Back Button (Mobile) -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('messages.index') }}" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        
                        <div class="relative">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                        </div>
                        
                        <div>
                            <h2 class="font-bold text-gray-900 dark:text-white text-lg leading-tight">{{ $user->name }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Response time: Usually within an hour</p>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 px-3 py-1.5 rounded-lg transition">
                            View Item
                        </a>
                    </div>
                </div>

                <!-- Product & Offer Snapshot - Integrated Compact View -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-3 flex flex-wrap items-center justify-between gap-4 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-600 flex-shrink-0">
                            <!-- Placeholder Icon for Product -->
                             <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $project->title }}</h3>
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $project->formatted_price }}</p>
                        </div>
                    </div>

                    <!-- Compact Offer Actions -->
                    <div class="flex items-center gap-2">
                        @if($project->user_id !== auth()->id())
                             <button onclick="document.getElementById('offer-modal').classList.remove('hidden')" 
                                     class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm">
                                Make Offer
                             </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Messages Stream -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50/50 dark:bg-gray-900 scroll-smooth">
                
                <!-- Safety/Intro Badge -->
                <div class="flex justify-center mb-8">
                     <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 text-xs rounded-full border border-gray-200 dark:border-gray-700">
                         This conversation is about <strong>{{ $project->title }}</strong>
                     </span>
                </div>

                <!-- Offers History Stream (Inlined) -->
                @foreach($offers as $offer)
                    <div class="flex justify-center my-4">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm max-w-sm w-full">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Offer {{ $offer->status }}</span>
                                <span class="text-xs text-gray-400">{{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $offer->formatted_amount }}</span>
                                <span class="text-sm text-gray-500">offered by {{ $offer->buyer_id === auth()->id() ? 'You' : $offer->buyer->name }}</span>
                            </div>
                            @if($offer->note)
                                <p class="text-sm text-gray-600 dark:text-gray-300 italic bg-gray-50 dark:bg-gray-700/50 p-2 rounded mb-3">"{{ $offer->note }}"</p>
                            @endif

                            @if($offer->status === 'pending' && $offer->seller_id === auth()->id())
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    <form method="POST" action="{{ route('offers.reject', $offer) }}">
                                        @csrf
                                        <button class="w-full py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Decline</button>
                                    </form>
                                    <form method="POST" action="{{ route('offers.accept', $offer) }}">
                                        @csrf
                                        <button class="w-full py-2 bg-green-600 dark:bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition">Accept</button>
                                    </form>
                                </div>
                            @endif

                            @if($offer->status === 'accepted' && $offer->buyer_id === auth()->id() && $project->status !== 'sold')
                                <div class="mt-3">
                                    <a href="{{ route('offers.checkout', $offer) }}" 
                                       class="block w-full py-2 bg-blue-600 dark:bg-blue-500 text-white text-center font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm">
                                        Pay Now ({{ $offer->formatted_amount }})
                                    </a>
                                </div>
                            @elseif(in_array($offer->status, ['paid', 'transferred', 'completed']))
                                <div class="mt-3">
                                    <a href="{{ route('offers.tracking', $offer) }}" 
                                       class="block w-full py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm">
                                        View Order Tracking
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Messages -->
                @forelse($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} group animate-fade-in-up">
                        <div class="max-w-[70%]">
                            @if($message->sender_id !== auth()->id())
                                <div class="flex items-end gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <!-- Receiver Bubble -->
                                        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white px-5 py-3 rounded-2xl rounded-bl-none shadow-sm">
                                            <p class="text-[15px] leading-relaxed break-words">{{ $message->message }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1 ml-1">
                                            <span class="text-[10px] text-gray-400">{{ $message->created_at->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Sender Bubble -->
                                <div class="flex flex-col items-end">
                                    <div class="bg-blue-600 dark:bg-blue-600 text-white px-5 py-3 rounded-2xl rounded-br-none shadow-md">
                                        <p class="text-[15px] leading-relaxed break-words">{{ $message->message }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1 mr-1">
                                        <span class="text-[10px] text-gray-400">{{ $message->created_at->format('g:i A') }}</span>
                                        @if($message->read_at)
                                            <span class="text-[10px] text-blue-500 font-medium">Seen</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-40 text-gray-500">
                        <p>No messages yet.</p>
                        <p class="text-sm">Send a message to start the conversation!</p>
                    </div>
                @endforelse
                <div id="bottom-anchor"></div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('messages.store') }}" class="flex items-end gap-3 max-w-5xl mx-auto">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    
                    <div class="flex-grow relative">
                         <textarea name="message" required rows="1" 
                                  class="w-full bg-gray-100 dark:bg-gray-800 border-0 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-800 transition-all resize-none max-h-32 custom-scrollbar shadow-inner"
                                  placeholder="Type a message..."
                                  oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'"></textarea>
                    </div>

                    <button type="submit" class="p-3.5 bg-blue-600 dark:bg-blue-500 text-white rounded-full hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple Offer Modal -->
@if($project->user_id !== auth()->id())
<div id="offer-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 transition-opacity backdrop-blur-sm" onclick="document.getElementById('offer-modal').classList.add('hidden')"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('offers.store') }}" class="p-6">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    
                    <div class="mb-5 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 mb-4">
                            <span class="text-xl">💰</span>
                        </div>
                        <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white" id="modal-title">Make an Offer</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Enter your offer price for <strong>{{ $project->title }}</strong></p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Offer Amount ($)</label>
                            <input type="number" name="amount" step="0.01" min="1" required 
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 text-lg font-semibold px-4"
                                   placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Note (Optional)</label>
                            <input type="text" name="note" maxlength="500" 
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2"
                                   placeholder="Add a message with your offer...">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="document.getElementById('offer-modal').classList.add('hidden')" 
                                class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-blue-600 dark:bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                            Send Offer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Scroll to bottom
    const messagesContainer = document.querySelector('.overflow-y-auto');
    if(messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
</script>
@endsection
