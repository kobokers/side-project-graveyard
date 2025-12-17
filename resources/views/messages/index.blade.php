@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 h-[calc(100vh-5rem)]">
    @if($conversations->isEmpty())
        <!-- Empty State (No Conversations at all) -->
        <div class="h-full flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center max-w-lg w-full">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">No messages yet</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8">When you contact sellers about projects, conversations will appear here.</p>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-xl font-semibold hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-md hover:shadow-lg">
                    Browse Projects
                </a>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden h-full flex border border-gray-200 dark:border-gray-800">
            <!-- Sidebar (List) -->
            <div class="w-full md:w-1/3 lg:w-1/4 min-w-[300px] flex-shrink-0 h-full">
                @include('messages.sidebar', ['conversations' => $conversations])
            </div>

            <!-- Main Area (Placeholder) -->
            <div class="hidden md:flex flex-1 flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 p-8 text-center border-l border-gray-200 dark:border-gray-800 relative">
                 <!-- Background Decoration -->
                 <div class="absolute inset-0 opacity-5 pointer-events-none">
                     <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                         <pattern id="grid" width="4" height="4" patternUnits="userSpaceOnUse">
                             <circle cx="1" cy="1" r="1" />
                         </pattern>
                         <rect width="100%" height="100%" fill="url(#grid)" />
                     </svg>
                 </div>

                <div class="relative z-10 max-w-md">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-800 dark:to-gray-700 rounded-full mx-auto mb-6 flex items-center justify-center shadow-inner">
                        <svg class="w-12 h-12 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">Your Messages</h2>
                    <p class="text-gray-500 dark:text-gray-400">Select a conversation from the list to view details and start chatting.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
