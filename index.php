



<?php get_header() ?>

<main class="flex-1 px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 lg:pt-24 pb-16 sm:pb-24">
    <div class="mx-auto max-w-7xl">
        <header class="max-w-3xl">
            <?php
            $blog_page_title = arash_get_theme_option('blog_page_title');
            $blog_page_description = arash_get_theme_option('blog_page_description');
            ?>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight" style="font-size: clamp(1.75rem, 5vw, 2.5rem);">
                <?php echo esc_html($blog_page_title); ?>
            </h1>

            <?php if (!empty($blog_page_description)): ?>
                <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-relaxed text-zinc-600 dark:text-zinc-400" style="font-size: clamp(1rem, 2.5vw, 1.125rem); line-height: 1.75;">
                    <?php echo esc_html($blog_page_description); ?>
                </p>
            <?php endif; ?>
        </header>

        <section class="mt-6 sm:mt-8 lg:mt-10">
            <div class="bg-white/80 dark:bg-zinc-900/80 border border-zinc-200/80 dark:border-zinc-800/80 rounded-2xl sm:rounded-3xl px-4 sm:px-6 py-4 sm:py-5 shadow-sm backdrop-blur">
                <div class="flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center">
                    <div class="flex-1">
                        <div class="relative">
                            <input
                                id="blog-search"
                                type="text"
                                placeholder="جستجو در مقالات..."
                                class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50/80 dark:bg-zinc-900/80 px-4 py-2.5 pr-9 text-sm sm:text-base text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/80 focus:border-transparent"
                            />
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="7" />
                                    <line x1="16.5" y1="16.5" x2="21" y2="21" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="md:w-px h-px md:h-9 bg-zinc-200 dark:bg-zinc-800 md:mx-2 lg:mx-4"></div>

                    <div class="flex-1 md:flex-initial">
                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                class="blog-category-chip active flex items-center gap-2 rounded-full px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-red-600 text-white shadow-sm hover:bg-red-500 transition-colors"
                                data-category=""
                            >
                                <span>همه مقالات</span>
                            </button>
                            <?php
                            $categories = get_categories(array(
                                'hide_empty' => true,
                                'number'     => 6,
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                            ));
                            foreach ($categories as $category): ?>
                                <button
                                    type="button"
                                    class="blog-category-chip flex items-center gap-2 rounded-full px-3 sm:px-4 py-1.5 text-xs sm:text-sm font-medium bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                                    data-category="<?php echo esc_attr($category->term_id); ?>"
                                >
                                    <span><?php echo esc_html($category->name); ?></span>
                                    <span class="text-[0.7rem] sm:text-xs text-zinc-400">
                                        <?php echo fadaee_persian_numbers($category->count); ?>
                                    </span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="blog-filters-meta" class="hidden"
             data-page="1"
             data-max-pages="<?php echo esc_attr($wp_query->max_num_pages); ?>"
             data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
        </div>

        <section class="mt-8 sm:mt-10 lg:mt-12">
            <div id="post-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ):
                        the_post();
                        get_template_part('template/post-card', 'post-card');
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

            <div class="flex justify-center mt-8 sm:mt-10 lg:mt-12">
                <button id="loadmore" 
                        data-page="1" 
                        data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" 
                        class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-3.5 bg-red-600 hover:bg-red-500 text-white text-sm sm:text-base font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <span>مشاهده بیشتر</span>
                    <svg class="mr-2 h-5 w-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </section>
    </div>
</main>

<?php get_footer()?>
