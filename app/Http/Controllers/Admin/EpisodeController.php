<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Episode;
use App\Models\EpisodeServer;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * Display a listing of episodes for a content.
     */
    public function index(Content $content)
    {
        $episodes = $content->episodes()->orderBy('episode_number')->get();
        return view('admin.episodes.index', compact('content', 'episodes'));
    }

    /**
     * Show the form for creating a new episode.
     */
    public function create(Content $content)
    {
        return view('admin.episodes.create', compact('content'));
    }

    /**
     * Store a newly created episode.
     */
    public function store(Request $request, Content $content)
    {
        $validated = $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_path' => 'nullable|string',
            'air_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['content_id'] = $content->id;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        
        // Check if episode number already exists
        $existingEpisode = Episode::where('content_id', $content->id)
            ->where('episode_number', $validated['episode_number'])
            ->first();
        
        if ($existingEpisode) {
            return back()->withInput()->withErrors(['episode_number' => 'Episode number already exists for this content.']);
        }

        Episode::create($validated);

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Episode created successfully.');
    }

    /**
     * Show the form for editing the specified episode.
     */
    public function edit(Content $content, Episode $episode)
    {
        return view('admin.episodes.edit', compact('content', 'episode'));
    }

    /**
     * Update the specified episode.
     */
    public function update(Request $request, Content $content, Episode $episode)
    {
        $validated = $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_path' => 'nullable|string',
            'air_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Check if episode number already exists (excluding current episode)
        $existingEpisode = Episode::where('content_id', $content->id)
            ->where('episode_number', $validated['episode_number'])
            ->where('id', '!=', $episode->id)
            ->first();
        
        if ($existingEpisode) {
            return back()->withInput()->withErrors(['episode_number' => 'Episode number already exists for this content.']);
        }

        $episode->update($validated);

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Episode updated successfully.');
    }

    /**
     * Remove the specified episode.
     */
    public function destroy(Content $content, Episode $episode)
    {
        $episode->delete();

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Episode deleted successfully.');
    }
}

