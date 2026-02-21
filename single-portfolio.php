<?php
/**
 * Template for displaying single portfolio items
 */

get_header();

while (have_posts()) : the_post();
    $post_id = get_the_ID();
    
    // Get custom fields
    $project_image = get_post_meta($post_id, '_project_image', true);
    $project_url = get_post_meta($post_id, '_project_url', true);
    $project_technologies = get_post_meta($post_id, '_project_technologies', true);
    
    // Get categories
    $categories = get_the_terms($post_id, 'portfolio_category');
?>

<main class="flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
    <div class="mx-auto max-w-4xl">
        
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="group inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 transition">
                <div class="h-4 w-4 -scale-x-100 stroke-zinc-500 group-hover:stroke-zinc-700 dark:stroke-zinc-400">
                    <svg viewBox="0 0 16 16" fill="none" class="h-4 w-4 stroke-zinc-500 group-hover:stroke-zinc-700 dark:stroke-zinc-400 arrow">
                        <path d="M7.25 11.25 3.75 8m0 0 3.5-3.25M3.75 8h8.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span>بازگشت به نمونه‌کارها</span>
            </a>
        </div>

        <nav class="article-breadcrumbs mb-6 sm:mb-8 overflow-x-auto" aria-label="Breadcrumb">
            <?php
            if (function_exists('rank_math_the_breadcrumbs')) {
                rank_math_the_breadcrumbs();
            } elseif (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p class="yoast-breadcrumbs">','</p>');
            } else {
                ?>
                <div class="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors">
                        خانه
                    </a>
                    <span class="mx-1.5 text-zinc-400">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors">
                        نمونه‌کارها
                    </a>
                    <span class="mx-1.5 text-zinc-400">/</span>
                    <span class="text-zinc-700 dark:text-zinc-200">
                        <?php the_title(); ?>
                    </span>
                </div>
                <?php
            }
            ?>
        </nav>

        <!-- Portfolio Header -->
        <article class="portfolio-single">
            <header class="mb-8 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight mb-4">
                    <?php the_title(); ?>
                </h1>
                
                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                    <?php if ($categories && !is_wp_error($categories)) : ?>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M2.5 3A1.5 1.5 0 001 4.5v4A1.5 1.5 0 002.5 10h6A1.5 1.5 0 0010 8.5v-4A1.5 1.5 0 008.5 3h-6zm11 2A1.5 1.5 0 0012 6.5v7a1.5 1.5 0 001.5 1.5h4a1.5 1.5 0 001.5-1.5v-7A1.5 1.5 0 0017.5 5h-4zm-10 7A1.5 1.5 0 002 13.5v2A1.5 1.5 0 003.5 17h6a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 12h-6z" clip-rule="evenodd" />
                            </svg>
                            <?php 
                            $cat_names = array();
                            foreach ($categories as $category) {
                                $cat_names[] = $category->name;
                            }
                            echo implode(', ', $cat_names);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <span>•</span>
                    
                    <time datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date('F j, Y'); ?>
                    </time>
                    
                    <?php if ($project_url) : ?>
                        <span>•</span>
                        <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                            </svg>
                            مشاهده پروژه
                        </a>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 sm:mb-12 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-zinc-900/5 dark:ring-white/10">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
                </div>
            <?php elseif ($project_image) : ?>
                <div class="mb-8 sm:mb-12 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-zinc-900/5 dark:ring-white/10">
                    <img src="<?php echo esc_url($project_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-auto">
                </div>
            <?php endif; ?>

            <!-- Technologies Used -->
            <?php if (!empty($project_technologies) && is_array($project_technologies)) : ?>
                <div class="mb-8 sm:mb-12 p-6 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-500">
                            <path fill-rule="evenodd" d="M6 4.75A.75.75 0 016.75 4h10.5a.75.75 0 010 1.5H6.75A.75.75 0 016 4.75zM6 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H6.75A.75.75 0 016 10zm0 5.25a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H6.75a.75.75 0 01-.75-.75zM1.99 4.75a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1v-.01zM1.99 15.25a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1v-.01zM1.99 10a1 1 0 011-1H3a1 1 0 011 1v.01a1 1 0 01-1 1h-.01a1 1 0 01-1-1V10z" clip-rule="evenodd" />
                        </svg>
                        تکنولوژی‌های استفاده شده
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        $tech_labels = array(
                            'figma' => 'Figma',
                            'wordpress' => 'WordPress',
                            'github' => 'GitHub',
                            'woocommerce' => 'WooCommerce',
                            'jetengine' => 'Jet Engine',
                            'react' => 'React',
                            'vue' => 'Vue.js',
                            'angular' => 'Angular',
                            'javascript' => 'JavaScript',
                            'php' => 'PHP',
                            'mysql' => 'MySQL',
                            'html' => 'HTML',
                            'css' => 'CSS',
                            'sass' => 'Sass',
                            'bootstrap' => 'Bootstrap',
                            'tailwind' => 'Tailwind CSS',
                            'laravel' => 'Laravel',
                            'nodejs' => 'Node.js',
                            'python' => 'Python',
                            'photoshop' => 'Photoshop',
                            'illustrator' => 'Illustrator',
                            'xd' => 'Adobe XD',
                        );
                        
                        foreach ($project_technologies as $tech) {
                            $label = isset($tech_labels[$tech]) ? $tech_labels[$tech] : $tech;
                            echo '<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">' . esc_html($label) . '</span>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="article-content prose prose-zinc dark:prose-invert max-w-none prose-headings:scroll-mt-20 prose-headings:font-bold prose-h2:text-2xl prose-h2:sm:text-3xl prose-h3:text-xl prose-h3:sm:text-2xl prose-a:text-red-600 hover:prose-a:text-red-500 dark:prose-a:text-red-400 prose-img:rounded-xl prose-img:shadow-lg">
                <?php the_content(); ?>
            </div>

            <!-- Excerpt if exists -->
            <?php if (has_excerpt()) : ?>
                <div class="mt-8 p-6 bg-red-50 dark:bg-red-900/20 border-r-4 border-red-500 rounded-lg">
                    <p class="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>

            <!-- Navigation -->
            <div class="mt-12 sm:mt-16 pt-8 border-t border-zinc-200 dark:border-zinc-800">
                <div class="flex flex-col sm:flex-row justify-between gap-6">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" class="group flex-1 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition border border-zinc-200 dark:border-zinc-800">
                            <div class="text-xs text-zinc-500 dark:text-zinc-500 mb-1 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                                </svg>
                                پروژه قبلی
                            </div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-500 dark:group-hover:text-red-400 transition">
                                <?php echo get_the_title($prev_post); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>" class="group flex-1 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition border border-zinc-200 dark:border-zinc-800 text-left">
                            <div class="text-xs text-zinc-500 dark:text-zinc-500 mb-1 flex items-center gap-1 justify-end">
                                پروژه بعدی
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-500 dark:group-hover:text-red-400 transition text-right">
                                <?php echo get_the_title($next_post); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </article>

    </div>
</main>

<?php
endwhile;
get_footer();
?>
