<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Portfolio_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_portfolio';
    }

    public function get_title() {
        return esc_html__('آژانس - نمونه‌کارها', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
            'default' => esc_html__('نمونه‌کارها', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('پروژه‌های اجراشده برای برندها و کسب‌وکارهای مختلف', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('count', [
            'label' => esc_html__('تعداد آیتم', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'max' => 18,
        ]);

        $this->add_control('columns', [
            'label' => esc_html__('تعداد ستون در دسکتاپ', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
        ]);

        $this->add_control('image_ratio', [
            'label' => esc_html__('نسبت تصویر', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'aspect-[4/3]',
            'options' => [
                'aspect-square' => '1:1',
                'aspect-[4/3]' => '4:3',
                'aspect-[16/10]' => '16:10',
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

        $this->end_controls_section();

        $this->start_controls_section('style_common', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-portfolio-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-portfolio-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-portfolio-card-title',
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
                '{{WRAPPER}} .fadaee-agency-portfolio-card' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-agency-portfolio-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio-card' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio-card' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('title_light', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('subtitle_light', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_card_title', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-portfolio-card-title' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio-card' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio-card' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('title_dark', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('subtitle_dark', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card_title', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-portfolio-card-title' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $count = !empty($settings['count']) ? absint($settings['count']) : 6;
        $count = $count > 0 ? $count : 6;
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'date';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'DESC';

        $query = new WP_Query([
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => $count,
            'orderby' => in_array($order_by, ['date', 'title', 'rand', 'menu_order'], true) ? $order_by : 'date',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC',
        ]);

        $columns_map = [
            '2' => 'lg:grid-cols-2',
            '3' => 'lg:grid-cols-3',
            '4' => 'lg:grid-cols-4',
        ];
        $desktop_cols = isset($columns_map[$settings['columns']]) ? $columns_map[$settings['columns']] : 'lg:grid-cols-3';
        $ratio_class = !empty($settings['image_ratio']) ? $settings['image_ratio'] : 'aspect-[4/3]';
        ?>
        <section class="fadaee-agency-portfolio rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24">
            <div class="mx-auto max-w-7xl">
                <h3 class="fadaee-agency-portfolio-title text-3xl sm:text-4xl font-black text-center mb-10">
                    <?php echo esc_html($settings['title']); ?>
                </h3>

                <?php if (!empty($settings['subtitle'])): ?>
                    <p class="fadaee-agency-portfolio-subtitle text-center text-sm sm:text-base mb-8 text-zinc-600 dark:text-zinc-400">
                        <?php echo esc_html($settings['subtitle']); ?>
                    </p>
                <?php endif; ?>

                <div class="fadaee-agency-portfolio-grid grid grid-cols-1 sm:grid-cols-2 <?php echo esc_attr($desktop_cols); ?> gap-6">
                    <?php if ($query->have_posts()): ?>
                        <?php while ($query->have_posts()): $query->the_post(); ?>
                            <article class="fadaee-agency-portfolio-card rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 transition-transform hover:-translate-y-1">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="<?php echo esc_attr($ratio_class); ?> w-full object-cover" loading="lazy" />
                                    <?php else: ?>
                                        <div class="<?php echo esc_attr($ratio_class); ?> w-full bg-zinc-100 dark:bg-zinc-800"></div>
                                    <?php endif; ?>
                                </a>
                                <div class="p-4">
                                    <h4 class="fadaee-agency-portfolio-card-title text-base font-semibold text-zinc-900 dark:text-zinc-100"><?php the_title(); ?></h4>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="sm:col-span-2 lg:col-span-3 text-center text-zinc-500 dark:text-zinc-400">
                            <?php echo esc_html__('هیچ نمونه‌کاری یافت نشد.', 'arash-theme'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
