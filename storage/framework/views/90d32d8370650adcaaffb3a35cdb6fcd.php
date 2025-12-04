

<?php $__env->startSection('title', 'Tags - Tech Blog'); ?>

<?php $__env->startSection('content'); ?>
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
        <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('tags.show', $tag->slug)); ?>" class="group px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-accent hover:text-white hover:border-accent transition-all dark:!bg-bg-card dark:!border-border-secondary dark:!hover:bg-accent">
                <span class="text-sm font-semibold text-gray-700 dark:!text-white group-hover:text-white transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    <?php echo e($tag->name); ?>

                </span>
                <span class="ml-2 text-xs text-gray-500 dark:!text-text-secondary group-hover:text-white/80" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    (<?php echo e(number_format($tag->articles_count ?? 0)); ?>)
                </span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="w-full text-center py-16">
                <p class="text-gray-600 dark:!text-text-secondary text-lg" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    No tags found.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php if($tags->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($tags->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/tags/index.blade.php ENDPATH**/ ?>