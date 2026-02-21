<?php get_header()?>
    <main class="flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
        <?php
        $hero_headline = arash_get_theme_option('hero_headline');
        $hero_subheadline = arash_get_theme_option('hero_subheadline');
        $hero_primary_button_label = arash_get_theme_option('hero_primary_button_label');
        $hero_primary_button_url = arash_get_theme_option('hero_primary_button_url');
        $hero_secondary_button_label = arash_get_theme_option('hero_secondary_button_label');
        $hero_secondary_button_url = arash_get_theme_option('hero_secondary_button_url');
        $hero_background_type = arash_get_theme_option('hero_background_type');
        $hero_background_image_id = arash_get_theme_option('hero_background_image');
        $hero_style = '';

        if ($hero_background_type === 'image' && $hero_background_image_id) {
            $hero_background_image_id = (int) $hero_background_image_id;
            $hero_image_url = wp_get_attachment_image_url($hero_background_image_id, 'full');
            if ($hero_image_url) {
                $hero_style = 'background-image:url(' . $hero_image_url . ');background-size:cover;background-position:center;';
            }
        }

        $social_options = arash_get_theme_options();
        $social_links = [];

        if (!empty($social_options['social_github'])) {
            $icon_id = !empty($social_options['social_github_icon']) ? (int) $social_options['social_github_icon'] : 0;
            $social_links[] = [
                'key' => 'github',
                'label' => 'GitHub',
                'url' => $social_options['social_github'],
                'icon_id' => $icon_id,
            ];
        }

        if (!empty($social_options['social_linkedin'])) {
            $icon_id = !empty($social_options['social_linkedin_icon']) ? (int) $social_options['social_linkedin_icon'] : 0;
            $social_links[] = [
                'key' => 'linkedin',
                'label' => 'LinkedIn',
                'url' => $social_options['social_linkedin'],
                'icon_id' => $icon_id,
            ];
        }

        if (!empty($social_options['social_twitter'])) {
            $icon_id = !empty($social_options['social_twitter_icon']) ? (int) $social_options['social_twitter_icon'] : 0;
            $social_links[] = [
                'key' => 'twitter',
                'label' => 'Twitter',
                'url' => $social_options['social_twitter'],
                'icon_id' => $icon_id,
            ];
        }

        if (!empty($social_options['social_dribbble'])) {
            $icon_id = !empty($social_options['social_dribbble_icon']) ? (int) $social_options['social_dribbble_icon'] : 0;
            $social_links[] = [
                'key' => 'dribbble',
                'label' => 'Dribbble',
                'url' => $social_options['social_dribbble'],
                'icon_id' => $icon_id,
            ];
        }

        if (!empty($social_options['social_email'])) {
            $social_links[] = [
                'key' => 'email',
                'label' => 'Email',
                'url' => 'mailto:' . $social_options['social_email'],
                'icon_id' => 0,
            ];
        }
        ?>
        <section class="hero-section-custom rounded-3xl lg:rounded-[2rem] px-4 sm:px-8 py-8 sm:py-10 shadow-sm backdrop-blur" style="<?php echo esc_attr($hero_style); ?>">
        <div class="mx-auto max-w-2xl lg:max-w-5xl">

            <?php
            $hero_avatar_id = (int) arash_get_theme_option('hero_avatar_id');
            $hero_avatar_url = $hero_avatar_id ? wp_get_attachment_image_url($hero_avatar_id, 'thumbnail') : THEME_URL . '/assets/img/arashfadaee-640.BGHMnvoM.webp';
            ?>
            <a href="/" class="block h-14 w-14 sm:h-16 sm:w-16 origin-left transition-transform hover:scale-105 mb-4 sm:mb-6 relative">
                <img src="<?php echo esc_url($hero_avatar_url); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                     class="h-14 w-14 sm:h-16 sm:w-16 rounded-full object-cover shadow-lg ring-4 ring-white/90 dark:ring-zinc-700"
                     loading="eager" />
            </a>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight">
                <?php
                $headline_fallback = fadaee_translate('senior_web_developer');
                echo esc_html($hero_headline ? $hero_headline : $headline_fallback);
                ?>
            </h1>

            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                <?php
                $subheadline_fallback = fadaee_translate('intro_text');
                echo esc_html($hero_subheadline ? $hero_subheadline : $subheadline_fallback);
                ?>
            </p>

            <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-4 sm:gap-6">
                <?php if ($hero_primary_button_label && $hero_primary_button_url): ?>
                    <a href="<?php echo esc_url($hero_primary_button_url); ?>" class="inline-flex items-center rounded-full bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-zinc-100 shadow-sm hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200 transition">
                        <?php echo esc_html($hero_primary_button_label); ?>
                    </a>
                <?php endif; ?>

                <?php if ($hero_secondary_button_label && $hero_secondary_button_url): ?>
                    <a href="<?php echo esc_url($hero_secondary_button_url); ?>" class="inline-flex items-center rounded-full border border-zinc-300/80 px-5 py-2.5 text-sm font-semibold text-zinc-800 hover:border-red-400 hover:text-red-500 dark:border-zinc-700 dark:text-zinc-200 dark:hover:border-red-400 dark:hover:text-red-400 transition">
                        <?php echo esc_html($hero_secondary_button_label); ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($social_links)): ?>
                    <div class="flex items-center gap-3 sm:gap-4">
                        <?php foreach ($social_links as $social): ?>
                            <a href="<?php echo esc_url($social['url']); ?>" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors" aria-label="<?php echo esc_attr($social['label']); ?>" target="_blank" rel="noopener noreferrer">
                                <span class="sr-only"><?php echo esc_html($social['label']); ?></span>
                                <?php if (!empty($social['icon_id'])):
                                    $icon_url = wp_get_attachment_image_url((int) $social['icon_id'], 'thumbnail');
                                endif; ?>
                                <?php if (!empty($icon_url)): ?>
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($social['label']); ?>" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                                <?php else: ?>
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-xs font-semibold uppercase">
                                        <?php echo esc_html(mb_substr($social['label'], 0, 1)); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            $ids = array(107,105,86,20,18);

            $args = array(
                'post_type'      => 'portfolio',
                'post__in'       => $ids,
                'orderby'        => 'post__in',
                'posts_per_page' => -1
            );

            $query_portfolio = new WP_Query($args);
            ?>

            <div class="mt-12 sm:mt-16 md:mt-20 overflow-hidden py-4">
                <div class="scroll-container gap-4 sm:gap-6 md:gap-8">

                    <?php if ($query_portfolio->have_posts()) : ?>
                        <?php while ($query_portfolio->have_posts()) : $query_portfolio->the_post(); ?>

                            <a href="<?= esc_url(get_permalink()) ?>"
                               class="photo-item w-40 sm:w-56 md:w-72 flex-none block">
                                <img src="<?= esc_url(get_the_post_thumbnail_url()) ?>"
                                     alt="<?= esc_attr(get_the_title()) ?>"
                                     class="photo-tilt aspect-9/10 w-full rounded-xl sm:rounded-2xl object-cover shadow-lg sm:shadow-2xl"
                                     loading="lazy" />
                            </a>

                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>

                </div>
            </div>

        </div>
        </section>

        <?php
        $education_enabled = arash_get_theme_option('education_enabled');
        $work_enabled = arash_get_theme_option('work_enabled');
        $testimonials_enabled = arash_get_theme_option('testimonials_enabled');
        $education_order = (int) arash_get_theme_option('education_order');
        $work_order = (int) arash_get_theme_option('work_order');
        $testimonials_order = (int) arash_get_theme_option('testimonials_order');

        $home_sections = [];
        if ($education_enabled) {
            $home_sections[] = [
                'key' => 'education',
                'order' => $education_order ?: 1,
            ];
        }
        if ($work_enabled) {
            $home_sections[] = [
                'key' => 'work',
                'order' => $work_order ?: 2,
            ];
        }
        if ($testimonials_enabled) {
            $home_sections[] = [
                'key' => 'testimonials',
                'order' => $testimonials_order ?: 3,
            ];
        }

        if (!empty($home_sections)) {
            usort($home_sections, function ($a, $b) {
                if ($a['order'] === $b['order']) {
                    return 0;
                }
                return ($a['order'] < $b['order']) ? -1 : 1;
            });
        }
        ?>

        <?php foreach ($home_sections as $section): ?>
            <?php if ($section['key'] === 'education'): ?>
                <section class="w-full py-16 sm:py-20">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="flex items-center justify-between mb-8 sm:mb-10">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                    تحصیلات
                                </h2>
                                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400">
                                    مسیرهای آموزشی و مدارک تحصیلی من
                                </p>
                            </div>
                        </div>

                        <?php
                        $education_query = new WP_Query([
                            'post_type' => 'education',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        ]);
                        ?>

                        <?php if ($education_query->have_posts()): ?>
                            <div class="relative">
                                <div class="absolute inset-y-4 sm:inset-y-2 start-4 sm:start-1.5 w-px bg-gradient-to-b from-zinc-200 via-zinc-300 to-zinc-200 dark:from-zinc-800 dark:via-zinc-700 dark:to-zinc-800 pointer-events-none"></div>

                                <div class="space-y-8 sm:space-y-10 relative">
                                    <?php while ($education_query->have_posts()): $education_query->the_post(); ?>
                                        <?php
                                        $degree = get_post_meta(get_the_ID(), '_degree', true);
                                        $institution = get_post_meta(get_the_ID(), '_institution', true);
                                        $field = get_post_meta(get_the_ID(), '_field', true);
                                        $start = get_post_meta(get_the_ID(), '_start_date', true);
                                        $end = get_post_meta(get_the_ID(), '_end_date', true);
                                        $gpa = get_post_meta(get_the_ID(), '_gpa', true);
                                        ?>
                                        <article class="relative ps-10 sm:ps-8">
                                            <div class="absolute start-2 sm:start-0 top-2 h-3 w-3 rounded-full bg-zinc-900 dark:bg-zinc-100 ring-4 ring-zinc-100 dark:ring-zinc-900"></div>
                                            <div class="rounded-2xl bg-white/80 dark:bg-zinc-900/80 shadow-sm ring-1 ring-zinc-200/70 dark:ring-zinc-800/70 p-4 sm:p-6">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                                                    <div>
                                                        <h3 class="text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                                            <?php echo esc_html($degree ? $degree : get_the_title()); ?>
                                                        </h3>
                                                        <?php if ($institution): ?>
                                                            <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                                <?php echo esc_html($institution); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                        <?php if ($start || $end): ?>
                                                            <?php echo esc_html(trim($start . ' - ' . $end)); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php if ($field || $gpa): ?>
                                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                                        <?php if ($field): ?>
                                                            <span class="inline-flex items-center rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1 text-xs text-zinc-600 dark:text-zinc-300">
                                                                <?php echo esc_html($field); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if ($gpa): ?>
                                                            <span class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 px-3 py-1 text-xs">
                                                                معدل: <?php echo esc_html($gpa); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="prose prose-sm max-w-none text-zinc-600 dark:prose-invert dark:text-zinc-300">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                تحصیلی ثبت نشده است.
                            </p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($section['key'] === 'work'): ?>
                <section class="w-full py-16 sm:py-20 bg-zinc-50 dark:bg-zinc-950/40">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="flex items-center justify-between mb-8 sm:mb-10">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                    تجربه‌های کاری
                                </h2>
                                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400">
                                    همکاری‌ها و پروژه‌هایی که روی آن‌ها کار کرده‌ام
                                </p>
                            </div>
                        </div>

                        <?php
                        $work_query = new WP_Query([
                            'post_type' => 'work_experience',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        ]);
                        ?>

                        <?php if ($work_query->have_posts()): ?>
                            <div class="relative">
                                <div class="absolute inset-y-4 sm:inset-y-2 start-4 sm:start-1.5 w-px bg-gradient-to-b from-zinc-200 via-zinc-300 to-zinc-200 dark:from-zinc-800 dark:via-zinc-700 dark:to-zinc-800 pointer-events-none"></div>

                                <div class="space-y-8 sm:space-y-10 relative">
                                    <?php while ($work_query->have_posts()): $work_query->the_post(); ?>
                                        <?php
                                        $company = get_post_meta(get_the_ID(), '_company', true);
                                        $employment_type = get_post_meta(get_the_ID(), '_employment_type', true);
                                        $location = get_post_meta(get_the_ID(), '_location', true);
                                        $start = get_post_meta(get_the_ID(), '_work_start_date', true);
                                        $end = get_post_meta(get_the_ID(), '_work_end_date', true);
                                        $technologies_raw = get_post_meta(get_the_ID(), '_work_technologies', true);
                                        if (is_array($technologies_raw)) {
                                            $technologies = $technologies_raw;
                                        } elseif (!empty($technologies_raw) && is_string($technologies_raw)) {
                                            $technologies = array_map('trim', explode(',', $technologies_raw));
                                        } else {
                                            $technologies = [];
                                        }
                                        ?>
                                        <article class="relative ps-10 sm:ps-8">
                                            <div class="absolute start-2 sm:start-0 top-2 h-3 w-3 rounded-full bg-red-500 dark:bg-red-400 ring-4 ring-red-100/80 dark:ring-red-900/40"></div>
                                            <div class="rounded-2xl bg-white/80 dark:bg-zinc-900/80 shadow-sm ring-1 ring-zinc-200/70 dark:ring-zinc-800/70 p-4 sm:p-6">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                                                    <div>
                                                        <h3 class="text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                                            <?php the_title(); ?>
                                                        </h3>
                                                        <?php if ($company): ?>
                                                            <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                                <?php echo esc_html($company); ?>
                                                                <?php if ($location): ?>
                                                                    <span class="mx-1">•</span>
                                                                    <span><?php echo esc_html($location); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                        <?php if ($start || $end): ?>
                                                            <?php echo esc_html(trim($start . ' - ' . $end)); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php if ($employment_type || !empty($technologies)): ?>
                                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                                        <?php if ($employment_type): ?>
                                                            <span class="inline-flex items-center rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1 text-xs text-zinc-600 dark:text-zinc-300">
                                                                <?php echo esc_html($employment_type); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php
                                                        $clean_tech = array_values(array_filter(array_map('trim', $technologies), function($v){ return $v !== ''; }));
                                                        if (!empty($clean_tech)): ?>
                                                            <div class="flex flex-wrap gap-1.5">
                                                                <?php
                                                                $max_display = 4;
                                                                $displayed = 0;
                                                                foreach ($clean_tech as $tech_item):
                                                                    if ($displayed >= $max_display) {
                                                                        break;
                                                                    }
                                                                    $displayed++;
                                                                    ?>
                                                                    <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800 px-2.5 py-0.5 text-[0.7rem] font-medium text-zinc-700 dark:text-zinc-200">
                                                                        <?php echo esc_html($tech_item); ?>
                                                                    </span>
                                                                <?php endforeach; ?>
                                                                <?php if (count($clean_tech) > $max_display): ?>
                                                                    <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800 px-2.5 py-0.5 text-[0.7rem] font-medium text-zinc-500 dark:text-zinc-400">
                                                                        +<?php echo esc_html(fadaee_persian_numbers(count($clean_tech) - $max_display)); ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="prose prose-sm max-w-none text-zinc-600 dark:prose-invert dark:text-zinc-300">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                تجربه کاری ثبت نشده است.
                            </p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
            <?php if ($section['key'] === 'testimonials'): ?>
                <?php
                $testimonials_title = arash_get_theme_option('testimonials_title');
                $testimonials_subtitle = arash_get_theme_option('testimonials_subtitle');
                $testimonials_items = (int) arash_get_theme_option('testimonials_items');
                if (!$testimonials_items) {
                    $testimonials_items = 6;
                }
                $testimonials_query = new WP_Query([
                    'post_type' => 'testimonial',
                    'posts_per_page' => $testimonials_items,
                    'meta_query' => [
                        [
                            'key' => '_testimonial_featured',
                            'value' => 1,
                            'compare' => '=',
                        ],
                    ],
                ]);
                ?>
                <section class="w-full py-16 sm:py-20 bg-gradient-to-b from-white via-zinc-50 to-white dark:from-black dark:via-zinc-950 dark:to-black">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                    <?php echo esc_html($testimonials_title ? $testimonials_title : 'نظرات مشتریان'); ?>
                                </h2>
                                <?php if ($testimonials_subtitle): ?>
                                    <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 max-w-xl">
                                        <?php echo esc_html($testimonials_subtitle); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($testimonials_query->have_posts()): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                                <?php while ($testimonials_query->have_posts()): $testimonials_query->the_post(); ?>
                                    <?php
                                    $client_name = get_post_meta(get_the_ID(), '_client_name', true);
                                    $client_position = get_post_meta(get_the_ID(), '_client_position', true);
                                    $client_company = get_post_meta(get_the_ID(), '_client_company', true);
                                    $client_avatar = get_post_meta(get_the_ID(), '_client_avatar', true);
                                    $testimonial_rating = (int) get_post_meta(get_the_ID(), '_testimonial_rating', true);
                                    if ($testimonial_rating < 1 || $testimonial_rating > 5) {
                                        $testimonial_rating = 5;
                                    }
                                    $project_name = get_post_meta(get_the_ID(), '_project_name', true);
                                    ?>
                                    <article class="relative overflow-hidden rounded-2xl bg-white/90 dark:bg-zinc-900/90 border border-zinc-200/70 dark:border-zinc-800/70 shadow-sm hover:shadow-lg transition-shadow duration-200">
                                        <div class="absolute inset-0 pointer-events-none">
                                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-l from-red-500 via-orange-400 to-amber-400 dark:from-red-400 dark:via-orange-300 dark:to-amber-300 opacity-80"></div>
                                        </div>
                                        <div class="relative p-5 sm:p-6">
                                            <div class="flex items-start gap-4 mb-4">
                                                <div class="flex-shrink-0">
                                                    <?php if ($client_avatar): ?>
                                                        <img src="<?php echo esc_url($client_avatar); ?>" alt="<?php echo esc_attr($client_name ? $client_name : get_the_title()); ?>" class="h-12 w-12 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-800" loading="lazy" />
                                                    <?php else: ?>
                                                        <div class="h-12 w-12 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-sm font-semibold text-zinc-600 dark:text-zinc-300 ring-2 ring-zinc-100 dark:ring-zinc-800">
                                                            <?php echo esc_html(mb_substr($client_name ? $client_name : get_the_title(), 0, 1)); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between gap-2 mb-1">
                                                        <div>
                                                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                                                <?php echo esc_html($client_name ? $client_name : get_the_title()); ?>
                                                            </div>
                                                            <?php if ($client_position || $client_company): ?>
                                                                <div class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                                                    <?php if ($client_position): ?>
                                                                        <span><?php echo esc_html($client_position); ?></span>
                                                                    <?php endif; ?>
                                                                    <?php if ($client_company): ?>
                                                                        <?php if ($client_position): ?>
                                                                            <span class="mx-1">•</span>
                                                                        <?php endif; ?>
                                                                        <span><?php echo esc_html($client_company); ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <svg class="h-4 w-4 <?php echo $i <= $testimonial_rating ? 'text-amber-400' : 'text-zinc-300 dark:text-zinc-700'; ?>" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <?php if ($project_name): ?>
                                                        <div class="text-xs font-medium text-red-600 dark:text-red-400 mb-2">
                                                            <?php echo esc_html($project_name); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                                                <?php echo wp_kses_post(wp_trim_words(get_the_content(), 40, '...')); ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                هنوز نظری ثبت نشده است.
                            </p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php
        $home_categories_enabled = arash_get_theme_option('home_categories_enabled');
        $home_category_1 = (int) arash_get_theme_option('home_category_1');
        $home_category_2 = (int) arash_get_theme_option('home_category_2');
        $home_category_3 = (int) arash_get_theme_option('home_category_3');
        ?>

        <?php
        $home_category_ids = array_unique(array_filter([
            $home_category_1,
            $home_category_2,
            $home_category_3,
        ]));
        ?>

        <?php if ($home_categories_enabled && !empty($home_category_ids)): ?>
        <section class="w-full py-20 bg-gradient-to-b from-zinc-100 to-white dark:from-zinc-900 dark:to-black">
            <div class="max-w-6xl mx-auto px-6">

                <div class="text-center mb-12">
                    <div class="text-3xl font-bold text-zinc-800 dark:text-zinc-100 mb-4">دسته‌بندی مقالات</div>
                    <p class="text-zinc-600 dark:text-zinc-400 text-lg">موضوعات مختلف در حوزه برنامه‌نویسی را مرور کنید</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($home_category_ids as $cat_id):
                        $term = get_category($cat_id);
                        if (!$term || is_wp_error($term)) {
                            continue;
                        }
                        $term_link = get_term_link($term);
                        if (is_wp_error($term_link)) {
                            continue;
                        }
                        ?>
                        <div class="group relative rounded-2xl p-6 bg-white dark:bg-zinc-900 shadow hover:shadow-xl transition-all duration-300 border border-zinc-200/50 dark:border-zinc-700/40 cursor-pointer overflow-hidden">
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 transition duration-300"></div>
                            <div class="relative z-10">
                                <div class="text-xl font-semibold text-zinc-800 dark:text-zinc-100 mb-2">
                                    <?php echo esc_html($term->name); ?>
                                </div>
                                <?php if (!empty($term->description)): ?>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-sm mb-4">
                                        <?php echo esc_html(wp_trim_words($term->description, 18, '...')); ?>
                                    </p>
                                <?php endif; ?>
                                <a href="<?php echo esc_url($term_link); ?>">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-medium text-sm">مشاهده مقالات →</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>


        <?php
        $blog_enabled = arash_get_theme_option('blog_enabled');
        $blog_items_per_page = arash_get_theme_option('blog_items_per_page');
        if (!$blog_items_per_page) {
            $blog_items_per_page = 4;
        }
        ?>
        <?php if ($blog_enabled): ?>
        <div class="max-w-6xl mx-auto px-6 pt-10 " style="text-align: right;">
            <div class="flex items-center justify-between mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                    <?php echo fadaee_translate('recent_notes'); ?>
                </h2>

                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>"
                   class="text-sm sm:text-base font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                    ←<?php echo fadaee_translate('view_all'); ?> 
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">

                <?php
                $the_query = new WP_Query(array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => $blog_items_per_page,
                ));

                if ($the_query->have_posts()):
                    while ($the_query->have_posts()):
                        $the_query->the_post();
                        $post_id = get_the_ID();
                        $views = fadaee_get_post_views($post_id);
                        ?>
                        <article class="group">

                            <a href="<?php the_permalink(); ?>"
                               class="text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                <div class="text-lg sm:text-xl font-semibold leading-tight mb-2">
                                    <?php the_title(); ?>
                                </div>
                            </a>

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
        <?php endif; ?>

    </main>

<?php get_footer(); ?>
