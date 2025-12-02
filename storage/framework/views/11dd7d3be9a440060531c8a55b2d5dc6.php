

<?php $__env->startSection('title', $article->title . ' - Tech Blog'); ?>

<?php $__env->startPush('head'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Main Content -->
        <div>
            <!-- Article Header -->
            <div class="mb-6">
                <?php if($article->category): ?>
                    <a href="<?php echo e(route('categories.show', $article->category->slug)); ?>" class="inline-block px-3 py-1 bg-accent text-white rounded-full text-sm font-semibold mb-4 hover:bg-accent-light transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <?php echo e($article->category->name); ?>

                    </a>
                <?php endif; ?>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    <?php echo e($article->title); ?>

                </h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-600 dark:!text-text-secondary mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    <?php if($article->author): ?>
                        <span>By <?php echo e($article->author->name); ?></span>
                    <?php endif; ?>
                    <?php if($article->published_at): ?>
                        <span>•</span>
                        <span><?php echo e($article->published_at->format('M d, Y')); ?></span>
                    <?php endif; ?>
                    <?php if($article->reading_time): ?>
                        <span>•</span>
                        <span><?php echo e($article->reading_time); ?> min read</span>
                    <?php endif; ?>
                    <span>•</span>
                    <span>👁 <?php echo e(number_format($article->views)); ?> views</span>
                </div>

                <!-- Tags -->
                <?php if($article->tags->count() > 0): ?>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('tags.show', $tag->slug)); ?>" class="px-3 py-1 bg-gray-100 hover:bg-accent text-gray-700 hover:text-white rounded-full text-xs transition-all dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-accent" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                <?php echo e($tag->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Featured Image -->
            <?php if($article->featured_image): ?>
                <div class="mb-8 rounded-lg overflow-hidden">
                    <?php
                        $imageUrl = str_starts_with($article->featured_image, 'http') 
                            ? $article->featured_image 
                            : asset('storage/' . $article->featured_image);
                    ?>
                    <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-auto" onerror="this.style.display='none'">
                </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="prose prose-lg dark:prose-invert max-w-none mb-8 article-content" style="font-family: 'Poppins', sans-serif;">
                <?php echo $article->rendered_content; ?>

            </div>

            <!-- Article Actions (Like Button) -->
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-200 dark:!border-border-secondary">
                <button id="likeButton" 
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all <?php echo e($isLiked ?? false ? 'bg-red-100 text-red-600 dark:!bg-red-900/20 dark:!text-red-400' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:!bg-bg-card-hover dark:!text-white dark:!hover:bg-bg-card'); ?>"
                        data-article-id="<?php echo e($article->id); ?>"
                        data-liked="<?php echo e($isLiked ?? false ? 'true' : 'false'); ?>">
                    <svg class="w-5 h-5" fill="<?php echo e($isLiked ?? false ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="font-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <span id="likesCount"><?php echo e($article->likes()->count()); ?></span> Like<?php echo e($article->likes()->count() !== 1 ? 's' : ''); ?>

                    </span>
                </button>
            </div>

            <!-- Comments Section -->
            <?php if($article->allow_comments): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary">
                <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Comments (<?php echo e($article->comments->count()); ?>)
                </h2>

                <!-- Comment Form -->
                <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:!text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Leave a Comment
                    </h3>
                    
                    <?php if(session('success')): ?>
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('comments.store', $article)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="comment-name" 
                                       value="<?php echo e(old('name', auth()->check() ? auth()->user()->name : '')); ?>" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                       placeholder="Your name">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="comment-email" 
                                       value="<?php echo e(old('email', auth()->check() ? auth()->user()->email : '')); ?>" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                       placeholder="your@email.com">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                Comment <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" id="content" rows="5" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                      placeholder="Write your comment here..."><?php echo e(old('content')); ?></textarea>
                            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all hover:scale-105 hover:shadow-accent" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            Post Comment
                        </button>
                    </form>
                </div>

                <!-- Comments List -->
                <div id="commentsList" class="space-y-3">
                <?php if($article->comments->count() > 0): ?>
                    <?php $__currentLoopData = $article->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <?php if($comment->user && $comment->user->avatar): ?>
                                            <img src="<?php echo e($comment->user->avatar); ?>" alt="<?php echo e($comment->user->name); ?>" class="w-10 h-10 rounded-full object-cover">
                                        <?php else: ?>
                                            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-sm">
                                                <?php echo e(strtoupper(substr($comment->user ? $comment->user->name : $comment->name, 0, 1))); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                <?php echo e($comment->user ? $comment->user->name : $comment->name); ?>

                                            </h4>
                                            <?php if($comment->user && $comment->user->isAuthor()): ?>
                                                <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                                    Author
                                                </span>
                                            <?php endif; ?>
                                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                                • <?php echo e($comment->created_at->diffForHumans()); ?>

                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:!text-text-primary mb-2 whitespace-pre-wrap text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.5;">
                                            <?php echo e($comment->content); ?>

                                        </p>

                                        <!-- Reply Button -->
                                        <button onclick="showReplyForm(<?php echo e($comment->id); ?>)" class="text-sm text-accent hover:text-accent-light font-semibold transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                            Reply
                                        </button>

                                        <!-- Reply Form (Hidden by default) -->
                                        <div id="reply-form-<?php echo e($comment->id); ?>" class="hidden mt-4 pt-4 border-t border-gray-200 dark:!border-border-secondary">
                                            <form action="<?php echo e(route('comments.reply', [$article, $comment])); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label for="reply-name-<?php echo e($comment->id); ?>" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                            Name <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="text" name="name" id="reply-name-<?php echo e($comment->id); ?>" 
                                                               class="reply-name-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" 
                                                               value="<?php echo e(auth()->check() ? auth()->user()->name : ''); ?>"
                                                               required
                                                               placeholder="Your name">
                                                    </div>
                                                    <div>
                                                        <label for="reply-email-<?php echo e($comment->id); ?>" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                            Email <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="email" name="email" id="reply-email-<?php echo e($comment->id); ?>" 
                                                               class="reply-email-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" 
                                                               value="<?php echo e(auth()->check() ? auth()->user()->email : ''); ?>"
                                                               required
                                                               placeholder="your@email.com">
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <textarea name="content" rows="3" required
                                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                                              placeholder="Write your reply..."></textarea>
                                                </div>

                                                <div class="flex gap-3">
                                                    <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                        Post Reply
                                                    </button>
                                                    <button type="button" onclick="hideReplyForm(<?php echo e($comment->id); ?>)" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all text-sm dark:!bg-bg-card-hover dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Replies -->
                                        <?php if($comment->replies->count() > 0): ?>
                                            <div class="mt-6 ml-8 space-y-4 border-l-2 border-gray-200 dark:!border-border-secondary pl-6">
                                                <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-start gap-4">
                                                        <div class="flex-shrink-0">
                                                            <?php if($reply->user && $reply->user->avatar): ?>
                                                                <img src="<?php echo e($reply->user->avatar); ?>" alt="<?php echo e($reply->user->name); ?>" class="w-10 h-10 rounded-full object-cover">
                                                            <?php else: ?>
                                                                <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold">
                                                                    <?php echo e(strtoupper(substr($reply->user ? $reply->user->name : $reply->name, 0, 1))); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-3 mb-1">
                                                                <h5 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                                    <?php echo e($reply->user ? $reply->user->name : $reply->name); ?>

                                                                </h5>
                                                                <?php if($reply->user && $reply->user->isAuthor()): ?>
                                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                                                                        Author
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <p class="text-xs text-gray-500 dark:!text-text-secondary mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                                                                <?php echo e($reply->created_at->format('M d, Y \a\t g:i A')); ?>

                                                            </p>
                                                            <p class="text-gray-700 dark:!text-text-primary text-sm whitespace-pre-wrap" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.6;">
                                                                <?php echo e($reply->content); ?>

                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div id="noCommentsMessage" class="text-center py-12 bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary">
                        <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            No comments yet. Be the first to comment!
                        </p>
                    </div>
                <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary text-center">
                <p class="text-gray-600 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Comments are disabled for this article.
                </p>
            </div>
            <?php endif; ?>

            <!-- Related Articles -->
            <?php if($relatedArticles->count() > 0): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:!border-border-secondary">
                <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-6" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Related Articles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $relatedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('articles._card', ['article' => $relatedArticle], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// LocalStorage keys
const COMMENT_NAME_KEY = 'comment_user_name';
const COMMENT_EMAIL_KEY = 'comment_user_email';

// Load saved name and email from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const savedName = localStorage.getItem(COMMENT_NAME_KEY);
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
    
    // Fill main comment form
    const nameInput = document.getElementById('comment-name');
    const emailInput = document.getElementById('comment-email');
    
    if (nameInput && savedName) {
        nameInput.value = savedName;
    }
    if (emailInput && savedEmail) {
        emailInput.value = savedEmail;
    }
    
    // Fill reply forms when they're shown
    const replyNameInputs = document.querySelectorAll('.reply-name-input');
    const replyEmailInputs = document.querySelectorAll('.reply-email-input');
    
    replyNameInputs.forEach(input => {
        if (savedName) {
            input.value = savedName;
        }
    });
    
    replyEmailInputs.forEach(input => {
        if (savedEmail) {
            input.value = savedEmail;
        }
    });
});

