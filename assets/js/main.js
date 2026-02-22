let q = jQuery.noConflict();

q(document).ready(function(){

    q('#Like_Post').on('click', function(){

        let button = q(this);
        let post_id = button.data('post_id');

        q.ajax({
            method: 'POST',
            url: fadaee_ajax.ajaxurl, // ← درست شد
            data: {
                action: 'fadaee_like_post',
                post_id: post_id,
                nonce: fadaee_ajax.nonce
            },
            success: function(response){

                if(response.success){
                    button.find("span").text(response.data.likes);
                } else {
                    alert(response.data.message);
                }
            }
        });
    });

    // DisLike
    q('#DisLike_Post').on('click', function () {

        let button = q(this);
        let post_id = button.data('post_id');

        q.ajax({
            method: 'POST',
            url: fadaee_ajax.ajaxurl, // استفاده از object
            data: {
                action: 'fadaee_dislike_post',
                post_id: post_id,
                nonce: fadaee_ajax.nonce
            },
            success: function(response){

                if(response.success){
                    button.find("span").text(response.data.dislikes);
                } else {
                    alert(response.data.message);
                }
            }
        });
    });


});

document.addEventListener("DOMContentLoaded", function () {

    const html = document.documentElement;
    const toggleBtn = document.getElementById('theme-toggle');
    const sunIcon = toggleBtn ? toggleBtn.querySelector('.sun') : null;
    const moonIcon = toggleBtn ? toggleBtn.querySelector('.moon') : null;

    const updateThemeIcons = () => {
        if (!sunIcon || !moonIcon) return;
        if (html.classList.contains('dark')) {
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        }
    };

    // ست اولیه بر اساس LocalStorage
    if(localStorage.getItem('theme_fadaee') === 'dark') {
        html.classList.add('dark');
    } else if(localStorage.getItem('theme_fadaee') === 'light') {
        html.classList.remove('dark');
    } else {
        // بررسی سیستم کاربر
        if(window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
            localStorage.setItem('theme_fadaee','dark');
        }
    }

    updateThemeIcons();

    // کلیک روی دکمه
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            html.classList.toggle('dark');

            if(html.classList.contains('dark')) {
                localStorage.setItem('theme_fadaee','dark');
            } else {
                localStorage.setItem('theme_fadaee','light');
            }

            updateThemeIcons();
        });
    }

});


q(function($) {

    $("#loadmore").on("click", function() {

        let button = $(this);
        let page   = button.data('page');
        let ajaxurl = button.data('url');

        const searchInput = document.getElementById('blog-search');
        const activeChip = document.querySelector('.blog-category-chip.active');
        const category = activeChip ? activeChip.getAttribute('data-category') : '';
        const search   = searchInput ? searchInput.value : '';

        button.text("در حال بارگذاری...");

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "fadaee_load_more",
                page: page + 1,
                category: category,
                search: search
            },
            success: function(res) {
                if(res.trim() !== "") {
                    $("#post-container").append(res);
                    button.data("page", page + 1);
                    button.text("مشاهده بیشتر");
                } else {
                    button.text("مقاله‌ای دیگر وجود ندارد");
                    button.prop("disabled", true);
                }
            }
        });

    });

});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('blog-search');
    const categoryChips = document.querySelectorAll('.blog-category-chip');
    const postContainer = document.getElementById('post-container');
    const loadMoreBtn = document.getElementById('loadmore');
    const meta = document.getElementById('blog-filters-meta');

    if (!postContainer || !loadMoreBtn || !meta) {
        return;
    }

    const ajaxUrl = meta.getAttribute('data-ajax-url');

    function setLoading(state) {
        if (state) {
            postContainer.classList.add('opacity-60');
            postContainer.classList.add('pointer-events-none');
        } else {
            postContainer.classList.remove('opacity-60');
            postContainer.classList.remove('pointer-events-none');
        }
    }

    function fetchPosts(page) {
        const activeChip = document.querySelector('.blog-category-chip.active');
        const defaultCategory = meta.getAttribute('data-current-category') || '';
        const category = activeChip ? activeChip.getAttribute('data-category') || defaultCategory : defaultCategory;
        const search = searchInput ? searchInput.value : '';

        setLoading(true);

        q.ajax({
            method: 'POST',
            url: ajaxUrl,
            data: {
                action: 'fadaee_load_more',
                page: page,
                category: category,
                search: search
            },
            success: function (res) {
                setLoading(false);

                if (page === 1) {
                    postContainer.innerHTML = res.trim() !== '' ? res : '<div class="col-span-full text-center py-12"><p class="text-lg text-zinc-600 dark:text-zinc-400">مقاله‌ای یافت نشد.</p></div>';
                } else if (res.trim() !== '') {
                    postContainer.insertAdjacentHTML('beforeend', res);
                }

                if (res.trim() === '') {
                    loadMoreBtn.textContent = 'مقاله‌ای دیگر وجود ندارد';
                    loadMoreBtn.disabled = true;
                } else {
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'مشاهده بیشتر';
                }

                loadMoreBtn.dataset.page = page;
            }
        });
    }

    categoryChips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            categoryChips.forEach(function (c) {
                c.classList.remove('active');
                c.classList.remove('bg-red-600', 'text-white');
                c.classList.remove('hover:bg-red-500');
                c.classList.remove('dark:bg-red-500', 'dark:text-white', 'dark:hover:bg-red-400');
                c.classList.add('bg-zinc-100', 'text-zinc-700', 'dark:bg-zinc-800', 'dark:text-zinc-200', 'dark:hover:bg-zinc-700');
            });

            this.classList.add('active');
            this.classList.remove('bg-zinc-100', 'text-zinc-700', 'dark:bg-zinc-800', 'dark:text-zinc-200', 'dark:hover:bg-zinc-700');
            this.classList.add('bg-red-600', 'text-white', 'hover:bg-red-500', 'dark:bg-red-500', 'dark:text-white', 'dark:hover:bg-red-400');

            fetchPosts(1);
        });
    });

    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                fetchPosts(1);
            }, 400);
        });
    }
});


