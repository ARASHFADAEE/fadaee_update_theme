<?php
$options = arash_get_theme_options();
$sticky_phone = !empty($options['sticky_contact_phone']) ? preg_replace('/\s+/', '', $options['sticky_contact_phone']) : '';
$sticky_label = !empty($options['sticky_contact_label']) ? $options['sticky_contact_label'] : 'تماس مستقیم با من';
?>
<?php if (!empty($sticky_phone)): ?>
    <a href="tel:<?php echo esc_attr($sticky_phone); ?>" class="fixed bottom-6 left-6 z-50 flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-full shadow-lg shadow-emerald-600/20 transition-all duration-300">
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
            <div class="border-t border-zinc-100 pt-8 pb-14 dark:border-zinc-700/40">
                <div class="relative">
                    <div class="mx-auto max-w-2xl lg:max-w-5xl">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

                            <div class="w-full md:w-auto">
                                <div class="flex flex-wrap justify-center md:justify-start gap-x-4 gap-y-2 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    <?php
                                    $menus = get_nav_menu_locations();
                                    $menu_id = $menus['main_menu'];
                                    $get_items = wp_get_nav_menu_items($menu_id);

                                    foreach ($get_items as $item):
                                        if ($item->menu_item_parent != 0) continue;
                                    ?>
                                        <a class="transition hover:text-red-500 dark:hover:text-red-400 px-2"
                                           href="<?= esc_url($item->url) ?>">
                                            <?= esc_html($item->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <p class="text-center md:text-left text-xs sm:text-sm text-zinc-400 dark:text-zinc-500 leading-relaxed">
                                <?php
                                $footer_text = arash_get_theme_option('footer_text');
                                $footer_fallback = 'استفاده از تمامی مطالب با ذکر منبع بلامانع است.';
                                echo esc_html($footer_text ? $footer_text : $footer_fallback);
                                ?>
                            </p>

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
