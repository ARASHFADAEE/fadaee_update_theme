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
        'intro_text' => 'سلام! من آرش فدایی هستم، یک توسعه‌دهنده وب با بیش از 10 سال تجربه در طراحی و توسعه وب‌سایت‌ها و اپلیکیشن‌های وب. علاقه‌مند به یادگیری تکنولوژی‌های جدید و به اشتراک‌گذاری دانش.',
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


// AJAX Load More
add_action('wp_ajax_fadaee_load_more', 'fadaee_load_more');
add_action('wp_ajax_nopriv_fadaee_load_more', 'fadaee_load_more');

function fadaee_load_more() {

    $paged = intval($_POST['page']) + 2;

    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $paged
    ]);

    if ($query->have_posts()) :

        while ($query->have_posts()):
            $query->the_post();
            get_template_part('template/post-card','post-card');
        endwhile;

    endif;

    wp_reset_postdata();
    exit;
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
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-portfolio',
        'rewrite' => array('slug' => 'portfolio'),
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
