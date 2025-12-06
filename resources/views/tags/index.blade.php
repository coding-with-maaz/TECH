@extends('layouts.app')

@section('title', 'Tags - HARPALJOB TECH')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Tags
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Browse articles by tags
        </p>
    </div>

    <div class="flex flex-wrap gap-3">
        @forelse($tags as $tag)
            <a href="{{ route('tags.show', $tag->slug) }}" class="group px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-accent hover:text-white hover:border-accent transition-all dark:!bg-bg-card dark:!border-border-secondary dark:!hover:bg-accent">
                <span class="text-sm font-semibold text-gray-700 dark:!text-white group-hover:text-white transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    {{ $tag->name }}
                </span>
                <span class="ml-2 text-xs text-gray-500 dark:!text-text-secondary group-hover:text-white/80" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    ({{ number_format($tag->articles_count ?? 0) }})
                </span>
            </a>
        @empty
            <div class="w-full text-center py-16">
                <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    No tags found.
                </p>
            </div>
        @endforelse
    </div>

    @if($tags->hasPages())
    <div class="mt-8">
        {{ $tags->links() }}
    </div>
    @endif
</div>
@endsection

