<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::active()
            ->featured()
            ->latest()
            ->take(4)
            ->get();

        $recentProjects = Project::active()
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProjects', 'recentProjects'));
    }

    public function howItWorks()
    {
        return view('how-it-works');
    }

    public function pricing()
    {
        return view('pricing');
    }

    public function about()
    {
        return view('about');
    }
}
