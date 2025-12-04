<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;
use App\Services\DownloadTokenService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;
    protected $tokenService;

    public function __construct(ArticleService $articleService, DownloadTokenService $tokenService)
    {
        $this->articleService = $articleService;
        $this->tokenService = $tokenService;
    }

    /**
     * Display a listing of articles
     */
    public function index(Request $request)
    {
        $query = Article::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // If author, only show their articles
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin()) {
            $query->where('author_id', Auth::id());
        }

        $articles = $query->with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // Generate token URLs for each article (use permanent token if exists)
        $articles->getCollection()->transform(function ($article) {
            $downloadLink = $article->download_link ?? 'https://mega.nz/file/example#test-link';
            // Use permanent token if exists, otherwise generate temporary one
            if ($article->download_token) {
                $token = $article->download_token;
            } else {
                $token = $this->tokenService->createToken($downloadLink, $article->id, 30);
            }
            $article->token_url = route('articles.show', $article->slug) . '?dl=' . urlencode($token);
            return $article;
        });

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $series = \App\Models\Series::where('is_active', true)->orderBy('title')->get();
        return view('admin.articles.create', compact('categories', 'tags', 'series'));
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
            'download_link' => 'nullable|string|max:1000',
            'download_token' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'series_id' => 'nullable|exists:article_series,id',
            'series_order' => 'nullable|integer|min:1',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|string|in:published,draft,scheduled',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'post_to_facebook' => 'nullable|boolean',
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
        
        // If author (not admin), force author_id to be themselves
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin()) {
            $validated['author_id'] = Auth::id();
        } else {
            $validated['author_id'] = $validated['author_id'] ?? Auth::id();
        }

        // Handle published_at
        if ($validated['status'] === 'scheduled' && $validated['published_at']) {
            $validated['published_at'] = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $article = Article::create($validated);
        
        // Generate permanent token if download_link is provided (after article is created so we have the ID)
        if (!empty($validated['download_link']) && !$article->download_token) {
            $article->download_token = $this->tokenService->createPermanentToken(
                $validated['download_link'],
                $article->id
            );
            $article->save();
        }

        // Attach tags
        if (!empty($tags)) {
            $article->tags()->sync($tags);
        }

        // Create initial revision
        if ($article->exists) {
            $article->createRevision(auth()->id(), 'Initial version');
        }

        // Handle scheduled publishing
        if ($validated['status'] === 'scheduled' && isset($validated['published_at'])) {
            $publishDate = Carbon::parse($validated['published_at']);
            if ($publishDate->isFuture()) {
                \App\Jobs\PublishScheduledArticle::dispatch($article)->delay($publishDate);
            }
        }

        // Post to social media platforms if article is published and user opted in
        if ($validated['status'] === 'published') {
            if (config('services.facebook.enabled', false) && ($request->has('post_to_facebook') && $request->post_to_facebook)) {
                \App\Jobs\PostToFacebookJob::dispatch($article);
            }
            if (config('services.twitter.enabled', false) && ($request->has('post_to_twitter') && $request->post_to_twitter)) {
                \App\Jobs\PostToTwitterJob::dispatch($article);
            }
            if (config('services.instagram.enabled', false) && ($request->has('post_to_instagram') && $request->post_to_instagram)) {
                \App\Jobs\PostToInstagramJob::dispatch($article);
            }
            if (config('services.threads.enabled', false) && ($request->has('post_to_threads') && $request->post_to_threads)) {
                \App\Jobs\PostToThreadsJob::dispatch($article);
            }
        }

        // Clear cache
        $this->articleService->clearCache();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Article saved successfully.',
                'article_id' => $article->id,
            ]);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Auto-save draft
     */
    public function autoSave(Request $request, Article $article = null)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'download_link' => 'nullable|string|max:1000',
            'download_token' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // If article exists, update it; otherwise create new draft
        if ($article) {
            // Check permission
            if (Auth::user()->isAuthor() && !Auth::user()->isAdmin() && $article->author_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $article->update(array_merge($validated, [
                'status' => 'draft', // Always save as draft when auto-saving
            ]));
            
            // Generate permanent token if download_link is provided and token doesn't exist
            if (!empty($validated['download_link']) && !$article->download_token) {
                $article->download_token = $this->tokenService->createPermanentToken(
                    $validated['download_link'],
                    $article->id
                );
                $article->save();
            }
        } else {
            $article = Article::create(array_merge($validated, [
                'author_id' => Auth::id(),
                'status' => 'draft',
            ]));
            
            // Generate permanent token if download_link is provided
            if (!empty($validated['download_link'])) {
                $article->download_token = $this->tokenService->createPermanentToken(
                    $validated['download_link'],
                    $article->id
                );
                $article->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Draft saved successfully.',
            'article_id' => $article->id,
        ]);
    }

    /**
     * Display the specified article
     */
    public function show(Article $article)
    {
        $article->load(['category', 'author', 'tags', 'comments']);
        
        // Use article's download link if available, otherwise use test link
        $downloadLink = $article->download_link ?? 'https://mega.nz/file/example#test-link';
        $isTestLink = empty($article->download_link);
        
        // Use permanent token if exists, otherwise generate a temporary one for display
        if ($article->download_token) {
            $testToken = $article->download_token; // Use permanent token
        } else {
            // Generate a temporary token for display (only if no permanent token exists)
            $testToken = $this->tokenService->createToken($downloadLink, $article->id, 30);
        }
        
        // Generate URLs
        $articleUrl = route('articles.show', $article->slug);
        $articleUrlWithToken = $articleUrl . '?dl=' . urlencode($testToken);
        
        return view('admin.articles.show', compact('article', 'testToken', 'articleUrl', 'articleUrlWithToken', 'downloadLink', 'isTestLink'));
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit(Article $article)
    {
        // Check permission
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin() && $article->author_id !== Auth::id()) {
            abort(403, 'You can only edit your own articles.');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $series = \App\Models\Series::where('is_active', true)->orderBy('title')->get();
        $article->load('tags', 'series');
        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'series'));
    }

    /**
     * Update the specified article
     */
    public function update(Request $request, Article $article)
    {
        // Check permission
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin() && $article->author_id !== Auth::id()) {
            abort(403, 'You can only edit your own articles.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'download_link' => 'nullable|string|max:1000',
            'download_token' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'series_id' => 'nullable|exists:article_series,id',
            'series_order' => 'nullable|integer|min:1',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|string|in:published,draft,scheduled',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'post_to_facebook' => 'nullable|boolean',
            'post_to_twitter' => 'nullable|boolean',
            'post_to_instagram' => 'nullable|boolean',
            'post_to_threads' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // If author (not admin), prevent changing author_id and is_featured
        if (Auth::user()->isAuthor() && !Auth::user()->isAdmin()) {
            $validated['author_id'] = Auth::id();
            $validated['is_featured'] = false; // Authors can't feature their own articles
        }

        // Handle published_at
        if ($validated['status'] === 'scheduled' && $validated['published_at']) {
            $validated['published_at'] = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        // Check for significant changes before updating
        $changedFields = ['title', 'content', 'excerpt'];
        $hasChanges = false;
        foreach ($changedFields as $field) {
            if (isset($validated[$field]) && $article->$field !== $validated[$field]) {
                $hasChanges = true;
                break;
            }
        }

        // Create revision before updating if there are changes
        if ($article->exists && $hasChanges) {
            $article->createRevision(auth()->id());
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        // Generate or update permanent token if download_link is provided/changed
        if (!empty($validated['download_link'])) {
            // Only generate new token if download_link changed or token doesn't exist
            if ($article->download_link !== $validated['download_link'] || !$article->download_token) {
                $validated['download_token'] = $this->tokenService->createPermanentToken(
                    $validated['download_link'],
                    $article->id
                );
            } else {
                // Keep existing token if download_link hasn't changed
                unset($validated['download_token']);
            }
        } elseif (empty($validated['download_link']) && $article->download_link) {
            // If download_link is removed, remove token too
            $validated['download_token'] = null;
        }

        $article->update($validated);

        // Sync tags
        $article->tags()->sync($tags);

        // Handle scheduled publishing
        if ($validated['status'] === 'scheduled' && isset($validated['published_at'])) {
            $publishDate = Carbon::parse($validated['published_at']);
            if ($publishDate->isFuture()) {
                \App\Jobs\PublishScheduledArticle::dispatch($article)->delay($publishDate);
            }
        }

        // Post to social media platforms if article status changed to published and user opted in
        if ($validated['status'] === 'published' && $article->wasChanged('status')) {
            if (config('services.facebook.enabled', false) && ($request->has('post_to_facebook') && $request->post_to_facebook)) {
                \App\Jobs\PostToFacebookJob::dispatch($article->fresh());
            }
            if (config('services.twitter.enabled', false) && ($request->has('post_to_twitter') && $request->post_to_twitter)) {
                \App\Jobs\PostToTwitterJob::dispatch($article->fresh());
            }
            if (config('services.instagram.enabled', false) && ($request->has('post_to_instagram') && $request->post_to_instagram)) {
                \App\Jobs\PostToInstagramJob::dispatch($article->fresh());
            }
            if (config('services.threads.enabled', false) && ($request->has('post_to_threads') && $request->post_to_threads)) {
                \App\Jobs\PostToThreadsJob::dispatch($article->fresh());
            }
        }

        // Clear cache
        $this->articleService->clearCache();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Article saved successfully.',
            ]);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified article
     */
    public function destroy(Article $article)
    {
        // Only admins can delete
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can delete articles.');
        }

        $article->delete();

        // Clear cache
        $this->articleService->clearCache();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
