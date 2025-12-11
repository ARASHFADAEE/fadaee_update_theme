



<?php get_header() ?>

<main class="flex-1 px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 lg:pt-24 pb-16 sm:pb-24">
    <div class="mx-auto max-w-7xl">
        <header class="max-w-3xl">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight" style="font-size: clamp(1.75rem, 5vw, 2.5rem);">
                <?php echo fadaee_translate('everything_more'); ?>
            </h1>

            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-relaxed text-zinc-600 dark:text-zinc-400" style="font-size: clamp(1rem, 2.5vw, 1.125rem); line-height: 1.75;">
                <?php echo fadaee_translate('blog_description'); ?>
            </p>
        </header>

        <!-- Articles Grid -->
        <div id="post-container" class="mt-8 sm:mt-12 lg:mt-16 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">


            <?php
            if ( have_posts() ) :
                while ( have_posts() ):
                    the_post();
                    $post_id = get_the_ID();
                    $views = fadaee_get_post_views($post_id);
                    $likes = get_post_meta($post_id, 'likes_count', true) ?: 0;
                    ?>
                    <article class="group relative flex flex-col bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-zinc-200 dark:border-zinc-800">
                        <?php if ( has_post_thumbnail() ): ?>
                            <div class="relative aspect-video w-full overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                                <a href="<?php the_permalink(); ?>" class="block">
                                    <img 
                                        src="<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>" 
                                        alt="<?php echo esc_attr(get_the_title()); ?>"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        loading="lazy"
                                    />
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex flex-col flex-1 p-4 sm:p-6">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
                                <time datetime="<?php echo get_the_date('c'); ?>" class="whitespace-nowrap"><?php echo get_the_date('F j, Y'); ?></time>
                                <span class="hidden sm:inline">•</span>
                                <span class="whitespace-nowrap"><?php echo fadaee_persian_numbers($views); ?> <?php echo fadaee_translate('views'); ?></span>
                                <?php if ($likes > 0): ?>
                                    <span class="hidden sm:inline">•</span>
                                    <span class="flex items-center gap-1 whitespace-nowrap">
                                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                        </svg>
                                        <?php echo fadaee_persian_numbers($likes); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h2 class="mt-3 sm:mt-4 text-lg sm:text-xl lg:text-2xl font-bold leading-tight" style="font-size: clamp(1.125rem, 3vw, 1.5rem); line-height: 1.3;">
                                <a href="<?php the_permalink(); ?>" class="text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <p class="mt-2 sm:mt-3 text-sm sm:text-base leading-relaxed text-zinc-600 dark:text-zinc-400 line-clamp-3" style="font-size: clamp(0.9375rem, 2vw, 1rem); line-height: 1.75;">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>
                            
                            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm sm:text-base font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors group/link">
                                    <?php echo fadaee_translate('read_more'); ?>
                                    <svg class="h-4 w-4 transition-transform group-hover/link:translate-x-1 arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
            else:
                ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-lg text-zinc-600 dark:text-zinc-400"><?php echo fadaee_translate('no_posts'); ?></p>
                </div>
            <?php
            endif;
            ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8 sm:mt-12 lg:mt-16">
            <button id="loadmore" 
                    data-page="1" 
                    data-url="<?php echo admin_url('admin-ajax.php'); ?>" 
                    class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-3.5 bg-red-600 hover:bg-red-500 text-white text-sm sm:text-base font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                <span>مشاهده بیشتر</span>
                <svg class="mr-2 h-5 w-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
</main>




<?php get_footer()?>
