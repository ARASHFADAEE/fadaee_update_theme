<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Demo_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_demo';
    }

    public function get_title() {
        return esc_html__('دمو آژانس (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-landing-page';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('badge_text', [
            'label' => esc_html__('متن برچسب', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('دمو ۲ • آژانس نُوا', 'arash-theme'),
        ]);

        $this->add_control('title', [
            'label' => esc_html__('تیتر اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('طراحی سایت سریع و مقیاس‌پذیر برای کسب‌وکار شما', 'arash-theme'),
        ]);

        $this->add_control('description', [
            'label' => esc_html__('توضیح', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 4,
            'default' => esc_html__('توسعه سیستم‌های تحت وب، وردپرس اختصاصی و SaaS با تمرکز روی سرعت، سئو و تجربه کاربری.', 'arash-theme'),
        ]);

        $this->add_control('primary_text', [
            'label' => esc_html__('متن دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('دریافت مشاوره رایگان', 'arash-theme'),
        ]);

        $this->add_control('primary_url', [
            'label' => esc_html__('لینک دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ]);

        $this->add_control('secondary_text', [
            'label' => esc_html__('متن دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('مشاهده نمونه‌کار', 'arash-theme'),
        ]);

        $this->add_control('secondary_url', [
            'label' => esc_html__('لینک دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ]);

        $this->add_control('portfolio_items', [
            'label' => esc_html__('تعداد نمونه‌کار', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'max' => 9,
        ]);

        $this->add_control('testimonial_items', [
            'label' => esc_html__('تعداد نظرات مشتری', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'max' => 6,
        ]);

        $this->add_control('blog_items', [
            'label' => esc_html__('تعداد مقالات', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'max' => 6,
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_common', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-demo-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-demo-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-demo-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-demo-btn',
            ]
        );

        $this->add_control('section_radius', [
            'label' => esc_html__('گردی باکس', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
            ],
            'default' => [
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-demo' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('button_radius', [
            'label' => esc_html__('گردی دکمه‌ها', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 30],
            ],
            'default' => [
                'size' => 12,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-demo-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg_info', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => '<div style="color: #666; font-size: 12px;">پس‌زمینه بخش در light mode اختیاری است. برای حذف رنگ پس‌زمینه، مقدار خالی بگذارید.</div>',
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => 'transparent',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_border', [
            'label' => esc_html__('رنگ کادر بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_title_color', [
            'label' => esc_html__('رنگ تیتر اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_text_color', [
            'label' => esc_html__('رنگ متن اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-description' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_badge_bg', [
            'label' => esc_html__('پس‌زمینه برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-badge' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_badge_color', [
            'label' => esc_html__('رنگ برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-badge' => 'color: {{VALUE}}; border-color: {{VALUE}}33;',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo .fadaee-agency-demo-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_border', [
            'label' => esc_html__('رنگ کادر کارت‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo .fadaee-agency-demo-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_primary_btn_bg', [
            'label' => esc_html__('رنگ دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_primary_btn_text', [
            'label' => esc_html__('رنگ متن دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-btn-primary' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_secondary_btn_text', [
            'label' => esc_html__('رنگ متن دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-btn-secondary' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_secondary_btn_border', [
            'label' => esc_html__('رنگ کادر دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-demo-btn-secondary' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_section_bg_info', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => '<div style="color: #999; font-size: 12px;">پس‌زمینه بخش در dark mode اختیاری است. برای حذف رنگ پس‌زمینه، مقدار خالی بگذارید.</div>',
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => 'transparent',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_border', [
            'label' => esc_html__('رنگ کادر بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_title_color', [
            'label' => esc_html__('رنگ تیتر اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_text_color', [
            'label' => esc_html__('رنگ متن اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-description' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_badge_bg', [
            'label' => esc_html__('پس‌زمینه برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#27272a',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-badge' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_badge_color', [
            'label' => esc_html__('رنگ برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-badge' => 'color: {{VALUE}}; border-color: {{VALUE}}33;',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo .fadaee-agency-demo-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_border', [
            'label' => esc_html__('رنگ کادر کارت‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo .fadaee-agency-demo-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_primary_btn_bg', [
            'label' => esc_html__('رنگ دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_primary_btn_text', [
            'label' => esc_html__('رنگ متن دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-btn-primary' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_secondary_btn_text', [
            'label' => esc_html__('رنگ متن دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-btn-secondary' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_secondary_btn_border', [
            'label' => esc_html__('رنگ کادر دکمه دوم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-demo-btn-secondary' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    private function get_inline_styles() {
        $settings = $this->get_settings_for_display();
        $is_dark = wp_is_mobile() ? false : true;
        
        $styles = [
            '--bg-color' => $is_dark 
                ? (!empty($settings['dark_section_bg']) ? $settings['dark_section_bg'] : 'transparent')
                : (!empty($settings['light_section_bg']) ? $settings['light_section_bg'] : 'transparent'),
            '--border-color' => $is_dark
                ? (!empty($settings['dark_section_border']) ? $settings['dark_section_border'] : '#3f3f46')
                : (!empty($settings['light_section_border']) ? $settings['light_section_border'] : '#e4e4e7'),
            '--text-color' => $is_dark
                ? (!empty($settings['dark_title_color']) ? $settings['dark_title_color'] : '#f4f4f5')
                : (!empty($settings['light_title_color']) ? $settings['light_title_color'] : '#18181b'),
        ];
        
        $css = '';
        foreach ($styles as $key => $value) {
            if (!empty($value)) {
                $css .= $key . ': ' . esc_attr($value) . '; ';
            }
        }
        
        return $css;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['primary_url'])) {
            $this->add_link_attributes('primary_link', $settings['primary_url']);
        }

        if (!empty($settings['secondary_url'])) {
            $this->add_link_attributes('secondary_link', $settings['secondary_url']);
        }

        $portfolio_items = !empty($settings['portfolio_items']) ? absint($settings['portfolio_items']) : 6;
        if ($portfolio_items < 1) {
            $portfolio_items = 6;
        }

        $testimonial_items = !empty($settings['testimonial_items']) ? absint($settings['testimonial_items']) : 3;
        if ($testimonial_items < 1) {
            $testimonial_items = 3;
        }

        $blog_items = !empty($settings['blog_items']) ? absint($settings['blog_items']) : 3;
        if ($blog_items < 1) {
            $blog_items = 3;
        }

        $portfolio_query = new WP_Query([
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => $portfolio_items,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $testimonials_query = new WP_Query([
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            'posts_per_page' => $testimonial_items,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $blog_query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $blog_items,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        ?>
        <section class="fadaee-agency-demo relative overflow-hidden rounded-3xl border px-6 py-16 sm:px-8 lg:px-12 lg:py-24 shadow-sm transition-shadow duration-500" style="<?php echo $this->get_inline_styles(); ?>">
            <div class="pointer-events-none absolute -top-20 -right-20 h-60 w-60 rounded-full blur-3xl" style="background: currentColor; opacity: 0.05;"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-20 h-72 w-72 rounded-full blur-3xl" style="background: currentColor; opacity: 0.03;"></div>

            <div class="relative grid gap-12 lg:grid-cols-2 items-center">
                <div>
                    <span class="fadaee-agency-demo-badge inline-flex items-center rounded-full border px-3 py-1 text-sm">
                        <?php echo esc_html($settings['badge_text']); ?>
                    </span>

                    <h2 class="fadaee-agency-demo-title mt-6 text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                        <?php echo esc_html($settings['title']); ?>
                    </h2>

                    <p class="fadaee-agency-demo-description mt-5 text-base sm:text-lg leading-8">
                        <?php echo esc_html($settings['description']); ?>
                    </p>

                    <ul class="mt-6 space-y-2 text-sm">
                        <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full text-emerald-500">✓</span> تحویل سریع با کیفیت پایدار</li>
                        <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full text-emerald-500">✓</span> معماری قابل توسعه برای رشد آینده</li>
                        <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full text-emerald-500">✓</span> تمرکز بر KPI واقعی کسب‌وکار</li>
                    </ul>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <?php if (!empty($settings['primary_text']) && !empty($settings['primary_url']['url'])): ?>
                            <a <?php echo $this->get_render_attribute_string('primary_link'); ?> class="fadaee-agency-demo-btn fadaee-agency-demo-btn-primary inline-flex items-center rounded-xl px-6 py-3 text-sm font-semibold transition">
                                <?php echo esc_html($settings['primary_text']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['secondary_text']) && !empty($settings['secondary_url']['url'])): ?>
                            <a <?php echo $this->get_render_attribute_string('secondary_link'); ?> class="fadaee-agency-demo-btn fadaee-agency-demo-btn-secondary inline-flex items-center rounded-xl border px-6 py-3 text-sm font-semibold transition">
                                <?php echo esc_html($settings['secondary_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="mt-8 grid grid-cols-3 gap-4 text-center sm:max-w-md">
                        <div class="fadaee-agency-demo-card rounded-xl border p-3">
                            <div class="text-2xl font-bold">+80</div>
                            <div class="mt-1 text-xs opacity-70">پروژه تکمیل‌شده</div>
                        </div>
                        <div class="fadaee-agency-demo-card rounded-xl border p-3">
                            <div class="text-2xl font-bold">+6</div>
                            <div class="mt-1 text-xs opacity-70">سال تجربه</div>
                        </div>
                        <div class="fadaee-agency-demo-card rounded-xl border p-3">
                            <div class="text-2xl font-bold">%98</div>
                            <div class="mt-1 text-xs opacity-70">رضایت مشتری</div>
                        </div>
                    </div>
                </div>

                <div class="fadaee-agency-demo-card rounded-3xl border border-zinc-800 bg-zinc-900/80 p-6 shadow-2xl transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm font-medium text-zinc-300">Roadmap پروژه</div>
                        <div class="text-xs text-zinc-500">Sprint Active</div>
                    </div>
                    <div class="space-y-4">
                        <div class="fadaee-agency-demo-card rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                            <div class="text-sm font-semibold text-zinc-200">تحلیل و استراتژی</div>
                            <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[90%] rounded bg-red-500"></div></div>
                        </div>
                        <div class="fadaee-agency-demo-card rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                            <div class="text-sm font-semibold text-zinc-200">طراحی UI/UX</div>
                            <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[75%] rounded bg-indigo-500"></div></div>
                        </div>
                        <div class="fadaee-agency-demo-card rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                            <div class="text-sm font-semibold text-zinc-200">توسعه و تست</div>
                            <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[65%] rounded bg-emerald-500"></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">خدمات کلیدی</h3>
                <div class="grid md:grid-cols-3 gap-6 mt-10">
                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                        <div class="text-xs text-red-400 mb-2">01</div>
                        <h4 class="font-semibold">طراحی سایت اختصاصی</h4>
                        <p class="text-sm text-zinc-400 mt-2">پیاده‌سازی سریع و استاندارد با تمرکز روی نرخ تبدیل.</p>
                    </div>
                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                        <div class="text-xs text-indigo-400 mb-2">02</div>
                        <h4 class="font-semibold">توسعه وردپرس</h4>
                        <p class="text-sm text-zinc-400 mt-2">قالب و افزونه اختصاصی متناسب با نیاز دقیق کسب‌وکار.</p>
                    </div>
                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                        <div class="text-xs text-emerald-400 mb-2">03</div>
                        <h4 class="font-semibold">سئو و سرعت</h4>
                        <p class="text-sm text-zinc-400 mt-2">بهبود Core Web Vitals و رتبه‌پذیری بهتر در گوگل.</p>
                    </div>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">نمونه‌کارها</h3>

                <div class="grid md:grid-cols-3 gap-6 mt-10">
                    <?php if ($portfolio_query->have_posts()): ?>
                        <?php while ($portfolio_query->have_posts()): $portfolio_query->the_post(); ?>
                            <article class="group transition-transform duration-300 hover:-translate-y-1">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900 transition-colors duration-300 group-hover:border-zinc-700">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy" />
                                    <?php else: ?>
                                        <div class="h-56 w-full bg-zinc-800"></div>
                                    <?php endif; ?>
                                </a>
                                <h4 class="mt-4 font-semibold text-zinc-100"><?php echo esc_html(get_the_title()); ?></h4>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">
                            <?php echo esc_html__('هنوز نمونه‌کاری منتشر نشده است.', 'arash-theme'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">نظر مشتری‌ها</h3>
                <div class="grid md:grid-cols-3 gap-6 mt-10">
                    <?php if ($testimonials_query->have_posts()): ?>
                        <?php while ($testimonials_query->have_posts()): $testimonials_query->the_post(); ?>
                            <?php $client_name = get_post_meta(get_the_ID(), '_client_name', true); ?>
                            <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                                <div class="text-amber-400">★★★★★</div>
                                <p class="mt-4 text-sm leading-7 text-zinc-300"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_content()), 28, '...')); ?></p>
                                <div class="mt-4 text-sm font-semibold text-zinc-100"><?php echo esc_html($client_name ? $client_name : get_the_title()); ?></div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">نظری برای نمایش وجود ندارد.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">تعرفه خدمات</h3>
                <div class="grid md:grid-cols-3 gap-6 mt-10">
                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                        <h4 class="text-xl font-semibold">پایه</h4>
                        <div class="text-3xl font-bold mt-4">۱۰ میلیون</div>
                        <ul class="mt-5 space-y-2 text-sm text-zinc-400">
                            <li>• لندینگ یا سایت معرفی</li>
                            <li>• طراحی ریسپانسیو</li>
                            <li>• تحویل ۷ تا ۱۰ روز</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border border-red-500/40 bg-red-500 p-8 text-white shadow-lg shadow-red-500/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-red-500/40">
                        <h4 class="text-xl font-semibold">حرفه‌ای</h4>
                        <div class="text-3xl font-bold mt-4">۲۵ میلیون</div>
                        <ul class="mt-5 space-y-2 text-sm text-white/90">
                            <li>• سایت یا وب‌اپ اختصاصی</li>
                            <li>• بهینه‌سازی سرعت و سئو</li>
                            <li>• پنل مدیریت اختصاصی</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                        <h4 class="text-xl font-semibold">سازمانی</h4>
                        <div class="text-3xl font-bold mt-4">تماس بگیرید</div>
                        <ul class="mt-5 space-y-2 text-sm text-zinc-400">
                            <li>• معماری مقیاس‌پذیر</li>
                            <li>• SLA و پشتیبانی اختصاصی</li>
                            <li>• توسعه چندماژوله</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">آخرین مقاله‌ها</h3>
                <div class="grid md:grid-cols-3 gap-6 mt-10">
                    <?php if ($blog_query->have_posts()): ?>
                        <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
                            <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                                <div class="text-xs text-zinc-500"><?php echo esc_html(get_the_date('Y/m/d')); ?></div>
                                <h4 class="mt-3 text-lg font-semibold text-zinc-100 leading-8"><?php echo esc_html(get_the_title()); ?></h4>
                                <p class="mt-3 text-sm text-zinc-400 leading-7"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?></p>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="mt-5 inline-flex items-center text-sm font-semibold text-red-400 hover:text-red-300 transition">مشاهده مقاله ←</a>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">مقاله‌ای برای نمایش وجود ندارد.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-center">سوالات متداول</h3>
                <div class="mt-8 space-y-4">
                    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5 transition-all duration-300 hover:border-zinc-700">
                        <h4 class="font-semibold text-zinc-100">مدت زمان اجرای پروژه چقدر است؟</h4>
                        <p class="text-sm text-zinc-400 mt-2 leading-7">بسته به نوع پروژه، نسخه اولیه بین ۷ تا ۲۰ روز تحویل می‌شود و سپس توسعه مرحله‌ای ادامه پیدا می‌کند.</p>
                    </div>
                    <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5 transition-all duration-300 hover:border-zinc-700">
                        <h4 class="font-semibold text-zinc-100">آیا بعد از تحویل پشتیبانی دارید؟</h4>
                        <p class="text-sm text-zinc-400 mt-2 leading-7">بله، برای همه پلن‌ها پشتیبانی پایه ارائه می‌شود و برای پروژه‌های سازمانی SLA اختصاصی قابل تعریف است.</p>
                    </div>
                </div>
            </div>

            <div class="mt-14 border-t border-zinc-800/70 pt-12 text-center">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight">آماده شروع همکاری هستید؟</h3>
                <p class="mt-3 text-zinc-400">اگر پروژه‌ای دارید که نیاز به اجرای سریع و حرفه‌ای دارد، همین حالا شروع کنیم.</p>
                <?php if (!empty($settings['primary_text']) && !empty($settings['primary_url']['url'])): ?>
                    <div class="mt-6">
                        <a <?php echo $this->get_render_attribute_string('primary_link'); ?> class="inline-flex items-center rounded-xl bg-red-500 px-8 py-3 text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-red-400 hover:shadow-lg hover:shadow-red-500/30">
                            <?php echo esc_html($settings['primary_text']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
