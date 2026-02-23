<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
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
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('headline', [
            'label' => esc_html__('تیتر اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('سلام، من آرش فدایی هستم', 'arash-theme'),
        ]);

        $this->add_control('subheadline', [
            'label' => esc_html__('تیتر فرعی', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => esc_html__('توسعه‌دهنده ارشد وب و متخصص PHP و لاراول', 'arash-theme'),
        ]);

        $this->add_control('primary_button_text', [
            'label' => esc_html__('متن دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('شروع همکاری', 'arash-theme'),
        ]);

        $this->add_control('primary_button_url', [
            'label' => esc_html__('لینک دکمه اصلی', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ]);

        $this->add_control('secondary_button_text', [
            'label' => esc_html__('متن دکمه ثانویه', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('مشاهده نمونه‌کارها', 'arash-theme'),
        ]);

        $this->add_control('secondary_button_url', [
            'label' => esc_html__('لینک دکمه ثانویه', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل', 'arash-theme'),
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

        if (!empty($settings['primary_button_url'])) {
            $this->add_link_attributes('primary_button_link', $settings['primary_button_url']);
        }

        if (!empty($settings['secondary_button_url'])) {
            $this->add_link_attributes('secondary_button_link', $settings['secondary_button_url']);
        }

        ?>
        <section class="hero-section-custom rounded-3xl lg:rounded-[2rem] px-4 sm:px-8 py-8 sm:py-10 shadow-sm backdrop-blur">
            <div class="mx-auto max-w-2xl lg:max-w-5xl">
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-center">
                    <div class="fadaee-hero-content flex-1">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-50 leading-tight mb-4">
                            <?php echo esc_html($headline); ?>
                        </h1>
                        <?php if (!empty($subheadline)): ?>
                            <p class="text-base sm:text-lg text-zinc-600 dark:text-zinc-300 leading-relaxed mb-6">
                                <?php echo esc_html($subheadline); ?>
                            </p>
                        <?php endif; ?>

                        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                            <?php if (!empty($primary_text) && !empty($primary_url)): ?>
                                <a <?php echo $this->get_render_attribute_string('primary_button_link'); ?>
                                   class="inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm sm:text-base font-semibold text-white shadow-lg shadow-red-600/40 transition hover:bg-red-500 hover:shadow-red-500/50">
                                    <span><?php echo esc_html($primary_text); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($secondary_text) && !empty($secondary_url)): ?>
                                <a <?php echo $this->get_render_attribute_string('secondary_button_link'); ?>
                                   class="inline-flex items-center justify-center rounded-xl border border-zinc-200 px-4 py-2.5 text-sm sm:text-base font-medium text-zinc-800 dark:text-zinc-100 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
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

