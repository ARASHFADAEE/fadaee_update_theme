<?php



define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('ARASH_THEME_OPTIONS_KEY', 'arash_theme_options');


//support theme

function support_theme_arash()
{

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'menus' );
    load_theme_textdomain( 'arash-theme', THEME_DIR . '/languages' );



}

add_action( 'after_setup_theme', 'support_theme_arash' );

require_once THEME_DIR . '/inc/elementor-widgets.php';

function enqueue_theme_styles() {
    // بارگذاری CSS تم
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/src/output.css',
        array(), // وابستگی‌ها
        filemtime( get_template_directory() . '/src/output.css' ) // ورژن براساس تغییرات فایل
    );

    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/src/custom.css',
        array(), // وابستگی‌ها
        filemtime( get_template_directory() . '/src/custom.css' ) // ورژن براساس تغییرات فایل
    );

    wp_enqueue_style(
        'agency-widgets-style',
        get_template_directory_uri() . '/src/agency-widgets.css',
        array(),
        filemtime( get_template_directory() . '/src/agency-widgets.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );


//registe js docs

function enqueue_theme_scripts() {


    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '', true);


}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );

add_action('wp_enqueue_scripts', function () {
    wp_localize_script('main-js', 'fadaee_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('fadaee_nonce')
    ]);
});


function arash_get_anonymous_visitor_id() {
    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
    if ($ip === '') {
        return '';
    }

    if (function_exists('wp_privacy_anonymize_ip')) {
        $ip = wp_privacy_anonymize_ip($ip);
    }

    return hash('sha256', $ip . NONCE_SALT);
}




function fadaee_like_post_handler() {

    check_ajax_referer('fadaee_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    if (!$post_id || get_post_status($post_id) !== 'publish') {
        wp_send_json_error(['message' => 'Invalid Post ID']);
    }

    $visitor_id = arash_get_anonymous_visitor_id();
    if ($visitor_id === '') {
        wp_send_json_error(['message' => 'امکان ثبت رای وجود ندارد']);
    }

    $liked_ips = get_post_meta($post_id, 'liked_ips', true);

    if (!is_array($liked_ips)) {
        $liked_ips = [];
    }

    // جلوگیری از لایک تکراری
    if (in_array($visitor_id, $liked_ips, true)) {
        wp_send_json_error(['message' => 'شما قبلا این پست را لایک کرده‌اید']);
    }

    // افزایش تعداد لایک
    $likes = (int) get_post_meta($post_id, 'likes_count', true);
    $likes++;

    update_post_meta($post_id, 'likes_count', $likes);

    // ذخیره IP
    $liked_ips[] = $visitor_id;
    $liked_ips = array_slice(array_values(array_unique($liked_ips)), -1000);
    update_post_meta($post_id, 'liked_ips', $liked_ips);

    wp_send_json_success([
        'likes' => $likes
    ]);
}
add_action('wp_ajax_fadaee_like_post', 'fadaee_like_post_handler');
add_action('wp_ajax_nopriv_fadaee_like_post', 'fadaee_like_post_handler');

//register nav

function nav_handler()
{

    register_nav_menus(
        array(
            'main_menu' => 'Main Menu',

        )

    );

}

add_action('init', 'nav_handler');

add_action("wp_ajax_fadaee_dislike_post", "fadaee_dislike_post");
add_action("wp_ajax_nopriv_fadaee_dislike_post", "fadaee_dislike_post");

function fadaee_dislike_post() {
    check_ajax_referer('fadaee_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    if (!$post_id || get_post_status($post_id) !== 'publish') {
        wp_send_json_error(['message' => 'شناسه پست معتبر نیست.']);
    }

    $visitor_id = arash_get_anonymous_visitor_id();
    if ($visitor_id === '') {
        wp_send_json_error(['message' => 'امکان ثبت رای وجود ندارد']);
    }

    // گرفتن لیست IP هایی که قبلاً دیسلایک کرده‌اند
    $ips = get_post_meta($post_id, 'dislikes_ips', true);

    // اگر لیست خالی بود => آرایه بساز
    if (!is_array($ips)) {
        $ips = [];
    }

    // اگر این IP قبلاً رای داده، اجازه ثبت دوباره نده
    if (in_array($visitor_id, $ips, true)) {
        wp_send_json_error([
            'message' => 'شما قبلاً دیسلایک کرده‌اید.'
        ]);
    }

    // ثبت دیسلایک
    $count = intval(get_post_meta($post_id, 'dislikes_count', true));
    $count++;

    update_post_meta($post_id, 'dislikes_count', $count);

    // اضافه کردن IP جدید به لیست
    $ips[] = $visitor_id;
    $ips = array_slice(array_values(array_unique($ips)), -1000);
    update_post_meta($post_id, 'dislikes_ips', $ips);

    wp_send_json_success([
        'dislikes' => $count,
        'message' => 'دیسلایک ثبت شد.'
    ]);
}




// افزایش تعداد بازدید پست
function fadaee_set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// جلوگیری از کش پاک شدن بازدیدها
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


// اجرای تابع هنگام مشاهده پست
function fadaee_track_post_views()
{
    if (is_single() && !is_admin() && !is_preview() && !wp_doing_ajax() && !is_user_logged_in()) {
        global $post;
        if (!empty($post->ID)) {
            fadaee_set_post_views($post->ID);
        }
    }
}
add_action('template_redirect', 'fadaee_track_post_views');






function fadaee_get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        return 0;
    }

    return $count;
}

/**
 * Translation helper function for Persian localization
 * 
 * @param string $key Translation key
 * @return string Translated Persian text or key if not found
 */
function fadaee_translate($key) {
    $translations = [
        'back_to_home' => 'بازگشت به خانه',
        'recent_notes' => 'یادداشت‌های اخیر',
        'view_all' => 'مشاهده همه',
        'views' => 'بازدید',
        'likes' => 'پسندیدن',
        'read_more' => 'ادامه مطلب',
        'no_posts' => 'پستی یافت نشد',
        'all_rights_reserved' => 'تمامی حقوق محفوظ است',
        'senior_web_developer' => 'توسعه‌دهنده ارشد وب و متخصص PHP',
        'intro_text' => 'سلام! من آرش فدایی هستم، یک توسعه‌دهنده وب با بیش از 6 سال تجربه در طراحی و توسعه وب‌سایت‌ها و اپلیکیشن‌های وب. علاقه‌مند به یادگیری تکنولوژی‌های جدید و به اشتراک‌گذاری دانش.',
        'everything_more' => 'همه چیز و کمی بیشتر',
        'blog_description' => 'یادداشت‌ها و مقالاتی درباره برنامه‌نویسی، توسعه وب، و تجربیات شخصی من در دنیای تکنولوژی.',
    ];
    
    if (!isset($translations[$key])) {
        error_log("Missing translation for key: {$key}");
        return $key;
    }
    
    return $translations[$key];
}

/**
 * Convert English numbers to Persian numbers
 * 
 * @param string|int $number Number to convert
 * @return string Number with Persian digits
 */
function fadaee_persian_numbers($number) {
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    
    return str_replace($english, $persian, (string)$number);
}


