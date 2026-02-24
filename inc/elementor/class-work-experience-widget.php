<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;

class Fadaee_Elementor_Work_Experience_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_work_experience';
    }

    public function get_title() {
        return esc_html__('تجربه‌های کاری (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-time-line';
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
            'default' => esc_html__('تجربه‌های کاری', 'arash-theme'),
        ]);

        $this->add_control('section_subtitle', [
            'label' => esc_html__('توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => esc_html__('همکاری‌ها و پروژه‌هایی که روی آن‌ها کار کرده‌ام', 'arash-theme'),
        ]);

        $this->add_control('items_limit', [
            'label' => esc_html__('حداکثر تعداد آیتم‌ها', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => -1,
        ]);

        $this->add_control('order_by', [
            'label' => esc_html__('مرتب‌سازی بر اساس', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'menu_order',
            'options' => [
                'menu_order' => esc_html__('ترتیب دستی', 'arash-theme'),
                'date' => esc_html__('تاریخ', 'arash-theme'),
                'title' => esc_html__('عنوان', 'arash-theme'),
            ],
        ]);

        $this->add_control('order', [
            'label' => esc_html__('جهت مرتب‌سازی', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC' => esc_html__('صعودی', 'arash-theme'),
                'DESC' => esc_html__('نزولی', 'arash-theme'),
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'label' => esc_html__('تایپوگرافی عنوان بخش', 'arash-theme'),
                'selector' => '{{WRAPPER}} .fadaee-work-section-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'label' => esc_html__('تایپوگرافی توضیح بخش', 'arash-theme'),
                'selector' => '{{WRAPPER}} .fadaee-work-section-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('تایپوگرافی عنوان کارت', 'arash-theme'),
                'selector' => '{{WRAPPER}} .fadaee-work-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('تایپوگرافی متن', 'arash-theme'),
                'selector' => '{{WRAPPER}} .fadaee-work-excerpt',
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
                '{{WRAPPER}} .fadaee-work-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('card_padding', [
            'label' => esc_html__('فاصله داخلی کارت', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 8, 'max' => 48],
            ],
            'default' => [
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-work-card' => 'padding: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .fadaee-work-card',
            ]
        );

        $this->add_control('timeline_width', [
            'label' => esc_html__('ضخامت تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 1, 'max' => 8],
            ],
            'default' => [
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-work-timeline-line' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('timeline_dot_size', [
            'label' => esc_html__('اندازه نقطه تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 6, 'max' => 24],
            ],
            'default' => [
                'size' => 12,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-work-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light_section', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#fafafa',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_title_color', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-section-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_subtitle_color', [
            'label' => esc_html__('رنگ توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-section-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_timeline_color', [
            'label' => esc_html__('رنگ خط تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-timeline-line' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_timeline_dot_color', [
            'label' => esc_html__('رنگ نقطه تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-dot' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_title_color', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_meta_color', [
            'label' => esc_html__('رنگ متای کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_text_color', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_chip_color', [
            'label' => esc_html__('رنگ برچسب‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-chip' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_chip_bg', [
            'label' => esc_html__('پس‌زمینه برچسب‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-work-chip' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark_section', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_title_color', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-section-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_subtitle_color', [
            'label' => esc_html__('رنگ توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-section-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_timeline_color', [
            'label' => esc_html__('رنگ خط تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-timeline-line' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_timeline_dot_color', [
            'label' => esc_html__('رنگ نقطه تایم‌لاین', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f87171',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-dot' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_title_color', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_meta_color', [
            'label' => esc_html__('رنگ متای کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_text_color', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_chip_color', [
            'label' => esc_html__('رنگ برچسب‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-chip' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_chip_bg', [
            'label' => esc_html__('پس‌زمینه برچسب‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#27272a',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-work-chip' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
        $section_subtitle = isset($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $items_limit = isset($settings['items_limit']) ? (int) $settings['items_limit'] : -1;
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'menu_order';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'ASC';

        $query_args = [
            'post_type' => 'work_experience',
            'posts_per_page' => $items_limit,
            'orderby' => in_array($order_by, ['menu_order', 'date', 'title'], true) ? $order_by : 'menu_order',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'ASC',
        ];

        $work_query = new WP_Query($query_args);

        ?>
        <section class="fadaee-work-section w-full py-16 sm:py-20 bg-zinc-50 dark:bg-zinc-950/40">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex items-center justify-between mb-8 sm:mb-10">
                    <div>
                        <?php if (!empty($section_title)): ?>
                            <h2 class="fadaee-work-section-title text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
                                <?php echo esc_html($section_title); ?>
                            </h2>
                        <?php endif; ?>
                        <?php if (!empty($section_subtitle)): ?>
                            <p class="fadaee-work-section-subtitle text-sm sm:text-base text-zinc-600 dark:text-zinc-400">
                                <?php echo esc_html($section_subtitle); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($work_query->have_posts()): ?>
                    <div class="relative">
                        <div class="fadaee-work-timeline-line absolute inset-y-4 sm:inset-y-2 start-4 sm:start-1.5 w-px bg-gradient-to-b from-zinc-200 via-zinc-300 to-zinc-200 dark:from-zinc-800 dark:via-zinc-700 dark:to-zinc-800 pointer-events-none"></div>

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
                                    <div class="fadaee-work-dot absolute start-2 sm:start-0 top-2 h-3 w-3 rounded-full bg-red-500 dark:bg-red-400 ring-4 ring-red-100/80 dark:ring-red-900/40"></div>
                                    <div class="fadaee-work-card rounded-2xl bg-white/80 dark:bg-zinc-900/80 shadow-sm ring-1 ring-zinc-200/70 dark:ring-zinc-800/70 p-4 sm:p-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                                            <div>
                                                <h3 class="fadaee-work-title text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <?php if ($company): ?>
                                                    <div class="fadaee-work-meta mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                        <?php echo esc_html($company); ?>
                                                        <?php if ($location): ?>
                                                            <span class="mx-1">•</span>
                                                            <span><?php echo esc_html($location); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="fadaee-work-meta text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                <?php if ($start || $end): ?>
                                                    <?php echo esc_html(trim($start . ' - ' . $end)); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if ($employment_type || !empty($technologies)): ?>
                                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                                <?php if ($employment_type): ?>
                                                    <span class="fadaee-work-chip inline-flex items-center rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1 text-xs text-zinc-600 dark:text-zinc-300">
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
                                                            <span class="fadaee-work-chip inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800 px-2.5 py-0.5 text-[0.7rem] font-medium text-zinc-700 dark:text-zinc-200">
                                                                <?php echo esc_html($tech_item); ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                        <?php if (count($clean_tech) > $max_display): ?>
                                                            <span class="fadaee-work-chip inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-800 px-2.5 py-0.5 text-[0.7rem] font-medium text-zinc-500 dark:text-zinc-400">
                                                                +<?php echo esc_html(fadaee_persian_numbers(count($clean_tech) - $max_display)); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="fadaee-work-excerpt prose prose-sm max-w-none text-zinc-600 dark:prose-invert dark:text-zinc-300">
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
                        <?php echo esc_html__('تجربه کاری ثبت نشده است.', 'arash-theme'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

