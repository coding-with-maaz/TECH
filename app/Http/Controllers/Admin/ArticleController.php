<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of articles
     */
    public function index(Request $request)
    {
        $query = Article::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->with(['category', 'author', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|string|in:published,draft,scheduled',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Set defaults
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        $validated['allow_comments'] = $validated['allow_comments'] ?? true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['author_id'] = $validated['author_id'] ?? auth()->id();

        // Handle published_at
        if ($validated['status'] === 'scheduled' && $validated['published_at']) {
            $validated['published_at'] = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $article = Article::create($validated);

        // Attach tags
        if (!empty($tags)) {
            $article->tags()->sync($tags);
        }

        // Clear cache
        $this->articleService->clearCache();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified article
     */
    public function show(Article $article)
    {
        $article->load(['category', 'author', 'tags', 'comments']);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit(Article $article)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $article->load('tags');
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified article
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|string|in:published,draft,scheduled',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Handle published_at
        if ($validated['status'] === 'scheduled' && $validated['published_at']) {
            $validated['published_at'] = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $article->update($validated);

        // Sync tags
        $article->tags()->sync($tags);

        // Clear cache
        $this->articleService->clearCache();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified article
     */
    public function destroy(Article $article)
    {
        $article->delete();

        // Clear cache
        $this->articleService->clearCache();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}

