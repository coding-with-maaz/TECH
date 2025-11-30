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
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Dashboard
            </a>
            <a href="{{ route('admin.seo-pages.create') }}" class="px-4 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                Add New SEO Page
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400">
        {{ session('error') }}
    </div>
    @endif

    <!-- Available Pages Info -->
    <div class="mb-6 bg-blue-50 dark:!bg-blue-900/10 border border-blue-200 dark:!border-blue-800 rounded-lg p-4">
        <p class="text-sm text-blue-800 dark:!text-blue-300" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            <strong>Total Public Pages Available:</strong> {{ count($availablePages) }} | 
            <strong>Configured:</strong> {{ $seoPages->total() }} | 
            <strong>Remaining:</strong> {{ count($availablePages) - $seoPages->total() }}
        </p>
    </div>

    @if($seoPages->count() > 0)
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:!bg-bg-card-hover">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Page Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Page Key</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Meta Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Updated</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:!text-white uppercase tracking-wider" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:!divide-border-secondary">
                    @foreach($seoPages as $seoPage)
                    <tr class="hover:bg-gray-50 dark:!hover:bg-bg-card-hover">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                {{ $seoPage->page_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                <code class="px-2 py-1 bg-gray-100 dark:!bg-bg-card-hover rounded text-xs">{{ $seoPage->page_key }}</code>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                {{ $seoPage->meta_title ? Str::limit($seoPage->meta_title, 50) : '<span class="text-gray-400 italic">Not set</span>' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($seoPage->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:!bg-green-900/20 dark:!text-green-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:!bg-gray-800 dark:!text-gray-400" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:!text-text-tertiary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            {{ $seoPage->updated_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.seo-pages.edit', $seoPage) }}" class="text-indigo-600 hover:text-indigo-900 dark:!text-indigo-400 dark:!hover:text-indigo-300" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Edit</a>
                                <form action="{{ route('admin.seo-pages.destroy', $seoPage) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this SEO page?');">
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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $seoPages->links() }}
    </div>
    @else
    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-12 text-center">
        <p class="text-gray-600 dark:!text-text-secondary text-lg mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">No SEO pages configured yet.</p>
        <p class="text-gray-500 dark:!text-text-tertiary text-sm mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            You have {{ count($availablePages) }} public pages available for SEO configuration.
        </p>
        <a href="{{ route('admin.seo-pages.create') }}" class="inline-block px-6 py-3 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
            Create First SEO Page
        </a>
    </div>
    @endif
</div>
@endsection

