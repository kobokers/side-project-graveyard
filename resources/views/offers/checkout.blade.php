@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('offers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Offers
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Checkout</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Review Your Order</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Please review the details below before proceeding to payment.</p>
        </div>
        
        <div class="p-6">
            <!-- Project Details -->
            <div class="flex gap-4 mb-8">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                    {{ strtoupper(substr($offer->project->title, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $offer->project->title }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Sold by {{ $offer->seller->name }}</p>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        {{ ucfirst($offer->project->category) }}
                    </span>
                </div>
            </div>

            <!-- Price Breakdown -->
            <div class="border-t border-gray-200 dark:border-gray-700 py-6 space-y-3">
                <div class="flex justify-between text-gray-600 dark:text-gray-300">
                    <span>Agreed Offer Amount</span>
                    <span class="font-medium">{{ $offer->formatted_amount }}</span>
                </div>
                <div class="flex justify-between text-gray-600 dark:text-gray-300">
                    <span>Processing Fee (0%)</span>
                    <span class="font-medium">$0.00</span>
                </div>
                <div class="flex justify-between text-gray-900 dark:text-white font-bold text-lg pt-3 border-t border-gray-100 dark:border-gray-700">
                    <span>Total</span>
                    <span>{{ $offer->formatted_amount }}</span>
                </div>
            </div>

            <!-- Payment Button -->
            <form action="{{ route('payments.checkout') }}" method="GET" class="mt-6">
                <!-- Use GET for createCheckout as per routes -->
                <input type="hidden" name="project_id" value="{{ $offer->project->id }}">
                <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                <input type="hidden" name="type" value="project_purchase">
                
                <button type="submit" class="w-full py-4 text-white font-bold text-lg rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg transform transition hover:-translate-y-0.5">
                    Proceed to Payment Safe & Securely
                </button>
                <div class="text-center mt-3">
                    <p class="text-xs text-gray-400 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                        Transactions are secured by Stripe. Funds are held until transfer is complete.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