function arash_get_theme_option_defaults() {
    return [
        'general_logo' => 0,
        'general_favicon' => 0,
        'general_copyright' => 'تمامی حقوق برای آرش فدایی محفوظ است.',
        'general_google_analytics_id' => '',
        'hero_headline' => 'توسعه‌دهنده ارشد وب و متخصص PHP',
        'hero_subheadline' => 'سلام! من آرش فدایی هستم، یک توسعه‌دهنده وب با بیش از ۶ سال تجربه در طراحی و توسعه وب‌سایت‌ها و اپلیکیشن‌های وب.',
        'hero_primary_button_label' => 'همکاری با من',
        'hero_primary_button_url' => '',
        'hero_secondary_button_label' => 'مشاهده رزومه',
        'hero_secondary_button_url' => '',
        'hero_background_type' => 'color',
        'hero_background_color' => '',
        'hero_background_color_light' => '',
        'hero_background_color_dark' => '#020617',
        'hero_background_image' => 0,
        'hero_avatar_id' => 0,
        'primary_color' => '#f97316',
        'accent_color' => '#ef4444',
        'font_family' => 'IRANYekan',
        'social_github' => '',
        'social_linkedin' => '',
        'social_twitter' => '',
        'social_dribbble' => '',
        'social_email' => '',
        'social_github_icon' => 0,
        'social_linkedin_icon' => 0,
        'social_twitter_icon' => 0,
        'social_dribbble_icon' => 0,
        'home_categories_enabled' => 1,
        'home_category_1' => 0,
        'home_category_2' => 0,
        'home_category_3' => 0,
        'education_enabled' => 1,
        'education_order' => 1,
        'work_enabled' => 1,
        'work_order' => 2,
        'testimonials_enabled' => 1,
        'testimonials_order' => 3,
        'testimonials_title' => 'نظرات مشتریان',
        'testimonials_subtitle' => 'مشتری‌ها در مورد همکاری با من چه می‌گویند؟',
        'testimonials_items' => 6,
        'portfolio_items_per_page' => 6,
        'portfolio_layout' => 'grid',
        'hero_portfolio_1' => 0,
        'hero_portfolio_2' => 0,
        'hero_portfolio_3' => 0,
        'hero_portfolio_4' => 0,
        'hero_portfolio_5' => 0,
        'home_builder_mode' => 'elementor',
        'home_demo_variant' => 'classic_personal',
        'use_agency_styling' => 0,
        'blog_enabled' => 1,
        'blog_items_per_page' => 6,
        'blog_page_title' => fadaee_translate('everything_more'),
        'blog_page_description' => fadaee_translate('blog_description'),
        'blog_comment_rating_enabled' => 1,
        'comments_per_page' => 10,
        'contact_email' => '',
        'contact_map_embed' => '',
        'contact_form_shortcode' => '',
        'sticky_contact_phone' => '',
        'sticky_contact_label' => 'تماس مستقیم با من',
        'sticky_contact_color' => '#059669',
        'footer_text' => 'تمامی حقوق این وب‌سایت محفوظ است.',
        'footer_cta_enabled' => 1,
        'footer_cta_title' => 'آماده‌ای روی پروژه بعدی‌ات کار کنیم؟',
        'footer_cta_subtitle' => 'اگر روی یک محصول جدید، وب‌اپلیکیشن یا سیستم پیچیده کار می‌کنی، خوشحال می‌شوم در کنار هم روی آن فکر کنیم.',
        'footer_cta_button_label' => 'در ارتباط باشیم',
        'footer_cta_button_url' => '',
    ];
}


function arash_get_theme_options() {
    $defaults = arash_get_theme_option_defaults();
    $options = get_option(ARASH_THEME_OPTIONS_KEY, []);
    if (!is_array($options)) {
        $options = [];
    }
    return array_merge($defaults, $options);
}


function arash_get_theme_option($key) {
    $options = arash_get_theme_options();
    if (isset($options[$key])) {
        return $options[$key];
    }
    $defaults = arash_get_theme_option_defaults();
    if (isset($defaults[$key])) {
        return $defaults[$key];
    }
    return null;
}


function arash_sanitize_checkbox($value) {
    return $value ? 1 : 0;
}


function arash_sanitize_text($value) {
    return sanitize_text_field($value);
}


function arash_sanitize_textarea($value) {
    return sanitize_textarea_field($value);
}


function arash_sanitize_url($value) {
    return esc_url_raw($value);
}


function arash_sanitize_email_field($value) {
    return sanitize_email($value);
}


function arash_sanitize_color($value) {
    return sanitize_hex_color($value);
}


function arash_sanitize_integer($value) {
    return absint($value);
}


function arash_sanitize_choice($value, $setting = null) {
    if (is_object($setting) && isset($setting->manager, $setting->id)) {
        $control = $setting->manager->get_control($setting->id);
        if ($control && !empty($control->choices)) {
            if (isset($control->choices[$value])) {
                return $value;
            }
            $keys = array_keys($control->choices);
            return reset($keys);
        }
    }

    return sanitize_text_field((string) $value);
}


function arash_output_google_analytics() {
    $options = arash_get_theme_options();
    $tracking_id = '';
    if (isset($options['general_google_analytics_id'])) {
        $tracking_id = trim($options['general_google_analytics_id']);
    }
    if (!$tracking_id) {
        return;
    }
    echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr($tracking_id) . '"></script>';
    echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","' . esc_js($tracking_id) . '");</script>';
}
add_action('wp_head', 'arash_output_google_analytics');


