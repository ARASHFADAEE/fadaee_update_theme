
<?php get_header('single')?>


<?php

$post_id = get_the_ID();
$post_title = get_the_title($post_id);
$post_content = get_the_content();
$post_date = get_the_time('F j, Y');
$post_author = the_author_meta('display_name', $post_id);



?>
    <!-- Main Article Content -->
    <main class="flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-4xl">

            <!-- Back Button -->
            <div class="mb-8 sm:mb-12">
                <a href="<?php echo get_home_url()?>" class="group inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 transition">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-md ring-1 ring-zinc-900/5 transition group-hover:ring-zinc-900/10 dark:bg-zinc-800 dark:ring-0">
                        <svg viewBox="0 0 16 16" fill="none" class="h-4 w-4 stroke-zinc-500 group-hover:stroke-zinc-700 dark:stroke-zinc-400 arrow">
                            <path d="M7.25 11.25 3.75 8m0 0 3.5-3.25M3.75 8h8.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span><?php echo fadaee_translate('back_to_home'); ?></span>
                </a>
            </div>

            <article class="prose prose-zinc dark:prose-invert max-w-none prose-img:rounded-xl prose-img:shadow-lg" dir="rtl" >
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-zinc-900 dark:text-white leading-tight" style="font-size: clamp(1.75rem, 5vw, 2.5rem);">
                        <?= $post_title ?>
                    </h1>
                    <div class="mt-4 sm:mt-6 flex flex-wrap items-center gap-2 sm:gap-4 text-sm sm:text-base text-zinc-500 dark:text-zinc-400">
                        <time datetime="2025-08-21"><?= $post_date?></time>
                        <span>•</span>
                        <span><?php echo $post_author?></span>
                    </div>
                </div>

                <div class="mt-8 sm:mt-12 prose-headings:scroll-mt-20 prose-headings:font-bold prose-h2:text-xl prose-h2:sm:text-2xl prose-h3:text-lg prose-h3:sm:text-xl prose-a:text-red-600 hover:prose-a:text-red-500 dark:prose-a:text-red-400" style="font-size: 17px; line-height: 1.8;">

                    <!-- Hero Image -->
                    <img
                        src="<?= get_the_post_thumbnail_url($post_id) ?>"
                        alt="<?= esc_attr($post_title) ?>"
                        class="w-full rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl ring-1 ring-zinc-900/5 dark:ring-white/10"
                        loading="lazy"
                    />


                    <div class="content pt-6 sm:pt-10 prose-p:text-base prose-p:sm:text-lg prose-p:leading-relaxed" style="font-size: 17px; line-height: 1.8;">


                        <?= $post_content ?>

                    </div>
                </div>

                <!-- Engagement Footer -->
                <div class="not-prose mt-12 sm:mt-16 border-t border-zinc-200 dark:border-zinc-700 pt-6 sm:pt-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                        <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 order-2 sm:order-1">
                            <span><?php echo fadaee_persian_numbers(fadaee_get_post_views($post_id)); ?> <?php echo fadaee_translate('views'); ?></span>
                            <span class="mx-2 sm:mx-3">•</span>
                            <span><?php echo fadaee_persian_numbers(get_post_meta($post_id, 'likes_count', true) ?: 0); ?> <?php echo fadaee_translate('likes'); ?></span>
                        </div>
                        <div class="flex gap-2 sm:gap-4 order-1 sm:order-2">
                            <button id="Like_Post" data-post_id="<?php echo $post_id ?>" class="Like_Post flex items-center justify-center gap-1.5 sm:gap-2 rounded-lg bg-green-50 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-green-700 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 transition-colors flex-1 sm:flex-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                <span><?php echo fadaee_persian_numbers(get_post_meta($post_id, 'likes_count', true) ?: 0); ?></span>
                            </button>
                            <button id="DisLike_Post" data-post_id="<?php echo $post_id; ?>" class="flex items-center justify-center gap-1.5 sm:gap-2 rounded-lg bg-red-50 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 transition-colors flex-1 sm:flex-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/></svg>
                                <span><?php echo fadaee_persian_numbers(get_post_meta($post_id, 'dislikes_count', true) ?: 0); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>



<?php
get_footer('single');?>