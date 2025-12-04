<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e($url['loc']); ?></loc>
        <?php if(isset($url['lastmod'])): ?>
        <lastmod><?php echo e($url['lastmod']); ?></lastmod>
        <?php endif; ?>
        <?php if(isset($url['changefreq'])): ?>
        <changefreq><?php echo e($url['changefreq']); ?></changefreq>
        <?php endif; ?>
        <?php if(isset($url['priority'])): ?>
        <priority><?php echo e($url['priority']); ?></priority>
        <?php endif; ?>
    </url>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>

<?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/sitemap/index.blade.php ENDPATH**/ ?>