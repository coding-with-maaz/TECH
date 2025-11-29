<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seoPages = SeoPage::orderBy('page_name', 'asc')->paginate(20);
        $availablePages = SeoPage::getAvailablePageKeys();
        
        return view('admin.seo-pages.index', compact('seoPages', 'availablePages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availablePages = SeoPage::getAvailablePageKeys();
        $existingPageKeys = SeoPage::pluck('page_key')->toArray();
        $availablePages = array_diff_key($availablePages, array_flip($existingPageKeys));
        
        return view('admin.seo-pages.create', compact('availablePages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_key' => 'required|string|unique:seo_pages,page_key|max:255',
            'page_name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'og_url' => 'nullable|url|max:500',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|url|max:500',
            'canonical_url' => 'nullable|url|max:500',
            'schema_markup' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;
        
        // Handle schema_markup - convert JSON string to array if provided
        if (isset($validated['schema_markup']) && is_string($validated['schema_markup'])) {
            $decoded = json_decode($validated['schema_markup'], true);
            $validated['schema_markup'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        SeoPage::create($validated);

        return redirect()->route('admin.seo-pages.index')
            ->with('success', 'SEO page created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeoPage $seoPage)
    {
        return view('admin.seo-pages.edit', compact('seoPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeoPage $seoPage)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'og_url' => 'nullable|url|max:500',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|url|max:500',
            'canonical_url' => 'nullable|url|max:500',
            'schema_markup' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;
        
        // Handle schema_markup - convert JSON string to array if provided
        if (isset($validated['schema_markup']) && is_string($validated['schema_markup'])) {
            $decoded = json_decode($validated['schema_markup'], true);
            $validated['schema_markup'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        $seoPage->update($validated);

        return redirect()->route('admin.seo-pages.index')
            ->with('success', 'SEO page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoPage $seoPage)
    {
        $seoPage->delete();

        return redirect()->route('admin.seo-pages.index')
            ->with('success', 'SEO page deleted successfully.');
    }
}

