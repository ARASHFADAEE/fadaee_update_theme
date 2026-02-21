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
    require_once get_template_directory() . '/inc/elementor/class-education-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-work-experience-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-blog-widget.php';
    require_once get_template_directory() . '/inc/elementor/class-blog-categories-widget.php';

    $widgets_manager->register(new \Fadaee_Elementor_Hero_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Testimonials_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Education_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Work_Experience_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Blog_Widget());
    $widgets_manager->register(new \Fadaee_Elementor_Blog_Categories_Widget());
}

add_action('elementor/widgets/register', 'fadaee_register_elementor_widgets');