function arash_customize_register($wp_customize) {
    $defaults = arash_get_theme_option_defaults();

    $wp_customize->add_panel('arash_theme_options_panel', [
        'title' => __('تنظیمات قالب مینیمو', 'arash-theme'),
        'priority' => 10,
    ]);

    $wp_customize->add_section('arash_theme_section_general', [
        'title' => __('عمومی', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 10,
    ]);

    $wp_customize->add_section('arash_theme_section_hero', [
        'title' => __('بخش هیرو', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 20,
    ]);

    $wp_customize->add_section('arash_theme_section_colors', [
        'title' => __('رنگ‌ها و تایپوگرافی', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 30,
    ]);

    $wp_customize->add_section('arash_theme_section_social', [
        'title' => __('شبکه‌های اجتماعی', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 40,
    ]);

    $wp_customize->add_section('arash_theme_section_home', [
        'title' => __('صفحه اصلی', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 43,
    ]);

    $wp_customize->add_section('arash_theme_section_home_categories', [
        'title' => __('دسته‌بندی‌های صفحه اصلی', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 45,
    ]);

    $wp_customize->add_section('arash_theme_section_education', [
        'title' => __('بخش تحصیلات', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 50,
    ]);

    $wp_customize->add_section('arash_theme_section_work', [
        'title' => __('بخش تجربه کاری', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 60,
    ]);

    $wp_customize->add_section('arash_theme_section_testimonials', [
        'title' => __('بخش نظرات مشتریان', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 65,
    ]);

    $wp_customize->add_section('arash_theme_section_portfolio', [
        'title' => __('بخش نمونه‌کارها', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 70,
    ]);

    $wp_customize->add_section('arash_theme_section_blog', [
        'title' => __('بخش مقالات', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 80,
    ]);

    $wp_customize->add_section('arash_theme_section_contact', [
        'title' => __('بخش تماس', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 90,
    ]);

    $wp_customize->add_section('arash_theme_section_footer', [
        'title' => __('فوتر', 'arash-theme'),
        'panel' => 'arash_theme_options_panel',
        'priority' => 100,
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[general_logo]', [
        'type' => 'option',
        'default' => $defaults['general_logo'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_general_logo', [
        'label' => __('لوگوی سایت', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[general_logo]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[general_favicon]', [
        'type' => 'option',
        'default' => $defaults['general_favicon'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_general_favicon', [
        'label' => __('فیوآیکون اختصاصی', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[general_favicon]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[general_copyright]', [
        'type' => 'option',
        'default' => $defaults['general_copyright'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_general_copyright', [
        'label' => __('متن کپی‌رایت', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[general_copyright]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[general_google_analytics_id]', [
        'type' => 'option',
        'default' => $defaults['general_google_analytics_id'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_general_google_analytics_id', [
        'label' => __('Google Analytics ID', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[general_google_analytics_id]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_headline]', [
        'type' => 'option',
        'default' => $defaults['hero_headline'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_headline', [
        'label' => __('عنوان اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_headline]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_subheadline]', [
        'type' => 'option',
        'default' => $defaults['hero_subheadline'],
        'sanitize_callback' => 'arash_sanitize_textarea',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_subheadline', [
        'label' => __('متن توضیحی', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'textarea',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_subheadline]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_primary_button_label]', [
        'type' => 'option',
        'default' => $defaults['hero_primary_button_label'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_primary_button_label', [
        'label' => __('متن دکمه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_primary_button_label]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_primary_button_url]', [
        'type' => 'option',
        'default' => $defaults['hero_primary_button_url'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_primary_button_url', [
        'label' => __('لینک دکمه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_primary_button_url]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_secondary_button_label]', [
        'type' => 'option',
        'default' => $defaults['hero_secondary_button_label'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_secondary_button_label', [
        'label' => __('متن دکمه دوم', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_secondary_button_label]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_secondary_button_url]', [
        'type' => 'option',
        'default' => $defaults['hero_secondary_button_url'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_secondary_button_url', [
        'label' => __('لینک دکمه دوم', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_secondary_button_url]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_background_type]', [
        'type' => 'option',
        'default' => $defaults['hero_background_type'],
        'sanitize_callback' => 'arash_sanitize_choice',
    ]);

    $wp_customize->add_control('arash_theme_options_hero_background_type', [
        'label' => __('نوع پس‌زمینه', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'type' => 'select',
        'choices' => [
            'color' => __('رنگ ثابت', 'arash-theme'),
            'image' => __('تصویر', 'arash-theme'),
        ],
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_background_type]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_background_color]', [
        'type' => 'option',
        'default' => $defaults['hero_background_color'],
        'sanitize_callback' => 'arash_sanitize_color',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'arash_theme_options_hero_background_color', [
        'label' => __('رنگ پس‌زمینه هیرو', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_background_color]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_background_color_light]', [
        'type' => 'option',
        'default' => $defaults['hero_background_color'],
        'sanitize_callback' => 'arash_sanitize_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'arash_theme_options_hero_background_color_light', [
        'label' => __('رنگ هیرو در حالت روشن', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_background_color_light]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_background_color_dark]', [
        'type' => 'option',
        'default' => '#0b1020',
        'sanitize_callback' => 'arash_sanitize_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'arash_theme_options_hero_background_color_dark', [
        'label' => __('رنگ هیرو در حالت تاریک', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_background_color_dark]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_background_image]', [
        'type' => 'option',
        'default' => $defaults['hero_background_image'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_hero_background_image', [
        'label' => __('تصویر پس‌زمینه هیرو', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_background_image]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_avatar_id]', [
        'type' => 'option',
        'default' => $defaults['hero_avatar_id'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_hero_avatar_id', [
        'label' => __('تصویر آواتار هیرو', 'arash-theme'),
        'section' => 'arash_theme_section_hero',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_avatar_id]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[primary_color]', [
        'type' => 'option',
        'default' => $defaults['primary_color'],
        'sanitize_callback' => 'arash_sanitize_color',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'arash_theme_options_primary_color', [
        'label' => __('رنگ اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_colors',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[primary_color]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[accent_color]', [
        'type' => 'option',
        'default' => $defaults['accent_color'],
        'sanitize_callback' => 'arash_sanitize_color',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'arash_theme_options_accent_color', [
        'label' => __('رنگ تأکیدی', 'arash-theme'),
        'section' => 'arash_theme_section_colors',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[accent_color]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[font_family]', [
        'type' => 'option',
        'default' => $defaults['font_family'],
        'sanitize_callback' => 'arash_sanitize_choice',
    ]);

    $wp_customize->add_control('arash_theme_options_font_family', [
        'label' => __('فونت اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_colors',
        'type' => 'select',
        'choices' => [
            'IRANYekan' => __('ایران یکان', 'arash-theme'),
            'PeydaWebVF' => __('پیدا', 'arash-theme'),
        ],
        'settings' => ARASH_THEME_OPTIONS_KEY . '[font_family]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_github]', [
        'type' => 'option',
        'default' => $defaults['social_github'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_social_github', [
        'label' => __('لینک گیت‌هاب', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_github]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_github_icon]', [
        'type' => 'option',
        'default' => 0,
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_social_github_icon', [
        'label' => __('آیکن گیت‌هاب', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_github_icon]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_linkedin]', [
        'type' => 'option',
        'default' => $defaults['social_linkedin'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_social_linkedin', [
        'label' => __('لینک لینکدین', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_linkedin]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_linkedin_icon]', [
        'type' => 'option',
        'default' => 0,
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_social_linkedin_icon', [
        'label' => __('آیکن لینکدین', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_linkedin_icon]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_twitter]', [
        'type' => 'option',
        'default' => $defaults['social_twitter'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_social_twitter', [
        'label' => __('لینک توییتر / ایکس', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_twitter]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_twitter_icon]', [
        'type' => 'option',
        'default' => 0,
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_social_twitter_icon', [
        'label' => __('آیکن توییتر/ایکس', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_twitter_icon]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_dribbble]', [
        'type' => 'option',
        'default' => $defaults['social_dribbble'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_social_dribbble', [
        'label' => __('لینک دریبل', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_dribbble]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_dribbble_icon]', [
        'type' => 'option',
        'default' => 0,
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'arash_theme_options_social_dribbble_icon', [
        'label' => __('آیکن دریبل', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'mime_type' => 'image',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_dribbble_icon]',
    ]));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[social_email]', [
        'type' => 'option',
        'default' => $defaults['social_email'],
        'sanitize_callback' => 'arash_sanitize_email_field',
    ]);

    $wp_customize->add_control('arash_theme_options_social_email', [
        'label' => __('ایمیل تماس', 'arash-theme'),
        'section' => 'arash_theme_section_social',
        'type' => 'email',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[social_email]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_categories_enabled]', [
        'type' => 'option',
        'default' => 1,
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);
    $wp_customize->add_control('arash_theme_options_home_categories_enabled', [
        'label' => __('نمایش دسته‌بندی‌های صفحه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_home_categories',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_categories_enabled]',
    ]);

    $categories = get_categories([
        'hide_empty' => false,
    ]);
    $category_choices = [
        0 => __('— انتخاب دسته‌بندی —', 'arash-theme'),
    ];
    foreach ($categories as $cat) {
        $category_choices[$cat->term_id] = $cat->name;
    }

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_category_1]', [
        'type' => 'option',
        'default' => $defaults['home_category_1'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_home_category_1', [
        'label' => __('دسته‌بندی اول صفحه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_home_categories',
        'type' => 'select',
        'choices' => $category_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_category_1]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_category_2]', [
        'type' => 'option',
        'default' => $defaults['home_category_2'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_home_category_2', [
        'label' => __('دسته‌بندی دوم (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_home_categories',
        'type' => 'select',
        'choices' => $category_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_category_2]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_category_3]', [
        'type' => 'option',
        'default' => $defaults['home_category_3'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_home_category_3', [
        'label' => __('دسته‌بندی سوم (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_home_categories',
        'type' => 'select',
        'choices' => $category_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_category_3]',
    ]);
    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[education_enabled]', [
        'type' => 'option',
        'default' => $defaults['education_enabled'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_education_enabled', [
        'label' => __('نمایش بخش تحصیلات', 'arash-theme'),
        'section' => 'arash_theme_section_education',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[education_enabled]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[education_order]', [
        'type' => 'option',
        'default' => $defaults['education_order'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_education_order', [
        'label' => __('ترتیب نمایش تحصیلات', 'arash-theme'),
        'section' => 'arash_theme_section_education',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[education_order]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[work_enabled]', [
        'type' => 'option',
        'default' => $defaults['work_enabled'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_work_enabled', [
        'label' => __('نمایش بخش تجربه کاری', 'arash-theme'),
        'section' => 'arash_theme_section_work',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[work_enabled]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[work_order]', [
        'type' => 'option',
        'default' => $defaults['work_order'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_work_order', [
        'label' => __('ترتیب نمایش تجربه کاری', 'arash-theme'),
        'section' => 'arash_theme_section_work',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[work_order]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[testimonials_enabled]', [
        'type' => 'option',
        'default' => $defaults['testimonials_enabled'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_testimonials_enabled', [
        'label' => __('نمایش بخش نظرات مشتریان', 'arash-theme'),
        'section' => 'arash_theme_section_testimonials',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[testimonials_enabled]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[testimonials_order]', [
        'type' => 'option',
        'default' => $defaults['testimonials_order'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_testimonials_order', [
        'label' => __('ترتیب نمایش نظرات مشتریان', 'arash-theme'),
        'section' => 'arash_theme_section_testimonials',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[testimonials_order]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[testimonials_title]', [
        'type' => 'option',
        'default' => $defaults['testimonials_title'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_testimonials_title', [
        'label' => __('عنوان بخش نظرات مشتریان', 'arash-theme'),
        'section' => 'arash_theme_section_testimonials',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[testimonials_title]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[testimonials_subtitle]', [
        'type' => 'option',
        'default' => $defaults['testimonials_subtitle'],
        'sanitize_callback' => 'arash_sanitize_textarea',
    ]);

    $wp_customize->add_control('arash_theme_options_testimonials_subtitle', [
        'label' => __('توضیح کوتاه بخش نظرات مشتریان', 'arash-theme'),
        'section' => 'arash_theme_section_testimonials',
        'type' => 'textarea',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[testimonials_subtitle]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[testimonials_items]', [
        'type' => 'option',
        'default' => $defaults['testimonials_items'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_testimonials_items', [
        'label' => __('تعداد نظرات در صفحه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_testimonials',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[testimonials_items]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[portfolio_items_per_page]', [
        'type' => 'option',
        'default' => $defaults['portfolio_items_per_page'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_portfolio_items_per_page', [
        'label' => __('تعداد نمونه‌کار در هر صفحه', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[portfolio_items_per_page]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[portfolio_layout]', [
        'type' => 'option',
        'default' => $defaults['portfolio_layout'],
        'sanitize_callback' => 'arash_sanitize_choice',
    ]);

    $wp_customize->add_control('arash_theme_options_portfolio_layout', [
        'label' => __('چیدمان نمونه‌کارها', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => [
            'grid' => __('شبکه‌ای', 'arash-theme'),
            'masonry' => __('ماسونری', 'arash-theme'),
            'list' => __('لیستی', 'arash-theme'),
        ],
        'settings' => ARASH_THEME_OPTIONS_KEY . '[portfolio_layout]',
    ]);

    $portfolio_posts = get_posts([
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    $portfolio_choices = [
        0 => __('— انتخاب نمونه‌کار —', 'arash-theme'),
    ];
    foreach ($portfolio_posts as $portfolio_post) {
        $portfolio_choices[$portfolio_post->ID] = $portfolio_post->post_title;
    }

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_1]', [
        'type' => 'option',
        'default' => $defaults['hero_portfolio_1'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_hero_portfolio_1', [
        'label' => __('نمونه‌کار ۱ اسلایدر هیرو', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => $portfolio_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_1]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_2]', [
        'type' => 'option',
        'default' => $defaults['hero_portfolio_2'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_hero_portfolio_2', [
        'label' => __('نمونه‌کار ۲ اسلایدر هیرو (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => $portfolio_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_2]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_3]', [
        'type' => 'option',
        'default' => $defaults['hero_portfolio_3'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_hero_portfolio_3', [
        'label' => __('نمونه‌کار ۳ اسلایدر هیرو (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => $portfolio_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_3]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_4]', [
        'type' => 'option',
        'default' => $defaults['hero_portfolio_4'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_hero_portfolio_4', [
        'label' => __('نمونه‌کار ۴ اسلایدر هیرو (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => $portfolio_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_4]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_5]', [
        'type' => 'option',
        'default' => $defaults['hero_portfolio_5'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);
    $wp_customize->add_control('arash_theme_options_hero_portfolio_5', [
        'label' => __('نمونه‌کار ۵ اسلایدر هیرو (اختیاری)', 'arash-theme'),
        'section' => 'arash_theme_section_portfolio',
        'type' => 'select',
        'choices' => $portfolio_choices,
        'settings' => ARASH_THEME_OPTIONS_KEY . '[hero_portfolio_5]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_builder_mode]', [
        'type' => 'option',
        'default' => $defaults['home_builder_mode'],
        'sanitize_callback' => 'arash_sanitize_choice',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[home_demo_variant]', [
        'type' => 'option',
        'default' => $defaults['home_demo_variant'],
        'sanitize_callback' => 'arash_sanitize_choice',
    ]);

    $wp_customize->add_control('arash_theme_options_home_demo_variant', [
        'label' => __('دموی صفحه اصلی (حالت قالب)', 'arash-theme'),
        'section' => 'arash_theme_section_home',
        'type' => 'select',
        'choices' => [
            'classic_personal' => __('دمو ۱ - شخصی کلاسیک', 'arash-theme'),
            'agency_nova' => __('دمو ۲ - آژانس نُوا', 'arash-theme'),
        ],
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_demo_variant]',
    ]);

    $wp_customize->add_control('arash_theme_options_home_builder_mode', [
        'label' => __('حالت صفحه اصلی', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'type' => 'select',
        'choices' => [
            'theme' => __('حالت پیش‌فرض قالب', 'arash-theme'),
            'elementor' => __('سازگار با المنتور', 'arash-theme'),
        ],
        'settings' => ARASH_THEME_OPTIONS_KEY . '[home_builder_mode]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[use_agency_styling]', [
        'type' => 'option',
        'default' => $defaults['use_agency_styling'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_use_agency_styling', [
        'label' => __('استفاده از هدر/فوتر اختصاصی آژانس', 'arash-theme'),
        'description' => __('هدر و فوتر تیره‌رنگ آژانس را حتی در حالت المنتور استفاده کن', 'arash-theme'),
        'section' => 'arash_theme_section_general',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[use_agency_styling]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[blog_enabled]', [
        'type' => 'option',
        'default' => $defaults['blog_enabled'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_blog_enabled', [
        'label' => __('نمایش بخش مقالات', 'arash-theme'),
        'section' => 'arash_theme_section_blog',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[blog_enabled]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[blog_items_per_page]', [
        'type' => 'option',
        'default' => $defaults['blog_items_per_page'],
        'sanitize_callback' => 'arash_sanitize_integer',
    ]);

    $wp_customize->add_control('arash_theme_options_blog_items_per_page', [
        'label' => __('تعداد مقاله در هر صفحه', 'arash-theme'),
        'section' => 'arash_theme_section_blog',
        'type' => 'number',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[blog_items_per_page]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[blog_page_title]', [
        'type' => 'option',
        'default' => $defaults['blog_page_title'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_blog_page_title', [
        'label' => __('عنوان صفحه وبلاگ', 'arash-theme'),
        'section' => 'arash_theme_section_blog',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[blog_page_title]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[blog_page_description]', [
        'type' => 'option',
        'default' => $defaults['blog_page_description'],
        'sanitize_callback' => 'arash_sanitize_textarea',
    ]);

    $wp_customize->add_control('arash_theme_options_blog_page_description', [
        'label' => __('توضیح کوتاه صفحه وبلاگ', 'arash-theme'),
        'section' => 'arash_theme_section_blog',
        'type' => 'textarea',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[blog_page_description]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[contact_email]', [
        'type' => 'option',
        'default' => $defaults['contact_email'],
        'sanitize_callback' => 'arash_sanitize_email_field',
    ]);

    $wp_customize->add_control('arash_theme_options_contact_email', [
        'label' => __('ایمیل فرم تماس', 'arash-theme'),
        'section' => 'arash_theme_section_contact',
        'type' => 'email',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[contact_email]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[contact_map_embed]', [
        'type' => 'option',
        'default' => $defaults['contact_map_embed'],
        'sanitize_callback' => 'arash_sanitize_textarea',
    ]);

    $wp_customize->add_control('arash_theme_options_contact_map_embed', [
        'label' => __('کد نقشه گوگل یا نقشه ایرانی', 'arash-theme'),
        'section' => 'arash_theme_section_contact',
        'type' => 'textarea',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[contact_map_embed]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[contact_form_shortcode]', [
        'type' => 'option',
        'default' => $defaults['contact_form_shortcode'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_contact_form_shortcode', [
        'label' => __('شورت‌کد فرم تماس', 'arash-theme'),
        'section' => 'arash_theme_section_contact',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[contact_form_shortcode]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[sticky_contact_phone]', [
        'type' => 'option',
        'default' => '',
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_sticky_contact_phone', [
        'label' => __('شماره تماس دکمه ثابت', 'arash-theme'),
        'section' => 'arash_theme_section_contact',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[sticky_contact_phone]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[sticky_contact_label]', [
        'type' => 'option',
        'default' => 'تماس مستقیم با من',
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_sticky_contact_label', [
        'label' => __('متن دکمه تماس ثابت', 'arash-theme'),
        'section' => 'arash_theme_section_contact',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[sticky_contact_label]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[sticky_contact_color]', [
        'type' => 'option',
        'default' => $defaults['sticky_contact_color'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'arash_theme_options_sticky_contact_color',
        [
            'label' => __('رنگ دکمه تماس ثابت', 'arash-theme'),
            'section' => 'arash_theme_section_contact',
            'settings' => ARASH_THEME_OPTIONS_KEY . '[sticky_contact_color]',
        ]
    ));

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_text]', [
        'type' => 'option',
        'default' => $defaults['footer_text'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_text', [
        'label' => __('متن فوتر', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_text]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_cta_enabled]', [
        'type' => 'option',
        'default' => $defaults['footer_cta_enabled'],
        'sanitize_callback' => 'arash_sanitize_checkbox',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_cta_enabled', [
        'label' => __('نمایش بخش دعوت به اقدام در فوتر', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'checkbox',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_cta_enabled]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_cta_title]', [
        'type' => 'option',
        'default' => $defaults['footer_cta_title'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_cta_title', [
        'label' => __('عنوان بخش دعوت به اقدام', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_cta_title]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_cta_subtitle]', [
        'type' => 'option',
        'default' => $defaults['footer_cta_subtitle'],
        'sanitize_callback' => 'arash_sanitize_textarea',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_cta_subtitle', [
        'label' => __('توضیح کوتاه بخش دعوت به اقدام', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'textarea',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_cta_subtitle]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_cta_button_label]', [
        'type' => 'option',
        'default' => $defaults['footer_cta_button_label'],
        'sanitize_callback' => 'arash_sanitize_text',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_cta_button_label', [
        'label' => __('متن دکمه دعوت به اقدام', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'text',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_cta_button_label]',
    ]);

    $wp_customize->add_setting(ARASH_THEME_OPTIONS_KEY . '[footer_cta_button_url]', [
        'type' => 'option',
        'default' => $defaults['footer_cta_button_url'],
        'sanitize_callback' => 'arash_sanitize_url',
    ]);

    $wp_customize->add_control('arash_theme_options_footer_cta_button_url', [
        'label' => __('لینک دکمه دعوت به اقدام', 'arash-theme'),
        'section' => 'arash_theme_section_footer',
        'type' => 'url',
        'settings' => ARASH_THEME_OPTIONS_KEY . '[footer_cta_button_url]',
    ]);
}
add_action('customize_register', 'arash_customize_register');

// AJAX Load More
add_action('wp_ajax_fadaee_load_more', 'fadaee_load_more');
add_action('wp_ajax_nopriv_fadaee_load_more', 'fadaee_load_more');

function fadaee_load_more() {

    check_ajax_referer('fadaee_nonce', 'nonce');

    $paged = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
    $category = isset($_POST['category']) ? intval($_POST['category']) : 0;
    $search   = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'paged'          => $paged,
        's'              => $search,
        'post_status'    => 'publish',
    ];

    if ($category) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [$category],
            ],
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        while ($query->have_posts()):
            $query->the_post();
            get_template_part('template/post-card','post-card');
        endwhile;

    endif;

    wp_reset_postdata();
    wp_die();
}


/**
 * Custom Post Types
 */
function arash_register_post_types() {
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('نمونه‌کارها', 'arash-theme'),
            'singular_name' => __('نمونه‌کار', 'arash-theme'),
            'add_new' => __('افزودن نمونه‌کار', 'arash-theme'),
            'add_new_item' => __('افزودن نمونه‌کار جدید', 'arash-theme'),
            'edit_item' => __('ویرایش نمونه‌کار', 'arash-theme'),
            'new_item' => __('نمونه‌کار جدید', 'arash-theme'),
            'view_item' => __('مشاهده نمونه‌کار', 'arash-theme'),
            'search_items' => __('جستجوی نمونه‌کارها', 'arash-theme'),
            'not_found' => __('نمونه‌کاری یافت نشد', 'arash-theme'),
            'not_found_in_trash' => __('نمونه‌کاری در زباله‌دان یافت نشد', 'arash-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rest_base' => 'portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'menu_icon' => 'dashicons-portfolio',
        'rewrite' => array('slug' => 'portfolio'),
    ));

    register_post_type('education', array(
        'labels' => array(
            'name' => __('تحصیلات', 'arash-theme'),
            'singular_name' => __('تحصیل', 'arash-theme'),
            'add_new' => __('افزودن تحصیل', 'arash-theme'),
            'add_new_item' => __('افزودن تحصیل جدید', 'arash-theme'),
            'edit_item' => __('ویرایش تحصیل', 'arash-theme'),
            'new_item' => __('تحصیل جدید', 'arash-theme'),
            'view_item' => __('مشاهده تحصیل', 'arash-theme'),
            'search_items' => __('جستجوی تحصیلات', 'arash-theme'),
            'not_found' => __('موردی یافت نشد', 'arash-theme'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'menu_icon' => 'dashicons-welcome-learn-more',
        'rewrite' => array('slug' => 'education'),
    ));

    register_post_type('work_experience', array(
        'labels' => array(
            'name' => __('تجربه‌های کاری', 'arash-theme'),
            'singular_name' => __('تجربه کاری', 'arash-theme'),
            'add_new' => __('افزودن تجربه کاری', 'arash-theme'),
            'add_new_item' => __('افزودن تجربه کاری جدید', 'arash-theme'),
            'edit_item' => __('ویرایش تجربه کاری', 'arash-theme'),
            'new_item' => __('تجربه کاری جدید', 'arash-theme'),
            'view_item' => __('مشاهده تجربه کاری', 'arash-theme'),
            'search_items' => __('جستجوی تجربه‌های کاری', 'arash-theme'),
            'not_found' => __('موردی یافت نشد', 'arash-theme'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'comments'),
        'menu_icon' => 'dashicons-briefcase',
        'rewrite' => array('slug' => 'work-experience'),
    ));
    // Testimonials Post Type
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('نظرات مشتریان', 'arash-theme'),
            'singular_name' => __('نظر مشتری', 'arash-theme'),
            'add_new' => __('افزودن نظر', 'arash-theme'),
            'add_new_item' => __('افزودن نظر جدید', 'arash-theme'),
            'edit_item' => __('ویرایش نظر', 'arash-theme'),
            'new_item' => __('نظر جدید', 'arash-theme'),
            'view_item' => __('مشاهده نظر', 'arash-theme'),
            'search_items' => __('جستجوی نظرات', 'arash-theme'),
            'not_found' => __('نظری یافت نشد', 'arash-theme'),
            'not_found_in_trash' => __('نظری در زباله‌دان یافت نشد', 'arash-theme'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-testimonial',
        'menu_position' => 25,
    ));
}
add_action('init', 'arash_register_post_types');

/**
 * Custom Taxonomies
 */
function arash_register_taxonomies() {
    // Portfolio Categories
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => __('دسته‌بندی نمونه‌کارها', 'arash-theme'),
            'singular_name' => __('دسته‌بندی', 'arash-theme'),
            'search_items' => __('جستجوی دسته‌بندی‌ها', 'arash-theme'),
            'all_items' => __('همه دسته‌بندی‌ها', 'arash-theme'),
            'edit_item' => __('ویرایش دسته‌بندی', 'arash-theme'),
            'update_item' => __('به‌روزرسانی دسته‌بندی', 'arash-theme'),
            'add_new_item' => __('افزودن دسته‌بندی جدید', 'arash-theme'),
            'new_item_name' => __('نام دسته‌بندی جدید', 'arash-theme'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'portfolio-category',
            'with_front' => false,
            'hierarchical' => true,
        ),
    ));
}
add_action('init', 'arash_register_taxonomies');

/**
 * Flush rewrite rules on theme activation
 * This ensures taxonomy URLs work correctly
 */
function arash_flush_rewrites() {
    arash_register_post_types();
    arash_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'arash_flush_rewrites');

function arash_output_hero_custom_styles() {
    $options = arash_get_theme_options();
    $light = !empty($options['hero_background_color_light']) ? $options['hero_background_color_light'] : 'transparent';
    $dark = !empty($options['hero_background_color_dark']) ? $options['hero_background_color_dark'] : '#020617';
    $primary = !empty($options['primary_color']) ? $options['primary_color'] : '#f97316';
    $font_option = !empty($options['font_family']) ? $options['font_family'] : 'IRANYekan';
    if ($font_option === 'PeydaWebVF') {
        $font_stack = "'PeydaWebVF', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    } else {
        $font_stack = "'IRANYekan', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    }
    ?>
    <style id="arash-hero-custom-styles">
        .hero-section-custom {
            background-color: <?php echo esc_html($light); ?>;
        }
        .dark .hero-section-custom {
            background-color: <?php echo esc_html($dark); ?>;
        }
        :root {
            --arash-primary: <?php echo esc_html($primary); ?>;
            --arash-font-family: <?php echo $font_stack; ?>;
        }
        body {
            font-family: var(--arash-font-family) !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'arash_output_hero_custom_styles', 99);

function arash_is_elementor_built($post_id = null) {
    if (!$post_id) {
        $post_id = get_queried_object_id();
    }

    $post_id = absint($post_id);
    if ($post_id <= 0) {
        return false;
    }

    if (!class_exists('Elementor\\Plugin')) {
        return false;
    }

    $edit_mode = get_post_meta($post_id, '_elementor_edit_mode', true);
    if (!empty($edit_mode)) {
        return true;
    }

    $plugin = Elementor\Plugin::instance();
    if (isset($plugin->db) && method_exists($plugin->db, 'is_built_with_elementor')) {
        return (bool) $plugin->db->is_built_with_elementor($post_id);
    }

    return false;
}

function arash_output_elementor_compat_styles() {
    if (!class_exists('Elementor\\Plugin')) {
        return;
    }
    ?>
    <style id="arash-elementor-compat-styles">
        body.elementor-page .elementor {
            color: #18181b;
        }

        body.dark.elementor-page .elementor {
            color: #e4e4e7;
        }

        body.elementor-page .elementor-widget-text-editor,
        body.elementor-page .elementor-widget-text-editor p,
        body.elementor-page .elementor-widget-heading .elementor-heading-title {
            color: inherit;
        }

        body.elementor-page .elementor-widget-container,
        body.elementor-page .elementor-column,
        body.elementor-page .elementor-section {
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
        }

        body.dark.elementor-page .elementor-widget-divider .elementor-divider-separator {
            border-color: rgba(161, 161, 170, 0.35);
        }

        body.dark.elementor-page .elementor-widget-icon-list .elementor-icon-list-text,
        body.dark.elementor-page .elementor-widget-button .elementor-button-text,
        body.dark.elementor-page .elementor-widget-text-editor,
        body.dark.elementor-page .elementor-widget-text-editor p {
            color: inherit;
        }
    </style>
    <?php
}
add_action('wp_head', 'arash_output_elementor_compat_styles', 100);

function arash_add_education_meta_box() {
    add_meta_box('education_meta_box', 'فیلدهای تحصیلات', 'arash_education_meta_box_callback', 'education', 'normal', 'high');
}
add_action('add_meta_boxes', 'arash_add_education_meta_box');

function arash_education_meta_box_callback($post) {
    wp_nonce_field('arash_education_meta_box_nonce', 'arash_education_nonce');
    $degree = get_post_meta($post->ID, '_degree', true);
    $institution = get_post_meta($post->ID, '_institution', true);
    $institution_logo = get_post_meta($post->ID, '_institution_logo', true);
    $field = get_post_meta($post->ID, '_field', true);
    $start_date = get_post_meta($post->ID, '_start_date', true);
    $end_date = get_post_meta($post->ID, '_end_date', true);
    $gpa = get_post_meta($post->ID, '_gpa', true);
    ?>
    <p>
        <label>عنوان مدرک/گواهی</label><br>
        <input type="text" name="degree" value="<?php echo esc_attr($degree); ?>" style="width:100%;">
    </p>
    <p>
        <label>نام موسسه</label><br>
        <input type="text" name="institution" value="<?php echo esc_attr($institution); ?>" style="width:100%;">
    </p>
    <p>
        <label>لوگوی موسسه</label><br>
        <input type="text" id="institution_logo" name="institution_logo" value="<?php echo esc_attr($institution_logo); ?>" style="width:70%;">
        <input type="button" id="institution_logo_button" class="button" value="آپلود تصویر" />
    </p>
    <script>
    jQuery(function($){
        let uploader;
        $('#institution_logo_button').on('click', function(e){
            e.preventDefault();
            uploader = wp.media.frames.file_frame = wp.media({
                title: 'انتخاب لوگو',
                button: { text: 'انتخاب' },
                multiple: false
            });
            uploader.on('select', function(){
                const attachment = uploader.state().get('selection').first().toJSON();
                $('#institution_logo').val(attachment.url);
            });
            uploader.open();
        });
    });
    </script>
    <p>
        <label>رشته/حوزه</label><br>
        <input type="text" name="field" value="<?php echo esc_attr($field); ?>" style="width:100%;">
    </p>
    <div style="display:flex;gap:12px;">
        <p style="flex:1;">
            <label>تاریخ شروع</label><br>
            <input type="text" name="start_date" value="<?php echo esc_attr($start_date); ?>" placeholder="مثلاً ۱۳۹۸" style="width:100%;">
        </p>
        <p style="flex:1;">
            <label>تاریخ پایان یا «در حال حاضر»</label><br>
            <input type="text" name="end_date" value="<?php echo esc_attr($end_date); ?>" placeholder="مثلاً ۱۴۰۲ یا حاضر" style="width:100%;">
        </p>
    </div>
    <p>
        <label>معدل/GPA (اختیاری)</label><br>
        <input type="text" name="gpa" value="<?php echo esc_attr($gpa); ?>" style="width:100%;">
    </p>
    <?php
}

function arash_save_education_meta_box($post_id) {
    if (!isset($_POST['arash_education_nonce']) || !wp_verify_nonce($_POST['arash_education_nonce'], 'arash_education_meta_box_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    $fields = ['degree','institution','institution_logo','field','start_date','end_date','gpa'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_education', 'arash_save_education_meta_box');

function arash_add_work_meta_box() {
    add_meta_box('work_meta_box', 'فیلدهای تجربه کاری', 'arash_work_meta_box_callback', 'work_experience', 'normal', 'high');
}
add_action('add_meta_boxes', 'arash_add_work_meta_box');

function arash_work_meta_box_callback($post) {
    wp_nonce_field('arash_work_meta_box_nonce', 'arash_work_nonce');
    $company = get_post_meta($post->ID, '_company', true);
    $company_logo = get_post_meta($post->ID, '_company_logo', true);
    $employment_type = get_post_meta($post->ID, '_employment_type', true);
    $location = get_post_meta($post->ID, '_location', true);
    $start_date = get_post_meta($post->ID, '_work_start_date', true);
    $end_date = get_post_meta($post->ID, '_work_end_date', true);
    $technologies_raw = get_post_meta($post->ID, '_work_technologies', true);
    if (is_array($technologies_raw)) {
        $technologies = $technologies_raw;
    } elseif (!empty($technologies_raw) && is_string($technologies_raw)) {
        $technologies = array_map('trim', explode(',', $technologies_raw));
    } else {
        $technologies = [];
    }
    ?>
    <p>
        <label>نام شرکت</label><br>
        <input type="text" name="company" value="<?php echo esc_attr($company); ?>" style="width:100%;">
    </p>
    <p>
        <label>لوگوی شرکت</label><br>
        <input type="text" id="company_logo" name="company_logo" value="<?php echo esc_attr($company_logo); ?>" style="width:70%;">
        <input type="button" id="company_logo_button" class="button" value="آپلود تصویر" />
    </p>
    <script>
    jQuery(function($){
        let uploader;
        $('#company_logo_button').on('click', function(e){
            e.preventDefault();
            uploader = wp.media.frames.file_frame = wp.media({
                title: 'انتخاب لوگو شرکت',
                button: { text: 'انتخاب' },
                multiple: false
            });
            uploader.on('select', function(){
                const attachment = uploader.state().get('selection').first().toJSON();
                $('#company_logo').val(attachment.url);
            });
            uploader.open();
        });
    });
    </script>
    <div style="display:flex;gap:12px;">
        <p style="flex:1;">
            <label>نوع همکاری</label><br>
            <select name="employment_type" style="width:100%;">
                <?php
                $types = ['full-time'=>'تمام‌وقت','part-time'=>'پاره‌وقت','freelance'=>'فریلنس','contract'=>'قراردادی'];
                $current = $employment_type ?: 'full-time';
                foreach ($types as $key=>$label) {
                    echo '<option value="'.esc_attr($key).'" '.selected($current,$key,false).'>'.esc_html($label).'</option>';
                }
                ?>
            </select>
        </p>
        <p style="flex:1;">
            <label>مکان</label><br>
            <input type="text" name="location" value="<?php echo esc_attr($location); ?>" placeholder="Remote / On-site / City" style="width:100%;">
        </p>
    </div>
    <div style="display:flex;gap:12px;">
        <p style="flex:1;">
            <label>تاریخ شروع</label><br>
            <input type="text" name="work_start_date" value="<?php echo esc_attr($start_date); ?>" style="width:100%;">
        </p>
        <p style="flex:1;">
            <label>تاریخ پایان یا «حاضر»</label><br>
            <input type="text" name="work_end_date" value="<?php echo esc_attr($end_date); ?>" style="width:100%;">
        </p>
    </div>
    <p>
        <label>تکنولوژی‌های استفاده شده</label><br>
        <div id="work_technologies_wrapper">
            <?php if (!empty($technologies)): ?>
                <?php foreach ($technologies as $tech_item): ?>
                    <?php if (trim($tech_item) === '') continue; ?>
                    <div class="work-tech-row" style="margin-bottom:6px; display:flex; gap:6px; align-items:center;">
                        <input type="text" name="work_technologies[]" value="<?php echo esc_attr($tech_item); ?>" style="width:100%;">
                        <button type="button" class="button remove-work-tech">حذف</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="work-tech-row" style="margin-bottom:6px; display:flex; gap:6px; align-items:center;">
                    <input type="text" name="work_technologies[]" value="" style="width:100%;" placeholder="مثلاً: PHP">
                    <button type="button" class="button remove-work-tech">حذف</button>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" class="button" id="add_work_technology">افزودن تکنولوژی</button>
    </p>
    <script>
    jQuery(function($){
        $('#add_work_technology').on('click', function(e){
            e.preventDefault();
            var $wrapper = $('#work_technologies_wrapper');
            var $row = $('<div class="work-tech-row" style="margin-bottom:6px; display:flex; gap:6px; align-items:center;">' +
                '<input type="text" name="work_technologies[]" value="" style="width:100%;">' +
                '<button type="button" class="button remove-work-tech">حذف</button>' +
            '</div>');
            $wrapper.append($row);
        });
        $(document).on('click', '.remove-work-tech', function(e){
            e.preventDefault();
            var $row = $(this).closest('.work-tech-row');
            var $wrapper = $('#work_technologies_wrapper');
            if ($wrapper.find('.work-tech-row').length > 1) {
                $row.remove();
            } else {
                $row.find('input[type="text"]').val('');
            }
        });
    });
    </script>
    <?php
}

function arash_save_work_meta_box($post_id) {
    if (!isset($_POST['arash_work_nonce']) || !wp_verify_nonce($_POST['arash_work_nonce'], 'arash_work_meta_box_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    $map = [
        'company' => '_company',
        'company_logo' => '_company_logo',
        'employment_type' => '_employment_type',
        'location' => '_location',
        'work_start_date' => '_work_start_date',
        'work_end_date' => '_work_end_date',
        'work_technologies' => '_work_technologies',
    ];
    foreach ($map as $post_key=>$meta_key) {
        if (isset($_POST[$post_key])) {
            if ($post_key === 'work_technologies' && is_array($_POST[$post_key])) {
                $techs = array_map('sanitize_text_field', $_POST[$post_key]);
                $techs = array_filter($techs, function($v){ return trim($v) !== ''; });
                update_post_meta($post_id, $meta_key, array_values($techs));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
            }
        }
    }
}
add_action('save_post_work_experience', 'arash_save_work_meta_box');

function arash_enqueue_comment_reply() {
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'arash_enqueue_comment_reply');

function arash_comment_form_fields($fields) {
    $fields['hp_field'] = '<p class="comment-form-url" style="display:none;"><label>تست</label><input type="text" name="hp_field" value=""></p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'arash_comment_form_fields');

function arash_preprocess_comment($commentdata) {
    if (!empty($_POST['hp_field'])) {
        wp_die(__('ارسال شما به‌عنوان اسپم شناسایی شد.', 'arash-theme'));
    }
    return $commentdata;
}
add_filter('preprocess_comment', 'arash_preprocess_comment');

function arash_save_comment_rating($comment_id, $approved, $commentdata) {
    $opts = arash_get_theme_options();
    $enabled = !empty($opts['blog_comment_rating_enabled']);
    if ($enabled && isset($_POST['rating']) && get_post_type($commentdata['comment_post_ID']) === 'post') {
        $rating = max(1, min(5, intval($_POST['rating'])));
        add_comment_meta($comment_id, 'rating', $rating, true);
    }
}
add_action('comment_post', 'arash_save_comment_rating', 10, 3);

function arash_filter_comments_per_page($value) {
    $opts = arash_get_theme_options();
    if (!empty($opts['comments_per_page'])) {
        return (int) $opts['comments_per_page'];
    }
    return $value;
}
add_filter('option_comments_per_page', 'arash_filter_comments_per_page');

function arash_comment_callback($comment, $args, $depth) {
    $rating = get_comment_meta($comment->comment_ID, 'rating', true);
    ?>
    <div id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item rounded-xl border border-zinc-100 dark:border-zinc-800 bg-white/60 dark:bg-zinc-900/60 p-4 sm:p-5'); ?>>
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <?php echo get_avatar($comment, 40, '', '', ['class' => 'h-10 w-10 rounded-full']); ?>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <div>
                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            <?php echo get_comment_author(); ?>
                        </div>
                        <time datetime="<?php comment_time('c'); ?>" class="text-xs text-zinc-500 dark:text-zinc-400">
                            <?php comment_date(); ?>
                        </time>
                    </div>
                    <?php if ($rating): ?>
                        <div class="flex items-center gap-1 text-amber-400 text-xs">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="<?php echo $i <= (int) $rating ? 'currentColor' : 'none'; ?>" class="h-4 w-4 stroke-amber-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-sm leading-relaxed text-zinc-700 dark:text-zinc-200">
                    <?php comment_text(); ?>
                </div>

                <?php if ($comment->comment_approved == '0'): ?>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-2">
                        نظر شما پس از تایید نمایش داده خواهد شد.
                    </p>
                <?php endif; ?>

                <div class="mt-3 flex items-center gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                    <?php
                    comment_reply_link(array_merge($args, [
                        'reply_text' => 'پاسخ',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'class' => 'cursor-pointer text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300',
                    ]));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
/**
 * اضافه کردن تصویر شاخص کامل (url + alt + width + height + sizes) به همه پست‌ها و CPTها
 */
add_action('rest_api_init', function () {
    register_rest_field(
        ['post', 'portfolio', 'testimonial', 'page'],
        'featured_image',
        [
            'get_callback' => function ($object) {
                $post_id = $object['id'];
                
                // اگر تصویر شاخص نداشت
                if (!has_post_thumbnail($post_id)) {
                    return null;
                }
                
                $thumb_id = get_post_thumbnail_id($post_id);
                
                // تمام سایزهای تصویر
                $sizes = wp_get_attachment_image_src($thumb_id, 'full');
                $large = wp_get_attachment_image_src($thumb_id, 'large');
                $medium = wp_get_attachment_image_src($thumb_id, 'medium');
                $thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail');
                
                return [
                    'id' => $thumb_id,
                    'alt' => get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title($post_id),
                    'title' => get_the_title($thumb_id),
                    'caption' => wp_get_attachment_caption($thumb_id),
                    'full' => $sizes[0] ?? null,
                    'large' => $large[0] ?? null,
                    'medium' => $medium[0] ?? null,
                    'thumbnail' => $thumbnail[0] ?? null,
                    'width' => $sizes[1] ?? null,
                    'height' => $sizes[2] ?? null,
                ];
            },
            'schema' => [
                'description' => 'تصویر شاخص کامل با تمام سایزها و alt',
                'type' => 'object'
            ]
        ]
    );
});

/**
 * Portfolio Meta Box
 */
function arash_add_portfolio_meta_box() {
    add_meta_box(
        'portfolio_meta_box',
        'فیلدهای نمونه‌کار',
        'arash_portfolio_meta_box_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'arash_add_portfolio_meta_box');

function arash_portfolio_meta_box_callback($post) {
    wp_nonce_field('arash_portfolio_meta_box_nonce', 'arash_portfolio_nonce');
    
    $project_image = get_post_meta($post->ID, '_project_image', true);
    $project_url = get_post_meta($post->ID, '_project_url', true);
    $project_technologies = get_post_meta($post->ID, '_project_technologies', true);
    
    if (!is_array($project_technologies)) {
        $project_technologies = array();
    }
    ?>
    <p>
        <label for="project_image">تصویر پروژه</label><br>
        <input type="text" id="project_image" name="project_image" value="<?php echo esc_attr($project_image); ?>" size="50" />
        <input type="button" id="project_image_button" class="button" value="آپلود تصویر" />
        <?php if ($project_image): ?>
            <br><img src="<?php echo esc_url($project_image); ?>" style="max-width: 300px; height: auto;" />
        <?php endif; ?>
    </p>
    
    <script>
    jQuery(document).ready(function($) {
        var project_image_uploader;
        $('#project_image_button').click(function(e) {
            e.preventDefault();
            if (project_image_uploader) {
                project_image_uploader.open();
                return;
            }
            project_image_uploader = wp.media.frames.file_frame = wp.media({
                title: 'انتخاب تصویر پروژه',
                button: { text: 'انتخاب تصویر' },
                multiple: false
            });
            project_image_uploader.on('select', function() {
                var attachment = project_image_uploader.state().get('selection').first().toJSON();
                $('#project_image').val(attachment.url);
                $('#project_image').next('img').remove();
                $('#project_image').after('<br><img src="' + attachment.url + '" style="max-width: 300px; height: auto;" />');
            });
            project_image_uploader.open();
        });
    });
    </script>
    
    <p>
        <label for="project_url">لینک پروژه</label><br>
        <input type="url" id="project_url" name="project_url" value="<?php echo esc_attr($project_url); ?>" size="50" />
    </p>
    
    <p>
        <label>تکنولوژی‌های استفاده شده</label><br>
        <div class="technologies-checkboxes">
            <?php
            $technologies = array(
                'figma' => 'Figma',
                'wordpress' => 'WordPress',
                'github' => 'GitHub',
                'woocommerce' => 'WooCommerce',
                'jetengine' => 'Jet Engine',
                'react' => 'React',
                'vue' => 'Vue.js',
                'angular' => 'Angular',
                'javascript' => 'JavaScript',
                'php' => 'PHP',
                'mysql' => 'MySQL',
                'html' => 'HTML',
                'css' => 'CSS',
                'sass' => 'Sass',
                'bootstrap' => 'Bootstrap',
                'tailwind' => 'Tailwind CSS',
                'laravel' => 'Laravel',
                'nodejs' => 'Node.js',
                'python' => 'Python',
                'photoshop' => 'Photoshop',
                'illustrator' => 'Illustrator',
                'xd' => 'Adobe XD',
            );
            
            foreach ($technologies as $key => $label) {
                $checked = in_array($key, $project_technologies) ? 'checked' : '';
                echo '<label style="display: inline-block; margin-left: 15px;"><input type="checkbox" name="project_technologies[]" value="' . esc_attr($key) . '" ' . $checked . '> ' . esc_html($label) . '</label>';
            }
            ?>
        </div>
    </p>
    <?php
}

/**
 * Save Portfolio Meta Box Data
 */
function arash_save_portfolio_meta_box($post_id) {
    if (!isset($_POST['arash_portfolio_nonce']) || !wp_verify_nonce($_POST['arash_portfolio_nonce'], 'arash_portfolio_meta_box_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['project_image'])) {
        update_post_meta($post_id, '_project_image', sanitize_text_field($_POST['project_image']));
    }
    
    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }
    
    if (isset($_POST['project_technologies'])) {
        $technologies = array_map('sanitize_text_field', $_POST['project_technologies']);
        update_post_meta($post_id, '_project_technologies', $technologies);
    } else {
        delete_post_meta($post_id, '_project_technologies');
    }
}
add_action('save_post_portfolio', 'arash_save_portfolio_meta_box');

/**
 * Testimonial Meta Box
 */
function arash_add_testimonial_meta_box() {
    add_meta_box(
        'testimonial_meta_box',
        'فیلدهای نظر مشتری',
        'arash_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'arash_add_testimonial_meta_box');

function arash_testimonial_meta_box_callback($post) {
    wp_nonce_field('arash_testimonial_meta_box_nonce', 'arash_testimonial_nonce');
    
    $client_name = get_post_meta($post->ID, '_client_name', true);
    $client_position = get_post_meta($post->ID, '_client_position', true);
    $client_company = get_post_meta($post->ID, '_client_company', true);
    $client_avatar = get_post_meta($post->ID, '_client_avatar', true);
    $testimonial_rating = get_post_meta($post->ID, '_testimonial_rating', true);
    $project_name = get_post_meta($post->ID, '_project_name', true);
    $testimonial_featured = get_post_meta($post->ID, '_testimonial_featured', true);
    ?>
    <div class="testimonial-fields">
        <p>
            <label for="client_name">نام مشتری</label><br>
            <input type="text" id="client_name" name="client_name" value="<?php echo esc_attr($client_name); ?>" style="width: 100%;" required />
        </p>
        
        <p>
            <label for="client_position">سمت/شغل مشتری</label><br>
            <input type="text" id="client_position" name="client_position" value="<?php echo esc_attr($client_position); ?>" style="width: 100%;" />
        </p>
        
        <p>
            <label for="client_company">شرکت/سازمان</label><br>
            <input type="text" id="client_company" name="client_company" value="<?php echo esc_attr($client_company); ?>" style="width: 100%;" />
        </p>
        
        <p>
            <label for="client_avatar">تصویر مشتری</label><br>
            <input type="text" id="client_avatar" name="client_avatar" value="<?php echo esc_attr($client_avatar); ?>" style="width: 70%;" />
            <input type="button" id="client_avatar_button" class="button" value="آپلود تصویر" />
            <?php if ($client_avatar): ?>
                <br><img src="<?php echo esc_url($client_avatar); ?>" style="max-width: 150px; height: auto; margin-top: 10px;" />
            <?php endif; ?>
        </p>
        
        <p>
            <label for="testimonial_rating">امتیاز (از ۵)</label><br>
            <input type="number" id="testimonial_rating" name="testimonial_rating" value="<?php echo esc_attr($testimonial_rating ? $testimonial_rating : 5); ?>" min="1" max="5" />
        </p>
        
        <p>
            <label for="project_name">نام پروژه</label><br>
            <input type="text" id="project_name" name="project_name" value="<?php echo esc_attr($project_name); ?>" style="width: 100%;" />
        </p>
        
        <p>
            <input type="checkbox" id="testimonial_featured" name="testimonial_featured" value="1" <?php checked(1, $testimonial_featured); ?> />
            <label for="testimonial_featured">نظر ویژه (این نظر در صفحه اصلی نمایش داده شود؟)</label>
        </p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var client_avatar_uploader;
        $('#client_avatar_button').click(function(e) {
            e.preventDefault();
            if (client_avatar_uploader) {
                client_avatar_uploader.open();
                return;
            }
            client_avatar_uploader = wp.media.frames.file_frame = wp.media({
                title: 'انتخاب تصویر مشتری',
                button: { text: 'انتخاب تصویر' },
                multiple: false
            });
            client_avatar_uploader.on('select', function() {
                var attachment = client_avatar_uploader.state().get('selection').first().toJSON();
                $('#client_avatar').val(attachment.url);
                $('#client_avatar').next('img').remove();
                $('#client_avatar').parent().append('<br><img src="' + attachment.url + '" style="max-width: 150px; height: auto; margin-top: 10px;" />');
            });
            client_avatar_uploader.open();
        });
    });
    </script>
    <?php
}

/**
 * Save Testimonial Meta Box Data
 */
function arash_save_testimonial_meta_box($post_id) {
    if (!isset($_POST['arash_testimonial_nonce']) || !wp_verify_nonce($_POST['arash_testimonial_nonce'], 'arash_testimonial_meta_box_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = ['client_name', 'client_position', 'client_company', 'client_avatar', 'testimonial_rating', 'project_name'];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    if (isset($_POST['testimonial_featured'])) {
        update_post_meta($post_id, '_testimonial_featured', 1);
    } else {
        delete_post_meta($post_id, '_testimonial_featured');
    }
}
add_action('save_post_testimonial', 'arash_save_testimonial_meta_box');
