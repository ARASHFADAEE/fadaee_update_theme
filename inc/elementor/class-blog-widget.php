<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Blog_Widget extends Widget_Base {

    private function get_blog_category_options() {
        $options = [];
        $categories = get_categories([
            'hide_empty' => false,
        ]);

        if (is_array($categories)) {
            foreach ($categories as $category) {
                $options[$category->term_id] = $category->name;
            }
        }

        return $options;
    }

    public function get_name() {
        return 'fadaee_blog';
    }

    public function get_title() {
        return esc_html__('یادداشت‌ها / مقالات (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('section_title', [
            'label' => esc_html__('عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => fadaee_translate('recent_notes'),
        ]);

        $this->add_control('items_per_page', [
            'label' => esc_html__('تعداد یادداشت‌ها', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 12,
        ]);

        $this->add_control('category_filter', [
            'label' => esc_html__('فیلتر دسته‌بندی', 'arash-theme'),
            'type' => Controls_Manager::SELECT2,
            'options' => $this->get_blog_category_options(),
            'multiple' => true,
            'label_block' => true,
        ]);

        $this->add_control('order_by', [
            'label' => esc_html__('مرتب‌سازی بر اساس', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => esc_html__('تاریخ', 'arash-theme'),
                'title' => esc_html__('عنوان', 'arash-theme'),
                'comment_count' => esc_html__('تعداد دیدگاه', 'arash-theme'),
                'rand' => esc_html__('تصادفی', 'arash-theme'),
            ],
        ]);

        $this->add_control('order', [
            'label' => esc_html__('جهت مرتب‌سازی', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'DESC' => esc_html__('نزولی', 'arash-theme'),
                'ASC' => esc_html__('صعودی', 'arash-theme'),
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل آیتم‌ها', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش (روشن)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت (روشن)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-card' => 'background-color: {{VALUE}};',
            ],
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
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'date';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'DESC';
        $category_filter = isset($settings['category_filter']) && is_array($settings['category_filter']) ? array_map('absint', $settings['category_filter']) : [];

        $query_args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $items_per_page,
            'orderby' => in_array($order_by, ['date', 'title', 'comment_count', 'rand'], true) ? $order_by : 'date',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC',
        ];

        if (!empty($category_filter)) {
            $query_args['category__in'] = array_values(array_filter($category_filter));
        }

        $the_query = new WP_Query($query_args);

        ?>
        <section class="fadaee-blog-section rounded-3xl">
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
                        <article class="fadaee-blog-card group rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5">
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
        </section>
        <?php
    }
}

