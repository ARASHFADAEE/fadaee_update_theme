<?php get_header() ?>

<main class="flex-1 px-4 sm:px-8 mt-8 sm:mt-12 pb-16 sm:pb-24">
    <div class="mx-auto max-w-7xl">

        <header class="max-w-3xl">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                آموزش رایگان لاراول ۱۲
            </h1>

            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                سرفصل‌ها و مقالات مرتبط با دسته لاراول برای شروع و تسلط بر نسخه ۱۲.
            </p>
        </header>

        <!-- Articles Grid -->
        <div class="mt-12 sm:mt-16 md:mt-24 grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">

        <?php
        $query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 12,
            'cat'            => 38,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        if ( $query->have_posts() ):
            while ( $query->have_posts() ):
                $query->the_post();

                $post_id = get_the_ID();
                $views = fadaee_get_post_views($post_id);
                $likes = get_post_meta($post_id, 'likes_count', true) ?: 0;
                ?>

                <article class="group relative flex flex-col">
                    <?php if ( has_post_thumbnail() ): ?>
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
                            <span><?php echo fadaee_persian_numbers($views); ?> بازدید</span>

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
                            ادامه مطلب
                        </a>
                    </div>
                </article>

            <?php
            endwhile;
        else:
            ?>
            <div class="col-span-full text-center py-12">
                <p class="text-lg text-zinc-600 dark:text-zinc-400">هیچ مقاله‌ای یافت نشد.</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
        </div>

    </div>
</main>

<?php get_footer() ?>
