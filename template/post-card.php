<?php
$post_id = get_the_ID();
$views = fadaee_get_post_views($post_id);
$likes = get_post_meta($post_id, 'likes_count', true) ?: 0;
$comments = get_comments_number($post_id);
?>

<article class="group relative flex flex-col">

    <?php if (has_post_thumbnail()): ?>
        <div class="relative aspect-video w-full overflow-hidden rounded-xl sm:rounded-2xl bg-zinc-100 dark:bg-zinc-800">
            <a href="<?php the_permalink(); ?>" class="block">
                <img 
                    src="<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>" 
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                />
            </a>
        </div>
    <?php endif; ?>

    <div class="flex flex-col flex-1 mt-4 sm:mt-6">
        
        <div class="flex items-center gap-3 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
            <time datetime="<?php echo get_the_date('c'); ?>">
                <?php echo get_the_date('F j, Y'); ?>
            </time>

            <span>•</span>
            <span><?php echo fadaee_persian_numbers($views); ?> <?php echo fadaee_translate('views'); ?></span>

            <?php if ($comments > 0): ?>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m5 8l-4.586-4.586A2 2 0 0012.172 15H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v6a2 2 0 01-2 2h-1.172A2 2 0 0016 17.414L18.586 20z" />
                    </svg>
                    <?php echo fadaee_persian_numbers($comments); ?>
                </span>
            <?php endif; ?>

            <?php if ($likes > 0): ?>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                    </svg>
                    <?php echo fadaee_persian_numbers($likes); ?>
                </span>
            <?php endif; ?>
        </div>

        <h2 class="mt-3 sm:mt-4 text-lg sm:text-xl font-semibold leading-tight">
            <a href="<?php the_permalink(); ?>" class="text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                <?php the_title(); ?>
            </a>
        </h2>

        <p class="mt-2 sm:mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-400 line-clamp-3">
            <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
        </p>

        <a href="<?php the_permalink(); ?>" class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors group/link">
            <svg class="h-4 w-4 transition-transform group-hover/link:translate-x-1 arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
            <?php echo fadaee_translate('read_more'); ?>

        </a>
    </div>
</article>