// AJAX Comment Submission
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.querySelector('form[action*="comments.store"]');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Posting...';
            
            // Save to localStorage
            const nameInput = document.getElementById('comment-name');
            const emailInput = document.getElementById('comment-email');
            
            if (nameInput && nameInput.value.trim()) {
                localStorage.setItem(COMMENT_NAME_KEY, nameInput.value.trim());
            }
            if (emailInput && emailInput.value.trim()) {
                localStorage.setItem(COMMENT_EMAIL_KEY, emailInput.value.trim());
            }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');
                    
                    // Clear form
                    this.reset();
                    
                    // Re-fill with saved values
                    if (nameInput) nameInput.value = localStorage.getItem(COMMENT_NAME_KEY) || '';
                    if (emailInput) emailInput.value = localStorage.getItem(COMMENT_EMAIL_KEY) || '';
                    
                    // If not pending, add comment to list
                    if (!data.pending && data.comment) {
                        addCommentToPage(data.comment);
                        updateCommentCount();
                        document.getElementById('noCommentsMessage')?.remove();
                    }
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        });
    }
    
    // AJAX Reply Submission
    document.addEventListener('submit', function(e) {
        if (e.target.matches('form[action*="comments.reply"]')) {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            // Extract parent comment ID from form action: /articles/{article}/comments/{commentId}/reply
            const actionParts = form.action.split('/');
            const parentId = actionParts[actionParts.length - 2]; // Second to last part
            
            submitButton.disabled = true;
            submitButton.textContent = 'Posting...';
            
            // Save to localStorage
            const nameInput = form.querySelector('.reply-name-input');
            const emailInput = form.querySelector('.reply-email-input');
            
            if (nameInput && nameInput.value.trim()) {
                localStorage.setItem(COMMENT_NAME_KEY, nameInput.value.trim());
            }
            if (emailInput && emailInput.value.trim()) {
                localStorage.setItem(COMMENT_EMAIL_KEY, emailInput.value.trim());
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    
                    // Hide reply form
                    const replyFormDiv = form.closest('[id^="reply-form-"]');
                    if (replyFormDiv) {
                        const commentId = replyFormDiv.id.replace('reply-form-', '');
                        hideReplyForm(commentId);
                    }
                    
                    // If not pending, add reply to page
                    if (!data.pending && data.reply) {
                        addReplyToPage(data.reply, parentId);
                        updateCommentCount();
                    }
                } else {
                    showMessage(data.message || 'An error occurred. Please try again.', 'error');
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }
    });
});

