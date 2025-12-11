<?php get_header()?>
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-8 mt-8 sm:mt-12 pb-16 sm:pb-24">
        <div class="mx-auto max-w-2xl lg:max-w-5xl">

            <!-- Avatar near content -->
            <a href="/" class="block h-14 w-14 sm:h-16 sm:w-16 origin-left transition-transform hover:scale-105 mb-4 sm:mb-6 relative">
                <img src="<?php echo THEME_URL?>/assets/img/arashfadaee-640.BGHMnvoM.webp" 
                     alt="Arash Fadaei" 
                     class="h-14 w-14 sm:h-16 sm:w-16 rounded-full object-cover shadow-lg ring-4 ring-white/90 dark:ring-zinc-700" 
                     loading="eager" />
            </a>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight">
                <?php echo fadaee_translate('senior_web_developer'); ?>
            </h1>
            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                <?php echo fadaee_translate('intro_text'); ?>
            </p>

            <!-- Social -->
            <div class="mt-6 sm:mt-8 flex gap-4 sm:gap-6">
                <a href="#" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors" aria-label="Social link">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor"><path d="M12 2..."/></svg>
                </a>
            </div>

            <!-- Photo Gallery -->
            <div class="mt-12 sm:mt-16 md:mt-20 overflow-hidden py-4">
                <div class="scroll-container gap-4 sm:gap-6 md:gap-8">
                    <div class="photo-item w-40 sm:w-56 md:w-72 flex-none">
                        <img src="<?php echo THEME_URL?>/assets/img/1.jpg" 
                             alt="Gallery image 1" 
                             class="photo-tilt aspect-9/10 w-full rounded-xl sm:rounded-2xl object-cover shadow-lg sm:shadow-2xl" 
                             loading="lazy" />
                    </div>
                    <div class="photo-item w-40 sm:w-56 md:w-72 flex-none">
                        <img src="<?php echo THEME_URL?>/assets/img/2.png" 
                             alt="Gallery image 2" 
                             class="photo-tilt aspect-9/10 w-full rounded-xl sm:rounded-2xl object-cover shadow-lg sm:shadow-2xl" 
                             loading="lazy" />
                    </div>
                    <div class="photo-item w-40 sm:w-56 md:w-72 flex-none">
                        <img src="<?php echo THEME_URL?>/assets/img/4.jpg" 
                             alt="Gallery image 3" 
                             class="photo-tilt aspect-9/10 w-full rounded-xl sm:rounded-2xl object-cover shadow-lg sm:shadow-2xl" 
                             loading="lazy" />
                    </div>
                    <div class="photo-item w-40 sm:w-56 md:w-72 flex-none">
                        <img src="<?php echo THEME_URL?>/assets/img/5.png" 
                             alt="Gallery image 4" 
                             class="photo-tilt aspect-9/10 w-full rounded-xl sm:rounded-2xl object-cover shadow-lg sm:shadow-2xl" 
                             loading="lazy" />
                    </div>
                </div>
            </div>

            <!-- Recent Articles -->
            <div class="mt-16 sm:mt-20 md:mt-24">
                <div class="flex items-center justify-between mb-8 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        <?php echo fadaee_translate('recent_notes'); ?>
                    </h2>
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" 
                       class="text-sm sm:text-base font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                        <?php echo fadaee_translate('view_all'); ?> ←
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">
                    <?php
                    $the_query = new WP_Query(array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => '4',
                    ));

                    if ($the_query->have_posts()):
                        while ($the_query->have_posts()):
                            $the_query->the_post();
                            $post_id = get_the_ID();
                            $views = fadaee_get_post_views($post_id);
                            ?>
                            <article class="group">

                                

                                <h3 class="text-lg sm:text-xl font-semibold leading-tight mb-2">
                                    <a href="<?php the_permalink(); ?>" 
                                       class="text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                                                <div class="flex items-center gap-2 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mb-2">
                                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                                    <span>•</span>
                                    <span><?php echo fadaee_persian_numbers($views); ?> <?php echo fadaee_translate('views'); ?></span>
                                </div>
                                
                                
                                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </article>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </main>



<?php get_footer(); ?>