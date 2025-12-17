@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h1 class="text-5xl font-bold mb-6">Give Your Dead Projects a Second Life</h1>
        <p class="text-xl mb-2 max-w-2xl mx-auto">
            Don't let your abandoned projects die alone. List them here and let someone else bring them to life.
        </p>
        <p class="text-lg mb-8 max-w-2xl mx-auto font-semibold">
            ✨ List for FREE! We only charge 5% when you sell.
        </p>
        <div class="flex justify-center space-x-4">
            @auth
                <a href="{{ route('projects.create') }}" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                    List Your Project
                </a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                    List Your Project
                </a>
            @endauth
            <a href="{{ route('projects.index') }}" class="px-8 py-3 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                Browse Projects
            </a>
        </div>
    </div>
</div>

@if($featuredProjects->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Featured Projects</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProjects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm font-semibold mb-3">
                        {{ ucfirst($project->category) }}
                    </span>
                    <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                        <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ $project->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $project->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $project->formatted_price }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $project->views }} views</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Recent Listings</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($recentProjects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold mb-3">
                        {{ ucfirst($project->category) }}
                    </span>
                    <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                        <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ $project->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $project->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $project->formatted_price }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $project->views }} views</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('projects.index') }}" class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition">
            View All Projects
        </a>
    </div>
</section>

<section class="bg-gray-50 dark:bg-gray-800 py-16 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">How It Works</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">List Your Project</h3>
                <p class="text-gray-600 dark:text-gray-300">Create a listing with details about your project, tech stack, and why it didn't work out.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Get Discovered</h3>
                <p class="text-gray-600 dark:text-gray-300">Your project appears in our marketplace where thousands of entrepreneurs browse daily.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Make a Deal</h3>
                <p class="text-gray-600 dark:text-gray-300">Connect with interested buyers and negotiate the transfer of your project.</p>
            </div>
        </div>
    </div>
</section>
@endsection
