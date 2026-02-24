<?php
$options = arash_get_theme_options();
$sticky_phone = !empty($options['sticky_contact_phone']) ? preg_replace('/\s+/', '', $options['sticky_contact_phone']) : '';
$sticky_label = !empty($options['sticky_contact_label']) ? $options['sticky_contact_label'] : 'تماس مستقیم با من';
$sticky_color = !empty($options['sticky_contact_color']) ? $options['sticky_contact_color'] : '#ef4444';
?>
<?php if (!empty($sticky_phone)): ?>
    <a href="tel:<?php echo esc_attr($sticky_phone); ?>" class="fixed bottom-6 start-6 z-50 flex items-center gap-2 text-white px-5 py-3 rounded-full shadow-lg transition-all duration-300" style="background-color: <?php echo esc_attr($sticky_color); ?>; box-shadow: 0 10px 25px <?php echo esc_attr($sticky_color); ?>33;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-2.772c0-.516-.351-.966-.852-1.091l-4.548-1.137a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.39 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.39-1.21l1.293-.97c.347-.26.49-.704.417-1.173L6.114 3.102A1.125 1.125 0 005.023 2.25H2.25A2.25 2.25 0 000 4.5v2.25z" />
        </svg>
        <span class="text-sm font-medium"><?php echo esc_html($sticky_label); ?></span>
    </a>
<?php endif; ?>

<footer class="mt-24 flex-none">
    <?php wp_footer() ?>

    <div class="px-4 sm:px-8 pb-10">
        <div class="mx-auto w-full max-w-7xl lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900/90 px-6 py-10 sm:px-10 sm:py-12 shadow-2xl">
                <div class="pointer-events-none absolute -top-24 -right-24 h-52 w-52 rounded-full bg-red-500/20 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -left-24 h-52 w-52 rounded-full bg-indigo-500/20 blur-3xl"></div>

                <div class="relative grid gap-8 md:grid-cols-3 md:items-start">
                    <div>
                        <h3 class="text-xl font-bold text-zinc-100">Agency Nova</h3>
                        <p class="mt-3 text-sm leading-7 text-zinc-400">طراحی و توسعه محصولات دیجیتال با تمرکز روی سرعت، تجربه کاربری و رشد پایدار.</p>
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-zinc-200 mb-3">لینک‌های سریع</div>
                        <div class="flex flex-col gap-2 text-sm text-zinc-400">
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
                                        <a class="transition hover:text-red-300" href="<?php echo esc_url($item->url); ?>"><?php echo esc_html($item->title); ?></a>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-zinc-200 mb-3">شروع همکاری</div>
                        <p class="text-sm text-zinc-400 leading-7">برای شروع پروژه جدید، از طریق صفحه تماس با ما در ارتباط باشید.</p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mt-4 inline-flex items-center rounded-xl bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-400">تماس با ما</a>
                    </div>
                </div>

                <div class="relative mt-8 border-t border-zinc-800 pt-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-zinc-500">© <?php echo esc_html(date('Y')); ?> - تمامی حقوق محفوظ است.</p>
                    <p class="text-xs text-zinc-500"><?php echo esc_html(get_bloginfo('name')); ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>

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
