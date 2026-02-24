<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Fadaee_Elementor_Agency_FAQ_Widget extends Widget_Base {

    public function get_name() {
        return 'fadaee_agency_faq';
    }

    public function get_title() {
        return esc_html__('آژانس - سوالات متداول', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-help-o';
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
            'default' => esc_html__('سوالات متداول', 'arash-theme'),
        ]);

        $this->add_control('subtitle', [
            'label' => esc_html__('زیرعنوان', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('پاسخ سریع به رایج‌ترین سوالات قبل از شروع همکاری', 'arash-theme'),
        ]);

        $repeater = new Repeater();
        $repeater->add_control('question', ['label' => 'سوال', 'type' => Controls_Manager::TEXT, 'default' => 'مدت زمان اجرای پروژه چقدر است؟']);
        $repeater->add_control('answer', ['label' => 'پاسخ', 'type' => Controls_Manager::TEXTAREA, 'default' => 'بسته به نوع پروژه، نسخه اولیه بین 7 تا 20 روز تحویل می‌شود.']);

        $this->add_control('items', [
            'label' => esc_html__('آیتم‌ها', 'arash-theme'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ question }}}',
            'default' => [
                ['question' => 'مدت زمان اجرای پروژه چقدر است؟', 'answer' => 'بسته به نوع پروژه، نسخه اولیه بین 7 تا 20 روز تحویل می‌شود.'],
                ['question' => 'آیا بعد از تحویل پشتیبانی دارید؟', 'answer' => 'بله، برای تمام پلن‌ها پشتیبانی ارائه می‌شود.'],
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
                'selector' => '{{WRAPPER}} .fadaee-agency-faq-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-faq-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'question_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-faq-question',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'answer_typography',
                'selector' => '{{WRAPPER}} .fadaee-agency-faq-answer',
            ]
        );

        $this->add_control('item_radius', [
            'label' => esc_html__('گردی آیتم', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 30],
            ],
            'default' => [
                'size' => 12,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-faq-item' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('item_padding', [
            'label' => esc_html__('فاصله داخلی آیتم', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 10, 'max' => 40],
            ],
            'default' => [
                'size' => 20,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-faq-item' => 'padding: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('items_gap', [
            'label' => esc_html__('فاصله بین آیتم‌ها', 'arash-theme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 6, 'max' => 36],
            ],
            'default' => [
                'size' => 16,
            ],
            'selectors' => [
                '{{WRAPPER}} .fadaee-agency-faq-list' => 'gap: {{SIZE}}{{UNIT}};',
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
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_item_bg', [
            'label' => esc_html__('پس‌زمینه آیتم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-item' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_item_border', [
            'label' => esc_html__('رنگ کادر آیتم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e4e4e7',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-item' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_question', [
            'label' => esc_html__('رنگ سوال', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-question' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_answer', [
            'label' => esc_html__('رنگ پاسخ', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-agency-faq-answer' => 'color: {{VALUE}};',
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
                'body.dark {{WRAPPER}} .fadaee-agency-faq' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_title', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_subtitle', [
            'label' => esc_html__('رنگ زیرعنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_item_bg', [
            'label' => esc_html__('پس‌زمینه آیتم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-item' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_item_border', [
            'label' => esc_html__('رنگ کادر آیتم', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3f3f46',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-item' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_question', [
            'label' => esc_html__('رنگ سوال', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-question' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_answer', [
            'label' => esc_html__('رنگ پاسخ', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d4d4d8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-agency-faq-answer' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = !empty($settings['items']) && is_array($settings['items']) ? $settings['items'] : [];
        ?>
        <section class="fadaee-agency-faq rounded-3xl px-6 py-16 sm:px-8 lg:px-12 lg:py-24 bg-white dark:bg-zinc-950">
            <div class="mx-auto max-w-5xl">
                <h3 class="fadaee-agency-faq-title text-3xl sm:text-4xl font-black text-center text-zinc-900 dark:text-zinc-100 mb-4"><?php echo esc_html($settings['title']); ?></h3>
                <?php if (!empty($settings['subtitle'])): ?>
                    <p class="fadaee-agency-faq-subtitle text-center text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mb-10"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>
                <div class="fadaee-agency-faq-list space-y-4">
                    <?php foreach ($items as $item): ?>
                        <article class="fadaee-agency-faq-item rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                            <h4 class="fadaee-agency-faq-question font-semibold text-zinc-900 dark:text-zinc-100"><?php echo esc_html($item['question']); ?></h4>
                            <p class="fadaee-agency-faq-answer mt-2 text-sm leading-7 text-zinc-600 dark:text-zinc-300"><?php echo esc_html($item['answer']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
