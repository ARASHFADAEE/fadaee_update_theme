<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_Pricing_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_pricing';
    }

    public function get_title() {
        return esc_html__('آژانس - تعرفه‌ها', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
            'default' => esc_html__('تعرفه خدمات', 'arash-theme'),
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('پلن مناسب خود را انتخاب کنید و همکاری را شروع کنیم.', 'arash-theme'),
        ]);

        $this->add_control('featured_plan_index', [
            'label' => esc_html__('شماره پلن ویژه', 'arash-theme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
            'min' => 0,
            'description' => esc_html__('اگر صفر باشد هیچ پلنی ویژه نمی‌شود. شماره‌گذاری از 1 شروع می‌شود.', 'arash-theme'),
        ]);

        $repeater = new Repeater();
        $repeater->add_control('plan_title', ['label' => 'نام پلن', 'type' => Controls_Manager::TEXT, 'default' => 'حرفه‌ای']);
        $repeater->add_control('price', ['label' => 'قیمت', 'type' => Controls_Manager::TEXT, 'default' => '25 میلیون']);
        $repeater->add_control('features', ['label' => 'ویژگی‌ها (هر خط یک مورد)', 'type' => Controls_Manager::TEXTAREA, 'default' => "سایت اختصاصی\nسئو و سرعت\nپنل مدیریت"]);
        $repeater->add_control('button_text', ['label' => 'متن دکمه', 'type' => Controls_Manager::TEXT, 'default' => 'انتخاب']);
        $repeater->add_control('button_url', ['label' => 'لینک دکمه', 'type' => Controls_Manager::URL]);

        $this->add_control('plans', [
            'label' => esc_html__('پلن‌ها', 'arash-theme'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ plan_title }}}',
            'default' => [
                ['plan_title' => 'پایه', 'price' => '10 میلیون', 'button_text' => 'انتخاب'],
                ['plan_title' => 'حرفه‌ای', 'price' => '25 میلیون', 'button_text' => 'انتخاب'],
                ['plan_title' => 'سازمانی', 'price' => 'تماس بگیرید', 'button_text' => 'تماس'],
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
                'selector' => '{{WRAPPER}} .fadaee-agency-pricing-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-pricing-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'plan_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-pricing-plan-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'plan_price_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-pricing-plan-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'plan_feature_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-pricing-feature',
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
                '{{WRAPPER}} .fadaee-agency-pricing-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('card_padding', [
            'label' => esc_html__('فاصله داخلی کارت', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 12, 'max' => 56],
            ],
            'default' => [
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-pricing-card' => 'padding: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-agency-pricing-grid' => 'gap: {{SIZE}}{{UNIT}};',
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
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-pricing-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_light', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_text', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-plan-title' => 'color: {{VALUE}};',
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-plan-price' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_feature_text', [
            'label' => esc_html__('رنگ ویژگی‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-feature' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_button_bg', [
            'label' => esc_html__('رنگ پس‌زمینه دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_button_text', [
            'label' => esc_html__('رنگ متن دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-btn' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('featured_accent_light', [
            'label' => esc_html__('رنگ پلن ویژه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-pricing-card.is-featured' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_dark', [
            'label' => esc_html__('رنگ‌ها - حالت تیره', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dark_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#09090b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_border', [
            'label' => esc_html__('رنگ کادر کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-card' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_text', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-plan-title' => 'color: {{VALUE}};',
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-plan-price' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_feature_text', [
            'label' => esc_html__('رنگ ویژگی‌ها', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-feature' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_button_bg', [
            'label' => esc_html__('رنگ پس‌زمینه دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_button_text', [
            'label' => esc_html__('رنگ متن دکمه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-btn' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('featured_accent_dark', [
            'label' => esc_html__('رنگ پلن ویژه', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#dc2626',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-pricing-card.is-featured' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $plans = !empty($settings['plans']) && is_array($settings['plans']) ? $settings['plans'] : [];
        $featured_plan_index = isset($settings['featured_plan_index']) ? absint($settings['featured_plan_index']) : 2;

        foreach ($plans as $index => $plan) {
            if (!empty($plan['button_url']['url'])) {
                $this->add_link_attributes('plan_btn_' . $index, $plan['button_url']);
            }
        }
        ?>
        <section class="fadaee-agency-pricing rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-7xl">
                <h3 class="fadaee-agency-pricing-title text-3xl sm:text-4xl font-black text-center text-zinc-900 dark:text-zinc-100 mb-4"><?php echo esc_html($settings['title']); ?></h3>
                <?php if (!empty($settings['subtitle'])): ?>
                    <p class="fadaee-agency-pricing-subtitle text-center text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mb-10"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>
                <div class="fadaee-agency-pricing-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($plans as $index => $plan): ?>
                        <?php $is_featured = ($featured_plan_index > 0 && ($index + 1) === $featured_plan_index); ?>
                        <article class="fadaee-agency-pricing-card rounded-2xl border p-6 <?php echo $is_featured ? 'is-featured text-white border-red-500/40 bg-red-500' : 'border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100'; ?>">
                            <h4 class="fadaee-agency-pricing-plan-title text-xl font-bold"><?php echo esc_html($plan['plan_title']); ?></h4>
                            <div class="fadaee-agency-pricing-plan-price text-3xl font-black mt-4"><?php echo esc_html($plan['price']); ?></div>
                            <ul class="mt-5 space-y-2 text-sm leading-7 <?php echo $is_featured ? 'text-white/90' : ''; ?>">
                                <?php $features = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($plan['features'] ?? '')))); ?>
                                <?php foreach ($features as $feature): ?>
                                    <li class="fadaee-agency-pricing-feature">• <?php echo esc_html($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <?php if (!empty($plan['button_text'])): ?>
                                <div class="mt-6">
                                    <?php if (!empty($plan['button_url']['url'])): ?>
                                        <a <?php echo $this->get_render_attribute_string('plan_btn_' . $index); ?> class="fadaee-agency-pricing-btn inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-semibold transition-opacity hover:opacity-90 <?php echo $is_featured ? 'bg-white text-red-600 border-white' : 'text-white bg-red-500 border-red-500'; ?>">
                                            <?php echo esc_html($plan['button_text']); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="fadaee-agency-pricing-btn inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-semibold <?php echo $is_featured ? 'bg-white text-red-600 border-white' : 'text-white bg-red-500 border-red-500'; ?>">
                                            <?php echo esc_html($plan['button_text']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
