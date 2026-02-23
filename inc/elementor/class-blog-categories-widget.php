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
        return ['general'];
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

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('استایل کارت‌ها', 'arash-theme'),
            'tab' => Controls_Manager::TAB_STYLE,
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .fadaee-blog-category-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
        $section_subtitle = isset($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $categories_input = isset($settings['categories']) ? $settings['categories'] : [];

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
        <section class="w-full py-20 bg-gradient-to-b from-zinc-100 to-white dark:from-zinc-900 dark:to-black">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                    <?php if (!empty($section_title)): ?>
                        <div class="text-3xl font-bold text-zinc-800 dark:text-zinc-100 mb-4 fadaee-blog-category-title">
                            <?php echo esc_html($section_title); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($section_subtitle)): ?>
                        <p class="text-zinc-600 dark:text-zinc-400 text-lg">
                            <?php echo esc_html($section_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($category_ids)): ?>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 transition duration-300"></div>
                                <div class="relative z-10">
                                    <div class="text-xl font-semibold text-zinc-800 dark:text-zinc-100 mb-2">
                                        <?php echo esc_html($term->name); ?>
                                    </div>
                                    <?php if (!empty($term->description)): ?>
                                        <p class="text-zinc-600 dark:text-zinc-400 text-sm mb-4">
                                            <?php echo esc_html(wp_trim_words($term->description, 18, '...')); ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url($term_link); ?>">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-medium text-sm">مشاهده مقالات →</span>
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

