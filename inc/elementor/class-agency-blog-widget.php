<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Blog_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_blog';
    }

    public function get_title() {
        return esc_html__('آژانس - بلاگ', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('آخرین مقاله‌ها', 'arash-theme'),
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('به‌روزترین یادداشت‌ها و آموزش‌های تیم ما', 'arash-theme'),
        ]);

        $this->add_control('count', [
            'label' => esc_html__('تعداد مقاله', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'max' => 12,
        ]);

        $this->add_control('columns', [
            'label' => esc_html__('تعداد ستون دسکتاپ', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
        ]);

        $this->add_control('show_meta', [
            'label' => esc_html__('نمایش تاریخ', 'arash-theme'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('order_by', [
            'label' => esc_html__('مرتب‌سازی بر اساس', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => esc_html__('تاریخ', 'arash-theme'),
                'title' => esc_html__('عنوان', 'arash-theme'),
                'comment_count' => esc_html__('دیدگاه', 'arash-theme'),
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

        $this->start_controls_section('style_common', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-blog-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-blog-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-blog-post-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_excerpt_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-blog-post-excerpt',
            ]
        );

        $this->add_control('card_radius', [
            'label' => esc_html__('گردی کارت', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 40],
            ],
            'default' => [
                'size' => 16,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-blog-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('cards_gap', [
            'label' => esc_html__('فاصله بین کارت‌ها', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 8, 'max' => 48],
            ],
            'default' => [
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-blog-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_post_title', [
            'label' => esc_html__('رنگ عنوان مقاله', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-post-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_post_meta', [
            'label' => esc_html__('رنگ متا', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#71717a',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-post-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_post_excerpt', [
            'label' => esc_html__('رنگ خلاصه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-blog-post-excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_post_title', [
            'label' => esc_html__('رنگ عنوان مقاله', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-post-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_post_meta', [
            'label' => esc_html__('رنگ متا', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-post-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_post_excerpt', [
            'label' => esc_html__('رنگ خلاصه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-blog-post-excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $count = !empty($settings['count']) ? absint($settings['count']) : 3;
        $columns = isset($settings['columns']) ? $settings['columns'] : '3';
        $show_meta = isset($settings['show_meta']) && $settings['show_meta'] === 'yes';
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'date';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'DESC';

        $grid_columns_class = 'lg:grid-cols-3';
        if ($columns === '2') {
            $grid_columns_class = 'lg:grid-cols-2';
        } elseif ($columns === '4') {
            $grid_columns_class = 'lg:grid-cols-4';
        }

        $query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $count,
            'orderby' => in_array($order_by, ['date', 'title', 'comment_count', 'rand'], true) ? $order_by : 'date',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC',
        ]);
        ?>
        <section class="fadaee-agency-blog rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-7xl">
                <h3 class="fadaee-agency-blog-title text-3xl sm:text-4xl font-black text-center text-zinc-900 dark:text-zinc-100 mb-4"><?php echo esc_html($settings['title']); ?></h3>
                <?php if (!empty($settings['subtitle'])): ?>
                    <p class="fadaee-agency-blog-subtitle text-center text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mb-10"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>
                <div class="fadaee-agency-blog-grid grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($grid_columns_class); ?> gap-6">
                    <?php if ($query->have_posts()): ?>
                        <?php while ($query->have_posts()): $query->the_post(); ?>
                            <article class="fadaee-agency-blog-card rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">
                                <?php if ($show_meta): ?>
                                    <div class="fadaee-agency-blog-post-meta text-xs text-zinc-500"><?php echo esc_html(get_the_date('Y/m/d')); ?></div>
                                <?php endif; ?>
                                <h4 class="fadaee-agency-blog-post-title mt-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100 leading-8"><?php echo esc_html(get_the_title()); ?></h4>
                                <p class="fadaee-agency-blog-post-excerpt mt-3 text-sm text-zinc-600 dark:text-zinc-300 leading-7"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?></p>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
