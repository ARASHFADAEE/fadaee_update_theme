<?php



define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());


//support theme

function support_theme_arash()
{

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'menus' );



}

add_action( 'after_setup_theme', 'support_theme_arash' );




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




function fadaee_like_post_handler() {

    check_ajax_referer('fadaee_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    if (!$post_id) {
        wp_send_json_error(['message' => 'Invalid Post ID']);
    }

    $ip = $_SERVER['REMOTE_ADDR'];
    $liked_ips = get_post_meta($post_id, 'liked_ips', true);

    if (!is_array($liked_ips)) {
        $liked_ips = [];
    }

    // جلوگیری از لایک تکراری
    if (in_array($ip, $liked_ips)) {
        wp_send_json_error(['message' => 'شما قبلا این پست را لایک کرده‌اید']);
    }

    // افزایش تعداد لایک
    $likes = (int) get_post_meta($post_id, 'likes_count', true);
    $likes++;

    update_post_meta($post_id, 'likes_count', $likes);

    // ذخیره IP
    $liked_ips[] = $ip;
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

    $post_id = intval($_POST['post_id']);
    $user_ip = $_SERVER['REMOTE_ADDR']; // IP کاربر

    // گرفتن لیست IP هایی که قبلاً دیسلایک کرده‌اند
    $ips = get_post_meta($post_id, 'dislikes_ips', true);

    // اگر لیست خالی بود => آرایه بساز
    if (!is_array($ips)) {
        $ips = [];
    }

    // اگر این IP قبلاً رای داده، اجازه ثبت دوباره نده
    if (in_array($user_ip, $ips)) {
        wp_send_json_error([
            'message' => 'شما قبلاً دیسلایک کرده‌اید.'
        ]);
    }

    // ثبت دیسلایک
    $count = intval(get_post_meta($post_id, 'dislikes_count', true));
    $count++;

    update_post_meta($post_id, 'dislikes_count', $count);

    // اضافه کردن IP جدید به لیست
    $ips[] = $user_ip;
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
    if (is_single()) {
        global $post;
        fadaee_set_post_views($post->ID);
    }
}
add_action('wp_head', 'fadaee_track_post_views');






function fadaee_get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        return 0;
    }

    return $count;
}