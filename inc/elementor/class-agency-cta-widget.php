<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_CTA_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_cta';
    }

    public function get_title() {
        return esc_html__('آژانس - CTA', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-button';
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
            'default' => esc_html__('آماده شروع یک پروژه جدید هستید؟', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('توضیح', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('برای شروع همکاری همین حالا با ما تماس بگیرید.', 'arash-theme'),
            'dynamic' => ['active' => true],
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

        $this->add_control('bg_image', [
            'label' => esc_html__('تصویر پس‌زمینه', 'arash-theme'),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => ''],
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
                '{{WRAPPER}} .fadaee-agency-cta-content' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-cta-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-cta-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-cta-btn',
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
                '{{WRAPPER}} .fadaee-agency-cta' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-agency-cta-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                'size' => 60,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-cta-overlay' => 'opacity: calc({{SIZE}}/100);',
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
            'default' => '#f8fafc',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-cta' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_border', [
            'label' => esc_html__('رنگ کادر بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-cta' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('title_light', [
            'label' => esc_html__('رنگ عنوان روشن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-cta-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('text_light', [
            'label' => esc_html__('رنگ متن روشن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-cta-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_bg', [
            'label' => esc_html__('رنگ پس‌زمینه دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => ['{{WRAPPER}} .fadaee-agency-cta-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_light_text', [
            'label' => esc_html__('رنگ متن دکمه (روشن)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-cta-btn' => 'color: {{VALUE}};'],
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
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-cta' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_border', [
            'label' => esc_html__('رنگ کادر بخش (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-cta' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('title_dark', [
            'label' => esc_html__('رنگ عنوان تیره', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-cta-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('text_dark', [
            'label' => esc_html__('رنگ متن تیره', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-cta-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_dark_text', [
            'label' => esc_html__('رنگ متن دکمه (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-cta-btn' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : '';

        if (!empty($settings['button_url']['url'])) {
            $this->add_link_attributes('cta_btn', $settings['button_url']);
        }
        ?>
        <section class="fadaee-agency-cta relative overflow-hidden rounded-3xl border px-6 py-16 sm:px-8 lg:px-12 lg:py-24 text-center">
            <?php if ($bg_image): ?>
                <div class="absolute inset-0">
                    <img src="<?php echo esc_url($bg_image); ?>" alt="" class="h-full w-full object-cover" loading="lazy" />
                    <div class="fadaee-agency-cta-overlay absolute inset-0 bg-black/60"></div>
                </div>
            <?php endif; ?>

            <div class="fadaee-agency-cta-content relative z-10 mx-auto max-w-3xl">
                <h3 class="fadaee-agency-cta-title text-3xl sm:text-4xl font-black"><?php echo esc_html($settings['title']); ?></h3>
                <p class="fadaee-agency-cta-subtitle mt-4 text-base sm:text-lg leading-8"><?php echo esc_html($settings['subtitle']); ?></p>

                <?php if (!empty($settings['button_text'])): ?>
                    <?php if (!empty($settings['button_url']['url'])): ?>
                        <a <?php echo $this->get_render_attribute_string('cta_btn'); ?> class="fadaee-agency-cta-btn inline-flex mt-8 rounded-xl border px-7 py-3 text-sm font-semibold transition-opacity hover:opacity-90">
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php else: ?>
                        <span class="fadaee-agency-cta-btn inline-flex mt-8 rounded-xl border px-7 py-3 text-sm font-semibold">
                            <?php echo esc_html($settings['button_text']); ?>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
