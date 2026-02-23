<?php get_header(); ?>

<?php
$posts_page_id = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');
?>

<main class="flex flex-col items-center justify-center text-center px-6 py-24 sm:py-32">
    
    <h1 class="text-8xl font-extrabold text-red-600 dark:text-red-500 tracking-tight">
        404
    </h1>

    <h2 class="mt-6 text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-zinc-100">
        صفحه مورد نظر پیدا نشد!
    </h2>

    <p class="mt-4 max-w-xl text-base sm:text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
        متأسفانه صفحه‌ای که دنبالش هستید وجود ندارد یا ممکن است حذف شده باشد.  
        می‌توانید به صفحه اصلی بازگردید یا از طریق جستجو آنچه نیاز دارید را پیدا کنید.
    </p>

    <div class="mt-8 flex gap-4">
        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all shadow-sm">
            بازگشت به صفحه اصلی
        </a>

        <a href="<?php echo esc_url($posts_page_url); ?>"
           class="px-6 py-3 bg-zinc-800 hover:bg-zinc-700 text-white rounded-xl transition-all dark:bg-zinc-700 dark:hover:bg-zinc-600">
            مشاهده مقالات
        </a>
    </div>

    <!-- Search Box -->
    <div class="mt-10 max-w-md w-full">
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex">
            <input 
                type="text" 
                name="s" 
                placeholder="جستجو کنید..." 
                class="flex-1 px-4 py-3 rounded-r-xl bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-100 focus:outline-none"
            >
            <button 
                type="submit" 
                class="px-5 bg-red-600 hover:bg-red-700 rounded-l-xl text-white transition-all"
            >
                جستجو
            </button>
        </form>
    </div>

</main>

<?php get_footer(); ?>
