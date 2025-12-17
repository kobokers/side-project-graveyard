@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-4xl font-bold mb-8">How It Works</h1>
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="space-y-8">
            <div>
                <h2 class="text-2xl font-bold mb-4">For Sellers</h2>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Create an account (free)</li>
                    <li>List your project (completely free - no payment required)</li>
                    <li>Your project goes live immediately in our marketplace</li>
                    <li>Optional: Upgrade to featured listing for $25/month for better visibility</li>
                    <li>Connect with interested buyers directly via email</li>
                    <li>When a deal is made, we charge a 5% commission on the final sale price</li>
                </ol>
                <div class="mt-4 p-4 bg-green-50 rounded-md">
                    <p class="text-sm text-green-800 font-semibold">No upfront costs! You only pay when you successfully sell.</p>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-4">For Buyers</h2>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Browse projects for free</li>
                    <li>Filter by category, price, traffic, and revenue</li>
                    <li>View detailed information about each project</li>
                    <li>Contact sellers directly via email</li>
                    <li>Negotiate and close the deal</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