// ===============================
// Responsive Tables - Add data-label
// ===============================
document.addEventListener("DOMContentLoaded", function () {
    const tables = document.querySelectorAll('table');
    
    tables.forEach(table => {
        const headers = table.querySelectorAll('thead th');
        const rows = table.querySelectorAll('tbody tr');
        
        // اگر جدول header نداشت، skip کن
        if (headers.length === 0) return;
        
        // برای هر ردیف
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            
            // برای هر سلول، data-label اضافه کن
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    const headerText = headers[index].textContent.trim();
                    cell.setAttribute('data-label', headerText);
                }
            });
        });
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("mobile-menu-toggle");
    const menuOverlay = document.getElementById("mobile-menu");
    const navPanel = menuOverlay.querySelector(".mobile-nav");
    const backdrop = menuOverlay.querySelector(".mobile-menu-backdrop");
    const closeBtn = document.getElementById("mobile-menu-close");

    const openMenu = () => {
        menuOverlay.classList.remove("hidden");
        document.body.classList.add("menu-open");

        navPanel.classList.remove("translate-x-full");
        navPanel.classList.add("translate-x-0");
    };

    const closeMenu = () => {
        document.body.classList.remove("menu-open");

        navPanel.classList.remove("translate-x-0");
        navPanel.classList.add("translate-x-full");

        setTimeout(() => {
            menuOverlay.classList.add("hidden");
        }, 250);
    };

    toggle?.addEventListener("click", openMenu);
    backdrop?.addEventListener("click", closeMenu);
    closeBtn?.addEventListener("click", closeMenu);

    // Close menu when ESC is pressed
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeMenu();
    });
});

document.querySelectorAll('.submenu-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const submenu = this.closest('li').querySelector('.mobile-submenu');
        if (!submenu) return;

        const isHidden = submenu.classList.contains('hidden');
        submenu.classList.toggle('hidden');

        const icon = this.querySelector('svg');
        if (icon) {
            icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        this.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    });
});




function toggleContent(btn) {
    const box = btn.closest('.content-box');
    const preview = box.querySelector('.content-preview');
    const full = box.querySelector('.content-full');
    const isExpanded = full.style.display !== 'none';

    if (isExpanded) {
        full.style.display = 'none';
        preview.style.display = 'block';
        const label = btn.querySelector('.toggle-label');
        const icon = btn.querySelector('.toggle-icon');
        if (label) label.textContent = 'نمایش بیشتر';
        if (icon) icon.textContent = '↓';
        btn.setAttribute('aria-expanded', 'false');
    } else {
        full.style.display = 'block';
        preview.style.display = 'none';
        const label = btn.querySelector('.toggle-label');
        const icon = btn.querySelector('.toggle-icon');
        if (label) label.textContent = 'نمایش کمتر';
        if (icon) icon.textContent = '↑';
        btn.setAttribute('aria-expanded', 'true');
    }
}
