<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Hero_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_hero';
    }

    public function get_title() {
        return esc_html__('آژانس - هیرو', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return ['fadaee-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('محتوا', 'arash-theme'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('badge', [
            'label' => esc_html__('برچسب', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Agency Nova', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('title', [
            'label' => esc_html__('عنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('یک راهکار جامع برای تمام نیازهای دیجیتال شما', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('ما تیمی از طراحان و توسعه‌دهندگان حرفه‌ای هستیم که روی رشد واقعی کسب‌وکار شما تمرکز می‌کنیم.', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('bg_image', [
            'label' => esc_html__('تصویر پس‌زمینه', 'arash-theme'),
            'type' => Controls_Manager::MEDIA,
        ]);

        $this->add_control('button_text', [
            'label' => esc_html__('متن دکمه', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('شروع همکاری', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('button_url', [
            'label' => esc_html__('لینک دکمه', 'arash-theme'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'dynamic' => ['active' => true],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_common', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('content_align', [
            'label' => esc_html__('تراز محتوا', 'arash-theme'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
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
                '{{WRAPPER}} .fadaee-agency-hero-content' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-hero-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-hero-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-hero-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-hero-btn',
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
                '{{WRAPPER}} .fadaee-agency-hero' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('button_radius', [
            'label' => esc_html__('گردی دکمه', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 30],
            ],
            'default' => [
                'size' => 12,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-hero-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('overlay_opacity', [
            'label' => esc_html__('شدت لایه روی تصویر', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => ['min' => 0, 'max' => 100],
            ],
            'default' => [
                'size' => 50,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-hero-overlay' => 'opacity: calc({{SIZE}}/100);',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('استایل - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_bg', [
            'label' => esc_html__('پس‌زمینه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_text', [
            'label' => esc_html__('رنگ متن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_badge_bg', [
            'label' => esc_html__('پس‌زمینه برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-badge' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_badge_color', [
            'label' => esc_html__('رنگ متن برچسب', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-badge' => 'color: {{VALUE}}; border-color: {{VALUE}}33;',
            ],
        ]);

        $this->add_control('light_button_text', [
            'label' => esc_html__('رنگ متن دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-btn' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_button_border', [
            'label' => esc_html__('رنگ کادر دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-hero-btn' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('استایل - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_bg', [
            'label' => esc_html__('پس‌زمینه (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_text', [
            'label' => esc_html__('رنگ متن (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_bg', [
            'label' => esc_html__('رنگ دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-hero-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_badge_bg', [
            'label' => esc_html__('پس‌زمینه برچسب (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#27272a',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero-badge' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_badge_color', [
            'label' => esc_html__('رنگ متن برچسب (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero-badge' => 'color: {{VALUE}}; border-color: {{VALUE}}33;',
            ],
        ]);

        $this->add_control('dark_button_text', [
            'label' => esc_html__('رنگ متن دکمه (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-hero-btn' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : '';

        if (!empty($settings['button_url']['url'])) {
            $this->add_link_attributes('hero_btn', $settings['button_url']);
        }
        ?>
        <section class="fadaee-agency-hero relative overflow-hidden rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24">
            <?php if ($bg_image): ?>
                <div class="absolute inset-0">
                    <img src="<?php echo esc_url($bg_image); ?>" alt="" class="h-full w-full object-cover" loading="lazy" />
                    <div class="fadaee-agency-hero-overlay absolute inset-0 bg-black/50"></div>
                </div>
            <?php endif; ?>

            <div class="fadaee-agency-hero-content relative z-10 mx-auto max-w-4xl text-center">
                <?php if (!empty($settings['badge'])): ?>
                    <span class="fadaee-agency-hero-badge inline-flex items-center rounded-full border border-current/20 px-3 py-1 text-sm mb-5">
                        <?php echo esc_html($settings['badge']); ?>
                    </span>
                <?php endif; ?>

                <h2 class="fadaee-agency-hero-title text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                    <?php echo esc_html($settings['title']); ?>
                </h2>

                <p class="fadaee-agency-hero-subtitle mt-6 text-base sm:text-lg leading-8">
                    <?php echo esc_html($settings['subtitle']); ?>
                </p>

                <?php if (!empty($settings['button_text'])): ?>
                    <?php if (!empty($settings['button_url']['url'])): ?>
                        <a <?php echo $this->get_render_attribute_string('hero_btn'); ?> class="fadaee-agency-hero-btn inline-flex mt-8 rounded-xl border px-7 py-3 text-sm font-semibold text-white transition-opacity hover:opacity-90">
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php else: ?>
                        <span class="fadaee-agency-hero-btn inline-flex mt-8 rounded-xl border px-7 py-3 text-sm font-semibold text-white">
                            <?php echo esc_html($settings['button_text']); ?>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}