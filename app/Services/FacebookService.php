<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookService
{
    protected $pageId;
    protected $accessToken;
    protected $apiVersion;

    public function __construct()
    {
        $this->pageId = config('services.facebook.page_id');
        $this->accessToken = config('services.facebook.page_access_token');
        $this->apiVersion = config('services.facebook.api_version', 'v18.0');
    }

    /**
     * Check if Facebook integration is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->pageId) && !empty($this->accessToken);
    }

    /**
     * Post article to Facebook page
     */
    public function postArticle($article): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Facebook integration is not configured. Please set up Facebook credentials in admin settings.',
            ];
        }

        try {
            $url = route('articles.show', $article->slug);
            $message = $this->buildMessage($article);
            $imageUrl = $this->getImageUrl($article);

            // Build the post data
            $postData = [
                'message' => $message,
                'link' => $url,
            ];

            // Add image if available
            if ($imageUrl) {
                $postData['picture'] = $imageUrl;
            }

            // Post to Facebook page
            $response = Http::post(
                "https://graph.facebook.com/{$this->apiVersion}/{$this->pageId}/feed",
                array_merge($postData, [
                    'access_token' => $this->accessToken,
                ])
            );

            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info('Article posted to Facebook successfully', [
                    'article_id' => $article->id,
                    'article_title' => $article->title,
                    'facebook_post_id' => $responseData['id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Article posted to Facebook successfully.',
                    'post_id' => $responseData['id'] ?? null,
                ];
            } else {
                $error = $response->json();
                
                Log::error('Failed to post article to Facebook', [
                    'article_id' => $article->id,
                    'error' => $error,
                ]);

                return [
                    'success' => false,
                    'message' => $error['error']['message'] ?? 'Failed to post to Facebook.',
                    'error' => $error,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception while posting to Facebook', [
                'article_id' => $article->id,
                'exception' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while posting to Facebook: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Build the message for Facebook post
     */
    protected function buildMessage($article): string
    {
        $message = "📝 {$article->title}\n\n";
        
        if ($article->excerpt) {
            $message .= $article->excerpt . "\n\n";
        }
        
        $message .= "Read more: " . route('articles.show', $article->slug);
        
        // Add category if available
        if ($article->category) {
            $message .= "\n\n#{$article->category->name}";
        }
        
        // Add tags if available
        if ($article->tags->isNotEmpty()) {
            $tags = $article->tags->take(3)->pluck('name')->map(fn($tag) => "#{$tag}")->implode(' ');
            if ($tags) {
                $message .= " {$tags}";
            }
        }
        
        return $message;
    }

    /**
     * Get image URL for the article
     */
    protected function getImageUrl($article): ?string
    {
        if (!$article->featured_image) {
            return null;
        }

        // If it's already a full URL, return it
        if (filter_var($article->featured_image, FILTER_VALIDATE_URL)) {
            return $article->featured_image;
        }

        // Otherwise, make it a full URL
        return url($article->featured_image);
    }

    /**
     * Verify Facebook access token
     */
    public function verifyToken(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Facebook integration is not configured.',
            ];
        }

        try {
            $response = Http::get(
                "https://graph.facebook.com/{$this->apiVersion}/me",
                [
                    'access_token' => $this->accessToken,
                    'fields' => 'id,name',
                ]
            );

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Facebook token is valid.',
                    'page_info' => $response->json(),
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid Facebook access token.',
                    'error' => $response->json(),
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error verifying token: ' . $e->getMessage(),
            ];
        }
    }
}

