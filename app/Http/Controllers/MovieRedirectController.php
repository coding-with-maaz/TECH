<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Article;
use App\Services\DownloadTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieRedirectController extends Controller
{
    protected $tokenService;

    public function __construct(DownloadTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Handle movie download redirect
     * Route: GET /go/{slug}
     */
    public function redirect(Request $request, $slug)
    {
        try {
            // Get movie by slug
            $movie = Movie::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            // Get real download link
            $downloadLink = $movie->download_link;

            // Select article to redirect to
            $article = $this->selectArticle($movie);

            if (!$article) {
                Log::error("No article found for movie redirect: {$movie->slug}");
                return redirect()->route('articles.index')
                    ->with('error', 'Article not found. Please try again.');
            }

            // Create encrypted token
            $token = $this->tokenService->createToken($downloadLink, $movie->id, 30);

            // Increment redirect count
            $movie->incrementRedirects();

            // Redirect to article with download token
            // Format: /articles/{article-slug}?dl={encrypted-token}
            $redirectUrl = route('articles.show', $article->slug) . '?dl=' . urlencode($token);

            Log::info("Movie redirect created", [
                'movie_id' => $movie->id,
                'movie_slug' => $movie->slug,
                'article_id' => $article->id,
                'article_slug' => $article->slug,
                'redirect_url' => $redirectUrl,
            ]);

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            Log::error("Movie redirect failed: " . $e->getMessage(), [
                'slug' => $slug,
                'exception' => $e,
            ]);

            return redirect()->route('articles.index')
                ->with('error', 'Download link not found. Please try again.');
        }
    }

    /**
     * Select article for redirect
     * Priority: 1. Specific article_id, 2. Category-based, 3. Random
     */
    protected function selectArticle(Movie $movie): ?Article
    {
        // 1. If specific article is set, use it
        if ($movie->article_id) {
            $article = Article::published()
                ->where('id', $movie->article_id)
                ->first();
            
            if ($article) {
                return $article;
            }
        }

        // 2. If category is set, get random article from that category
        if ($movie->category_id) {
            $article = Article::published()
                ->where('category_id', $movie->category_id)
                ->inRandomOrder()
                ->first();
            
            if ($article) {
                return $article;
            }
        }

        // 3. Get random published article
        return Article::published()
            ->inRandomOrder()
            ->first();
    }
}

