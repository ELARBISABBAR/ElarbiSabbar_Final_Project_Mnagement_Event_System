<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Events::with(['user', 'tickets'])
            ->where('date_start', '>=', now())
            ->orderBy('date_start', 'asc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->where('date_start', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('date_start', '<=', $request->date_to);
        }

        $events = $query->paginate(12);

        // Get unique locations for filter dropdown
        $locations = Events::where('date_start', '>=', now())
            ->distinct()
            ->pluck('location')
            ->map(function($location) {
                return trim(explode(',', $location)[0]); // Get city part
            })
            ->unique()
            ->sort()
            ->values();

        return view("pages.home.home", compact('events', 'locations'));
    }
}
