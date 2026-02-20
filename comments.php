<?php
if (post_password_required()) {
    return;
}

$comment_count = get_comments_number();
?>

<section id="comments" class="mt-12 sm:mt-16">
    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-8 sm:pt-10">
        <h2 class="text-xl sm:text-2xl font-semibold text-zinc-900 dark:text-zinc-100 mb-6">
            <?php
            if ($comment_count === 0) {
                echo 'هنوز نظری ثبت نشده است';
            } else {
                echo sprintf('%s نظر', fadaee_persian_numbers($comment_count));
            }
            ?>
        </h2>

        <?php if (have_comments()): ?>
            <div class="space-y-6 mb-8">
                <?php
                wp_list_comments([
                    'style' => 'div',
                    'avatar_size' => 40,
                    'short_ping' => true,
                    'callback' => 'arash_comment_callback',
                ]);
                ?>
            </div>

            <?php
            $pagination = paginate_comments_links([
                'echo' => false,
                'type' => 'array',
            ]);
            if ($pagination):
                ?>
                <nav class="flex items-center justify-center gap-2 text-sm mt-6" aria-label="پیوست نظرات">
                    <?php foreach ($pagination as $link): ?>
                        <span class="inline-flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-700 px-3 py-1 text-zinc-600 dark:text-zinc-300 hover:border-red-400 hover:text-red-500 dark:hover:border-red-400 dark:hover:text-red-400 transition">
                            <?php echo wp_kses_post($link); ?>
                        </span>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!comments_open() && $comment_count > 0): ?>
            <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">
                بخش نظرات برای این محتوا بسته شده است.
            </p>
        <?php endif; ?>

        <?php if (comments_open()): ?>
            <div class="mt-10 mx-auto">
                <?php
                $current_post_type = get_post_type();
                $options = arash_get_theme_options();
                $rating_enabled = !empty($options['blog_comment_rating_enabled']) && $current_post_type === 'post';

                $fields = [
                    'author' =>
                        '<div class="grid sm:grid-cols-2 gap-4"><p class="comment-form-author">' .
                        '<label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1" for="author">نام</label> ' .
                        '<input id="author" name="author" type="text" class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-red-500" /></p>',
                    'email'  =>
                        '<p class="comment-form-email">' .
                        '<label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1" for="email">ایمیل</label> ' .
                        '<input id="email" name="email" type="email" class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-red-500" /></p></div>',
                ];

                $comment_field =
                    '<p class="comment-form-comment mt-4">' .
                    '<label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1" for="comment">متن نظر</label>' .
                    '<textarea id="comment" name="comment" rows="4" class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>' .
                    '</p>';

                if ($rating_enabled) {
                    $comment_field .=
                        '<p class="comment-form-rating mt-4">' .
                        '<label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-1" for="rating">امتیاز شما به این مطلب</label>' .
                        '<select id="rating" name="rating" class="w-40 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-red-500">' .
                        '<option value="5">۵ - عالی</option>' .
                        '<option value="4">۴ - خوب</option>' .
                        '<option value="3">۳ - معمولی</option>' .
                        '<option value="2">۲ - ضعیف</option>' .
                        '<option value="1">۱ - خیلی ضعیف</option>' .
                        '</select>' .
                        '</p>';
                }

                comment_form([
                    'fields' => $fields,
                    'comment_field' => $comment_field,
                    'class_submit' => 'inline-flex items-center rounded-full bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-zinc-100 shadow-sm hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200 transition mt-4',
                    'submit_field' => '<p class="form-submit mt-6">%1$s %2$s</p>',
                    'title_reply' => 'ارسال نظر',
                    'title_reply_before' => '<h3 id="reply-title" class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-4">',
                    'title_reply_after' => '</h3>',
                    'comment_notes_before' => '',
                    'comment_notes_after' => '',
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

