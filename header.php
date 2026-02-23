<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>

</head>
<body class="flex flex-col bg-zinc-50 dark:bg-black text-zinc-900 dark:text-zinc-100" style="overflow-x: hidden; max-width: 100vw;">

<!-- Background (optimized - no fixed) -->
<div class="absolute inset-0 flex justify-center overflow-hidden pointer-events-none -z-10">
    <div class="absolute inset-0 bg-gradient-to-t from-white/5 to-transparent dark:from-black/5"></div>
</div>

<div class="relative flex w-full flex-col max-w-7xl mx-auto" style="max-width: 100%; overflow-x: hidden;">
    <!-- Header -->
    <header class="pointer-events-none relative z-50 flex flex-none flex-col" style="height: var(--header-height); margin-bottom: var(--header-mb);">
        
        <!-- Top section with navigation -->
        <div class="top-0 z-10 h-16 pt-6">
            <div class="sm:px-8 w-full">
                <div class="mx-auto w-full max-w-7xl lg:px-8">
                    <div class="relative px-4 sm:px-8 lg:px-12">
                        <div class="mx-auto max-w-2xl lg:max-w-5xl">
                            <div class="relative flex gap-4">
                                
                                <!-- Left spacer -->
                                <div class="flex flex-1"></div>
                                
                                <!-- Center navigation -->
                                <div class="flex flex-1 justify-end md:justify-center">
                                    <?php
                                    $menus = get_nav_menu_locations();
                                    $menu_id = isset($menus['main_menu']) ? (int) $menus['main_menu'] : 0;
                                    $get_items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];
                                    if (!is_array($get_items)) {
                                        $get_items = [];
                                    }
                                    ?>
                                    
                                    <!-- Mobile menu button -->
                                    <div class="pointer-events-auto md:hidden">
                                        <button id="mobile-menu-toggle" 
                                                class="group flex items-center rounded-full bg-white/90 px-4 py-2 text-sm font-medium text-zinc-800 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10 dark:hover:ring-white/20" 
                                                type="button" 
                                                aria-expanded="false">
                                            منو
                                            <svg viewBox="0 0 8 6" aria-hidden="true" class="mr-3 h-auto w-2 stroke-zinc-500 group-hover:stroke-zinc-700 dark:group-hover:stroke-zinc-400 rtl:mr-3">
                                                <path d="M1.75 1.75 4 4.25l2.25-2.5" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Desktop navigation -->
<nav class="pointer-events-auto hidden md:block" style="width: max-content !important;">
    <ul class="flex rounded-full bg-white/90 px-3 text-sm font-medium text-zinc-800 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10">

        <?php foreach ($get_items as $item):
            // فقط آیتم‌های سطح اول
            if ($item->menu_item_parent != 0) continue;

            $active = in_array('current-menu-item', $item->classes) ? 'active' : '';

            // چک وجود زیرمنو
            $has_children = false;
            foreach ($get_items as $sub_item_check) {
                if ($sub_item_check->menu_item_parent == $item->ID) {
                    $has_children = true;
                    break;
                }
            }
        ?>

            <li class="relative group">
                <a href="<?= esc_url($item->url) ?>" 
                   class="relative block px-3 py-2 transition 
                       <?= $active ? 'text-red-500 dark:text-red-400' : 'hover:text-red-500 dark:hover:text-red-400' ?>">
                    <?= esc_html($item->title) ?>

                    <?php if ($active): ?>
                        <span class="absolute inset-x-1 -bottom-px h-px 
                            bg-gradient-to-r 
                            from-red-500/0 via-red-500/40 to-red-500/0
                            dark:from-red-400/0 dark:via-red-400/40 dark:to-red-400/0"></span>
                    <?php endif; ?>
                </a>

                <?php if ($has_children): ?>
                    <ul class="absolute right-0 top-full mt-1 min-w-[180px] bg-white dark:bg-zinc-800 
                               rounded-md shadow-lg opacity-0 invisible 
                               group-hover:visible group-hover:opacity-100 
                               transition-opacity duration-200 z-50">

                        <?php foreach ($get_items as $sub_item):
                            if ($sub_item->menu_item_parent != $item->ID) continue;

                            $sub_active = in_array('current-menu-item', $sub_item->classes)
                                ? 'text-red-500 dark:text-red-400'
                                : 'hover:text-red-500 dark:hover:text-red-400';
                        ?>

                            <li style="
    width: max-content;
">
                                <a href="<?= esc_url($sub_item->url) ?>" 
                                   class="block px-4 py-2 text-zinc-800 dark:text-zinc-200 <?= $sub_active ?> transition">
                                    <?= esc_html($sub_item->title) ?>
                                </a>
                            </li>

                        <?php endforeach; ?>

                    </ul>
                <?php endif; ?>

            </li>

        <?php endforeach; ?>

    </ul>
