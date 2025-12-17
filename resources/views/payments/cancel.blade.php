@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-lg shadow-md p-12">
        <div class="text-red-600 text-6xl mb-4">✕</div>
        <h1 class="text-3xl font-bold mb-4">Payment Cancelled</h1>
        <p class="text-gray-600 mb-8">Your payment was cancelled. Your project is still in draft mode.</p>
        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Back to Dashboard
        </a>
    </div>
</div>
@endsection
