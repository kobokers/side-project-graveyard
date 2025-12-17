@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Welcome back, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-6">Manage your projects and track your listings</p>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-200">
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->projects()->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Projects</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-200">
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ auth()->user()->projects()->where('status', 'active')->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Active</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-200">
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ auth()->user()->sales()->where('status', 'completed')->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sales</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-200">
            <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $purchasedProjects->where('status', 'completed')->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Purchases</p>
        </div>
    </div>

    <!-- Sales Section -->
    @if($soldProjects->isNotEmpty())
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <span>💰</span> My Sales
            </h2>
            <div class="grid gap-6">
                @foreach($soldProjects as $offer)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-blue-500 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $offer->project->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Sold to {{ $offer->buyer->name }} on {{ $offer->updated_at->format('M d, Y') }}</p>
                                
                                <div class="flex items-center gap-4">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $offer->formatted_amount }}</span>
                                    @if($offer->status === 'paid')
                                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full text-xs font-semibold animate-pulse">Action Required: Transfer Assets</span>
                                    @elseif($offer->status === 'transferred')
                                        <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-xs font-semibold">Waiting for Buyer Confirmation</span>
                                    @elseif($offer->status === 'completed')
                                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-semibold">Sale Completed</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('offers.tracking', $offer) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm">
                                    Manage Order
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Purchases Section -->
    @if($purchasedProjects->isNotEmpty())
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <span>🛍️</span> My Purchases
            </h2>
            <div class="grid gap-6">
                @foreach($purchasedProjects as $offer)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-green-500 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $offer->project->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Purchased from {{ $offer->seller->name }} on {{ $offer->updated_at->format('M d, Y') }}</p>
                                
                                <div class="flex items-center gap-4">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $offer->formatted_amount }}</span>
                                    @if($offer->status === 'paid')
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-semibold">Payment Secure</span>
                                    @elseif($offer->status === 'transferred')
                                        <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-xs font-semibold">Transfer Started</span>
                                    @elseif($offer->status === 'completed')
                                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-semibold">Completed</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('offers.tracking', $offer) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-sm">
                                    Track Order
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">My Projects</h2>
        <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition">
            + List New Project
        </a>
    </div>

    @if($projects->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center transition-colors duration-200">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">No Projects Yet</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Get started by listing your first project!</p>
            <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                List Your First Project
            </a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($projects as $project)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $project->title }}</h2>
                                @if($project->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-sm font-semibold">Pending Payment</span>
                                @elseif($project->status === 'active')
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-semibold">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-sm font-semibold">{{ ucfirst($project->status) }}</span>
                                @endif
                                @if($project->is_featured && $project->featured_until && $project->featured_until > now())
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm font-semibold">⭐ Featured</span>
                                @endif
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project->description }}</p>
                            <div class="flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                                <span>Price: <strong class="text-gray-900 dark:text-white">{{ $project->formatted_price }}</strong></span>
                                <span>Views: <strong class="text-gray-900 dark:text-white">{{ $project->views }}</strong></span>
                                <span>Category: <strong class="text-gray-900 dark:text-white">{{ ucfirst($project->category) }}</strong></span>
                                <span>Listed: <strong class="text-gray-900 dark:text-white">{{ $project->created_at->format('M d, Y') }}</strong></span>
                            </div>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                View
                            </a>
                            @if($project->status === 'active')
                                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                                    Edit
                                </a>
                                @if(!$project->is_featured || $project->featured_until < now())
                                    <form method="POST" action="{{ route('payments.upgrade-featured', $project) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-purple-600 dark:bg-purple-500 text-white rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition">
                                            Make Featured ($25)
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure you want to delete this project?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 dark:bg-red-500 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
