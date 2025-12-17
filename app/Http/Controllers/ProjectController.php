<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Project::active()->with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tech_stack', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('asking_price', '>=', $request->min_price * 100);
        }
        if ($request->filled('max_price')) {
            $query->where('asking_price', '<=', $request->max_price * 100);
        }

        // Filter by has traffic/revenue
        if ($request->boolean('has_traffic')) {
            $query->whereNotNull('monthly_traffic')->where('monthly_traffic', '>', 0);
        }
        if ($request->boolean('has_revenue')) {
            $query->whereNotNull('total_revenue')->where('total_revenue', '>', 0);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('asking_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('asking_price', 'desc');
                break;
            default:
                $query->latest();
        }

        $projects = $query->paginate(12)->withQueryString();
        $categories = ['saas', 'ecommerce', 'content', 'tool', 'game', 'other'];

        return view('projects.index', compact('projects', 'categories'));
    }

    public function show(Project $project)
    {
        $project->incrementViews();
        $project->load('user');

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        $categories = ['saas', 'ecommerce', 'content', 'tool', 'game', 'other'];
        return view('projects.create', compact('categories'));
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        // Convert price to cents
        $validated['asking_price'] = $validated['asking_price'] * 100;
        if (isset($validated['total_revenue'])) {
            $validated['total_revenue'] = $validated['total_revenue'] * 100;
        }

        $validated['user_id'] = auth()->id();
        $validated['contact_email'] = $validated['contact_email'] ?? auth()->user()->email;

        // Create project and activate immediately (free to list!)
        $validated['status'] = 'active';
        $project = Project::create($validated);

        // Redirect to dashboard with success message
        return redirect()->route('dashboard')->with('success', 'Project listed successfully! It\'s now live in the marketplace.');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $categories = ['saas', 'ecommerce', 'content', 'tool', 'game', 'other'];
        return view('projects.edit', compact('project', 'categories'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validated();

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($project->images) {
                foreach ($project->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        // Convert prices to cents
        if (isset($validated['asking_price'])) {
            $validated['asking_price'] = $validated['asking_price'] * 100;
        }
        if (isset($validated['total_revenue'])) {
            $validated['total_revenue'] = $validated['total_revenue'] * 100;
        }

        $project->update($validated);

        return redirect()->route('dashboard')->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        // Delete images
        if ($project->images) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully!');
    }
}
