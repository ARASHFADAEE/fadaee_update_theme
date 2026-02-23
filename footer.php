<?php
$options = arash_get_theme_options();
$sticky_phone = !empty($options['sticky_contact_phone']) ? preg_replace('/\s+/', '', $options['sticky_contact_phone']) : '';
$sticky_label = !empty($options['sticky_contact_label']) ? $options['sticky_contact_label'] : 'تماس مستقیم با من';
$sticky_color = !empty($options['sticky_contact_color']) ? $options['sticky_contact_color'] : '#059669';
$footer_cta_enabled = !empty($options['footer_cta_enabled']);
$footer_cta_title = !empty($options['footer_cta_title']) ? $options['footer_cta_title'] : '';
$footer_cta_subtitle = !empty($options['footer_cta_subtitle']) ? $options['footer_cta_subtitle'] : '';
$footer_cta_button_label = !empty($options['footer_cta_button_label']) ? $options['footer_cta_button_label'] : '';
$footer_cta_button_url = !empty($options['footer_cta_button_url']) ? $options['footer_cta_button_url'] : '';
?>
<?php if (!empty($sticky_phone)): ?>
    <a href="tel:<?php echo esc_attr($sticky_phone); ?>" class="fixed bottom-6 start-6 z-50 flex items-center gap-2 text-white px-5 py-3 rounded-full shadow-lg transition-all duration-300" style="background-color: <?php echo esc_attr($sticky_color); ?>; box-shadow: 0 10px 25px <?php echo esc_attr($sticky_color); ?>33;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-2.772c0-.516-.351-.966-.852-1.091l-4.548-1.137a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.39 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.39-1.21l1.293-.97c.347-.26.49-.704.417-1.173L6.114 3.102A1.125 1.125 0 005.023 2.25H2.25A2.25 2.25 0 000 4.5v2.25z" />
        </svg>
        <span class="text-sm font-medium"><?php echo esc_html($sticky_label); ?></span>
    </a>
<?php endif; ?>

<footer class="mt-32 flex-none">
    <?php wp_footer() ?>
    <div class="px-4 sm:px-8">
        <div class="mx-auto w-full max-w-7xl lg:px-8">

            <?php if ($footer_cta_enabled && ($footer_cta_title || $footer_cta_subtitle)): ?>
                <div class="relative mb-10 sm:mb-12">
                    <div class="absolute inset-0 bg-gradient-to-l from-red-500/10 via-red-500/5 to-transparent dark:from-red-400/15 dark:via-red-400/10 dark:to-transparent rounded-3xl blur-md -z-10"></div>
                    <div class="relative overflow-hidden rounded-3xl border border-zinc-200/70 bg-white/90 px-6 py-6 sm:px-10 sm:py-8 shadow-sm backdrop-blur dark:border-zinc-700/70 dark:bg-zinc-900/90">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="space-y-2">
                                <?php if ($footer_cta_title): ?>
                                    <h2 class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-zinc-50">
                                        <?php echo esc_html($footer_cta_title); ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if ($footer_cta_subtitle): ?>
                                    <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-300 leading-relaxed">
                                        <?php echo esc_html($footer_cta_subtitle); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($footer_cta_button_label && $footer_cta_button_url): ?>
                                <div class="flex sm:items-center">
                                    <a href="<?php echo esc_url($footer_cta_button_url); ?>"
                                       class="inline-flex items-center justify-center rounded-full bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-600/30 transition hover:bg-red-500 hover:shadow-red-500/40 dark:bg-red-500 dark:hover:bg-red-400">
                                                                               <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 10h10M10 5l5 5-5 5" />
                                        </svg>
                                        <span class="mr-2"><?php echo esc_html($footer_cta_button_label); ?></span>

                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="border-t border-zinc-100 pt-6 pb-10 dark:border-zinc-700/40">
                <div class="relative">
                    <div class="mx-auto max-w-2xl lg:max-w-5xl">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

                            <div class="w-full md:w-auto">
                                <div class="flex flex-wrap justify-center md:justify-start gap-x-4 gap-y-2 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    <?php
                                    $menus = get_nav_menu_locations();
                                    $menu_id = isset($menus['main_menu']) ? $menus['main_menu'] : 0;
                                    if ($menu_id) {
                                        $get_items = wp_get_nav_menu_items($menu_id);
                                        if ($get_items) {
                                            foreach ($get_items as $item) {
                                                if ($item->menu_item_parent != 0) {
                                                    continue;
                                                }
                                                ?>
                                                <a class="transition hover:text-red-500 dark:hover:text-red-400 px-2"
                                                   href="<?php echo esc_url($item->url); ?>">
                                                    <?php echo esc_html($item->title); ?>
                                                </a>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="flex flex-col items-center gap-3 md:items-end">
                                <p class="text-center text-xs sm:text-sm text-zinc-400 dark:text-zinc-500 leading-relaxed md:text-right">
                                    <?php
                                    $footer_text = arash_get_theme_option('footer_text');
                                    $footer_fallback = 'استفاده از تمامی مطالب با ذکر منبع بلامانع است.';
                                    echo esc_html($footer_text ? $footer_text : $footer_fallback);
                                    ?>
                                </p>
                                <p class="text-[11px] sm:text-xs text-zinc-400 dark:text-zinc-600">
                                    <?php echo esc_html('© ' . date('Y')); ?>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>

<!-- Optimized Dark Mode -->
<script>
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme_fadaee');
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
</body>
</html>
