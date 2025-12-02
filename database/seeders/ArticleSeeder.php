<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create an author
        $author = User::firstOrCreate(
            ['email' => 'admin@techblog.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'is_author' => true,
                'role' => 'admin',
            ]
        );

        // Get categories
        $programmingCategory = Category::where('slug', 'programming')->first();
        $webDevCategory = Category::where('slug', 'web-development')->first();
        $aiCategory = Category::where('slug', 'artificial-intelligence')->first();

        // Get some tags
        $laravelTag = Tag::where('slug', 'laravel')->first();
        $phpTag = Tag::where('slug', 'php')->first();
        $javascriptTag = Tag::where('slug', 'javascript')->first();
        $reactTag = Tag::where('slug', 'react')->first();
        $pythonTag = Tag::where('slug', 'python')->first();

        $articles = [
            [
                'title' => 'Getting Started with Laravel 12',
                'slug' => 'getting-started-with-laravel-12',
                'excerpt' => 'Learn the fundamentals of Laravel 12, the latest version of the popular PHP framework. This comprehensive guide covers installation, routing, controllers, and more.',
                'content' => self::getLaravelArticleContent(),
                'category_id' => $programmingCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(2),
                'featured_image' => 'https://via.placeholder.com/1200x630?text=Laravel+12',
            ],
            [
                'title' => 'Building Modern Web Applications with React',
                'slug' => 'building-modern-web-applications-with-react',
                'excerpt' => 'Discover how to build scalable and maintainable web applications using React. Learn about components, hooks, state management, and best practices.',
                'content' => self::getReactArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(5),
                'featured_image' => 'https://via.placeholder.com/1200x630?text=React+Development',
            ],
            [
                'title' => 'Introduction to Machine Learning with Python',
                'slug' => 'introduction-to-machine-learning-with-python',
                'excerpt' => 'A beginner-friendly guide to machine learning using Python. Learn about data preprocessing, model training, and evaluation techniques.',
                'content' => self::getMLArticleContent(),
                'category_id' => $aiCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subWeek(),
                'featured_image' => 'https://via.placeholder.com/1200x630?text=Machine+Learning',
            ],
            [
                'title' => 'Mastering JavaScript ES6+ Features',
                'slug' => 'mastering-javascript-es6-features',
                'excerpt' => 'Explore the powerful features introduced in ES6 and beyond. Learn about arrow functions, destructuring, async/await, and more modern JavaScript concepts.',
                'content' => self::getJavaScriptArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(10),
                'featured_image' => 'https://via.placeholder.com/1200x630?text=JavaScript+ES6',
            ],
        ];

        foreach ($articles as $articleData) {
            $article = Article::firstOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );

            // Attach tags based on article
            if ($article->slug === 'getting-started-with-laravel-12' && $laravelTag && $phpTag) {
                $article->tags()->syncWithoutDetaching([$laravelTag->id, $phpTag->id]);
            } elseif ($article->slug === 'building-modern-web-applications-with-react' && $reactTag && $javascriptTag) {
                $article->tags()->syncWithoutDetaching([$reactTag->id, $javascriptTag->id]);
            } elseif ($article->slug === 'introduction-to-machine-learning-with-python' && $pythonTag) {
                $article->tags()->syncWithoutDetaching([$pythonTag->id]);
            } elseif ($article->slug === 'mastering-javascript-es6-features' && $javascriptTag) {
                $article->tags()->syncWithoutDetaching([$javascriptTag->id]);
            }

            $this->command->info("Created article: {$article->title}");
        }

        $this->command->info('✅ Articles seeded successfully!');
    }

    private static function getLaravelArticleContent(): string
    {
        return <<<'HTML'
<h2>Introduction</h2>
<p>Laravel 12 is the latest version of the popular PHP framework, bringing new features and improvements to help developers build better applications faster.</p>

<h2>Installation</h2>
<p>To get started with Laravel 12, you can install it using Composer:</p>
<pre><code>composer create-project laravel/laravel my-project</code></pre>

<h2>Key Features</h2>
<ul>
    <li>Improved performance and speed</li>
    <li>Enhanced security features</li>
    <li>Better developer experience</li>
    <li>Modern PHP 8.2+ support</li>
</ul>

<h2>Conclusion</h2>
<p>Laravel 12 continues to be one of the best PHP frameworks for building modern web applications. Start your journey today!</p>
HTML;
    }

    private static function getReactArticleContent(): string
    {
        return <<<'HTML'
<h2>Why React?</h2>
<p>React has become the go-to library for building user interfaces. Its component-based architecture makes it easy to build and maintain complex applications.</p>

<h2>Core Concepts</h2>
<p>Understanding React's core concepts is essential:</p>
<ul>
    <li>Components and Props</li>
    <li>State Management</li>
    <li>Hooks (useState, useEffect, etc.)</li>
    <li>Event Handling</li>
</ul>

<h2>Best Practices</h2>
<p>Follow these best practices to write better React code:</p>
<ul>
    <li>Keep components small and focused</li>
    <li>Use functional components with hooks</li>
    <li>Implement proper error boundaries</li>
    <li>Optimize performance with memoization</li>
</ul>
HTML;
    }

    private static function getMLArticleContent(): string
    {
        return <<<'HTML'
<h2>What is Machine Learning?</h2>
<p>Machine Learning is a subset of artificial intelligence that enables computers to learn and make decisions from data without being explicitly programmed.</p>

<h2>Getting Started</h2>
<p>Python is the most popular language for machine learning. Start by installing essential libraries:</p>
<pre><code>pip install numpy pandas scikit-learn matplotlib</code></pre>

<h2>Basic Workflow</h2>
<ol>
    <li>Data Collection and Preprocessing</li>
    <li>Feature Selection</li>
    <li>Model Training</li>
    <li>Model Evaluation</li>
    <li>Prediction</li>
</ol>
HTML;
    }

    private static function getJavaScriptArticleContent(): string
    {
        return <<<'HTML'
<h2>ES6 and Beyond</h2>
<p>Modern JavaScript has evolved significantly with ES6 and subsequent versions, introducing powerful features that make development more efficient.</p>

<h2>Key Features</h2>
<ul>
    <li><strong>Arrow Functions:</strong> Concise function syntax</li>
    <li><strong>Destructuring:</strong> Extract values from arrays and objects</li>
    <li><strong>Template Literals:</strong> Enhanced string interpolation</li>
    <li><strong>Async/Await:</strong> Better asynchronous programming</li>
    <li><strong>Modules:</strong> Import and export functionality</li>
</ul>

<h2>Examples</h2>
<p>Here's an example of arrow functions and destructuring:</p>
<pre><code>const greet = (name) => `Hello, ${name}!`;
const { firstName, lastName } = user;</code></pre>
HTML;
    }
}

