<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;

class Fadaee_Elementor_Blog_Categories_Widget extends Widget_Base {

    private function get_blog_category_options() {
        $options = [];
        $categories = get_categories([
            'hide_empty' => false,
        ]);

        if (is_array($categories)) {
            foreach ($categories as $category) {
                $options[$category->term_id] = $category->name;
            }
        }

        return $options;
    }

    public function get_name() {
        return 'fadaee_blog_categories';
    }

    public function get_title() {
        return esc_html__('دسته‌بندی مقالات (Fadaee)', 'arash-theme');
    }

    public function get_icon() {
        return 'eicon-table-of-contents';
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
            'default' => esc_html__('دسته‌بندی مقالات', 'arash-theme'),
        ]);

        $this->add_control('section_subtitle', [
            'label' => esc_html__('توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::TEXTAREA,
            'rows' => 3,
            'default' => esc_html__('موضوعات مختلف در حوزه برنامه‌نویسی را مرور کنید', 'arash-theme'),
        ]);

        $this->add_control('categories', [
            'label' => esc_html__('انتخاب دسته‌ها', 'arash-theme'),
            'type' => Controls_Manager::SELECT2,
            'options' => $this->get_blog_category_options(),
            'multiple' => true,
            'label_block' => true,
            'description' => esc_html__('یک یا چند دسته را انتخاب کنید.', 'arash-theme'),
        ]);

        $this->add_control('columns', [
            'label' => esc_html__('تعداد ستون', 'arash-theme'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '2' => esc_html__('دو ستون', 'arash-theme'),
                '3' => esc_html__('سه ستون', 'arash-theme'),
                '4' => esc_html__('چهار ستون', 'arash-theme'),
            ],
        ]);

        $this->add_control('show_description', [
            'label' => esc_html__('نمایش توضیح دسته', 'arash-theme'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_post_count', [
            'label' => esc_html__('نمایش تعداد مقالات', 'arash-theme'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('link_text', [
            'label' => esc_html__('متن لینک', 'arash-theme'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('مشاهده مقالات', 'arash-theme'),
            'dynamic' => ['active' => true],
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
                'selector' => '{{WRAPPER}} .fadaee-blog-category-section-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_subtitle_typography',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-section-subtitle',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_title_typography',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-card-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_text_typography',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-card-description',
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
                '{{WRAPPER}} .fadaee-blog-category-card' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-blog-category-card' => 'padding: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .fadaee-blog-categories-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-card',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('style_light_section', [
            'label' => esc_html__('رنگ‌ها - حالت روشن', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('light_section_bg', [
            'label' => esc_html__('پس‌زمینه بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-categories-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_title_color', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-section-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_section_subtitle_color', [
            'label' => esc_html__('رنگ توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-section-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_title_color', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-card-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_text_color', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#52525b',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-card-description' => 'color: {{VALUE}};',
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-count' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_card_link_color', [
            'label' => esc_html__('رنگ لینک', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#4f46e5',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-link' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('light_hover_overlay', [
            'label' => esc_html__('رنگ افکت هاور', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(99, 102, 241, 0.12)',
            'selectors' => [
                'body:not(.dark) {{WRAPPER}} .fadaee-blog-category-overlay' => 'background-color: {{VALUE}};',
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
                'body.dark {{WRAPPER}} .fadaee-blog-categories-section' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_title_color', [
            'label' => esc_html__('رنگ عنوان بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-section-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_section_subtitle_color', [
            'label' => esc_html__('رنگ توضیح بخش', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-section-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_bg', [
            'label' => esc_html__('پس‌زمینه کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#18181b',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-card' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_title_color', [
            'label' => esc_html__('رنگ عنوان کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f4f4f5',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-card-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_text_color', [
            'label' => esc_html__('رنگ متن کارت', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#a1a1aa',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-card-description' => 'color: {{VALUE}};',
                'body.dark {{WRAPPER}} .fadaee-blog-category-count' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_card_link_color', [
            'label' => esc_html__('رنگ لینک', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#818cf8',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-link' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dark_hover_overlay', [
            'label' => esc_html__('رنگ افکت هاور', 'arash-theme'),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(129, 140, 248, 0.18)',
            'selectors' => [
                'body.dark {{WRAPPER}} .fadaee-blog-category-overlay' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
        $section_subtitle = isset($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $categories_input = isset($settings['categories']) ? $settings['categories'] : [];
        $columns = isset($settings['columns']) ? $settings['columns'] : '3';
        $show_description = isset($settings['show_description']) && $settings['show_description'] === 'yes';
        $show_post_count = isset($settings['show_post_count']) && $settings['show_post_count'] === 'yes';
        $link_text = isset($settings['link_text']) ? $settings['link_text'] : esc_html__('مشاهده مقالات', 'arash-theme');

        $grid_columns_class = 'lg:grid-cols-3';
        if ($columns === '2') {
            $grid_columns_class = 'lg:grid-cols-2';
        } elseif ($columns === '4') {
            $grid_columns_class = 'lg:grid-cols-4';
        }

        $category_ids = [];
        if (is_array($categories_input)) {
            foreach ($categories_input as $raw_id) {
                $id = absint($raw_id);
                if ($id > 0) {
                    $category_ids[] = $id;
                }
            }
        }

        if (empty($category_ids)) {
            $category_ids = [];
        }

        ?>
        <section class="fadaee-blog-categories-section w-full py-20 bg-gradient-to-b from-zinc-100 to-white dark:from-zinc-900 dark:to-black">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                    <?php if (!empty($section_title)): ?>
                        <div class="fadaee-blog-category-section-title text-3xl font-bold text-zinc-800 dark:text-zinc-100 mb-4">
                            <?php echo esc_html($section_title); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($section_subtitle)): ?>
                        <p class="fadaee-blog-category-section-subtitle text-zinc-600 dark:text-zinc-400 text-lg">
                            <?php echo esc_html($section_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($category_ids)): ?>
                    <div class="fadaee-blog-categories-grid grid sm:grid-cols-2 <?php echo esc_attr($grid_columns_class); ?> gap-6">
                        <?php foreach ($category_ids as $cat_id):
                            $term = get_category($cat_id);
                            if (!$term || is_wp_error($term)) {
                                continue;
                            }
                            $term_link = get_term_link($term);
                            if (is_wp_error($term_link)) {
                                continue;
                            }
                            ?>
                            <div class="fadaee-blog-category-card group relative rounded-2xl p-6 bg-white dark:bg-zinc-900 shadow hover:shadow-xl transition-all duration-300 border border-zinc-200/50 dark:border-zinc-700/40 cursor-pointer overflow-hidden">
                                <div class="fadaee-blog-category-overlay absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 transition duration-300"></div>
                                <div class="relative z-10">
                                    <div class="fadaee-blog-category-card-title text-xl font-semibold text-zinc-800 dark:text-zinc-100 mb-2">
                                        <?php echo esc_html($term->name); ?>
                                    </div>
                                    <?php if ($show_post_count): ?>
                                        <p class="fadaee-blog-category-count text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                                            <?php echo esc_html(fadaee_persian_numbers((int) $term->count)); ?> <?php echo esc_html__('مقاله', 'arash-theme'); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($show_description && !empty($term->description)): ?>
                                        <p class="fadaee-blog-category-card-description text-zinc-600 dark:text-zinc-400 text-sm mb-4">
                                            <?php echo esc_html(wp_trim_words($term->description, 18, '...')); ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url($term_link); ?>">
                                        <span class="fadaee-blog-category-link text-indigo-600 dark:text-indigo-400 font-medium text-sm"><?php echo esc_html($link_text); ?> →</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center">
                        <?php echo esc_html__('هنوز دسته‌ای انتخاب نشده است.', 'arash-theme'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

