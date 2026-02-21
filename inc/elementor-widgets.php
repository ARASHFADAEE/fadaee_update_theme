<?php

if (!defined('ABSPATH')) {
    exit;
}

function fadaee_register_elementor_widgets($widgets_manager) {
    if (!class_exists('\Elementor\Widget_Base')) {
        return;
    }

    require_once get_template_directory() . '/inc/elementor/class-hero-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-testimonials-widget.php';

    $widgets_manager->register(new \Fadaee_Elementor_Hero_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Testimonials_Widget());
}

add_action('elementor/widgets/register', 'fadaee_register_elementor_widgets');

