@extends('layouts.app')

@section('content')
<style>
    .seller-card {
        transition: all 0.2s ease;
    }
    .action-btn {
        transition: all 0.15s ease;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .info-badge {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    }
    .dark .info-badge {
        background: linear-gradient(135deg, #374151, #4b5563);
    }
</style>

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm mb-6">
            <a href="{{ route('projects.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                Marketplace
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('projects.index', ['category' => $project->category]) }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                {{ ucfirst($project->category) }}
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 dark:text-white font-medium truncate max-w-xs">{{ $project->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Left Column - Main Content -->
            <main class="flex-1 min-w-0">
                <!-- Project Header Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors duration-200 mb-6">
                    
                    <!-- Project Image/Hero -->
                    <div class="aspect-video bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 relative flex items-center justify-center">
                        <span class="text-8xl">
                            @switch($project->category)
                                @case('saas')
                                    ☁️
                                    @break
                                @case('mobile')
                                    📱
                                    @break
                                @case('web')
                                    🌐
                                    @break
                                @case('plugin')
                                    🔌
                                    @break
                                @default
                                    📦
                            @endswitch
                        </span>
                        
                        @if($project->is_featured && $project->featured_until > now())
                            <div class="absolute top-4 left-4 px-3 py-1.5 bg-yellow-500 text-white text-sm font-bold rounded-lg flex items-center gap-1 shadow">
                                ⭐ Featured Listing
                            </div>
                        @endif
                        
                        <!-- Share/Save Buttons -->
                        <div class="absolute top-4 right-4 flex gap-2">
                            <button class="w-10 h-10 bg-white/90 dark:bg-gray-800/90 rounded-full flex items-center justify-center shadow hover:bg-white dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                            </button>
                            <button class="w-10 h-10 bg-white/90 dark:bg-gray-800/90 rounded-full flex items-center justify-center shadow hover:bg-white dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Project Title & Price -->
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h1>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Listed {{ $project->created_at->diffForHumans() }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $project->views }} views
                                    </span>
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full font-medium">
                                        {{ ucfirst($project->category) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl md:text-4xl font-bold text-green-600 dark:text-green-400">{{ $project->formatted_price }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors duration-200 mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Details
                    </h2>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{ $project->description }}</p>
                    </div>
                    
                    <!-- The Story -->
                    @if($project->story)
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-l-4 border-blue-500">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <span>📖</span> The Story
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{ $project->story }}</p>
                    </div>
                    @endif
                    
                    <!-- Tech Stack -->
                    @if($project->tech_stack)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <span>🛠️</span> Tech Stack
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $project->tech_stack) as $tech)
                                <span class="info-badge px-3 py-1.5 rounded-full text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ trim($tech) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($project->domain)
                        <div class="info-badge rounded-xl p-4 text-center">
                            <p class="text-2xl mb-1">🌐</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Domain</p>
                            <a href="http://{{ $project->domain }}" target="_blank" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline truncate block">
                                {{ $project->domain }}
                            </a>
                        </div>
                        @endif
                        
                        @if($project->monthly_traffic)
                        <div class="info-badge rounded-xl p-4 text-center">
                            <p class="text-2xl mb-1">📊</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Monthly Traffic</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($project->monthly_traffic) }}</p>
                        </div>
                        @endif
                        
                        @if($project->total_revenue)
                        <div class="info-badge rounded-xl p-4 text-center">
                            <p class="text-2xl mb-1">💰</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Revenue</p>
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">${{ number_format($project->total_revenue / 100, 2) }}</p>
                        </div>
                        @endif
                        
                        <div class="info-badge rounded-xl p-4 text-center">
                            <p class="text-2xl mb-1">📅</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Listed On</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $project->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Column - Seller Info & Actions (Sticky) -->
            <aside class="lg:w-80 flex-shrink-0">
                <div class="lg:sticky lg:top-24 space-y-4">
                    
                    <!-- Seller Card -->
                    <div class="seller-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 transition-colors duration-200">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Seller Information</h3>
                        
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ strtoupper(substr($project->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $project->user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Member since {{ $project->user->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                        
                        @auth
                            @if($project->user_id === auth()->id())
                                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 text-center mb-4">
                                    <p class="text-blue-700 dark:text-blue-300 font-medium mb-2">This is your listing</p>
                                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit Project
                                    </a>
                                </div>
                            @else
                                <div class="space-y-3" x-data="{ showOfferModal: false }">
                                    <!-- Make Offer Button -->
                                    <button @click="showOfferModal = true" class="action-btn w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Make an Offer
                                    </button>
                                    
                                    <!-- Message Seller -->
                                    <form method="POST" action="{{ route('messages.store') }}">
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        <input type="hidden" name="receiver_id" value="{{ $project->user_id }}">
                                        <input type="hidden" name="message" value="Hi, I'm interested in {{ $project->title }}!">
                                        
                                        <button type="submit" class="action-btn w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-400 rounded-lg font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            Message Seller
                                        </button>
                                    </form>
                                    
                                    <!-- Offer Modal -->
                                    <div x-show="showOfferModal" 
                                         style="display: none;"
                                         class="fixed inset-0 z-50 overflow-y-auto" 
                                         aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            
                                            <div x-show="showOfferModal" 
                                                 x-transition:enter="ease-out duration-300" 
                                                 x-transition:enter-start="opacity-0" 
                                                 x-transition:enter-end="opacity-100" 
                                                 x-transition:leave="ease-in duration-200" 
                                                 x-transition:leave-start="opacity-100" 
                                                 x-transition:leave-end="opacity-0" 
                                                 class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
                                                 @click="showOfferModal = false" aria-hidden="true"></div>
            
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
                                            <div x-show="showOfferModal" 
                                                 x-transition:enter="ease-out duration-300" 
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave="ease-in duration-200" 
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                                
                                                <div class="p-6">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Make an Offer</h3>
                                                        <button @click="showOfferModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 mb-4 flex items-center gap-3">
                                                        <span class="text-3xl">
                                                            @switch($project->category)
                                                                @case('saas') ☁️ @break
                                                                @case('mobile') 📱 @break
                                                                @case('web') 🌐 @break
                                                                @default 📦
                                                            @endswitch
                                                        </span>
                                                        <div>
                                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $project->title }}</p>
                                                            <p class="text-sm text-gray-500">Listed at {{ $project->formatted_price }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <form method="POST" action="{{ route('offers.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                        
                                                        <div class="mb-4">
                                                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Offer</label>
                                                            <div class="relative">
                                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500 text-lg font-medium">$</span>
                                                                </div>
                                                                <input type="number" name="amount" id="amount" required step="0.01" min="1" 
                                                                       class="w-full pl-8 pr-4 py-3 bg-gray-100 dark:bg-gray-700 border-0 rounded-lg text-xl font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" 
                                                                       placeholder="0.00">
                                                            </div>
                                                        </div>

                                                        <div class="mb-6">
                                                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message (Optional)</label>
                                                            <textarea name="note" id="note" rows="3" 
                                                                      class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 border-0 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" 
                                                                      placeholder="I'm interested in buying this because..."></textarea>
                                                        </div>

                                                        <div class="flex gap-3">
                                                            <button type="button" @click="showOfferModal = false" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                                                Send Offer
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 text-center">
                                <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Sign in to contact the seller</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('login') }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                                        Log In
                                    </a>
                                    <a href="{{ route('register') }}" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition text-center">
                                        Sign Up
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Safety Tips -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                        <h4 class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Safety Tips
                        </h4>
                        <ul class="text-sm text-yellow-700 dark:text-yellow-400 space-y-1">
                            <li>• Verify the project before purchase</li>
                            <li>• Use secure payment methods</li>
                            <li>• Meet at safe locations for transfers</li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
