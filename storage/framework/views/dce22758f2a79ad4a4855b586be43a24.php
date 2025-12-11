<article class="group relative bg-white overflow-hidden cursor-pointer dark:!bg-bg-card transition-all duration-300 rounded-lg border border-gray-200 dark:!border-border-secondary">
    <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="block">
        <!-- Featured Image -->
        <div class="relative overflow-hidden w-full aspect-video bg-gray-200 dark:bg-gray-800">
            <?php if($article->featured_image): ?>
                <?php
                    $imageUrl = str_starts_with($article->featured_image, 'http') 
                        ? $article->featured_image 
                        : asset('storage/' . $article->featured_image);
                ?>
                <img src="<?php echo e($imageUrl); ?>" 
                     alt="<?php echo e($article->title); ?>" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                     loading="lazy"
                     decoding="async"
                     onerror="this.src='https://via.placeholder.com/800x450?text=No+Image'">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-700 dark:to-gray-800">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            <?php endif; ?>
            
            <!-- Category Badge -->
            <?php if($article->category): ?>
            <div class="absolute top-2 left-2 bg-accent text-white px-3 py-1 rounded-full text-xs font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600; z-index: 3; backdrop-filter: blur(4px); background-color: rgba(229, 9, 20, 0.9);">
                <?php echo e($article->category->name); ?>

            </div>
            <?php endif; ?>
            
            <!-- Featured Badge -->
            <?php if($article->is_featured): ?>
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600; z-index: 3; backdrop-filter: blur(4px); background-color: rgba(234, 179, 8, 0.9);">
                ⭐ Featured
            </div>
            <?php endif; ?>
            
            <!-- Title Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex items-end pointer-events-none" style="z-index: 2;">
                <div class="w-full p-4 pointer-events-auto">
                    <h3 class="text-xl font-bold text-white mb-1 line-clamp-2 group-hover:text-accent transition-colors duration-300" style="font-family: 'Poppins', sans-serif; font-weight: 800; text-shadow: 0 2px 8px rgba(0,0,0,0.9);">
                        <?php echo e($article->title); ?>

                    </h3>
                    <div class="flex items-center gap-3 text-sm text-gray-200 mt-2" style="font-family: 'Poppins', sans-serif; font-weight: 500; text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
                        <?php if($article->published_at): ?>
                            <span><?php echo e($article->published_at->format('M d, Y')); ?></span>
                        <?php endif; ?>
                        <?php if($article->reading_time): ?>
                            <span>•</span>
                            <span><?php echo e($article->reading_time); ?> min read</span>
                        <?php endif; ?>
                        <span>•</span>
                        <span>👁 <?php echo e(number_format($article->views)); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Article Info -->
        <div class="p-4">
            <?php if($article->excerpt): ?>
                <p class="text-sm text-gray-600 dark:!text-text-secondary line-clamp-2 mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    <?php echo e($article->excerpt); ?>

                </p>
            <?php endif; ?>
            
            <!-- Tags -->
            <?php if($article->tags->count() > 0): ?>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = $article->tags->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs dark:!bg-bg-card-hover dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            <?php echo e($tag->name); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($article->tags->count() > 3): ?>
                        <span class="px-2 py-1 text-gray-500 text-xs dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            +<?php echo e($article->tags->count() - 3); ?> more
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </a>
</article>

<?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/articles/_card.blade.php ENDPATH**/ ?>