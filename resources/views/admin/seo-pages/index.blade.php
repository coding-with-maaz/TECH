@extends('layouts.app')

@section('title', 'SEO Pages Management - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary dark:!hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    ← Dashboard
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                SEO Pages Management
            </h1>
            <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Manage SEO settings for all public pages
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.seo-pages.create') }}" class="px-4 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Add SEO Page
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:!bg-green-900/20 dark:!border-green-800 dark:!text-green-400" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
        {{ session('success') }}
    </div>
    @endif

    <!-- Available Pages Info -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:!bg-blue-900/20 dark:!border-blue-800">
        <p class="text-sm text-blue-700 dark:!text-blue-300" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            <strong>Available Pages:</strong> {{ implode(', ', array_keys($availablePages)) }}
        </p>
    </div>

    <!-- SEO Pages Table -->
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:!divide-border-secondary">
                <thead class="bg-gray-50 dark:!bg-bg-card-hover">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Page Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Page Key</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Meta Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:!bg-bg-card divide-y divide-gray-200 dark:!divide-border-secondary">
                    @forelse($seoPages as $seoPage)
                    <tr class="hover:bg-gray-50 dark:!hover:bg-bg-card-hover transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $seoPage->page_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                <code class="bg-gray-100 dark:!bg-bg-card-hover px-2 py-1 rounded text-xs">{{ $seoPage->page_key }}</code>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:!text-white line-clamp-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $seoPage->meta_title ?: 'Not set' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($seoPage->is_active)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:!bg-green-900/20 dark:!text-green-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Active
                            </span>
                            @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:!bg-gray-700 dark:!text-gray-300" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.seo-pages.edit', $seoPage) }}" class="text-accent hover:text-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.seo-pages.destroy', $seoPage) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this SEO page?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No SEO pages found. <a href="{{ route('admin.seo-pages.create') }}" class="text-accent hover:underline">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($seoPages->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:!border-border-secondary">
            {{ $seoPages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

