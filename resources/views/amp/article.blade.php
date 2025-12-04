<!doctype html>
<html ⚡ lang="en">
<head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <title>{{ $seo['title'] }}</title>
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="description" content="{{ $seo['description'] }}">
    
    <!-- AMP Boilerplate -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    
    <!-- AMP Components -->
    <script async custom-element="amp-img" src="https://cdn.ampproject.org/v0/amp-img-0.1.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    
    <!-- Structured Data -->
    @if(!empty($seo['schema']))
        @foreach($seo['schema'] as $schema)
        <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endforeach
    @endif
    
    <style amp-custom>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        .article-header {
            margin-bottom: 30px;
        }
        .article-title {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }
        .article-meta {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 20px;
        }
        .article-content {
            font-size: 1.1em;
            line-height: 1.8;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
        }
        .article-content h1, .article-content h2, .article-content h3 {
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .article-content p {
            margin-bottom: 15px;
        }
        .article-content code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .article-content pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .category-badge {
            display: inline-block;
            background: #E50914;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .tags {
            margin-top: 20px;
        }
        .tag {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <article>
        <header class="article-header">
            @if($article->category)
                <a href="{{ route('categories.show', $article->category->slug) }}" class="category-badge">
                    {{ $article->category->name }}
                </a>
            @endif
            
            <h1 class="article-title">{{ $article->title }}</h1>
            
            <div class="article-meta">
                @if($article->author)
                    <span>By {{ $article->author->name }}</span>
                @endif
                @if($article->published_at)
                    <span> • {{ $article->published_at->format('M d, Y') }}</span>
                @endif
                @if($article->reading_time)
                    <span> • {{ $article->reading_time }} min read</span>
                @endif
            </div>
            
            @if($article->featured_image)
                @php
                    $imageUrl = str_starts_with($article->featured_image, 'http') 
                        ? $article->featured_image 
                        : asset('storage/' . $article->featured_image);
                @endphp
                <amp-img src="{{ $imageUrl }}" 
                         alt="{{ $article->title }}"
                         width="800"
                         height="450"
                         layout="responsive">
                </amp-img>
            @endif
            
            @if($article->tags->count() > 0)
                <div class="tags">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="tag">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </header>
        
        <div class="article-content">
            {!! $article->rendered_content !!}
        </div>
        
        <!-- Social Share -->
        <div style="margin-top: 30px;">
            <amp-social-share type="twitter" width="40" height="40"></amp-social-share>
            <amp-social-share type="facebook" width="40" height="40" data-param-app_id=""></amp-social-share>
            <amp-social-share type="linkedin" width="40" height="40"></amp-social-share>
        </div>
        
        <footer style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="color: #666; font-size: 0.9em;">
                <a href="{{ route('articles.show', $article->slug) }}" style="color: #E50914;">
                    View original article
                </a>
            </p>
        </footer>
    </article>
</body>
</html>
