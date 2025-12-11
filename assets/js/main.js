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

    updateIcon();

    // کلیک روی دکمه
    toggleBtn.addEventListener('click', function () {
        html.classList.toggle('dark');

        if(html.classList.contains('dark')) {
            localStorage.setItem('theme_fadaee','dark');
        } else {
            localStorage.setItem('theme_fadaee','light');
        }

        updateIcon();
    });

    // آپدیت آیکون‌ها
    function updateIcon() {
        const sun = toggleBtn.querySelector('.sun');
        const moon = toggleBtn.querySelector('.moon');

        if(html.classList.contains('dark')) {
            sun.classList.add('hidden');
            moon.classList.remove('hidden');
        } else {
            sun.classList.remove('hidden');
            moon.classList.add('hidden');
        }
    }

});



q(function($) {

    $("#loadmore").on("click", function() {

        let button = $(this);
        let page   = button.data('page');
        let ajaxurl = button.data('url');

        button.text("در حال بارگذاری...");

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "fadaee_load_more",
                page: page
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
