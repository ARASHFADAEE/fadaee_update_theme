<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * تابع محاسبه روشنی رنگ (0-1)
 * رنگ روشن: > 0.5, رنگ تیره: < 0.5
 */
function fadaee_get_color_luminance($color) {
    // تبدیل hex به RGB
    $color = str_replace('#', '', $color);
    if (strlen($color) === 3) {
        $color = str_repeat($color[0], 2) . str_repeat($color[1], 2) . str_repeat($color[2], 2);
    }
    
    $r = hexdec(substr($color, 0, 2)) / 255;
    $g = hexdec(substr($color, 2, 2)) / 255;
    $b = hexdec(substr($color, 4, 2)) / 255;

    $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
    $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
    $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

    return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
}

/**
 * رنگ متن مناسب بر اساس background
 */
function fadaee_get_contrast_color($bg_color) {
    if (empty($bg_color)) {
        return '#ffffff';
    }
    $luminance = fadaee_get_color_luminance($bg_color);
    return $luminance > 0.5 ? '#000000' : '#ffffff';
}

/**
 * رنگ‌های preset theme
 */
function fadaee_get_theme_color_palette() {
    return [
        '#ffffff' => 'سفید',
        '#000000' => 'سیاه',
        '#f97316' => 'نارنجی (اصلی)',
        '#ef4444' => 'قرمز (درخت)',
        '#1f2937' => 'خاکستری تیره',
        '#111827' => 'خاکستری بیشتر تیره',
        '#3b82f6' => 'آبی',
        '#10b981' => 'سبز',
    ];
}

function fadaee_register_elementor_category($elements_manager) {
    if (!is_object($elements_manager) || !method_exists($elements_manager, 'add_category')) {
        return;
    }

    $elements_manager->add_category('fadaee-widgets', [
        'title' => esc_html__('ویجت‌های فدایی', 'arash-theme'),
        'icon' => 'fa fa-plug',
    ]);
}

add_action('elementor/elements/categories_registered', 'fadaee_register_elementor_category');

function fadaee_register_elementor_widgets($widgets_manager) {
    static $is_registered = false;
    if ($is_registered) {
        return;
    }

    if (!class_exists('\Elementor\Widget_Base')) {
        return;
    }

    require_once get_template_directory() . '/inc/elementor/class-hero-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-testimonials-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-education-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-work-experience-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-blog-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-blog-categories-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-demo-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-hero-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-services-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-portfolio-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-testimonials-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-pricing-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-faq-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-blog-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-agency-cta-widget.php';

    $widgets_manager->register(new \Fadaee_Elementor_Hero_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Testimonials_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Education_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Work_Experience_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Blog_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Blog_Categories_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Demo_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Hero_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Services_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Portfolio_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Testimonials_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Pricing_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_FAQ_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_Blog_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Agency_CTA_Widget());

    $is_registered = true;
}

add_action('elementor/widgets/register', 'fadaee_register_elementor_widgets');

function fadaee_register_elementor_widgets_legacy() {
    if (!class_exists('\Elementor\Plugin')) {
        return;
    }

    $instance = \Elementor\Plugin::instance();
    if (isset($instance->widgets_manager)) {
        fadaee_register_elementor_widgets($instance->widgets_manager);
    }
}

add_action('elementor/widgets/widgets_registered', 'fadaee_register_elementor_widgets_legacy');
