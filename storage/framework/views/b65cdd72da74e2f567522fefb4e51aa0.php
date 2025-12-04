<?php $__env->startSection('title', 'Edit Article - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="<?php echo e(route('admin.articles.index')); ?>" class="text-gray-600 hover:text-accent dark:!text-text-secondary dark:!hover:text-accent transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    ← Back to Articles
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                Edit Article
            </h1>
            <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                Update article: <?php echo e($article->title); ?>

            </p>
        </div>
    </div>

    <?php if($errors->any()): ?>
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400">
        <ul class="list-disc list-inside">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
        <form action="<?php echo e(route('admin.articles.update', $article)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="<?php echo e(old('title', $article->title)); ?>" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="Enter article title">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Slug
                        </label>
                        <input type="text" name="slug" value="<?php echo e(old('slug', $article->slug)); ?>"
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
                                  placeholder="Short description of the article"><?php echo e(old('excerpt', $article->excerpt)); ?></textarea>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" id="content" class="tinymce-editor w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                  placeholder="Write your article content here..."><?php echo old('content', $article->rendered_content); ?></textarea>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Featured Image URL
                        </label>
                        <input type="text" name="featured_image" value="<?php echo e(old('featured_image', $article->featured_image)); ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="https://example.com/image.jpg or /storage/image.jpg">
                        <?php if($article->featured_image): ?>
                            <div class="mt-2">
                                <?php
                                    $imageUrl = str_starts_with($article->featured_image, 'http') 
                                        ? $article->featured_image 
                                        : asset('storage/' . $article->featured_image);
                                ?>
                                <img src="<?php echo e($imageUrl); ?>" alt="Current featured image" class="w-32 h-32 object-cover rounded" onerror="this.style.display='none'">
                            </div>
                        <?php endif; ?>
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
                            <option value="published" <?php echo e(old('status', $article->status) === 'published' ? 'selected' : ''); ?>>Published</option>
                            <option value="draft" <?php echo e(old('status', $article->status) === 'draft' ? 'selected' : ''); ?>>Draft</option>
                            <option value="scheduled" <?php echo e(old('status', $article->status) === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                        </select>
                    </div>

                    <!-- Published At -->
                    <div id="published_at_field" style="display: <?php echo e(old('status', $article->status) === 'scheduled' ? 'block' : 'none'); ?>;">
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Publish Date & Time
                        </label>
                        <input type="datetime-local" name="published_at" 
                               value="<?php echo e(old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '')); ?>"
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
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $article->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php if(isset($series)): ?>
                                <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ser->id); ?>" <?php echo e(old('series_id', $article->series_id) == $ser->id ? 'selected' : ''); ?>><?php echo e($ser->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:!text-text-tertiary">Select a series to add this article to</p>
                    </div>

                    <!-- Series Order -->
                    <div id="series_order_field" style="display: <?php echo e(old('series_id', $article->series_id) ? 'block' : 'none'); ?>;">
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Order in Series
                        </label>
                        <input type="number" name="series_order" value="<?php echo e(old('series_order', $article->series_order ?? 1)); ?>" min="1"
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
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center gap-2 mb-2 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="<?php echo e($tag->id); ?>" 
                                           <?php echo e(in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray())) ? 'checked' : ''); ?>

                                           class="rounded border-gray-300 text-accent focus:ring-accent">
                                    <span class="text-sm text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;"><?php echo e($tag->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $article->is_featured) ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Featured Article</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="allow_comments" value="1" <?php echo e(old('allow_comments', $article->allow_comments) ? 'checked' : ''); ?>

                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-gray-700 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Allow Comments</span>
                        </label>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $article->sort_order)); ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Update Article
                </button>
                <a href="<?php echo e(route('admin.articles.revisions', $article)); ?>" class="px-6 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg transition-colors dark:!bg-purple-900/20 dark:!text-purple-400 dark:!hover:bg-purple-900/30" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    View Revisions
                </a>
                <a href="<?php echo e(route('admin.articles.index')); ?>" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
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
    const articleId = <?php echo e($article->id); ?>;
    
    function togglePublishedAt() {
        if (statusSelect.value === 'scheduled') {
            publishedAtField.style.display = 'block';
        } else {
            publishedAtField.style.display = 'none';
        }
    }
    
    statusSelect.addEventListener('change', togglePublishedAt);
    
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
        
        fetch(`/admin/articles/${articleId}/auto-save`, {
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/admin/articles/edit.blade.php ENDPATH**/ ?>