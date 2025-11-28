@extends('layouts.app')

@section('title', 'Manage Episodes - ' . $content->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Manage Episodes - {{ $content->title }}
            </h1>
            <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Add and manage episodes for this TV show
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.contents.edit', $content) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Back to Content
            </a>
            <a href="{{ route('admin.episodes.create', $content) }}" class="px-4 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Add Episode
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400">
        {{ session('success') }}
    </div>
    @endif

    @if($episodes->count() > 0)
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:!bg-bg-card-hover">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Episode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Servers</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:!divide-border-secondary">
                    @foreach($episodes as $episode)
                    <tr class="hover:bg-gray-50 dark:!hover:bg-bg-card-hover">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                E{{ $episode->episode_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $episode->title }}
                            </div>
                            @if($episode->description)
                            <div class="text-xs text-gray-500 dark:!text-text-tertiary mt-1 line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ Str::limit($episode->description, 100) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $episode->servers->count() }} server(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($episode->is_published)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:!bg-green-900/20 dark:!text-green-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Published</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:!bg-gray-800 dark:!text-gray-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.episodes.edit', [$content, $episode]) }}" class="text-blue-600 hover:text-blue-900 dark:!text-blue-400 dark:!hover:text-blue-300" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Edit</a>
                                <form action="{{ route('admin.episodes.destroy', [$content, $episode]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this episode?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:!text-red-400 dark:!hover:text-red-300" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-12 text-center">
        <p class="text-gray-600 dark:!text-text-secondary text-lg mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">No episodes added yet.</p>
        <a href="{{ route('admin.episodes.create', $content) }}" class="inline-block px-6 py-3 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
            Add First Episode
        </a>
    </div>
    @endif
</div>
@endsection

