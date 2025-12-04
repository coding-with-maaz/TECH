@extends('layouts.app')

@section('title', 'Create Article - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.articles.index') }}" class="text-gray-600 hover:text-accent dark:!text-text-secondary dark:!hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    ← Back to Articles
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Create New Article
            </h1>
            <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Add a new article to your tech blog
            </p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
        <form action="{{ route('admin.articles.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="Enter article title">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Slug
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="auto-generated-from-title">
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">Leave empty to auto-generate from title</p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Excerpt
                        </label>
                        <textarea name="excerpt" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                  placeholder="Short description of the article">{{ old('excerpt') }}</textarea>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" id="content" class="tinymce-editor w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                  placeholder="Write your article content here...">{!! old('content') !!}</textarea>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Featured Image URL
                        </label>
                        <input type="text" name="featured_image" value="{{ old('featured_image') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="https://example.com/image.jpg or /storage/image.jpg">
                    </div>

                    <!-- Download Link -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Download Link (Optional)
                        </label>
                        <input type="text" name="download_link" value="{{ old('download_link') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="https://mega.nz/file/... or https://drive.google.com/...">
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">
                            Optional: Add a download link for this article. This will be used when generating download tokens.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <!-- Published At -->
                    <div id="published_at_field" style="display: none;">
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Publish Date & Time
                        </label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Category
                        </label>
                        <select name="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                            <option value="">No Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Series -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Series
                        </label>
                        <select name="series_id" id="series_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                            <option value="">No Series</option>
                            @if(isset($series))
                                @foreach($series as $ser)
                                    <option value="{{ $ser->id }}" {{ old('series_id') == $ser->id ? 'selected' : '' }}>{{ $ser->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">Select a series to add this article to</p>
                    </div>

                    <!-- Series Order -->
                    <div id="series_order_field" style="display: {{ old('series_id') ? 'block' : 'none' }};">
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Order in Series
                        </label>
                        <input type="number" name="series_order" value="{{ old('series_order', 1) }}" min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="1">
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">Position of this article in the series</p>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Tags
                        </label>
                        <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3 dark:!bg-bg-card-hover dark:!border-border-primary">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 mb-2 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-accent focus:ring-accent">
                                    <span class="text-sm text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Featured Article</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Allow Comments</span>
                        </label>
                        @if(config('services.facebook.enabled', false))
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="post_to_facebook" value="1" {{ old('post_to_facebook', false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post to Facebook</span>
                        </label>
                        @endif
                        @if(config('services.twitter.enabled', false))
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="post_to_twitter" value="1" {{ old('post_to_twitter', false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post to Twitter/X</span>
                        </label>
                        @endif
                        @if(config('services.instagram.enabled', false))
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="post_to_instagram" value="1" {{ old('post_to_instagram', false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post to Instagram</span>
                        </label>
                        @endif
                        @if(config('services.threads.enabled', false))
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="post_to_threads" value="1" {{ old('post_to_threads', false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post to Threads</span>
                        </label>
                        @endif
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Create Article
                </button>
                <a href="{{ route('admin.articles.index') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    const publishedAtField = document.getElementById('published_at_field');
    const form = document.querySelector('form');
    let articleId = null;
    
    function togglePublishedAt() {
        if (statusSelect.value === 'scheduled') {
            publishedAtField.style.display = 'block';
        } else {
            publishedAtField.style.display = 'none';
        }
    }
    
    statusSelect.addEventListener('change', togglePublishedAt);
    togglePublishedAt();
    
    // Series order field toggle
    const seriesSelect = document.querySelector('select[name="series_id"]');
    const seriesOrderField = document.getElementById('series_order_field');
    
    function toggleSeriesOrder() {
        if (seriesSelect && seriesOrderField) {
            if (seriesSelect.value) {
                seriesOrderField.style.display = 'block';
            } else {
                seriesOrderField.style.display = 'none';
            }
        }
    }
    
    if (seriesSelect) {
        seriesSelect.addEventListener('change', toggleSeriesOrder);
        toggleSeriesOrder(); // Initialize on page load
    }
    
    // Auto-save functionality
    let autoSaveTimer;
    let isSaving = false;
    let lastSavedContent = '';
    
    function autoSave() {
        if (isSaving) return;
        
        const formData = new FormData(form);
        const currentContent = tinymce.get('content') ? tinymce.get('content').getContent() : formData.get('content');
        
        // Only save if content has changed
        if (currentContent === lastSavedContent) return;
        
        isSaving = true;
        
        // Get TinyMCE content if available
        if (tinymce.get('content')) {
            formData.set('content', tinymce.get('content').getContent());
        }
        
        const url = articleId ? `/admin/articles/${articleId}/auto-save` : '/admin/articles/auto-save';
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            isSaving = false;
            if (data.success) {
                lastSavedContent = currentContent;
                if (data.article_id && !articleId) {
                    articleId = data.article_id;
                    // Update form action to include article ID
                    form.action = `/admin/articles/${articleId}`;
                    form.innerHTML += `<input type="hidden" name="_method" value="PUT">`;
                }
                showAutoSaveIndicator('saved');
            }
        })
        .catch(error => {
            isSaving = false;
            console.error('Auto-save error:', error);
        });
    }
    
    function showAutoSaveIndicator(status) {
        let indicator = document.getElementById('auto-save-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'auto-save-indicator';
            indicator.className = 'fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 transition-all';
            document.body.appendChild(indicator);
        }
        
        if (status === 'saving') {
            indicator.className = 'fixed bottom-4 right-4 px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-lg z-50 transition-all';
            indicator.textContent = 'Saving...';
        } else if (status === 'saved') {
            indicator.className = 'fixed bottom-4 right-4 px-4 py-2 bg-green-500 text-white rounded-lg shadow-lg z-50 transition-all';
            indicator.textContent = 'Draft saved';
            setTimeout(() => {
                indicator.style.opacity = '0';
                setTimeout(() => indicator.remove(), 300);
            }, 2000);
        }
    }
    
    // Auto-save on input (debounced)
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(autoSaveTimer);
            showAutoSaveIndicator('saving');
            autoSaveTimer = setTimeout(autoSave, 3000); // Save after 3 seconds of inactivity
        });
    });
    
    // Auto-save on TinyMCE content change
    if (tinymce.get('content')) {
        tinymce.get('content').on('keyup', () => {
            clearTimeout(autoSaveTimer);
            showAutoSaveIndicator('saving');
            autoSaveTimer = setTimeout(autoSave, 3000);
        });
    }
});
</script>
@endsection

