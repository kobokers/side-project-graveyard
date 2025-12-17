@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-4xl font-bold mb-8 text-center">Pricing</h1>
    
    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-8 mb-8 text-center">
        <h2 class="text-3xl font-bold mb-4">List Projects for FREE! 🎉</h2>
        <p class="text-xl text-gray-700 mb-2">No upfront costs. No hidden fees.</p>
        <p class="text-gray-600">We only succeed when you succeed.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-4">Commission Model</h2>
            <p class="text-5xl font-bold text-blue-600 mb-4">5%</p>
            <p class="text-gray-600 mb-6">Commission on successful deals only</p>
            <ul class="space-y-3 text-gray-700">
                <li>✓ <strong>Free to list</strong> - no upfront payment</li>
                <li>✓ <strong>Unlimited listings</strong> - post as many as you want</li>
                <li>✓ <strong>Pay when sold</strong> - 5% commission on final sale price</li>
                <li>✓ <strong>Full project details</strong> and exposure</li>
                <li>✓ <strong>Direct buyer contact</strong> via email</li>
            </ul>
            <div class="mt-6 p-4 bg-gray-50 rounded-md">
                <p class="text-sm text-gray-600">
                    <strong>Example:</strong> If you sell a project for $1,000, we charge a 5% commission ($50). You keep $950!
                </p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-8 border-2 border-purple-500">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">Featured Listing</h2>
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">Optional</span>
            </div>
            <p class="text-5xl font-bold text-purple-600 mb-4">$25</p>
            <p class="text-gray-600 mb-6">Per 30 days</p>
            <ul class="space-y-3 text-gray-700">
                <li>✓ All free listing features</li>
                <li>✓ <strong>Homepage prominence</strong> - top position</li>
                <li>✓ <strong>Featured badge</strong> - stand out</li>
                <li>✓ <strong>Higher visibility</strong> - more views</li>
                <li>✓ <strong>Priority in search</strong> results</li>
            </ul>
            <div class="mt-6 p-4 bg-purple-50 rounded-md">
                <p class="text-sm text-gray-600">
                    Boost your chances of selling with premium placement. Can be added anytime from your dashboard.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-12 bg-blue-50 rounded-lg p-8">
        <h3 class="text-2xl font-bold mb-4 text-center">Why Commission-Based?</h3>
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div>
                <div class="text-4xl mb-2">💰</div>
                <h4 class="font-bold mb-2">No Risk</h4>
                <p class="text-gray-600 text-sm">You only pay if you successfully sell your project</p>
            </div>
            <div>
                <div class="text-4xl mb-2">🚀</div>
                <h4 class="font-bold mb-2">List Immediately</h4>
                <p class="text-gray-600 text-sm">Get your project live in minutes without payment barriers</p>
            </div>
            <div>
                <div class="text-4xl mb-2">🤝</div>
                <h4 class="font-bold mb-2">Aligned Incentives</h4>
                <p class="text-gray-600 text-sm">We're motivated to help you sell successfully</p>
            </div>
        </div>
    </div>
</div>
@endsection
