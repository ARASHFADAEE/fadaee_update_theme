<?php
if (!defined('ABSPATH')) {
    exit;
}

$hero_headline = arash_get_theme_option('hero_headline');
$hero_subheadline = arash_get_theme_option('hero_subheadline');
$hero_primary_button_label = arash_get_theme_option('hero_primary_button_label');
$hero_primary_button_url = arash_get_theme_option('hero_primary_button_url');
$hero_secondary_button_label = arash_get_theme_option('hero_secondary_button_label');
$hero_secondary_button_url = arash_get_theme_option('hero_secondary_button_url');

if (!$hero_headline) {
    $hero_headline = 'طراحی سایت سریع و مقیاس‌پذیر برای کسب‌وکار شما';
}
if (!$hero_subheadline) {
    $hero_subheadline = 'توسعه سیستم‌های تحت وب، وردپرس اختصاصی و SaaS با تمرکز روی سرعت، سئو و تجربه کاربری.';
}
if (!$hero_primary_button_label) {
    $hero_primary_button_label = 'دریافت مشاوره رایگان';
}
if (!$hero_secondary_button_label) {
    $hero_secondary_button_label = 'مشاهده نمونه‌کار';
}

$portfolio_query = new WP_Query([
    'post_type' => 'portfolio',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
]);

