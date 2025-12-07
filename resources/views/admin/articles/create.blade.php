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
                Add a new article to TECHNAZAARA
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
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" id="templateDropdownBtn" 
                                        class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card flex items-center gap-2"
                                        style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    📄 Load Template <span class="text-xs">▼</span>
                                </button>
                                <div id="templateDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-primary rounded-lg shadow-lg z-50" style="max-height: 400px; overflow-y: auto;">
                                    <div class="p-2">
                                        <div class="text-xs font-semibold text-gray-500 dark:!text-text-tertiary px-3 py-2 mb-1">Tutorial & Guides</div>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="tutorial">📚 Tutorial Template</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="guide">📖 Step-by-Step Guide</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="howto">🔧 How-To Guide</button>
                                        
                                        <div class="text-xs font-semibold text-gray-500 dark:!text-text-tertiary px-3 py-2 mt-3 mb-1">Reviews</div>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="review">⭐ Product Review</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="comparison">⚖️ Product Comparison</button>
                                        
                                        <div class="text-xs font-semibold text-gray-500 dark:!text-text-tertiary px-3 py-2 mt-3 mb-1">News & Updates</div>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="news">📰 News Article</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="announcement">📢 Announcement</button>
                                        
                                        <div class="text-xs font-semibold text-gray-500 dark:!text-text-tertiary px-3 py-2 mt-3 mb-1">Technical</div>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="api">🔌 API Documentation</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="troubleshooting">🔍 Troubleshooting Guide</button>
                                        
                                        <div class="text-xs font-semibold text-gray-500 dark:!text-text-tertiary px-3 py-2 mt-3 mb-1">Lists & Roundups</div>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="list">📋 Top 10 List</button>
                                        <button type="button" class="template-option w-full text-left px-3 py-2 text-sm hover:bg-gray-100 dark:!hover:bg-bg-card-hover rounded" data-template="roundup">🎯 Roundup Article</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <textarea name="content" id="content" class="tinymce-editor w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                  placeholder="Write your article content here...">{!! old('content') !!}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">Select a template from the dropdown to use a structured article template</p>
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
    
    // Load Template functionality
    const templateDropdownBtn = document.getElementById('templateDropdownBtn');
    const templateDropdown = document.getElementById('templateDropdown');
    const titleInput = document.querySelector('input[name="title"]');
    const categorySelect = document.querySelector('select[name="category_id"]');
    
    // Toggle dropdown
    if (templateDropdownBtn && templateDropdown) {
        templateDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            templateDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!templateDropdown.contains(e.target) && !templateDropdownBtn.contains(e.target)) {
                templateDropdown.classList.add('hidden');
            }
        });
        
        // Handle template selection
        const templateOptions = document.querySelectorAll('.template-option');
        templateOptions.forEach(option => {
            option.addEventListener('click', function() {
                const templateType = this.getAttribute('data-template');
                const title = titleInput.value || 'Your Article Title';
                const categoryName = categorySelect.options[categorySelect.selectedIndex]?.text || 'Technology';
                
                // Get the selected template
                const template = getTemplate(templateType, title, categoryName);
                
                // Insert into TinyMCE if available, otherwise into textarea
                if (tinymce.get('content')) {
                    tinymce.get('content').setContent(template);
                } else {
                    document.getElementById('content').value = template;
                }
                
                // Close dropdown
                templateDropdown.classList.add('hidden');
                
                // Show success message
                showNotification('Template loaded successfully!', 'success');
            });
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 px-4 py-2 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white rounded-lg shadow-lg z-50 transition-all`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
    
    function getTemplate(templateType, title, categoryName) {
        const templates = {
            tutorial: getTutorialTemplate(title, categoryName),
            guide: getGuideTemplate(title, categoryName),
            howto: getHowToTemplate(title, categoryName),
            review: getReviewTemplate(title, categoryName),
            comparison: getComparisonTemplate(title, categoryName),
            news: getNewsTemplate(title, categoryName),
            announcement: getAnnouncementTemplate(title, categoryName),
            api: getAPITemplate(title, categoryName),
            troubleshooting: getTroubleshootingTemplate(title, categoryName),
            list: getListTemplate(title, categoryName),
            roundup: getRoundupTemplate(title, categoryName)
        };
        
        return templates[templateType] || getTutorialTemplate(title, categoryName);
    }
    
    function getTutorialTemplate(title, categoryName) {
        return `<h1>${title}</h1>

<p>This is an introduction paragraph that provides an overview of the topic. It should be engaging and give readers a clear understanding of what they'll learn from this article. Make sure to include key points that will be covered.</p>

<h2>What is ${categoryName}?</h2>

<p>Start by explaining the fundamental concepts. Provide context and background information that helps readers understand the topic better. This section sets the foundation for the rest of the article.</p>

<figure class="image"><img title="${title}" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="${title}" width="1200" height="630">
<figcaption>Visual representation of ${categoryName}</figcaption>
</figure>

<h2>1. First Main Topic</h2>

<p>Begin your first main section with a clear explanation of the topic. Provide context and explain why this is important.</p>

<h3>Subsection Title</h3>

<p>Dive deeper into specific aspects of the topic. Use examples and practical information to help readers understand.</p>

<pre><code class="language-javascript">// Example code or configuration
// Add your code examples here
function example() {
    return "Your code here";
}
</code></pre>

<h3>Key Points</h3>

<ul>
<li>First important point</li>
<li>Second important point</li>
<li>Third important point</li>
</ul>

<h2>2. Second Main Topic</h2>

<p>Continue with your second main topic. Maintain a logical flow and build upon previous concepts.</p>

<h3>Practical Example</h3>

<p>Provide real-world examples or use cases that demonstrate the concept in action.</p>

<pre><code class="language-javascript">// Another code example
const example = {
    property: "value",
    method: function() {
        return "result";
    }
};
</code></pre>

<h2>3. Third Main Topic</h2>

<p>Add your third main section. Keep the content structured and easy to follow.</p>

<h3>Best Practices</h3>

<ul>
<li>Best practice one</li>
<li>Best practice two</li>
<li>Best practice three</li>
</ul>

<h2>Advanced Concepts</h2>

<p>For more experienced readers, include advanced topics or techniques. This adds depth to your article.</p>

<h2>Common Mistakes to Avoid</h2>

<p>Help readers avoid pitfalls by highlighting common mistakes and how to prevent them.</p>

<ul>
<li>Mistake one and how to avoid it</li>
<li>Mistake two and how to avoid it</li>
</ul>

<h2>Best Practices</h2>

<p>Summarize the best practices and recommendations for working with this topic:</p>

<ul>
<li>Use clear and descriptive names</li>
<li>Follow established patterns and conventions</li>
<li>Test thoroughly before deployment</li>
<li>Document your code and decisions</li>
</ul>

<h2>Conclusion</h2>

<p>Summarize the key points covered in the article. Reinforce the main takeaways and provide guidance on next steps. Encourage readers to practice and explore further.</p>

<p>Remember, the best way to learn is by doing. Try implementing these concepts in your next project and see how they can improve your development workflow!</p>`;
    }
    
    function getGuideTemplate(title, categoryName) {
        return `<h1>${title}: A Complete Step-by-Step Guide</h1>

<p>Welcome to this comprehensive guide on ${categoryName}. Whether you're a beginner or looking to enhance your skills, this step-by-step tutorial will walk you through everything you need to know.</p>

<h2>Prerequisites</h2>

<p>Before we begin, make sure you have the following:</p>

<ul>
<li>Required software or tools</li>
<li>Basic knowledge of related concepts</li>
<li>Access to necessary resources</li>
</ul>

<h2>Step 1: Getting Started</h2>

<p>Let's start with the basics. This first step will help you set up your environment and prepare for the journey ahead.</p>

<pre><code class="language-javascript">// Initial setup code
// Add your setup instructions here
</code></pre>

<h2>Step 2: Core Concepts</h2>

<p>Now that you're set up, let's dive into the core concepts. Understanding these fundamentals is crucial for success.</p>

<h3>Key Concept 1</h3>

<p>Explain the first key concept in detail.</p>

<h3>Key Concept 2</h3>

<p>Explain the second key concept in detail.</p>

<h2>Step 3: Implementation</h2>

<p>Time to put theory into practice. Follow these steps to implement what you've learned.</p>

<pre><code class="language-javascript">// Implementation code
// Add your implementation examples
</code></pre>

<h2>Step 4: Advanced Techniques</h2>

<p>Once you've mastered the basics, explore these advanced techniques to take your skills to the next level.</p>

<h2>Step 5: Troubleshooting</h2>

<p>Encountering issues? This section covers common problems and their solutions.</p>

<ul>
<li>Problem 1: Solution</li>
<li>Problem 2: Solution</li>
</ul>

<h2>Conclusion</h2>

<p>Congratulations! You've completed this guide. You should now have a solid understanding of ${categoryName}. Continue practicing and exploring to further enhance your skills.</p>`;
    }
    
    function getHowToTemplate(title, categoryName) {
        return `<h1>How to ${title}</h1>

<p>In this guide, you'll learn exactly how to ${title.toLowerCase()}. Follow these simple steps to achieve your goal.</p>

<h2>What You'll Need</h2>

<ul>
<li>Item or tool 1</li>
<li>Item or tool 2</li>
<li>Item or tool 3</li>
</ul>

<h2>Step-by-Step Instructions</h2>

<h3>Step 1: Preparation</h3>

<p>First, prepare your workspace and gather all necessary materials.</p>

<h3>Step 2: Main Process</h3>

<p>Now, follow these detailed instructions:</p>

<ol>
<li>First action to take</li>
<li>Second action to take</li>
<li>Third action to take</li>
</ol>

<h3>Step 3: Verification</h3>

<p>Verify that everything is working correctly.</p>

<h2>Tips and Tricks</h2>

<ul>
<li>Pro tip 1</li>
<li>Pro tip 2</li>
<li>Pro tip 3</li>
</ul>

<h2>Common Issues and Solutions</h2>

<p><strong>Issue:</strong> Description of common issue</p>
<p><strong>Solution:</strong> How to fix it</p>

<h2>Conclusion</h2>

<p>You've successfully learned how to ${title.toLowerCase()}. Practice makes perfect, so keep experimenting!</p>`;
    }
    
    function getReviewTemplate(title, categoryName) {
        return `<h1>${title} Review: In-Depth Analysis</h1>

<p>In this comprehensive review, we'll take a close look at ${title.toLowerCase()}, examining its features, performance, and value proposition. Whether you're considering a purchase or just curious, this review has everything you need to know.</p>

<figure class="image"><img title="${title}" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="${title}" width="1200" height="630">
<figcaption>${title} - Product Overview</figcaption>
</figure>

<h2>Overview</h2>

<p>${title} is a [product type] that [brief description]. It's designed for [target audience] and promises to [main benefit].</p>

<h2>Key Specifications</h2>

<ul>
<li><strong>Feature 1:</strong> Description</li>
<li><strong>Feature 2:</strong> Description</li>
<li><strong>Feature 3:</strong> Description</li>
<li><strong>Price:</strong> $XXX</li>
<li><strong>Availability:</strong> Where to buy</li>
</ul>

<h2>Design and Build Quality</h2>

<p>Discuss the physical design, materials used, build quality, and overall aesthetics.</p>

<h2>Performance</h2>

<p>Evaluate the performance in real-world scenarios. Include benchmarks, speed tests, or other relevant metrics.</p>

<h3>Strengths</h3>

<ul>
<li>Strength 1</li>
<li>Strength 2</li>
<li>Strength 3</li>
</ul>

<h3>Weaknesses</h3>

<ul>
<li>Weakness 1</li>
<li>Weakness 2</li>
</ul>

<h2>Features Breakdown</h2>

<h3>Feature 1</h3>
<p>Detailed analysis of the first major feature.</p>

<h3>Feature 2</h3>
<p>Detailed analysis of the second major feature.</p>

<h2>User Experience</h2>

<p>Share your experience using the product. What's it like day-to-day? Is it intuitive? Are there any pain points?</p>

<h2>Value for Money</h2>

<p>Is this product worth its price tag? Compare it to competitors and evaluate the overall value proposition.</p>

<h2>Who Should Buy This?</h2>

<p>This product is ideal for:</p>
<ul>
<li>User type 1</li>
<li>User type 2</li>
</ul>

<h2>Final Verdict</h2>

<p>Overall rating: X/5 stars</p>

<p>Summarize your overall thoughts. Would you recommend it? What are the main reasons to buy or avoid this product?</p>

<h2>Pros and Cons</h2>

<h3>Pros</h3>
<ul>
<li>Advantage 1</li>
<li>Advantage 2</li>
<li>Advantage 3</li>
</ul>

<h3>Cons</h3>
<ul>
<li>Disadvantage 1</li>
<li>Disadvantage 2</li>
</ul>`;
    }
    
    function getComparisonTemplate(title, categoryName) {
        return `<h1>${title}: Head-to-Head Comparison</h1>

<p>In this detailed comparison, we'll pit ${title.toLowerCase()} against its main competitors to help you make an informed decision.</p>

<h2>Comparison Overview</h2>

<p>We'll be comparing these products across multiple categories including features, performance, price, and value.</p>

<h2>Products Compared</h2>

<ul>
<li>Product A: ${title}</li>
<li>Product B: Competitor 1</li>
<li>Product C: Competitor 2</li>
</ul>

<h2>Feature Comparison</h2>

<table>
<thead>
<tr>
<th>Feature</th>
<th>Product A</th>
<th>Product B</th>
<th>Product C</th>
</tr>
</thead>
<tbody>
<tr>
<td>Feature 1</td>
<td>✓</td>
<td>✓</td>
<td>✗</td>
</tr>
<tr>
<td>Feature 2</td>
<td>✓</td>
<td>✗</td>
<td>✓</td>
</tr>
<tr>
<td>Feature 3</td>
<td>✓</td>
<td>✓</td>
<td>✓</td>
</tr>
</tbody>
</table>

<h2>Price Comparison</h2>

<ul>
<li><strong>Product A:</strong> $XXX</li>
<li><strong>Product B:</strong> $XXX</li>
<li><strong>Product C:</strong> $XXX</li>
</ul>

<h2>Performance Comparison</h2>

<p>Compare performance metrics, benchmarks, and real-world usage scenarios.</p>

<h2>Which One Should You Choose?</h2>

<h3>Choose Product A if:</h3>
<ul>
<li>Reason 1</li>
<li>Reason 2</li>
</ul>

<h3>Choose Product B if:</h3>
<ul>
<li>Reason 1</li>
<li>Reason 2</li>
</ul>

<h3>Choose Product C if:</h3>
<ul>
<li>Reason 1</li>
<li>Reason 2</li>
</ul>

<h2>Final Verdict</h2>

<p>After thorough comparison, [Product Name] emerges as the winner in [category]. However, the best choice depends on your specific needs and budget.</p>`;
    }
    
    function getNewsTemplate(title, categoryName) {
        return `<h1>${title}</h1>

<p class="text-gray-600 dark:!text-text-secondary"><em>Published: [Date] | Category: ${categoryName}</em></p>

<p><strong>[Location/Date]</strong> - [Opening sentence that summarizes the news]. This development marks a significant moment in [relevant industry/field].</p>

<figure class="image"><img title="${title}" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="${title}" width="1200" height="630">
<figcaption>Image caption related to the news</figcaption>
</figure>

<h2>What Happened?</h2>

<p>Provide detailed information about the event, announcement, or development. Include who, what, when, where, and why.</p>

<h2>Key Details</h2>

<ul>
<li>Important detail 1</li>
<li>Important detail 2</li>
<li>Important detail 3</li>
</ul>

<h2>Impact and Implications</h2>

<p>Explain what this means for the industry, users, or relevant stakeholders. Discuss both immediate and long-term implications.</p>

<h2>Reactions and Responses</h2>

<p>Include quotes, reactions, or responses from key figures, companies, or experts in the field.</p>

<blockquote>
<p>"[Quote from relevant person or organization]"</p>
<p><em>- Source Name</em></p>
</blockquote>

<h2>What's Next?</h2>

<p>Discuss what might happen next, upcoming developments, or related events to watch for.</p>

<h2>Conclusion</h2>

<p>Summarize the significance of this news and why it matters to readers.</p>`;
    }
    
    function getAnnouncementTemplate(title, categoryName) {
        return `<h1>${title}</h1>

<p>We're excited to announce ${title.toLowerCase()}! This is an important update that brings significant improvements and new features.</p>

<figure class="image"><img title="${title}" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="${title}" width="1200" height="630">
<figcaption>Announcement visual</figcaption>
</figure>

<h2>What's New?</h2>

<p>Here's what you can expect from this announcement:</p>

<ul>
<li>New feature or update 1</li>
<li>New feature or update 2</li>
<li>New feature or update 3</li>
</ul>

<h2>Key Highlights</h2>

<h3>Highlight 1</h3>
<p>Detailed description of the first major highlight.</p>

<h3>Highlight 2</h3>
<p>Detailed description of the second major highlight.</p>

<h2>Timeline</h2>

<ul>
<li><strong>Date 1:</strong> Event or milestone</li>
<li><strong>Date 2:</strong> Event or milestone</li>
<li><strong>Date 3:</strong> Event or milestone</li>
</ul>

<h2>How to Get Involved</h2>

<p>Information on how readers can participate, access, or benefit from this announcement.</p>

<h2>Questions?</h2>

<p>If you have any questions, feel free to reach out or check our FAQ section.</p>`;
    }
    
    function getAPITemplate(title, categoryName) {
        return `<h1>${title} API Documentation</h1>

<p>This documentation provides a comprehensive guide to using the ${title} API. Whether you're integrating for the first time or looking for advanced features, you'll find everything you need here.</p>

<h2>Getting Started</h2>

<p>Before you begin, make sure you have:</p>

<ul>
<li>API key or authentication credentials</li>
<li>Basic understanding of REST APIs</li>
<li>Access to the API endpoint</li>
</ul>

<h2>Authentication</h2>

<p>All API requests require authentication. Here's how to authenticate:</p>

<pre><code class="language-javascript">// Authentication example
const apiKey = 'your-api-key';
const headers = {
    'Authorization': \`Bearer \${apiKey}\`,
    'Content-Type': 'application/json'
};
</code></pre>

<h2>Base URL</h2>

<p>All API endpoints are relative to:</p>

<pre><code>https://api.example.com/v1</code></pre>

<h2>Endpoints</h2>

<h3>GET /resource</h3>
<p>Retrieve a list of resources.</p>

<pre><code class="language-javascript">fetch('https://api.example.com/v1/resource', {
    headers: headers
})
.then(response => response.json())
.then(data => console.log(data));
</code></pre>

<h3>POST /resource</h3>
<p>Create a new resource.</p>

<pre><code class="language-javascript">fetch('https://api.example.com/v1/resource', {
    method: 'POST',
    headers: headers,
    body: JSON.stringify({
        name: 'Example',
        value: 'Data'
    })
})
.then(response => response.json())
.then(data => console.log(data));
</code></pre>

<h2>Response Format</h2>

<p>All responses are returned in JSON format:</p>

<pre><code class="language-json">{
    "status": "success",
    "data": {
        // Response data
    }
}
</code></pre>

<h2>Error Handling</h2>

<p>The API uses standard HTTP status codes:</p>

<ul>
<li><strong>200:</strong> Success</li>
<li><strong>400:</strong> Bad Request</li>
<li><strong>401:</strong> Unauthorized</li>
<li><strong>404:</strong> Not Found</li>
<li><strong>500:</strong> Server Error</li>
</ul>

<h2>Rate Limiting</h2>

<p>API requests are limited to X requests per minute. Exceeding this limit will result in a 429 status code.</p>

<h2>Examples</h2>

<p>Here are some complete examples to get you started:</p>

<pre><code class="language-javascript">// Complete example
// Add your full code example here
</code></pre>

<h2>Support</h2>

<p>For additional help, visit our support documentation or contact our API support team.</p>`;
    }
    
    function getTroubleshootingTemplate(title, categoryName) {
        return `<h1>${title}: Troubleshooting Guide</h1>

<p>Encountering issues with ${categoryName.toLowerCase()}? This comprehensive troubleshooting guide will help you identify and resolve common problems.</p>

<h2>Common Issues</h2>

<h3>Issue 1: [Problem Description]</h3>

<p><strong>Symptoms:</strong> Describe what users experience when this issue occurs.</p>

<p><strong>Possible Causes:</strong></p>
<ul>
<li>Cause 1</li>
<li>Cause 2</li>
</ul>

<p><strong>Solution:</strong></p>

<ol>
<li>Step 1 to resolve</li>
<li>Step 2 to resolve</li>
<li>Step 3 to resolve</li>
</ol>

<pre><code class="language-javascript">// Code example if applicable
// Add troubleshooting code here
</code></pre>

<h3>Issue 2: [Problem Description]</h3>

<p><strong>Symptoms:</strong> Describe the symptoms.</p>

<p><strong>Solution:</strong> Step-by-step solution.</p>

<h2>Prevention Tips</h2>

<p>To avoid these issues in the future:</p>

<ul>
<li>Prevention tip 1</li>
<li>Prevention tip 2</li>
<li>Prevention tip 3</li>
</ul>

<h2>Diagnostic Steps</h2>

<p>If you're unsure what the problem is, follow these diagnostic steps:</p>

<ol>
<li>Check logs for error messages</li>
<li>Verify configuration settings</li>
<li>Test with minimal setup</li>
<li>Check system requirements</li>
</ol>

<h2>Still Having Issues?</h2>

<p>If none of these solutions work, try:</p>

<ul>
<li>Consulting official documentation</li>
<li>Checking community forums</li>
<li>Contacting support</li>
</ul>`;
    }
    
    function getListTemplate(title, categoryName) {
        return `<h1>${title}: Top 10 List</h1>

<p>In this article, we've compiled a list of the top 10 [items] in ${categoryName.toLowerCase()}. Whether you're looking for the best options or just curious about what's available, this list has you covered.</p>

<h2>How We Chose</h2>

<p>Our selection criteria included [criteria 1], [criteria 2], and [criteria 3]. Each item on this list has been thoroughly evaluated.</p>

<h2>10. [Item Name]</h2>

<figure class="image"><img title="Item 10" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="Item 10" width="1200" height="630">
<figcaption>Item 10</figcaption>
</figure>

<p>Description of item 10. Why it made the list and what makes it special.</p>

<p><strong>Pros:</strong> Advantage 1, Advantage 2</p>
<p><strong>Cons:</strong> Disadvantage 1</p>

<h2>9. [Item Name]</h2>

<p>Description of item 9.</p>

<h2>8. [Item Name]</h2>

<p>Description of item 8.</p>

<h2>7. [Item Name]</h2>

<p>Description of item 7.</p>

<h2>6. [Item Name]</h2>

<p>Description of item 6.</p>

<h2>5. [Item Name]</h2>

<p>Description of item 5.</p>

<h2>4. [Item Name]</h2>

<p>Description of item 4.</p>

<h2>3. [Item Name]</h2>

<p>Description of item 3.</p>

<h2>2. [Item Name]</h2>

<p>Description of item 2.</p>

<h2>1. [Item Name] - Our Top Pick</h2>

<figure class="image"><img title="Top Pick" src="https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop" alt="Top Pick" width="1200" height="630">
<figcaption>Our #1 Choice</figcaption>
</figure>

<p>Why this is our top pick. Detailed explanation of what makes it stand out from the rest.</p>

<h2>Comparison Table</h2>

<table>
<thead>
<tr>
<th>Item</th>
<th>Key Feature</th>
<th>Price</th>
<th>Rating</th>
</tr>
</thead>
<tbody>
<tr>
<td>Item 1</td>
<td>Feature</td>
<td>$XX</td>
<td>X/5</td>
</tr>
<!-- Add more rows -->
</tbody>
</table>

<h2>Final Thoughts</h2>

<p>Each item on this list offers something unique. The best choice depends on your specific needs and preferences.</p>`;
    }
    
    function getRoundupTemplate(title, categoryName) {
        return `<h1>${title}: Complete Roundup</h1>

<p>In this comprehensive roundup, we've gathered everything you need to know about ${categoryName.toLowerCase()}. From tools to techniques, this article covers it all.</p>

<h2>Overview</h2>

<p>${categoryName} encompasses a wide range of topics and tools. This roundup provides a curated selection of the most important and useful resources.</p>

<h2>Category 1: [Topic]</h2>

<h3>Option A</h3>
<p>Description and details about option A.</p>

<h3>Option B</h3>
<p>Description and details about option B.</p>

<h3>Option C</h3>
<p>Description and details about option C.</p>

<h2>Category 2: [Topic]</h2>

<h3>Option A</h3>
<p>Description and details.</p>

<h3>Option B</h3>
<p>Description and details.</p>

<h2>Category 3: [Topic]</h2>

<p>Overview of this category and its options.</p>

<h2>Quick Reference</h2>

<ul>
<li><strong>Best for Beginners:</strong> [Option]</li>
<li><strong>Best for Professionals:</strong> [Option]</li>
<li><strong>Best Value:</strong> [Option]</li>
<li><strong>Most Popular:</strong> [Option]</li>
</ul>

<h2>Conclusion</h2>

<p>This roundup covers the essential aspects of ${categoryName.toLowerCase()}. Use this as a starting point for your journey and explore the options that interest you most.</p>`;
    }
});
</script>
@endsection

