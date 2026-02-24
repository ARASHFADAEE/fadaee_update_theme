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
        return esc_html__('نظرات مشتریان (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label' => esc_html__('عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('نظرات مشتریان', 'arash-theme'),
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => esc_html__('مشتری‌ها در مورد همکاری با من چه می‌گویند؟', 'arash-theme'),
        ]);

        $this->add_control('items', [
            'label' => esc_html__('تعداد نظرات', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'max' => 24,
        ]);

        $this->add_control('featured_only', [
            'label' => esc_html__('فقط نظرات ویژه', 'arash-theme'),
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

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش (روشن)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-testimonials-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-testimonials-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت (روشن)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-testimonial-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-testimonial-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('title_color', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .fadaee-testimonials-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('content_color', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .fadaee-testimonial-content' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $title = isset($settings['title']) ? $settings['title'] : '';
        $subtitle = isset($settings['subtitle']) ? $settings['subtitle'] : '';
        $items = !empty($settings['items']) ? (int) $settings['items'] : 6;
        $featured_only = isset($settings['featured_only']) && $settings['featured_only'] === 'yes';
        $order_by = isset($settings['order_by']) ? sanitize_key($settings['order_by']) : 'date';
        $order = isset($settings['order']) ? strtoupper($settings['order']) : 'DESC';

        $query_args = [
            'post_type' => 'testimonial',
            'posts_per_page' => $items,
            'orderby' => in_array($order_by, ['date', 'title', 'rand', 'menu_order'], true) ? $order_by : 'date',
            'order' => in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC',
        ];

        if ($featured_only) {
            $query_args['meta_query'] = [
                [
                    'key' => '_testimonial_featured',
                    'value' => 1,
                    'compare' => '=',
                ],
            ];
        }

        $query = new WP_Query($query_args);

        ?>
        <section class="fadaee-testimonials-section w-full py-16 sm:py-20 bg-gradient-to-b from-white via-zinc-50 to-white dark:from-black dark:via-zinc-950 dark:to-black">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
                    <div>
                        <?php if (!empty($title)): ?>
                            <h2 class="fadaee-testimonials-title text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">
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
                            <article class="scroll-item  max-w-sm">
                                <div class="fadaee-testimonial-card relative overflow-hidden rounded-2xl bg-white/90 dark:bg-zinc-900/90 border border-zinc-200/70 dark:border-zinc-800/70 shadow-sm hover:shadow-lg transition-shadow duration-200">
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
                                        <div class="fadaee-testimonial-content text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                                            <?php echo wp_kses_post(wp_trim_words(get_the_content(), 40, '...')); ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        <?php echo esc_html__('هنوز نظری ثبت نشده است.', 'arash-theme'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

