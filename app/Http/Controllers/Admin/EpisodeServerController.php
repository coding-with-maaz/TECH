<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Episode;
use App\Models\EpisodeServer;
use Illuminate\Http\Request;

class EpisodeServerController extends Controller
{
    /**
     * Store a newly created server for an episode.
     */
    public function store(Request $request, Content $content, Episode $episode)
    {
        $validated = $request->validate([
            'server_name' => 'required|string|max:255',
            'quality' => 'nullable|string|max:50',
            'download_link' => 'nullable|url',
            'watch_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['episode_id'] = $episode->id;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        EpisodeServer::create($validated);

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Server added successfully.');
    }

    /**
     * Update the specified server.
     */
    public function update(Request $request, Content $content, Episode $episode, EpisodeServer $server)
    {
        $validated = $request->validate([
            'server_name' => 'required|string|max:255',
            'quality' => 'nullable|string|max:50',
            'download_link' => 'nullable|url',
            'watch_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $server->update($validated);

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Server updated successfully.');
    }

    /**
     * Remove the specified server.
     */
    public function destroy(Content $content, Episode $episode, EpisodeServer $server)
    {
        $server->delete();

        return redirect()->route('admin.episodes.index', $content)
            ->with('success', 'Server deleted successfully.');
    }
}

