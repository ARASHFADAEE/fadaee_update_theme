<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Testimonials_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_testimonials';
    }

    public function get_title() {
        return esc_html__('آژانس - نظرات مشتریان', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
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
            'label' => esc_html__('عنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('نظر مشتری‌ها', 'arash-theme'),
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('تجربه مشتریان از همکاری با تیم ما', 'arash-theme'),
        ]);

        $this->add_control('count', [
            'label' => esc_html__('تعداد آیتم', 'arash-theme'),
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

        $this->add_control('order_by', [
            'label' => esc_html__('مرتب‌سازی بر اساس', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => esc_html__('تاریخ', 'arash-theme'),
                'title' => esc_html__('عنوان', 'arash-theme'),
                'rand' => esc_html__('تصادفی', 'arash-theme'),
                'menu_order' => esc_html__('ترتیب دستی', 'arash-theme'),
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

        $this->add_control('featured_only', [
            'label' => esc_html__('فقط موارد ویژه', 'arash-theme'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'no',
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
                'selector' => '{{WRAPPER}} .fadaee-agency-testimonials-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-testimonials-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_content_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-testimonial-text',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_name_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-testimonial-name',
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
                '{{WRAPPER}} .fadaee-agency-testimonial-card' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-agency-testimonials-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_bg', [
            'label' => esc_html__('پس‌زمینه روشن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonials' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonials-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonials-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonial-card' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonial-card' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('light_text', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonial-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_name', [
            'label' => esc_html__('رنگ نام مشتری', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-testimonial-name' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_bg', [
            'label' => esc_html__('پس‌زمینه تیره', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonials' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonials-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonials-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonial-card' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonial-card' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_text', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonial-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_name', [
            'label' => esc_html__('رنگ نام مشتری', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-testimonial-name' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $count = !empty($settings['count']) ? absint($settings['count']) : 3;
        $columns = isset($settings['columns']) ? $settings['columns'] : '3';
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'date';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'DESC';

        $grid_columns_class = 'lg:grid-cols-3';
        if ($columns === '2') {
            $grid_columns_class = 'lg:grid-cols-2';
        } elseif ($columns === '4') {
            $grid_columns_class = 'lg:grid-cols-4';
        }

        $args = [
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            'posts_per_page' => $count,
            'orderby' => in_array($order_by, ['date', 'title', 'rand', 'menu_order'], true) ? $order_by : 'date',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC',
        ];

        if (!empty($settings['featured_only']) && $settings['featured_only'] === 'yes') {
            $args['meta_query'] = [[
                'key' => '_testimonial_featured',
                'value' => 1,
                'compare' => '=',
            ]];
        }

        $query = new WP_Query($args);
        ?>
        <section class="fadaee-agency-testimonials rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24">
            <div class="mx-auto max-w-7xl">
                <h3 class="fadaee-agency-testimonials-title text-3xl sm:text-4xl font-black text-zinc-900 dark:text-zinc-100 text-center mb-4"><?php echo esc_html($settings['title']); ?></h3>
                <?php if (!empty($settings['subtitle'])): ?>
                    <p class="fadaee-agency-testimonials-subtitle text-center text-zinc-600 dark:text-zinc-400 text-sm sm:text-base mb-10"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>
                <div class="fadaee-agency-testimonials-grid grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($grid_columns_class); ?> gap-6">
                    <?php if ($query->have_posts()): ?>
                        <?php while ($query->have_posts()): $query->the_post(); ?>
                            <?php $client_name = get_post_meta(get_the_ID(), '_client_name', true); ?>
                            <article class="fadaee-agency-testimonial-card rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6">
                                <div class="text-amber-400">★★★★★</div>
                                <p class="fadaee-agency-testimonial-text mt-4 text-sm leading-7 text-zinc-600 dark:text-zinc-300"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_content()), 28, '...')); ?></p>
                                <h4 class="fadaee-agency-testimonial-name mt-4 font-semibold text-zinc-900 dark:text-zinc-100"><?php echo esc_html($client_name ? $client_name : get_the_title()); ?></h4>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
