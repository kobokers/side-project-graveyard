<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()
            ->latest()
            ->with('transactions')
            ->get();

        $purchasedProjects = \App\Models\Offer::where('buyer_id', auth()->id())
            ->whereIn('status', ['paid', 'transferred', 'completed'])
            ->with('project', 'seller')
            ->latest()
            ->get();

        $soldProjects = \App\Models\Offer::where('seller_id', auth()->id())
            ->whereIn('status', ['paid', 'transferred', 'completed'])
            ->with('project', 'buyer')
            ->latest()
            ->get();

        return view('dashboard.index', compact('projects', 'purchasedProjects', 'soldProjects'));
    }
}
