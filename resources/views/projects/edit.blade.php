@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6">Edit Project</h1>
        <p class="text-gray-600 mb-8">Update your project details below.</p>
        
        <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" required class="w-full border border-gray-300 rounded-md px-4 py-2 @error('title') border-red-500 @enderror">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Short Description * (max 500 chars)</label>
                <textarea name="description" required maxlength="500" rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2 @error('description') border-red-500 @enderror">{{ old('description', $project->description) }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" required class="w-full border border-gray-300 rounded-md px-4 py-2 @error('category') border-red-500 @enderror">
                    <option value="">Select a category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $project->category) === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Story * (Why did you abandon it? Max 1000 chars)</label>
                <textarea name="story" required maxlength="1000" rows="5" class="w-full border border-gray-300 rounded-md px-4 py-2 @error('story') border-red-500 @enderror">{{ old('story', $project->story) }}</textarea>
                @error('story')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Asking Price (USD) *</label>
                    <input type="number" name="asking_price" value="{{ old('asking_price', $project->asking_price / 100) }}" min="0" step="0.01" required class="w-full border border-gray-300 rounded-md px-4 py-2 @error('asking_price') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Enter 0 for free</p>
                    @error('asking_price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Domain (optional)</label>
                    <input type="text" name="domain" value="{{ old('domain', $project->domain) }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tech Stack (optional)</label>
                <input type="text" name="tech_stack" value="{{ old('tech_stack', $project->tech_stack) }}" placeholder="e.g. Laravel, React, PostgreSQL" class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Traffic (optional)</label>
                    <input type="number" name="monthly_traffic" value="{{ old('monthly_traffic', $project->monthly_traffic) }}" min="0" class="w-full border border-gray-300 rounded-md px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Revenue (USD, optional)</label>
                    <input type="number" name="total_revenue" value="{{ old('total_revenue', $project->total_revenue ? $project->total_revenue / 100 : '') }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-md px-4 py-2">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Images (optional, max 5MB each)</label>
                @if($project->images && count($project->images) > 0)
                    <div class="mb-2 text-sm text-gray-600">
                        Current images: {{ count($project->images) }} file(s)
                    </div>
                @endif
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border border-gray-300 rounded-md px-4 py-2">
                <p class="text-sm text-gray-500 mt-1">Upload new images to replace existing ones</p>
                @error('images.*')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email (optional, defaults to your account email)</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $project->contact_email) }}" class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition">
                    Update Project
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md font-semibold hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
