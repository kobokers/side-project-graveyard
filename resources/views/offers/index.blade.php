@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Your Offers</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your buying and selling offers in one place.</p>
    </div>

    <!-- Offers Made (Outgoing) -->
    <div class="mb-12">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <span>📤</span> Offers You Made
        </h2>
        @if($sentOffers->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center text-gray-500 dark:text-gray-400">
                You haven't made any offers yet.
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($sentOffers as $offer)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $offer->status }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h3 class="font-bold text-lg mb-1 dark:text-white truncate">{{ $offer->project->title }}</h3>
                            <div class="flex items-baseline gap-1 mb-3">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $offer->formatted_amount }}</span>
                                <span class="text-xs text-gray-500">listed at {{ $offer->project->formatted_price }}</span>
                            </div>

                            @if($offer->status === 'accepted')
                                <a href="{{ route('offers.checkout', $offer) }}" 
                                   class="block w-full py-2 bg-green-600 hover:bg-green-700 text-white text-center rounded-lg font-semibold transition">
                                   Proceed to Checkout
                                </a>
                            @elseif(in_array($offer->status, ['paid', 'transferred', 'completed']))
                                <a href="{{ route('offers.tracking', $offer) }}" 
                                   class="block w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-lg font-semibold transition">
                                   Track Order
                                </a>
                            @else
                                <a href="{{ route('messages.show', ['project' => $offer->project->id, 'user' => $offer->seller_id]) }}" 
                                   class="block w-full py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-center rounded-lg font-medium transition">
                                   View Chat
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Offers Received (Incoming) -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <span>📥</span> Offers Received
        </h2>
        @if($receivedOffers->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center text-gray-500 dark:text-gray-400">
                You haven't received any offers yet.
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($receivedOffers as $offer)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold">
                                        {{ substr($offer->buyer->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium dark:text-gray-200">{{ $offer->buyer->name }}</span>
                                </div>
                                <span class="text-xs text-gray-400">{{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h3 class="font-bold text-lg mb-1 dark:text-white truncate">{{ $offer->project->title }}</h3>
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $offer->formatted_amount }}</span>
                            </div>

                            @if($offer->status === 'pending')
                                <div class="grid grid-cols-2 gap-2">
                                    <form method="POST" action="{{ route('offers.reject', $offer) }}">
                                        @csrf
                                        <button class="w-full py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white transition">
                                            Decline
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('offers.accept', $offer) }}">
                                        @csrf
                                        <button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
                                            Accept
                                        </button>
                                    </form>
                                </div>
                            @elseif($offer->status === 'accepted')
                                <div class="w-full py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-center rounded-lg font-semibold text-sm">
                                    Accepted - Awaiting Payment
                                </div>
                            @elseif(in_array($offer->status, ['paid', 'transferred', 'completed']))
                                <a href="{{ route('offers.tracking', $offer) }}" 
                                   class="block w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-lg font-semibold transition">
                                   View Order Tracking
                                </a>
                            @else
                                <div class="w-full py-2 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-center rounded-lg font-medium text-sm capitalize">
                                    {{ $offer->status }}
                                </div>
                            @endif
                            
                            <a href="{{ route('messages.show', ['project' => $offer->project->id, 'user' => $offer->buyer_id]) }}" 
                               class="block w-full mt-2 text-center text-sm text-blue-600 hover:underline">
                               Go to Chat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
