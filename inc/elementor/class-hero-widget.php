<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Hero_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_hero';
    }

    public function get_title() {
        return esc_html__('قهرمان صفحه (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('avatar', [
            'label' => esc_html__('آواتار', 'arash-theme'),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => ''],
        ]);

        $this->add_control('headline', [
            'label' => esc_html__('تیتر اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('سلام، من آرش فدایی هستم', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subheadline', [
            'label' => esc_html__('تیتر فرعی', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => esc_html__('توسعه‌دهنده ارشد وب و متخصص PHP و لاراول', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('primary_button_text', [
            'label' => esc_html__('متن دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('شروع همکاری', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('primary_button_url', [
            'label' => esc_html__('لینک دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('secondary_button_text', [
            'label' => esc_html__('متن دکمه ثانویه', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('مشاهده نمونه‌کارها', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('secondary_button_url', [
            'label' => esc_html__('لینک دکمه ثانویه', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('bg_image', [
            'label' => esc_html__('تصویر پس‌زمینه', 'arash-theme'),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => ''],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_general', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('content_align', [
            'label' => esc_html__('تراز محتوا', 'arash-theme'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'right',
            'options' => [
                'right' => [
                    'title' => esc_html__('راست', 'arash-theme'),
                    'icon' => 'eicon-text-align-right',
                ],
                'center' => [
                    'title' => esc_html__('وسط', 'arash-theme'),
                    'icon' => 'eicon-text-align-center',
                ],
                'left' => [
                    'title' => esc_html__('چپ', 'arash-theme'),
                    'icon' => 'eicon-text-align-left',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-hero-content' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->add_control('section_radius', [
            'label' => esc_html__('گردی باکس', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 0, 'max' => 60]],
            'default' => ['size' => 24],
            'selectors' => [
                '{{WRAPPER}} .fadaee-hero-section' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'headline_typography',
                'selector' => '{{WRAPPER}} .fadaee-hero-headline',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subheadline_typography',
                'selector' => '{{WRAPPER}} .fadaee-hero-subheadline',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_bg', [
            'label' => esc_html__('پس‌زمینه باکس', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-hero-section' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-hero-headline' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_text', [
            'label' => esc_html__('رنگ متن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-hero-subheadline' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_bg', [
            'label' => esc_html__('پس‌زمینه باکس (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-hero-section' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-hero-headline' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_text', [
            'label' => esc_html__('رنگ متن (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-hero-subheadline' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('primary_btn_bg', [
            'label' => esc_html__('رنگ دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#dc2626',
            'selectors' => ['{{WRAPPER}} .fadaee-hero-btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};'],
        ]);

        $this->add_control('secondary_btn_border', [
            'label' => esc_html__('رنگ کادر دکمه ثانویه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => ['{{WRAPPER}} .fadaee-hero-btn-secondary' => 'border-color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $headline = isset($settings['headline']) ? $settings['headline'] : '';
        $subheadline = isset($settings['subheadline']) ? $settings['subheadline'] : '';
        $primary_text = isset($settings['primary_button_text']) ? $settings['primary_button_text'] : '';
        $primary_url = isset($settings['primary_button_url']['url']) ? $settings['primary_button_url']['url'] : '';
        $secondary_text = isset($settings['secondary_button_text']) ? $settings['secondary_button_text'] : '';
        $secondary_url = isset($settings['secondary_button_url']['url']) ? $settings['secondary_button_url']['url'] : '';
        $avatar_url = !empty($settings['avatar']['url']) ? $settings['avatar']['url'] : '';
        $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : '';

        if (!empty($settings['primary_button_url'])) {
            $this->add_link_attributes('primary_button_link', $settings['primary_button_url']);
        }

        if (!empty($settings['secondary_button_url'])) {
            $this->add_link_attributes('secondary_button_link', $settings['secondary_button_url']);
        }

        ?>
        <section class="fadaee-hero-section relative overflow-hidden px-4 sm:px-8 py-8 sm:py-10 shadow-sm backdrop-blur">
            <?php if ($bg_image): ?>
                <div class="absolute inset-0">
                    <img src="<?php echo esc_url($bg_image); ?>" alt="" class="h-full w-full object-cover" loading="lazy" />
                    <div class="absolute inset-0 bg-black/45"></div>
                </div>
            <?php endif; ?>

            <div class="relative z-10 mx-auto max-w-2xl lg:max-w-5xl">
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-center">
                    <div class="fadaee-hero-content flex-1">
                        <?php if ($avatar_url): ?>
                            <div class="mb-5">
                                <img src="<?php echo esc_url($avatar_url); ?>" alt="" class="h-14 w-14 sm:h-16 sm:w-16 rounded-full object-cover ring-2 ring-white/80 dark:ring-zinc-700" loading="lazy" />
                            </div>
                        <?php endif; ?>

                        <h1 class="fadaee-hero-headline text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-4">
                            <?php echo esc_html($headline); ?>
                        </h1>

                        <?php if (!empty($subheadline)): ?>
                            <p class="fadaee-hero-subheadline text-base sm:text-lg leading-relaxed mb-6">
                                <?php echo esc_html($subheadline); ?>
                            </p>
                        <?php endif; ?>

                        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                            <?php if (!empty($primary_text) && !empty($primary_url)): ?>
                                <a <?php echo $this->get_render_attribute_string('primary_button_link'); ?>
                                   class="fadaee-hero-btn-primary inline-flex items-center justify-center rounded-xl border px-5 py-2.5 text-sm sm:text-base font-semibold text-white transition-opacity hover:opacity-90">
                                    <span><?php echo esc_html($primary_text); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($secondary_text) && !empty($secondary_url)): ?>
                                <a <?php echo $this->get_render_attribute_string('secondary_button_link'); ?>
                                   class="fadaee-hero-btn-secondary inline-flex items-center justify-center rounded-xl border px-4 py-2.5 text-sm sm:text-base font-medium text-zinc-800 dark:text-zinc-100 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-900">
                                    <span><?php echo esc_html($secondary_text); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
