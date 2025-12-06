<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class RssFeedController extends Controller
{
    /**
     * Display the main RSS feed
     */
    public function index()
    {
        $articles = Article::published()
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()
            ->view('feed.rss', [
                'articles' => $articles,
                'title' => config('app.name') . ' - Latest Articles',
                'description' => 'Latest articles from ' . config('app.name'),
                'link' => route('home'),
            ])
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    /**
     * Display RSS feed for a specific category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()
            ->view('feed.rss', [
                'articles' => $articles,
                'title' => config('app.name') . ' - ' . $category->name,
                'description' => 'Latest articles in ' . $category->name . ' from ' . config('app.name'),
                'link' => route('categories.show', $category->slug),
            ])
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    /**
     * Display RSS feed for a specific author
     */
    public function author($username)
    {
        $author = User::where('username', $username)->where('is_author', true)->firstOrFail();

        $articles = Article::published()
            ->where('author_id', $author->id)
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()
            ->view('feed.rss', [
                'articles' => $articles,
                'title' => config('app.name') . ' - Articles by ' . $author->name,
                'description' => 'Latest articles by ' . $author->name . ' from ' . config('app.name'),
                'link' => route('profile.show', $author->username),
            ])
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }
}
