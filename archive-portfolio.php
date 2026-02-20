<?php
/**
 * Template for displaying portfolio archive
 */

get_header();
?>

<main class="flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
    <div class="mx-auto max-w-7xl">
        
        <!-- Page Header -->
        <header class="mb-12 sm:mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight mb-4">
                نمونه‌کارها
            </h1>
            <p class="text-lg text-zinc-600 dark:text-zinc-400 max-w-3xl">
                مجموعه‌ای از پروژه‌های موفق که با تیم حرفه‌ای ما پیاده‌سازی شده‌اند
            </p>
        </header>

        <!-- Category Filter -->
        <?php
        $categories = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => true,
        ));
        
        if ($categories && !is_wp_error($categories)) :
        ?>
            <div class="mb-8 sm:mb-12">
                <div class="flex flex-wrap gap-2">
                    <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition <?php echo !is_tax('portfolio_category') ? 'bg-red-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'; ?>">
                        همه
                    </a>
                    <?php foreach ($categories as $category) : ?>
                        <a href="<?php echo get_term_link($category); ?>" 
                           class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition <?php echo is_tax('portfolio_category', $category->term_id) ? 'bg-red-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'; ?>">
                           <span class="mr-1.5 text-xs opacity-75">(<?php echo $category->count; ?>)</span>
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Portfolio Grid -->
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <?php while (have_posts()) : the_post(); 
                    $post_id = get_the_ID();
                    $project_image = get_post_meta($post_id, '_project_image', true);
                    $project_url = get_post_meta($post_id, '_project_url', true);
                    $project_technologies = get_post_meta($post_id, '_project_technologies', true);
                    $categories = get_the_terms($post_id, 'portfolio_category');
                    $comments = get_comments_number($post_id);
                ?>
                    <article class="group relative flex flex-col bg-white dark:bg-zinc-900 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-zinc-200 dark:border-zinc-800">
                        
                        <!-- Image -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', array(
                                        'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110',
                                        'loading' => 'lazy'
                                    )); ?>
                                <?php elseif ($project_image) : ?>
                                    <img src="<?php echo esc_url($project_image); ?>" 
                                         alt="<?php echo esc_attr(get_the_title()); ?>" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         loading="lazy">
                                <?php else : ?>
                                    <div class="w-full h-full flex items-center justify-center text-zinc-400 dark:text-zinc-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </a>
                            
                            <!-- Category Badge -->
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 dark:bg-zinc-900/90 text-zinc-900 dark:text-zinc-100 backdrop-blur-sm">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 p-5 sm:p-6">
                            <h2 class="text-lg sm:text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-2 group-hover:text-red-500 dark:group-hover:text-red-400 transition">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <?php if (has_excerpt()) : ?>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-4">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Technologies -->
                            <?php if (!empty($project_technologies) && is_array($project_technologies)) : ?>
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    <?php 
                                    $displayed_count = 0;
                                    $max_display = 3;
                                    foreach ($project_technologies as $tech) : 
                                        if ($displayed_count >= $max_display) break;
                                        $displayed_count++;
                                    ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                            <?php echo esc_html($tech); ?>
                                        </span>
                                    <?php endforeach; ?>
                                    <?php if (count($project_technologies) > $max_display) : ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                            +<?php echo count($project_technologies) - $max_display; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition">
                                    مشاهده جزئیات
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <div class="flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400">
                                    <?php if ($project_url) : ?>
                                        <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m5 8l-4.586-4.586A2 2 0 0012.172 15H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v6a2 2 0 01-2 2h-1.172A2 2 0 0016 17.414L18.586 20z" />
                                        </svg>
                                        <span><?php echo fadaee_persian_numbers($comments); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if (paginate_links()) : ?>
                <nav class="mt-12 sm:mt-16 flex justify-center" aria-label="Pagination">
                    <div class="pagination">
                        <?php
                        echo paginate_links(array(
                            'prev_text' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>',
                            'next_text' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>',
                            'type' => 'list',
                        ));
                        ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <!-- No Posts Found -->
            <div class="text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-zinc-400 dark:text-zinc-600 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                </svg>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                    نمونه‌کاری یافت نشد
                </h2>
                <p class="text-zinc-600 dark:text-zinc-400">
                    در حال حاضر هیچ نمونه‌کاری در این دسته‌بندی وجود ندارد.
                </p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
