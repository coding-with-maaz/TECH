<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display a listing of all movies with their servers
     */
    public function index(Request $request)
    {
        $query = Content::where('type', 'movie')
            ->where('status', 'published');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by movies with/without servers
        if ($request->has('has_servers')) {
            if ($request->has_servers === 'yes') {
                $query->whereNotNull('servers')
                      ->where('servers', '!=', '[]');
            } elseif ($request->has_servers === 'no') {
                $query->where(function($q) {
                    $q->whereNull('servers')
                      ->orWhere('servers', '[]');
                });
            }
        }

        $movies = $query->orderBy('title', 'asc')->paginate(20);

        return view('admin.servers.index', compact('movies'));
    }

    /**
     * Show server management page for a specific movie
     */
    public function show(Content $content)
    {
        // Ensure it's a movie
        if ($content->type !== 'movie') {
            return redirect()->route('admin.servers.index')
                ->with('error', 'Server management is only available for movies.');
        }

        // Get normalized servers
        $servers = $content->getNormalizedServers();

        return view('admin.servers.show', compact('content', 'servers'));
    }

    /**
     * Add server to movie
     */
    public function store(Request $request, Content $content)
    {
        // Ensure it's a movie
        if ($content->type !== 'movie') {
            return redirect()->back()->with('error', 'Server management is only available for movies.');
        }

        $validated = $request->validate([
            'server_name' => 'required|string|max:255',
            'quality' => 'nullable|string|max:50',
            'watch_link' => 'nullable|url',
            'download_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $servers = $content->servers ?? [];
        
        // Generate unique ID for server
        $serverId = uniqid('server_', true);
        
        $servers[] = [
            'id' => $serverId,
            'name' => $validated['server_name'],
            'url' => $validated['watch_link'] ?? null,
            'quality' => $validated['quality'] ?? 'HD',
            'download_link' => $validated['download_link'] ?? null,
            'sort_order' => $validated['sort_order'] ?? count($servers),
            'active' => true,
        ];

        // Sort servers by sort_order
        usort($servers, function($a, $b) {
            return ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0);
        });

        $content->update(['servers' => $servers]);

        return redirect()->route('admin.servers.show', $content)
            ->with('success', 'Server added successfully.');
    }

    /**
     * Update server
     */
    public function update(Request $request, Content $content)
    {
        // Ensure it's a movie
        if ($content->type !== 'movie') {
            return redirect()->back()->with('error', 'Server management is only available for movies.');
        }

        $validated = $request->validate([
            'server_id' => 'required|string',
            'server_name' => 'required|string|max:255',
            'quality' => 'nullable|string|max:50',
            'watch_link' => 'nullable|url',
            'download_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $servers = $content->servers ?? [];
        
        foreach ($servers as &$server) {
            if (isset($server['id']) && $server['id'] === $validated['server_id']) {
                $server['name'] = $validated['server_name'];
                $server['url'] = $validated['watch_link'] ?? $server['url'] ?? null;
                $server['quality'] = $validated['quality'] ?? $server['quality'] ?? 'HD';
                $server['download_link'] = $validated['download_link'] ?? $server['download_link'] ?? null;
                $server['sort_order'] = $validated['sort_order'] ?? $server['sort_order'] ?? 0;
                $server['active'] = $validated['is_active'] ?? true;
                break;
            }
        }

        // Sort servers by sort_order
        usort($servers, function($a, $b) {
            return ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0);
        });

        $content->update(['servers' => $servers]);

        return redirect()->route('admin.servers.show', $content)
            ->with('success', 'Server updated successfully.');
    }

    /**
     * Delete server
     */
    public function destroy(Request $request, Content $content)
    {
        // Ensure it's a movie
        if ($content->type !== 'movie') {
            return redirect()->back()->with('error', 'Server management is only available for movies.');
        }

        $validated = $request->validate([
            'server_id' => 'required|string',
        ]);

        $servers = $content->servers ?? [];
        $servers = array_filter($servers, function($server) use ($validated) {
            return !(isset($server['id']) && $server['id'] === $validated['server_id']);
        });

        // Reindex array and reset sort_order
        $servers = array_values($servers);
        foreach ($servers as $index => &$server) {
            $server['sort_order'] = $index;
        }

        $content->update(['servers' => $servers]);

        return redirect()->route('admin.servers.show', $content)
            ->with('success', 'Server deleted successfully.');
    }
}
