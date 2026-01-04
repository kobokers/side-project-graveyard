@extends('layouts.app')

@section('content')
<style>
    .marketplace-card {
        transition: all 0.2s ease;
    }
    .marketplace-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
    }
    .category-link {
        transition: all 0.15s ease;
    }
    .category-link:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }
    .category-link.active {
        background-color: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        font-weight: 600;
    }
    .filter-section {
        position: sticky;
        top: 80px;
    }
    .price-tag {
        background: linear-gradient(135deg, #059669, #10b981);
    }
</style>

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <span class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </span>
                    Marketplace
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Discover abandoned projects looking for new owners</p>
            </div>
            
            @auth
            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Listing
            </a>
            @endauth
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Left Sidebar - Filters -->
            <aside class="lg:w-72 flex-shrink-0">
                <div class="filter-section bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 transition-colors duration-200">
                    
                    <!-- Search -->
                    <form method="GET" action="{{ route('projects.index') }}" id="filterForm">
                        <div class="mb-6">
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Search projects..." 
                                       class="w-full pl-10 pr-4 py-2.5 bg-gray-100 dark:bg-gray-700 border-0 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Categories</h3>
                            <div class="space-y-1">
                                <a href="{{ route('projects.index', array_merge(request()->except('category'), ['category' => ''])) }}" 
                                   class="category-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 {{ !request('category') ? 'active' : '' }}">
                                    <span class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                    </span>
                                    All Categories
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('projects.index', array_merge(request()->except('category'), ['category' => $cat])) }}" 
                                       class="category-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 {{ request('category') === $cat ? 'active' : '' }}">
                                        <span class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-lg">
                                            @switch($cat)
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
                                                @case('other')
                                                    📦
                                                    @break
                                                @default
                                                    📁
                                            @endswitch
                                        </span>
                                        {{ ucfirst($cat) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Sort By</h3>
                            <select name="sort" onchange="document.getElementById('filterForm').submit()" 
                                    class="w-full px-3 py-2.5 bg-gray-100 dark:bg-gray-700 border-0 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <!-- Hidden submit for search -->
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    </form>
                    
                    <!-- Quick Stats -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $projects->total() }}</span> projects available
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content - Projects Grid -->
            <main class="flex-1 min-w-0">
                @if($projects->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center transition-colors duration-200">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">No Projects Found</h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Try adjusting your filters or search query.</p>
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                            Clear all filters
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <!-- Results Info -->
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Showing {{ $projects->firstItem() }}-{{ $projects->lastItem() }} of {{ $projects->total() }} results
                            @if(request('category'))
                                in <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst(request('category')) }}</span>
                            @endif
                        </p>
                    </div>
                    
                    <!-- Projects Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($projects as $project)
                            <a href="{{ route('projects.show', $project) }}" class="marketplace-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden group">
                                <!-- Project Image/Placeholder -->
                                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 relative">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-5xl">
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
                                    </div>
                                    
                                    <!-- Featured Badge -->
                                    @if($project->is_featured && $project->featured_until > now())
                                        <div class="absolute top-2 left-2 px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded-md flex items-center gap-1">
                                            ⭐ Featured
                                        </div>
                                    @endif
                                    
                                    <!-- Quick Save Button -->
                                    <button class="absolute top-2 right-2 w-8 h-8 bg-white/90 dark:bg-gray-800/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-sm hover:bg-white dark:hover:bg-gray-700" onclick="event.preventDefault();">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Project Info -->
                                <div class="p-3">
                                    <div class="price-tag inline-block px-2 py-0.5 rounded text-white text-sm font-bold mb-2">
                                        {{ $project->formatted_price }}
                                    </div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-2 text-sm leading-snug mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                        {{ $project->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                        {{ $project->tech_stack ?? ucfirst($project->category) }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-2 text-xs text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $project->views }}
                                        </span>
                                        <span>•</span>
                                        <span>{{ $project->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $projects->withQueryString()->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
