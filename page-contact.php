<?php
/*
Template Name: صفحه تماس با من
*/

get_header();

$options = arash_get_theme_options();
$contact_email = !empty($options['contact_email']) ? $options['contact_email'] : get_bloginfo('admin_email');
$map_embed = !empty($options['contact_map_embed']) ? $options['contact_map_embed'] : '';
$form_shortcode = !empty($options['contact_form_shortcode']) ? $options['contact_form_shortcode'] : '';

$allowed_map_iframe = [
    'iframe' => [
        'src' => true,
        'width' => true,
        'height' => true,
        'style' => true,
        'allow' => true,
        'allowfullscreen' => true,
        'loading' => true,
        'referrerpolicy' => true,
        'title' => true,
    ],
];

$social_links = [];
if (!empty($options['social_github'])) {
    $social_links[] = ['label' => 'GitHub', 'url' => $options['social_github']];
}
if (!empty($options['social_linkedin'])) {
    $social_links[] = ['label' => 'LinkedIn', 'url' => $options['social_linkedin']];
}
if (!empty($options['social_twitter'])) {
    $social_links[] = ['label' => 'Twitter', 'url' => $options['social_twitter']];
}
if (!empty($options['social_dribbble'])) {
    $social_links[] = ['label' => 'Dribbble', 'url' => $options['social_dribbble']];
}

?>

<main class="flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
    <div class="mx-auto max-w-6xl">
        <div class="grid lg:grid-cols-5 gap-10 lg:gap-12">
            <div class="lg:col-span-2 space-y-6">
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-zinc-900 dark:text-zinc-100">
                    تماس با من
                </h1>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    اگر روی پروژه‌ای کار می‌کنید یا سوالی در مورد همکاری دارید، از طریق فرم روبرو یا راه‌های زیر با من در تماس باشید.
                </p>

                <div class="space-y-4 text-sm sm:text-base">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M1.94 6.94a.75.75 0 011.06 0l.97.97A2.75 2.75 0 016 7h8a2.75 2.75 0 012.03.91l.97-.97a.75.75 0 111.06 1.06l-1.012 1.013A2.75 2.75 0 0117 10.75V13A2.75 2.75 0 0114.25 15.75H5.75A2.75 2.75 0 013 13v-2.25c0-.69-.263-1.353-.73-1.856L1.94 8a.75.75 0 010-1.06z" />
                                <path d="M5.75 4.25A2.75 2.75 0 003 7v.25h14V7a2.75 2.75 0 00-2.75-2.75h-8.5z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">ایمیل</div>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="text-zinc-900 dark:text-zinc-100 hover:text-red-500 dark:hover:text-red-400 transition">
                                <?php echo esc_html($contact_email); ?>
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($social_links)): ?>
                        <div>
                            <div class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400 mb-2">شبکه‌های اجتماعی</div>
                            <div class="flex flex-wrap items-center gap-3">
                                <?php foreach ($social_links as $social): ?>
                                    <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1.5 text-xs sm:text-sm text-zinc-700 dark:text-zinc-200 hover:border-red-400 hover:text-red-500 dark:hover:border-red-400 dark:hover:text-red-300 transition">
                                        <span><?php echo esc_html($social['label']); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($map_embed)): ?>
                    <div class="mt-6 rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
                        <?php echo wp_kses($map_embed, $allowed_map_iframe); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="lg:col-span-3">
                <div class="rounded-2xl bg-white dark:bg-zinc-900 shadow-lg ring-1 ring-zinc-200 dark:ring-zinc-800 p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">
                        فرم تماس
                    </h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
                        فرم زیر را پر کنید تا در کوتاه‌ترین زمان ممکن پاسخگو باشم.
                    </p>

                    <?php if (!empty($form_shortcode)): ?>
                        <div class="prose prose-sm max-w-none dark:prose-invert">
                            <?php echo do_shortcode(sanitize_text_field($form_shortcode)); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            لطفاً ابتدا شورت‌کد فرم تماس را از تنظیمات قالب در بخش «تماس» تنظیم کنید.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
