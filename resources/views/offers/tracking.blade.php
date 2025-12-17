@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Order Tracking</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Order #{{ $offer->id }}-{{ $offer->project_id }}</p>
        </div>
        <a href="{{ route('messages.show', ['project' => $offer->project->id, 'user' => $offer->buyer_id === auth()->id() ? $offer->seller_id : $offer->buyer_id]) }}" 
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white rounded-lg text-sm font-medium transition">
           Open Chat
        </a>
    </div>

    <!-- Progress Tracker -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 -translate-y-1/2 rounded-full z-0"></div>
            <div class="absolute top-1/2 left-0 h-1 bg-blue-500 -translate-y-1/2 rounded-full z-0 transition-all duration-1000"
                 style="width: {{ 
                    $offer->status === 'accepted' ? '0%' : 
                    ($offer->status === 'paid' ? '33%' : 
                    ($offer->status === 'transferred' ? '66%' : 
                    ($offer->status === 'completed' ? '100%' : '0%'))) 
                 }}"></div>

            <!-- Steps -->
            <div class="relative z-10 flex justify-between w-full">
                <!-- Step 1: Accepted -->
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400">Accepted</span>
                </div>

                <!-- Step 2: Paid -->
                <div class="flex flex-col items-center">
                    <div class="{{ in_array($offer->status, ['paid', 'transferred', 'completed']) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }} w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-gray-800 transition-colors duration-500">
                        @if(in_array($offer->status, ['paid', 'transferred', 'completed']))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            2
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold {{ in_array($offer->status, ['paid', 'transferred', 'completed']) ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">Paid</span>
                </div>

                <!-- Step 3: Transferred -->
                <div class="flex flex-col items-center">
                    <div class="{{ in_array($offer->status, ['transferred', 'completed']) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }} w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-gray-800 transition-colors duration-500">
                        @if(in_array($offer->status, ['transferred', 'completed']))
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            3
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold {{ in_array($offer->status, ['transferred', 'completed']) ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">Assets Transferred</span>
                </div>

                <!-- Step 4: Completed -->
                <div class="flex flex-col items-center">
                    <div class="{{ $offer->status === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }} w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white dark:ring-gray-800 transition-colors duration-500">
                        @if($offer->status === 'completed')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            4
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold {{ $offer->status === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-gray-500' }}">Completed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Area -->
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Status Card -->
        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Current Status</h3>
            
            @if($offer->status === 'paid')
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900 rounded-lg p-4">
                    <p class="font-semibold text-blue-800 dark:text-blue-200">Payment Secured</p>
                    <p class="text-sm text-blue-600 dark:text-blue-300 mt-1">The funds are held safely. The seller needs to transfer the project assets to you.</p>
                </div>
                @if(auth()->id() === $offer->seller_id)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Once you have transferred the domain/codebase to the buyer, please confirm below.</p>
                        <form method="POST" action="{{ route('offers.mark-transferred', $offer) }}">
                            @csrf
                            <button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                                I have transferred the assets
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-4 text-sm text-gray-500 italic">Waiting for seller to transfer assets...</div>
                @endif
            
            @elseif($offer->status === 'transferred')
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-900 rounded-lg p-4">
                    <p class="font-semibold text-yellow-800 dark:text-yellow-200">Transfer Initiated</p>
                    <p class="text-sm text-yellow-600 dark:text-yellow-300 mt-1">The seller has marked the assets as transferred. Please verify you have received everything.</p>
                </div>
                @if(auth()->id() === $offer->buyer_id)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Please confirm you have received all assets and control of the project.</p>
                        <form method="POST" action="{{ route('offers.mark-received', $offer) }}">
                            @csrf
                            <button class="w-full py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                                Confirm Receipt & Release Funds
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-4 text-sm text-gray-500 italic">Waiting for buyer to confirm receipt...</div>
                @endif

            @elseif($offer->status === 'completed')
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-900 rounded-lg p-4 text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-green-800 dark:text-green-200 text-lg">Order Completed</p>
                    <p class="text-sm text-green-600 dark:text-green-300">Transaction finished on {{ $offer->updated_at->format('M d, Y') }}</p>
                </div>

            @else
                <p class="text-gray-500">Processing...</p>
            @endif
        </div>

        <!-- Project Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700 h-fit">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Project Details</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr($offer->project->title, 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $offer->project->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $offer->formatted_amount }}</p>
                </div>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                <div class="flex justify-between">
                    <span>Buyer</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $offer->buyer->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Seller</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $offer->seller->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Date</span>
                    <span>{{ $offer->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
