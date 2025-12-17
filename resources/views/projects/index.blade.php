@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Browse Projects</h1>
    
    <!-- Search and Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8 transition-colors duration-200">
        <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search projects..." class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
            <select name="category" class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            <select name="sort" class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-4 py-2">
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-700 dark:hover:bg-blue-600 transition">Filter</button>
        </form>
    </div>

    <!-- Projects Grid -->
    @if($projects->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center transition-colors duration-200">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">No Projects Found</h2>
            <p class="text-gray-600 dark:text-gray-300">Try adjusting your filters or search query.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold">
                                {{ ucfirst($project->category) }}
                            </span>
                            @if($project->is_featured && $project->featured_until > now())
                                <span class="text-purple-500 dark:text-purple-400 text-xl">⭐</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                {{ $project->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $project->description }}</p>
                        @if($project->tech_stack)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $project->tech_stack }}</p>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $project->formatted_price }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $project->views }} views</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @endif
</div>
@endsection
