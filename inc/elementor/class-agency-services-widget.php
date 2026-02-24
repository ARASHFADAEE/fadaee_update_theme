<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Services_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_services';
    }

    public function get_title() {
        return esc_html__('آژانس - خدمات', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-library-open';
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
            'default' => esc_html__('خدمات ما', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('راهکارهای حرفه‌ای برای رشد کسب‌وکار شما', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $repeater = new Repeater();
        $repeater->add_control('icon', [
            'label' => esc_html__('آیکون/ایموجی', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => '⚡',
        ]);
        $repeater->add_control('item_title', [
            'label' => esc_html__('عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('طراحی و توسعه وب', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);
        $repeater->add_control('item_desc', [
            'label' => esc_html__('توضیح کارت', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('توسعه سریع، مقیاس‌پذیر و استاندارد.', 'arash-theme'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('items', [
            'label' => esc_html__('آیتم‌ها', 'arash-theme'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ item_title }}}',
            'default' => [
                ['icon' => '🎨', 'item_title' => 'طراحی UI/UX', 'item_desc' => 'طراحی تجربه کاربری و رابط کاربری حرفه‌ای.'],
                ['icon' => '💻', 'item_title' => 'توسعه وب', 'item_desc' => 'پیاده‌سازی استاندارد با تمرکز روی performance.'],
                ['icon' => '🚀', 'item_title' => 'سئو و سرعت', 'item_desc' => 'بهبود Core Web Vitals و رتبه جستجو.'],
            ],
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

        $this->end_controls_section();

        $this->start_controls_section('style_common', [
            'label' => esc_html__('استایل عمومی', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-services-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-services-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-service-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_desc_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-service-desc',
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
                '{{WRAPPER}} .fadaee-agency-service-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('card_padding', [
            'label' => esc_html__('فاصله داخلی کارت', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 12, 'max' => 48],
            ],
            'default' => [
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-service-card' => 'padding: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-agency-services-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('icon_color', [
            'label' => esc_html__('رنگ آیکون', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-service-icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('استایل - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-services' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('light_card', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f8fafc',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-service-card' => 'background-color: {{VALUE}}; border-color: #e4e4e7;'],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-services-title, body:not(.dark) {{WRAPPER}} .fadaee-agency-service-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('light_text', [
            'label' => esc_html__('رنگ متن', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => ['body:not(.dark) {{WRAPPER}} .fadaee-agency-services-subtitle, body:not(.dark) {{WRAPPER}} .fadaee-agency-service-desc' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('استایل - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_bg', [
            'label' => esc_html__('پس‌زمینه بخش (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-services' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('dark_card', [
            'label' => esc_html__('پس‌زمینه کارت (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-service-card' => 'background-color: {{VALUE}}; border-color: #3f3f46;'],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-services-title, body.dark {{WRAPPER}} .fadaee-agency-service-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('dark_text', [
            'label' => esc_html__('رنگ متن (تیره)', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => ['body.dark {{WRAPPER}} .fadaee-agency-services-subtitle, body.dark {{WRAPPER}} .fadaee-agency-service-desc' => 'color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = !empty($settings['items']) && is_array($settings['items']) ? $settings['items'] : [];
        $columns = isset($settings['columns']) ? $settings['columns'] : '3';
        $grid_columns_class = 'lg:grid-cols-3';
        if ($columns === '2') {
            $grid_columns_class = 'lg:grid-cols-2';
        } elseif ($columns === '4') {
            $grid_columns_class = 'lg:grid-cols-4';
        }
        ?>
        <section class="fadaee-agency-services rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24">
            <div class="mx-auto max-w-7xl">
                <div class="text-center mb-12">
                    <h3 class="fadaee-agency-services-title text-3xl sm:text-4xl font-black"><?php echo esc_html($settings['title']); ?></h3>
                    <p class="fadaee-agency-services-subtitle mt-4 text-base sm:text-lg"><?php echo esc_html($settings['subtitle']); ?></p>
                </div>

                <div class="fadaee-agency-services-grid grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($grid_columns_class); ?> gap-6">
                    <?php foreach ($items as $item): ?>
                        <article class="fadaee-agency-service-card rounded-2xl border p-6 transition-transform hover:-translate-y-1">
                            <div class="fadaee-agency-service-icon text-2xl mb-3"><?php echo esc_html($item['icon']); ?></div>
                            <h4 class="fadaee-agency-service-title text-lg font-bold"><?php echo esc_html($item['item_title']); ?></h4>
                            <p class="fadaee-agency-service-desc mt-2 text-sm leading-7"><?php echo esc_html($item['item_desc']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
