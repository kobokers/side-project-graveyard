@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('projects.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mb-4 inline-block">&larr; Back to Projects</a>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors duration-200">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">{{ $project->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Listed by {{ $project->user->name }} on {{ $project->created_at->format('M d, Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $project->formatted_price }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $project->views }} views</p>
            </div>
        </div>

        <div class="mb-6">
            <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold">
                {{ ucfirst($project->category) }}
            </span>
        </div>

        <div class="prose max-w-none mb-6">
            <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Description</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ $project->description }}</p>
        </div>

        <div class="prose max-w-none mb-6">
            <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">The Story</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ $project->story }}</p>
        </div>

        @if($project->tech_stack)
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Tech Stack</h2>
                <p class="text-gray-700 dark:text-gray-300">{{ $project->tech_stack }}</p>
            </div>
        @endif

        @if($project->domain)
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Domain</h2>
                <p><a href="http://{{ $project->domain }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $project->domain }}</a></p>
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            @if($project->monthly_traffic)
                <div>
                    <h3 class="font-bold mb-1 text-gray-900 dark:text-white">Monthly Traffic</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ number_format($project->monthly_traffic) }} visits/month</p>
                </div>
            @endif
            @if($project->total_revenue)
                <div>
                    <h3 class="font-bold mb-1 text-gray-900 dark:text-white">Total Revenue Generated</h3>
                    <p class="text-gray-700 dark:text-gray-300">${{ number_format($project->total_revenue / 100, 2) }}</p>
                </div>
            @endif
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Contact Seller</h2>
            
            @auth
                @if($project->user_id === auth()->id())
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 dark:text-gray-300">This is your project.</p>
                        <a href="{{ route('projects.edit', $project) }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 font-medium">Edit Project</a>
                    </div>
                @else
                    <div class="flex items-start gap-4 mb-6">
                        <!-- Seller Avatar -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($project->user->name, 0, 1)) }}
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                Seller: <span class="font-semibold text-gray-900 dark:text-white">{{ $project->user->name }}</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">Member since {{ $project->user->created_at->format('M Y') }}</p>

                            <div class="flex flex-col sm:flex-row gap-3" x-data="{ showOfferModal: false }">
                                <!-- Message Button -->
                                <form method="POST" action="{{ route('messages.store') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="receiver_id" value="{{ $project->user_id }}">
                                    <input type="hidden" name="message" value="Hi, I'm interested in {{ $project->title }}!">
                                    
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-400 rounded-lg font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Message Seller
                                    </button>
                                </form>

                                <!-- Make Offer Button -->
                                <button @click="showOfferModal = true" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Make Offer
                                </button>

                                <!-- Offer Modal -->
                                <div x-show="showOfferModal" 
                                     style="display: none;"
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        
                                        <div x-show="showOfferModal" 
                                             x-transition:enter="ease-out duration-300" 
                                             x-transition:enter-start="opacity-0" 
                                             x-transition:enter-end="opacity-100" 
                                             x-transition:leave="ease-in duration-200" 
                                             x-transition:leave-start="opacity-100" 
                                             x-transition:leave-end="opacity-0" 
                                             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                             @click="showOfferModal = false" aria-hidden="true"></div>
                
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                                        <div x-show="showOfferModal" 
                                             x-transition:enter="ease-out duration-300" 
                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                             x-transition:leave="ease-in duration-200" 
                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full ring-1 ring-black ring-opacity-5">
                                            
                                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                                    Make an Offer
                                                </h3>
                                                <p class="text-sm text-gray-500 mt-1">Listed Price: {{ $project->formatted_price }}</p>
                                                
                                                <form id="offerForm" method="POST" action="{{ route('offers.store') }}" class="mt-4">
                                                    @csrf
                                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                    
                                                    <div class="mb-4">
                                                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Offer ($)</label>
                                                        <div class="relative rounded-md shadow-sm">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">$</span>
                                                            </div>
                                                            <input type="number" name="amount" id="amount" required step="0.01" min="1" 
                                                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md" 
                                                                   placeholder="0.00">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message (Optional)</label>
                                                        <textarea name="note" id="note" rows="3" 
                                                                  class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md" 
                                                                  placeholder="I'm interested in buying this because..."></textarea>
                                                    </div>

                                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                                                            Send Offer
                                                        </button>
                                                        <button type="button" @click="showOfferModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Sign in to contact the seller</p>
                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Sign Up
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