// Helper functions
function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `mb-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700 dark:!bg-green-900/20 dark:!border-green-700 dark:!text-green-400' : 'bg-red-100 border border-red-400 text-red-700 dark:!bg-red-900/20 dark:!border-red-700 dark:!text-red-400'}`;
    messageDiv.textContent = message;
    messageDiv.style.fontFamily = "'Poppins', sans-serif";
    
    const commentForm = document.querySelector('.bg-white.dark\\!bg-bg-card.rounded-lg.border');
    if (commentForm) {
        const existingMessage = commentForm.querySelector('.mb-4.p-4.rounded-lg');
        if (existingMessage) {
            existingMessage.remove();
        }
        commentForm.insertBefore(messageDiv, commentForm.querySelector('form'));
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
}

function addCommentToPage(comment) {
    const commentsList = document.getElementById('commentsList');
    if (!commentsList) return;
    
    const commentHtml = `
        <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    ${comment.avatar ? 
                        `<img src="${comment.avatar}" alt="${comment.name}" class="w-10 h-10 rounded-full object-cover">` :
                        `<div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-sm">${comment.name.charAt(0).toUpperCase()}</div>`
                    }
                            </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                            ${comment.name}
                                </h4>
                        ${comment.is_author ? '<span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: \'Poppins\', sans-serif; font-weight: 500;">Author</span>' : ''}
                        <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                            • ${comment.created_at}
                        </span>
                    </div>
                    <p class="text-gray-700 dark:!text-text-primary mb-2 whitespace-pre-wrap text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.5;">
                        ${comment.content}
                    </p>
                    <button onclick="showReplyForm(${comment.id})" class="text-sm text-accent hover:text-accent-light font-semibold transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Reply
                    </button>
                    <div id="reply-form-${comment.id}" class="hidden mt-4 pt-4 border-t border-gray-200 dark:!border-border-secondary">
                        ${getReplyFormHtml(comment.id)}
                            </div>
                </div>
            </div>
        </div>
    `;
    
    commentsList.insertAdjacentHTML('afterbegin', commentHtml);
}

function addReplyToPage(reply, parentId) {
    // Find parent comment - could be a main comment or a nested reply
    let parentElement = document.querySelector(`[data-comment-id="${parentId}"]`);
    
    // If not found as main comment, try to find in replies
    if (!parentElement) {
        const allReplies = document.querySelectorAll('.replies-container > div');
        for (let replyDiv of allReplies) {
            if (replyDiv.getAttribute('data-reply-id') === parentId.toString()) {
                parentElement = replyDiv;
                break;
            }
        }
    }
    
    if (!parentElement) {
        // Find by looking for the reply form that was just submitted
        const replyForm = document.querySelector(`form[action*="/comments/${parentId}/reply"]`);
        if (replyForm) {
            parentElement = replyForm.closest('[data-comment-id]') || replyForm.closest('.bg-white');
        }
    }
    
    if (!parentElement) return;
    
    let repliesContainer = parentElement.querySelector('.replies-container');
    if (!repliesContainer) {
        repliesContainer = document.createElement('div');
        repliesContainer.className = 'mt-3 ml-6 space-y-2 border-l-2 border-gray-200 dark:!border-border-secondary pl-4 replies-container';
        const commentContent = parentElement.querySelector('.flex-1');
        if (commentContent) {
            commentContent.appendChild(repliesContainer);
        }
    }
    
    const replyHtml = `
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                ${reply.avatar ? 
                    `<img src="${reply.avatar}" alt="${reply.name}" class="w-8 h-8 rounded-full object-cover">` :
                    `<div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white font-semibold text-xs">${reply.name.charAt(0).toUpperCase()}</div>`
                }
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h5 class="font-semibold text-gray-900 dark:!text-white text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        ${reply.name}
                    </h5>
                    ${reply.is_author ? '<span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 rounded text-xs dark:!bg-blue-900/20 dark:!text-blue-400" style="font-family: \'Poppins\', sans-serif; font-weight: 500;">Author</span>' : ''}
                            <span class="text-xs text-gray-500 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                        • ${reply.created_at}
                            </span>
                </div>
                <p class="text-gray-700 dark:!text-text-primary text-sm whitespace-pre-wrap mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 400; line-height: 1.5;">
                    ${reply.content}
                </p>
            </div>
        </div>
    `;
    
    repliesContainer.insertAdjacentHTML('beforeend', replyHtml);
}

function getReplyFormHtml(commentId) {
    const savedName = localStorage.getItem(COMMENT_NAME_KEY) || '';
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY) || '';
    const articleId = <?php echo e($article->id); ?>;
    
    return `
        <form action="/articles/${articleId}/comments/${commentId}/reply" method="POST">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" class="reply-name-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" value="${savedName}" required placeholder="Your name">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" class="reply-email-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" value="${savedEmail}" required placeholder="your@email.com">
    </div>
