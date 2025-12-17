@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-lg shadow-md p-12">
        <div class="text-green-600 text-6xl mb-4">✓</div>
        <h1 class="text-3xl font-bold mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">Your project has been activated and is now live in the marketplace.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Go to Dashboard
            </a>
            <a href="{{ route('projects.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Browse Projects
            </a>
        </div>
    </div>
</div>
@endsection
