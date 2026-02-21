<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Fadaee_Elementor_Testimonials_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_testimonials';
    }

    public function get_title() {
        return 'نظرات مشتریان (Fadaee)';
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => 'عنوان بخش',
            'type' => Controls_Manager::TEXT,
            'default' => 'نظرات مشتریان',
        ]);

        $this->add_control('subtitle', [
            'label' => 'توضیح بخش',
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => 'مشتری‌ها در مورد همکاری با من چه می‌گویند؟',
        ]);

        $this->add_control('items', [
            'label' => 'تعداد نظرات',
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'max' => 24,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $title = isset($settings['title']) ? $settings['title'] : '';
        $subtitle = isset($settings['subtitle']) ? $settings['subtitle'] : '';
        $items = !empty($settings['items']) ? (int) $settings['items'] : 6;

        $query = new WP_Query([
            'post_type' => 'testimonial',
            'posts_per_page' => $items,
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
                        <?php if (!empty($title)): ?>
                            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        <?php if (!empty($subtitle)): ?>
                            <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 max-w-xl">
                                <?php echo esc_html($subtitle); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($query->have_posts()): ?>
                    <div class="scroll-container scrollbar-hidden py-1">
                        <?php while ($query->have_posts()): $query->the_post(); ?>
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
                            <article class="scroll-item testimonial-item max-w-sm">
                                <div class="relative overflow-hidden rounded-2xl bg-white/90 dark:bg-zinc-900/90 border border-zinc-200/70 dark:border-zinc-800/70 shadow-sm hover:shadow-lg transition-shadow duration-200">
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
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l-1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
        <?php
    }
}