$testimonials_query = new WP_Query([
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);

$blog_query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<section class="relative overflow-hidden rounded-3xl border border-zinc-800/60 bg-zinc-950 px-6 py-16 sm:px-8 lg:px-12 lg:py-24 text-zinc-200 shadow-2xl transition-shadow duration-500 hover:shadow-red-500/10">
    <div class="pointer-events-none absolute -top-20 -right-20 h-60 w-60 rounded-full bg-red-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>

    <div class="relative grid items-center gap-12 lg:grid-cols-2">
        <div>
            <span class="inline-flex items-center rounded-full border border-zinc-700 bg-zinc-900/90 px-3 py-1 text-sm text-zinc-300">
                دمو ۲ • آژانس نُوا
            </span>

            <h1 class="mt-6 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight text-zinc-100">
                <?php echo esc_html($hero_headline); ?>
            </h1>

            <p class="mt-5 text-base sm:text-lg text-zinc-400 leading-8 max-w-xl">
                <?php echo esc_html($hero_subheadline); ?>
            </p>

            <ul class="mt-6 space-y-2 text-sm text-zinc-300">
                <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">✓</span> توسعه سریع با استاندارد فنی بالا</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">✓</span> معماری قابل رشد برای توسعه‌های آینده</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">✓</span> تمرکز هم‌زمان بر سرعت، سئو و نرخ تبدیل</li>
            </ul>

            <div class="mt-8 flex flex-wrap gap-4">
                <?php if (!empty($hero_primary_button_url)): ?>
                    <a href="<?php echo esc_url($hero_primary_button_url); ?>" class="inline-flex items-center rounded-xl bg-red-500 px-6 py-3 text-sm font-semibold text-white hover:bg-red-400 transition">
                        <?php echo esc_html($hero_primary_button_label); ?>
                    </a>
                <?php else: ?>
                    <span class="inline-flex items-center rounded-xl bg-red-500 px-6 py-3 text-sm font-semibold text-white">
                        <?php echo esc_html($hero_primary_button_label); ?>
                    </span>
                <?php endif; ?>

                <?php if (!empty($hero_secondary_button_url)): ?>
                    <a href="<?php echo esc_url($hero_secondary_button_url); ?>" class="inline-flex items-center rounded-xl border border-zinc-700 px-6 py-3 text-sm font-semibold text-zinc-200 hover:border-zinc-500 transition">
                        <?php echo esc_html($hero_secondary_button_label); ?>
                    </a>
                <?php else: ?>
                    <span class="inline-flex items-center rounded-xl border border-zinc-700 px-6 py-3 text-sm font-semibold text-zinc-200">
                        <?php echo esc_html($hero_secondary_button_label); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="mt-8 grid grid-cols-3 gap-4 text-center sm:max-w-md">
                <div class="rounded-xl border border-zinc-800 bg-zinc-900/80 p-3">
                    <div class="text-2xl font-bold text-zinc-100">+80</div>
                    <div class="mt-1 text-xs text-zinc-400">پروژه تکمیل‌شده</div>
                </div>
                <div class="rounded-xl border border-zinc-800 bg-zinc-900/80 p-3">
                    <div class="text-2xl font-bold text-zinc-100">+6</div>
                    <div class="mt-1 text-xs text-zinc-400">سال تجربه</div>
                </div>
                <div class="rounded-xl border border-zinc-800 bg-zinc-900/80 p-3">
                    <div class="text-2xl font-bold text-zinc-100">%98</div>
                    <div class="mt-1 text-xs text-zinc-400">رضایت مشتری</div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                <div class="rounded-lg border border-zinc-800 bg-zinc-900/70 py-2 text-xs text-zinc-400">Laravel</div>
                <div class="rounded-lg border border-zinc-800 bg-zinc-900/70 py-2 text-xs text-zinc-400">WordPress</div>
                <div class="rounded-lg border border-zinc-800 bg-zinc-900/70 py-2 text-xs text-zinc-400">Vue / React</div>
                <div class="rounded-lg border border-zinc-800 bg-zinc-900/70 py-2 text-xs text-zinc-400">SEO Tech</div>
            </div>
        </div>

        <div class="rounded-3xl border border-zinc-800 bg-zinc-900/80 p-6 shadow-2xl transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium text-zinc-300">Roadmap پروژه</div>
                <div class="text-xs text-zinc-500">Sprint Active</div>
            </div>
            <div class="space-y-4">
                <div class="rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                    <div class="text-sm font-semibold text-zinc-200">تحلیل و استراتژی</div>
                    <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[90%] rounded bg-red-500"></div></div>
                </div>
                <div class="rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                    <div class="text-sm font-semibold text-zinc-200">طراحی UI/UX</div>
                    <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[75%] rounded bg-indigo-500"></div></div>
                </div>
                <div class="rounded-xl border border-zinc-800 bg-zinc-950/70 p-4 transition-all duration-300 hover:border-zinc-700 hover:bg-zinc-900/80">
                    <div class="text-sm font-semibold text-zinc-200">توسعه و تست</div>
                    <div class="mt-2 h-2 w-full rounded bg-zinc-800"><div class="h-2 w-[65%] rounded bg-emerald-500"></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70 mt-14">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <div class="grid md:grid-cols-3 gap-6 mb-14">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/80 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700 hover:shadow-lg hover:shadow-zinc-900/50">
                <div class="text-sm text-red-400">تحویل سریع</div>
                <p class="mt-2 text-zinc-300 text-sm leading-7">با برنامه‌ریزی Sprint محور، نسخه اولیه سریع تحویل می‌شود و به‌صورت مرحله‌ای توسعه پیدا می‌کند.</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/80 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700 hover:shadow-lg hover:shadow-zinc-900/50">
                <div class="text-sm text-indigo-400">فوکوس روی KPI</div>
                <p class="mt-2 text-zinc-300 text-sm leading-7">همه تصمیم‌های فنی و طراحی با معیارهای واقعی مثل سرعت، نرخ تبدیل و نگهداشت کاربر سنجیده می‌شوند.</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/80 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700 hover:shadow-lg hover:shadow-zinc-900/50">
                <div class="text-sm text-emerald-400">پشتیبانی واقعی</div>
                <p class="mt-2 text-zinc-300 text-sm leading-7">بعد از تحویل هم مسیر توسعه بسته نمی‌شود و در کنار شما برای بهبود مداوم محصول می‌مانیم.</p>
            </div>
        </div>

        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">خدمات ما</h2>
        <p class="text-zinc-400 text-center mt-4">راهکارهای حرفه‌ای برای رشد کسب‌وکار شما</p>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-red-400 mb-3">01</div>
                <h3 class="text-xl font-semibold">طراحی سایت اختصاصی</h3>
                <p class="text-zinc-400 mt-3">طراحی سایت حرفه‌ای با سرعت بالا، معماری اصولی و تمرکز روی تبدیل.</p>
            </div>
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-indigo-400 mb-3">02</div>
                <h3 class="text-xl font-semibold">توسعه وردپرس</h3>
                <p class="text-zinc-400 mt-3">پیاده‌سازی قالب و افزونه اختصاصی متناسب با نیاز دقیق کسب‌وکار شما.</p>
            </div>
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-emerald-400 mb-3">03</div>
                <h3 class="text-xl font-semibold">بهینه‌سازی سرعت و سئو</h3>
                <p class="text-zinc-400 mt-3">افزایش Core Web Vitals، بهبود رتبه گوگل و کاهش نرخ خروج کاربران.</p>
            </div>
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-amber-400 mb-3">04</div>
                <h3 class="text-xl font-semibold">طراحی پنل مدیریت</h3>
                <p class="text-zinc-400 mt-3">پیاده‌سازی داشبوردهای اختصاصی برای مدیریت ساده‌تر سفارش، کاربر و گزارش‌ها.</p>
            </div>
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-fuchsia-400 mb-3">05</div>
                <h3 class="text-xl font-semibold">توسعه API و SaaS</h3>
                <p class="text-zinc-400 mt-3">ساخت API امن و معماری SaaS برای محصولاتی که نیاز به مقیاس بالا دارند.</p>
            </div>
            <div class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-7 transition hover:-translate-y-1 hover:border-zinc-700">
                <div class="text-xs text-cyan-400 mb-3">06</div>
                <h3 class="text-xl font-semibold">نگهداری و توسعه مداوم</h3>
                <p class="text-zinc-400 mt-3">پشتیبانی فنی، مانیتورینگ عملکرد و بهبود مستمر براساس داده‌های واقعی.</p>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">مراحل همکاری</h2>

        <div class="grid md:grid-cols-4 gap-6 mt-12 text-center">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="text-3xl font-black text-red-400 mb-3">1</div>
                <h3 class="font-semibold">مشاوره</h3>
                <p class="text-zinc-400 mt-2 text-sm">بررسی نیازهای پروژه و هدف‌گذاری</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="text-3xl font-black text-indigo-400 mb-3">2</div>
                <h3 class="font-semibold">برنامه‌ریزی</h3>
                <p class="text-zinc-400 mt-2 text-sm">طراحی ساختار و زمان‌بندی توسعه</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="text-3xl font-black text-emerald-400 mb-3">3</div>
                <h3 class="font-semibold">توسعه</h3>
                <p class="text-zinc-400 mt-2 text-sm">پیاده‌سازی، تست و بهینه‌سازی</p>
            </div>
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="text-3xl font-black text-amber-400 mb-3">4</div>
                <h3 class="font-semibold">تحویل</h3>
                <p class="text-zinc-400 mt-2 text-sm">انتشار نهایی، آموزش و پشتیبانی</p>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">نمونه‌کارها</h2>
        <p class="text-zinc-400 text-center mt-4">نمونه‌هایی از پروژه‌های واقعی که با تمرکز روی نتیجه کسب‌وکار توسعه داده شده‌اند.</p>

        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <?php if ($portfolio_query->have_posts()): ?>
                <?php while ($portfolio_query->have_posts()): $portfolio_query->the_post(); ?>
                    <article class="group transition-transform duration-300 hover:-translate-y-1">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="block overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900 transition-colors duration-300 group-hover:border-zinc-700">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy" />
                            <?php else: ?>
                                <div class="h-56 w-full bg-zinc-800"></div>
                            <?php endif; ?>
                        </a>
                        <h3 class="mt-4 font-semibold text-zinc-100"><?php echo esc_html(get_the_title()); ?></h3>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">
                    هنوز نمونه‌کاری منتشر نشده است.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">نظر مشتری‌ها</h2>
        <p class="text-zinc-400 text-center mt-4">تجربه واقعی همکاری با ما از نگاه کارفرماها</p>

        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <?php if ($testimonials_query->have_posts()): ?>
                <?php while ($testimonials_query->have_posts()): $testimonials_query->the_post(); ?>
                    <?php $client_name = get_post_meta(get_the_ID(), '_client_name', true); ?>
                    <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                        <div class="text-amber-400">★★★★★</div>
                        <p class="mt-4 text-sm leading-7 text-zinc-300"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_content()), 35, '...')); ?></p>
                        <div class="mt-5 text-sm font-semibold text-zinc-100"><?php echo esc_html($client_name ? $client_name : get_the_title()); ?></div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">به‌زودی تجربه همکاری مشتری‌ها اینجا نمایش داده می‌شود.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">تعرفه خدمات</h2>
        <p class="text-zinc-400 text-center mt-4">پلن‌ها برای شروع سریع‌تر طراحی شده‌اند؛ امکان شخصی‌سازی برای هر پروژه وجود دارد.</p>

        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                <h3 class="text-xl font-semibold">پایه</h3>
                <div class="text-3xl font-bold mt-4">۱۰ میلیون</div>
                <ul class="mt-5 space-y-2 text-sm text-zinc-400">
                    <li>• لندینگ یا سایت معرفی</li>
                    <li>• طراحی ریسپانسیو</li>
                    <li>• تحویل ۷ تا ۱۰ روز</li>
                </ul>
                <button class="mt-6 w-full rounded-lg bg-zinc-800 py-3 text-zinc-100 hover:bg-zinc-700 transition">انتخاب</button>
            </div>

            <div class="rounded-2xl border border-red-500/40 bg-red-500 p-8 text-white shadow-lg shadow-red-500/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-red-500/40">
                <h3 class="text-xl font-semibold">حرفه‌ای</h3>
                <div class="text-3xl font-bold mt-4">۲۵ میلیون</div>
                <ul class="mt-5 space-y-2 text-sm text-white/90">
                    <li>• سایت یا وب‌اپ اختصاصی</li>
                    <li>• بهینه‌سازی سرعت و سئو</li>
                    <li>• پنل مدیریت اختصاصی</li>
                </ul>
                <button class="mt-6 w-full rounded-lg bg-white py-3 text-black font-semibold hover:bg-zinc-100 transition">انتخاب</button>
            </div>

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                <h3 class="text-xl font-semibold">سازمانی</h3>
                <div class="text-3xl font-bold mt-4">تماس بگیرید</div>
                <ul class="mt-5 space-y-2 text-sm text-zinc-400">
                    <li>• معماری مقیاس‌پذیر</li>
                    <li>• SLA و پشتیبانی اختصاصی</li>
                    <li>• توسعه چندماژوله</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-zinc-800 py-3 text-zinc-100 hover:bg-zinc-700 transition">تماس</a>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-7xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">آخرین مقاله‌ها</h2>
        <p class="text-zinc-400 text-center mt-4">نکات کاربردی برای رشد محصول، افزایش سرعت و بهبود سئو</p>

        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <?php if ($blog_query->have_posts()): ?>
                <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
                    <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700">
                        <div class="text-xs text-zinc-500"><?php echo esc_html(get_the_date('Y/m/d')); ?></div>
                        <h3 class="mt-3 text-lg font-semibold text-zinc-100 leading-8"><?php echo esc_html(get_the_title()); ?></h3>
                        <p class="mt-3 text-sm text-zinc-400 leading-7"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?></p>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="mt-5 inline-flex items-center text-sm font-semibold text-red-400 hover:text-red-300 transition">مشاهده مقاله ←</a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="md:col-span-3 rounded-2xl border border-zinc-800 bg-zinc-900 p-6 text-center text-zinc-400">مقاله‌ای برای نمایش وجود ندارد.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-5xl mx-auto py-20 lg:py-24">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center">سوالات متداول</h2>
        <div class="mt-10 space-y-4">
            <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5 transition-all duration-300 hover:border-zinc-700">
                <h3 class="font-semibold text-zinc-100">مدت زمان اجرای پروژه چقدر است؟</h3>
                <p class="text-sm text-zinc-400 mt-2 leading-7">بسته به نوع پروژه، نسخه اولیه بین ۷ تا ۲۰ روز تحویل می‌شود و سپس توسعه مرحله‌ای ادامه پیدا می‌کند.</p>
            </div>
            <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5 transition-all duration-300 hover:border-zinc-700">
                <h3 class="font-semibold text-zinc-100">آیا بعد از تحویل پشتیبانی دارید؟</h3>
                <p class="text-sm text-zinc-400 mt-2 leading-7">بله، برای همه پلن‌ها پشتیبانی پایه ارائه می‌شود و برای پروژه‌های سازمانی SLA اختصاصی قابل تعریف است.</p>
            </div>
            <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-5 transition-all duration-300 hover:border-zinc-700">
                <h3 class="font-semibold text-zinc-100">امکان توسعه تدریجی محصول وجود دارد؟</h3>
                <p class="text-sm text-zinc-400 mt-2 leading-7">بله، معماری پروژه از ابتدا طوری طراحی می‌شود که اضافه کردن ماژول‌های جدید در آینده ساده و کم‌هزینه باشد.</p>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-zinc-800/70">
    <div class="max-w-5xl mx-auto py-20 lg:py-24 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-zinc-100">آماده شروع پروژه خود هستید؟</h2>
        <p class="text-zinc-400 mt-4">همین حالا با ما تماس بگیرید تا مسیر رشد دیجیتال برندتان را شروع کنیم.</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mt-8 inline-flex items-center rounded-xl bg-red-500 px-8 py-4 font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-red-400 hover:shadow-lg hover:shadow-red-500/30">
            شروع همکاری
        </a>
    </div>
</section>