</div>
            <div class="mb-4">
                <textarea name="content" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white" placeholder="Write your reply..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-all text-sm" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Post Reply</button>
                <button type="button" onclick="hideReplyForm(${commentId})" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all text-sm dark:!bg-bg-card-hover dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Cancel</button>
            </div>
        </form>
    `;
}

function updateCommentCount() {
    const commentsList = document.getElementById('commentsList');
    const comments = commentsList.querySelectorAll('.bg-white.dark\\!bg-bg-card.rounded-lg');
    const count = comments.length;
    const countElement = document.querySelector('h2');
    if (countElement && countElement.textContent.includes('Comments')) {
        countElement.textContent = `Comments (${count})`;
    }
}

function showReplyForm(commentId) {
    const replyForm = document.getElementById('reply-form-' + commentId);
    replyForm.classList.remove('hidden');
    
    // Load saved name and email into reply form
    const savedName = localStorage.getItem(COMMENT_NAME_KEY);
    const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
    
    const nameInput = document.getElementById('reply-name-' + commentId);
    const emailInput = document.getElementById('reply-email-' + commentId);
    
    if (nameInput && savedName) {
        nameInput.value = savedName;
    }
    if (emailInput && savedEmail) {
        emailInput.value = savedEmail;
    }
}

function hideReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).classList.add('hidden');
    // Clear form
    const form = document.getElementById('reply-form-' + commentId).querySelector('form');
    if (form) {
        form.reset();
        
        // Re-fill with saved values after reset
        const savedName = localStorage.getItem(COMMENT_NAME_KEY);
        const savedEmail = localStorage.getItem(COMMENT_EMAIL_KEY);
        
        const nameInput = form.querySelector('.reply-name-input');
        const emailInput = form.querySelector('.reply-email-input');
        
        if (nameInput && savedName) {
            nameInput.value = savedName;
        }
        if (emailInput && savedEmail) {
            emailInput.value = savedEmail;
        }
    }
}

// Article Like functionality
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.getElementById('likeButton');
    if (likeButton) {
        likeButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const articleId = this.getAttribute('data-article-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value ||
                             document.querySelector('input[name="csrf_token"]')?.value;
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            
            // Disable button during request
            this.disabled = true;
            
            // Create form data for POST request
            const formData = new FormData();
            formData.append('_token', csrfToken);
            
            const likeUrl = `/articles/${articleId}/like`;
            fetch(likeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                this.disabled = false;
                
                const likesCountEl = document.getElementById('likesCount');
                if (likesCountEl && data.likes_count !== undefined) {
                    const likeText = data.likes_count === 1 ? 'Like' : 'Likes';
                    const parent = likesCountEl.parentElement;
                    if (parent) {
                        parent.innerHTML = `<span id="likesCount">${data.likes_count}</span> ${likeText}`;
                    }
                }
                
                // Update button state
                if (data.liked) {
                    this.setAttribute('data-liked', 'true');
                    this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                    this.classList.add('bg-red-100', 'text-red-600', 'dark:!bg-red-900/20', 'dark:!text-red-400');
                    const svg = this.querySelector('svg');
                    if (svg) {
                        svg.setAttribute('fill', 'currentColor');
                    }
                } else {
                    this.setAttribute('data-liked', 'false');
                    this.classList.remove('bg-red-100', 'text-red-600', 'dark:!bg-red-900/20', 'dark:!text-red-400');
                    this.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200', 'dark:!bg-bg-card-hover', 'dark:!text-white', 'dark:!hover:bg-bg-card');
                    const svg = this.querySelector('svg');
                    if (svg) {
                        svg.setAttribute('fill', 'none');
                    }
                }
            })
            .catch(error => {
                this.disabled = false;
                console.error('Error:', error);
                alert('Failed to like article. Please try again.');
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/articles/show.blade.php ENDPATH**/ ?>