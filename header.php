<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>

</head>
<body class="flex flex-col bg-zinc-50 dark:bg-black text-zinc-900 dark:text-zinc-100">

<!-- Background (optimized - no fixed) -->
<div class="absolute inset-0 flex justify-center overflow-hidden pointer-events-none -z-10">
    <div class="absolute inset-0 bg-gradient-to-t from-white/5 to-transparent dark:from-black/5"></div>
</div>

<div class="relative flex w-full flex-col max-w-7xl mx-auto">
    <!-- Header -->
    <header class="will-change-transform relative z-50 flex flex-none flex-col" style="height: var(--header-height); margin-bottom: var(--header-mb);">
        <div class="top-0 z-10 h-16 pt-6">
            <div class="relative mx-auto max-w-7xl px-4 sm:px-8 lg:px-12">
                <div class="flex items-center justify-between">

                    <!-- Avatar -->
                    <div class="hidden sm:block h-16 w-16 origin-left transition-transform hover:scale-105 relative">
                        <div class="avatar-border absolute inset-0 rounded-full ring-4 ring-red-500/20"></div>
                    </div>

                    <!-- Navigation -->
                    <nav class="md:block">
                        <?php
                        $menus = get_nav_menu_locations();
                        $menu_id = $menus['main_menu']; // location 'main_menu'
                        $get_items = wp_get_nav_menu_items($menu_id);

                        ?>
                        <ul class="flex rounded-full bg-white/0 px-3 text-sm font-medium shadow-lg ring-1 ring-zinc-900/5 backdrop-blur dark:bg-white/0 p-2">
                            <?php foreach ( $get_items as $item ):

                                $active = in_array('current-menu-item', $item->classes) ? 'active' : '';

                                ?>

                                <li><a href="<?php echo esc_url($item->url) ?>" class="block px-3 py-2 hover:text-red-500 dark:hover:text-red-400 <?= $active?>"><?php echo  esc_html($item->title)?></a></li>


                            <?php endforeach; ?>
                        </ul>
                    </nav>


                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="theme-toggle group rounded-full p-2 shadow-lg ring-1 ring-zinc-900/5 backdrop-blur bg-white/0 dark:bg-white/0">
                        <svg class="sun h-6 w-6 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 3v1m0 16v1m8.485-12.879l-.707.707M5.222 18.364l-.707.707m13.95-13.95l-.707-.707M5.222 5.222l-.707-.707M12 5.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13z" />
                        </svg>
                        <svg class="moon h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>


                </div>
            </div>
        </div>
    </header>
