<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body class="flex flex-col bg-zinc-950 text-zinc-100" style="overflow-x: hidden; max-width: 100vw;">

<div class="absolute inset-0 flex justify-center overflow-hidden pointer-events-none -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-900 via-zinc-950 to-black"></div>
    <div class="absolute -top-40 right-1/4 h-80 w-80 rounded-full bg-red-500/20 blur-3xl"></div>
    <div class="absolute -bottom-40 left-1/4 h-96 w-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
</div>

<div class="relative flex w-full flex-col max-w-7xl mx-auto" style="max-width: 100%; overflow-x: hidden;">
    <header class="pointer-events-none relative z-50 flex flex-none flex-col" style="height: var(--header-height); margin-bottom: var(--header-mb);">
        <div class="top-0 z-10 h-16 pt-6">
            <div class="sm:px-8 w-full">
                <div class="mx-auto w-full max-w-7xl lg:px-8">
                    <div class="relative px-4 sm:px-8 lg:px-12">
                        <div class="mx-auto max-w-2xl lg:max-w-6xl">
                            <div class="relative flex items-center gap-4">
                                <div class="flex flex-1 items-center">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="pointer-events-auto inline-flex items-center gap-2 rounded-full bg-zinc-900/90 px-4 py-2 text-sm font-semibold text-zinc-100 ring-1 ring-zinc-700/70 backdrop-blur-sm">
                                        <span class="inline-flex h-2 w-2 rounded-full bg-red-400"></span>
                                        Agency Nova
                                    </a>
                                </div>

                                <div class="flex flex-1 justify-end md:justify-center">
                                    <?php
                                    $menus = get_nav_menu_locations();
                                    $menu_id = isset($menus['main_menu']) ? (int) $menus['main_menu'] : 0;
                                    $get_items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];
                                    if (!is_array($get_items)) {
                                        $get_items = [];
                                    }
                                    ?>

                                    <div class="pointer-events-auto md:hidden">
                                        <button id="mobile-menu-toggle" 
                                                class="group flex items-center rounded-full bg-zinc-900/90 px-4 py-2 text-sm font-medium text-zinc-100 shadow-lg ring-1 ring-zinc-700/70 backdrop-blur-sm"
                                                type="button" 
                                                aria-expanded="false">
                                            منو
                                            <svg viewBox="0 0 8 6" aria-hidden="true" class="mr-3 h-auto w-2 stroke-zinc-400 group-hover:stroke-zinc-200 rtl:mr-3">
                                                <path d="M1.75 1.75 4 4.25l2.25-2.5" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <nav class="pointer-events-auto hidden md:block" style="width: max-content !important;">
                                        <ul class="flex rounded-full bg-zinc-900/90 px-3 text-sm font-medium text-zinc-200 shadow-lg ring-1 ring-zinc-700/70 backdrop-blur-sm">
                                            <?php foreach ($get_items as $item):
                                                if ($item->menu_item_parent != 0) continue;
                                                $active = in_array('current-menu-item', $item->classes) ? 'active' : '';
                                            ?>
                                                <li class="relative group">
                                                    <a href="<?= esc_url($item->url) ?>"
                                                       class="relative block px-3 py-2 transition <?= $active ? 'text-red-400' : 'hover:text-red-300' ?>">
                                                        <?= esc_html($item->title) ?>
                                                        <?php if ($active): ?>
                                                            <span class="absolute inset-x-1 -bottom-px h-px bg-gradient-to-r from-red-400/0 via-red-400/60 to-red-400/0"></span>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </nav>
                                </div>

                                <div class="flex justify-end md:flex-1 items-center gap-2">
                                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="pointer-events-auto hidden sm:inline-flex items-center rounded-full bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-400 transition">
                                        شروع همکاری
                                    </a>
                                    <div class="pointer-events-auto">
                                        <button id="theme-toggle" 
                                                type="button" 
                                                aria-label="تغییر تم" 
                                                class="group rounded-full bg-zinc-900/90 px-3 py-2 shadow-lg ring-1 ring-zinc-700/70 transition">
                                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="moon h-6 w-6 fill-zinc-200 stroke-zinc-400 transition group-hover:stroke-zinc-200 dark:hidden">
                                                <path d="M17.25 16.22a6.937 6.937 0 0 1-9.47-9.47 7.451 7.451 0 1 0 9.47 9.47ZM12.75 7C17 7 17 2.75 17 2.75S17 7 21.25 7C17 7 17 11.25 17 11.25S17 7 12.75 7Z"></path>
                                            </svg>
                                            <svg viewBox="0 0 24 24" aria-hidden="true" class="sun hidden h-6 w-6 fill-zinc-100 stroke-zinc-400 transition group-hover:fill-zinc-200 group-hover:stroke-zinc-200 dark:block">
                                                <path d="M8 12.25A4.25 4.25 0 0 1 12.25 8v0a4.25 4.25 0 0 1 4.25 4.25v0a4.25 4.25 0 0 1-4.25 4.25v0A4.25 4.25 0 0 1 8 12.25v0Z"></path>
                                                <path d="M12.25 3v1.5M21.5 12.25H20M18.791 18.791l-1.06-1.06M18.791 5.709l-1.06 1.06M12.25 20v1.5M4.5 12.25H3M6.77 6.77 5.709 5.709M6.77 17.73l-1.061 1.061" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="mobile-menu-overlay fixed inset-0 z-50 hidden">
            <div class="mobile-menu-backdrop absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            <nav class="mobile-nav pointer-events-auto absolute inset-y-0 right-0 h-full w-full max-w-xs sm:max-w-sm bg-zinc-900 shadow-2xl transform translate-x-full transition-transform duration-300">
                <div class="flex items-center justify-between px-4 pt-4 pb-3 border-b border-zinc-800">
                    <span class="text-sm font-medium text-zinc-100">منوی سایت</span>
                    <button id="mobile-menu-close" class="rounded-full w-9 h-9 flex items-center justify-center bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition" aria-label="بستن منو">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>
                </div>

                <div class="h-full overflow-y-auto pb-8">
                    <ul class="mobile-menu-list flex flex-col gap-1 px-3 pt-4">
                        <?php foreach ($get_items as $item):
                            if ($item->menu_item_parent != 0) continue;
                            $active = in_array('current-menu-item', $item->classes) ? 'active' : '';
                        ?>
                            <li>
                                <a href="<?= esc_url($item->url) ?>"
                                   class="block w-full rounded-xl px-4 py-3 text-right text-sm bg-transparent text-zinc-100 hover:bg-zinc-800 hover:text-red-300 transition-colors <?= $active ?>">
                                    <span class="truncate"><?= esc_html($item->title) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