</nav>


                                </div>
                                
                                <!-- Right side - Theme toggle -->
                                <div class="flex justify-end md:flex-1">
                                    <div class="pointer-events-auto">
                                        <button id="theme-toggle" 
                                                type="button" 
                                                aria-label="تغییر تم" 
                                                class="group rounded-full bg-white/90 px-3 py-2 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm transition dark:bg-zinc-800/90 dark:ring-white/10 dark:hover:ring-white/20">
                                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="moon h-6 w-6 fill-zinc-700 stroke-zinc-500 transition group-hover:stroke-zinc-700 dark:hidden">
                                                <path d="M17.25 16.22a6.937 6.937 0 0 1-9.47-9.47 7.451 7.451 0 1 0 9.47 9.47ZM12.75 7C17 7 17 2.75 17 2.75S17 7 21.25 7C17 7 17 11.25 17 11.25S17 7 12.75 7Z"></path>
                                            </svg>
                                            <svg viewBox="0 0 24 24" aria-hidden="true" class="sun hidden h-6 w-6 fill-zinc-100 stroke-zinc-500 transition group-hover:fill-zinc-200 group-hover:stroke-zinc-700 dark:block">
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
        
<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="mobile-menu-overlay fixed inset-0 z-50 hidden">
    <div class="mobile-menu-backdrop absolute inset-0 bg-zinc-900/50 dark:bg-black/70 backdrop-blur-sm"></div>

    <nav class="mobile-nav pointer-events-auto absolute inset-y-0 right-0 h-full w-full max-w-xs sm:max-w-sm bg-white dark:bg-zinc-900 shadow-2xl transform translate-x-full transition-transform duration-300">
        <div class="flex items-center justify-between px-4 pt-4 pb-3 border-b border-zinc-200 dark:border-zinc-800">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200">
                منوی سایت
            </span>
            <button id="mobile-menu-close" 
                    class="rounded-full w-9 h-9 flex items-center justify-center 
                           bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 
                           hover:bg-zinc-300 dark:hover:bg-zinc-700 transition"
                    aria-label="بستن منو">
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

                    $has_children = false;
                    foreach ($get_items as $sub_item_check) {
                        if ($sub_item_check->menu_item_parent == $item->ID) {
                            $has_children = true;
                            break;
                        }
                    }
                ?>
                    <li class="relative">
                        <?php if ($has_children): ?>
                            <div class="flex items-center justify-between gap-2">
                                <a href="<?= esc_url($item->url) ?>"
                                   class="mobile-menu-item flex-1 flex items-center justify-between rounded-xl px-4 py-3 text-right text-sm
                                          bg-transparent text-zinc-800 dark:text-zinc-100
                                          hover:bg-zinc-100 dark:hover:bg-zinc-800 
                                          hover:text-red-500 dark:hover:text-red-400 
                                          transition-colors <?= $active ?>">
                                    <span class="truncate">
                                        <?= esc_html($item->title) ?>
                                    </span>
                                </a>

                                <button class="submenu-toggle shrink-0 flex items-center justify-center w-8 h-8 rounded-full text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800" aria-expanded="false">
                                    <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 7.5L10 12.5L15 7.5" />
                                    </svg>
                                </button>
                            </div>

                            <ul class="mobile-submenu flex flex-col gap-1 mt-1 mr-4 mb-1 hidden">
                                <?php foreach ($get_items as $sub_item):
                                    if ($sub_item->menu_item_parent != $item->ID) continue;

                                    $sub_active = in_array('current-menu-item', $sub_item->classes) ? 'active' : '';
                                ?>
                                    <li>
                                        <a href="<?= esc_url($sub_item->url) ?>"
                                           class="block rounded-lg px-4 py-2 text-right text-sm
                                                  text-zinc-700 dark:text-zinc-200 
                                                  hover:bg-zinc-100 dark:hover:bg-zinc-800 
                                                  hover:text-red-500 dark:hover:text-red-400 
                                                  transition-colors <?= $sub_active ?>">
                                            <?= esc_html($sub_item->title) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <a href="<?= esc_url($item->url) ?>"
                               class="mobile-menu-item block w-full rounded-xl px-4 py-3 text-right text-sm
                                      bg-transparent text-zinc-800 dark:text-zinc-100
                                      hover:bg-zinc-100 dark:hover:bg-zinc-800 
                                      hover:text-red-500 dark:hover:text-red-400 
                                      transition-colors <?= $active ?>">
                                <span class="truncate">
                                    <?= esc_html($item->title) ?>
                                </span>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</div>

        
    </header>


    
