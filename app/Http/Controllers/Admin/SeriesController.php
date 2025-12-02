<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{
    /**
     * Display a listing of series
     */
    public function index(Request $request)
    {
        $query = Series::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // If author, only show their series
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin()) {
            $query->where('author_id', Auth::id());
        }

        $series = $query->withCount('articles')
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.series.index', compact('series'));
    }

    /**
     * Show the form for creating a new series
     */
    public function create()
    {
        return view('admin.series.create');
    }

    /**
     * Store a newly created series
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:article_series,slug',
            'description' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Set defaults
        $validated['author_id'] = Auth::id();
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Series::create($validated);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series created successfully.');
    }

    /**
     * Display the specified series
     */
    public function show(Series $series)
    {
        $series->load(['author', 'articles' => function($query) {
            $query->orderBy('series_order', 'asc');
        }]);
        return view('admin.series.show', compact('series'));
    }

    /**
     * Show the form for editing the specified series
     */
    public function edit(Series $series)
    {
        // Check permission
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin() && $series->author_id !== Auth::id()) {
            abort(403, 'You can only edit your own series.');
        }

        return view('admin.series.edit', compact('series'));
    }

    /**
     * Update the specified series
     */
    public function update(Request $request, Series $series)
    {
        // Check permission
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin() && $series->author_id !== Auth::id()) {
            abort(403, 'You can only edit your own series.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:article_series,slug,' . $series->id,
            'description' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $series->update($validated);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series updated successfully.');
    }

    /**
     * Remove the specified series
     */
    public function destroy(Series $series)
    {
        // Only admins can delete
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can delete series.');
        }

        $series->delete();

        return redirect()->route('admin.series.index')
            ->with('success', 'Series deleted successfully.');
    }
}
