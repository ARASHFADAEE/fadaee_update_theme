<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;

class Fadaee_Elementor_Blog_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_blog';
    }

    public function get_title() {
        return 'یادداشت‌ها / مقالات (Fadaee)';
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('section_title', [
            'label' => 'عنوان بخش',
            'type' => Controls_Manager::TEXT,
            'default' => fadaee_translate('recent_notes'),
        ]);

        $this->add_control('items_per_page', [
            'label' => 'تعداد یادداشت‌ها',
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 12,
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => 'استایل آیتم‌ها',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => 'رنگ عنوان',
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .fadaee-blog-item-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-blog-item-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
        $items_per_page = isset($settings['items_per_page']) ? (int) $settings['items_per_page'] : 4;

        $the_query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $items_per_page,
        ]);

        ?>
        <div class="max-w-6xl mx-auto px-6 pt-10" style="text-align: right;">
            <div class="flex items-center justify-between mb-8 sm:mb-12">
                <?php if (!empty($section_title)): ?>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        <?php echo esc_html($section_title); ?>
                    </h2>
                <?php endif; ?>

                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"
                   class="text-sm sm:text-base font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                    ←<?php echo esc_html(fadaee_translate('view_all')); ?>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">
                <?php if ($the_query->have_posts()): ?>
                    <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php
                        $post_id = get_the_ID();
                        $views = fadaee_get_post_views($post_id);
                        ?>
                        <article class="group">
                            <a href="<?php the_permalink(); ?>"
                               class="fadaee-blog-item-title text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                <div class="text-lg sm:text-xl font-semibold leading-tight mb-2">
                                    <?php the_title(); ?>
                                </div>
                            </a>

                            <div class="flex items-center gap-2 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mb-2">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                                <span>•</span>
                                <span><?php echo esc_html(fadaee_persian_numbers($views)); ?> <?php echo esc_html(fadaee_translate('views')); ?></span>
                            </div>

                            <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 line-clamp-3">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                            </p>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

