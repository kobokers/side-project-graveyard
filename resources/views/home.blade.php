@extends('layouts.app')

@section('content')
    <style>
        /* Hero section animations and effects */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.6);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-gradient {
            background: linear-gradient(-45deg, #6366f1, #8b5cf6, #a855f7, #6366f1);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        .floating-card-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: -3s;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .project-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-primary-glow:hover {
            animation: pulse-glow 1.5s ease-in-out infinite;
        }

        .step-icon {
            transition: all 0.3s ease;
        }

        .step-icon:hover {
            transform: scale(1.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <!-- Hero Section with Animated Gradient -->
    <div class="hero-gradient text-white relative overflow-hidden">
        <!-- Decorative floating elements -->
        <div class="absolute top-20 left-10 w-20 h-20 rounded-full glass-card floating-card hidden lg:block"></div>
        <div class="absolute top-40 right-20 w-32 h-32 rounded-full glass-card floating-card-delayed hidden lg:block"></div>
        <div class="absolute bottom-20 left-1/4 w-16 h-16 rounded-full glass-card floating-card hidden lg:block"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 text-center relative z-10">
            <span
                class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6 border border-white/20">
                🚀 The marketplace for abandoned projects
            </span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-6 text-gradient leading-tight">
                Give Your Dead Projects<br>a Second Life
            </h1>
            <p class="text-lg md:text-xl mb-3 max-w-3xl mx-auto text-purple-100 leading-relaxed">
                Don't let your abandoned projects die alone. List them here and let someone else bring them to life.
            </p>
            <p class="text-base md:text-lg mb-10 max-w-2xl mx-auto font-semibold text-yellow-300">
                ✨ List for FREE! We only charge 5% when you sell.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('projects.create') }}"
                        class="btn-primary-glow px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg hover:bg-gray-50 transition shadow-xl shadow-white/20">
                        🎯 List Your Project
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="btn-primary-glow px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg hover:bg-gray-50 transition shadow-xl shadow-white/20">
                        🎯 List Your Project
                    </a>
                @endauth
                <a href="{{ route('projects.index') }}"
                    class="px-8 py-4 bg-transparent border-2 border-white/50 text-white rounded-xl font-bold text-lg hover:bg-white/10 hover:border-white transition backdrop-blur-sm">
                    🔍 Browse Projects
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-2xl mx-auto">
                <div class="text-center">
                    <p class="text-3xl md:text-4xl font-bold text-white">500+</p>
                    <p class="text-purple-200 text-sm">Projects Listed</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl md:text-4xl font-bold text-white">100+</p>
                    <p class="text-purple-200 text-sm">Successful Sales</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl md:text-4xl font-bold text-white">5%</p>
                    <p class="text-purple-200 text-sm">Only When Sold</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Projects Section -->
    @if($featuredProjects->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-full text-sm font-semibold mb-2">⭐
                        Featured</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Featured Projects</h2>
                </div>
                <a href="{{ route('projects.index') }}"
                    class="hidden sm:inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:gap-3 gap-2 transition-all">
                    View all <span>→</span>
                </a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProjects as $project)
                    <div class="project-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group">
                        <div class="h-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500"></div>
                        <div class="p-6">
                            <span
                                class="inline-block px-3 py-1 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/50 dark:to-pink-900/50 text-purple-700 dark:text-purple-300 rounded-full text-xs font-semibold mb-4">
                                {{ ucfirst($project->category) }}
                            </span>
                            <h3
                                class="text-xl font-bold mb-3 text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                <a href="{{ route('projects.show', $project) }}">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-5 line-clamp-3 text-sm leading-relaxed">
                                {{ $project->description }}</p>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span
                                    class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $project->formatted_price }}</span>
                                <span class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $project->views }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Recent Listings Section -->
    <section
        class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 py-20 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full text-sm font-semibold mb-2">🆕
                        Just Listed</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Recent Listings</h2>
                </div>
                <a href="{{ route('projects.index') }}"
                    class="hidden sm:inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:gap-3 gap-2 transition-all">
                    View all <span>→</span>
                </a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentProjects as $project)
                    <div class="project-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group">
                        <div class="h-2 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500"></div>
                        <div class="p-6">
                            <span
                                class="inline-block px-3 py-1 bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/50 dark:to-cyan-900/50 text-blue-700 dark:text-blue-300 rounded-full text-xs font-semibold mb-4">
                                {{ ucfirst($project->category) }}
                            </span>
                            <h3
                                class="text-xl font-bold mb-3 text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                <a href="{{ route('projects.show', $project) }}">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-5 line-clamp-3 text-sm leading-relaxed">
                                {{ $project->description }}</p>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span
                                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">{{ $project->formatted_price }}</span>
                                <span class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $project->views }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg shadow-blue-500/25">
                    View All Projects
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white dark:bg-gray-900 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-sm font-semibold mb-4">Simple
                    Process</span>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white">How It Works</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Three simple steps to give your
                    project a new home</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="relative text-center group">
                    <div
                        class="step-icon w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg shadow-indigo-500/30">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">List Your Project</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Create a detailed listing with your project
                        info, tech stack, and the story behind it. Share what you've built!</p>
                    <!-- Connector line (hidden on mobile) -->
                    <div
                        class="hidden md:block absolute top-10 left-[60%] w-[80%] h-0.5 bg-gradient-to-r from-indigo-500 to-transparent">
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative text-center group">
                    <div
                        class="step-icon w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg shadow-purple-500/30">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Get Discovered</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Your project appears in our marketplace
                        where entrepreneurs and developers browse daily for opportunities.</p>
                    <!-- Connector line (hidden on mobile) -->
                    <div
                        class="hidden md:block absolute top-10 left-[60%] w-[80%] h-0.5 bg-gradient-to-r from-purple-500 to-transparent">
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="text-center group">
                    <div
                        class="step-icon w-20 h-20 bg-gradient-to-br from-pink-500 to-red-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-lg shadow-pink-500/30">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Make a Deal</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">Connect with interested buyers through our
                        messaging system and negotiate the best deal for your project.</p>
                </div>
            </div>

            <!-- CTA Box -->
            <div
                class="mt-16 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSI0Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-30">
                </div>
                <div class="relative z-10">
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Ready to Find a New Home for Your Project?
                    </h3>
                    <p class="text-purple-100 mb-8 max-w-xl mx-auto">Join hundreds of developers who have successfully
                        handed off their side projects.</p>
                    @auth
                        <a href="{{ route('projects.create') }}"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg hover:bg-gray-100 transition shadow-xl">
                            Start Listing Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold text-lg hover:bg-gray-100 transition shadow-xl">
                            Get Started Free
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection