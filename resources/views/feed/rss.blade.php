<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $title }}</title>
        <link>{{ $link }}</link>
        <description>{{ $description }}</description>
        <language>en-us</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ request()->url() }}" rel="self" type="application/rss+xml"/>
        <generator>{{ config('app.name') }}</generator>
        
        @foreach($articles as $article)
        <item>
            <title><![CDATA[{{ $article->title }}]]></title>
            <link>{{ route('articles.show', $article->slug) }}</link>
            <guid isPermaLink="true">{{ route('articles.show', $article->slug) }}</guid>
            <description><![CDATA[{{ $article->excerpt ?: substr(strip_tags($article->content), 0, 200) }}...]]></description>
            <content:encoded><![CDATA[{{ $article->content }}]]></content:encoded>
            <pubDate>{{ ($article->published_at ?: $article->created_at)->toRssString() }}</pubDate>
            <author>{{ $article->author->email ?? config('mail.from.address') }} ({{ $article->author->name ?? config('app.name') }})</author>
            @if($article->category)
            <category><![CDATA[{{ $article->category->name }}]]></category>
            @endif
            @if($article->featured_image)
            <enclosure url="{{ filter_var($article->featured_image, FILTER_VALIDATE_URL) ? $article->featured_image : url($article->featured_image) }}" type="image/jpeg"/>
            @endif
        </item>
        @endforeach
    </channel>
</rss>

