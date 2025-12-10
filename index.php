



<?php get_header() ?>

<main class="flex-1 px-4 sm:px-8 mt-12">
    <header class="max-w-3xl">
        <h1 class="text-2xl font-semibold tracking-tight sm:text-2xl text-black dark:text-zinc-100">
            Everything & a Little More
        </h1>

        <p class="mt-6 text-base text-zinc-600 dark:text-zinc-400">
            A place to keep the things that occupy my mind — from technical experiences and work lessons to my takeaways from books, the music I love, and thoughts I want to record.
        </p>
    </header>

    <!-- Notes -->
    <div class="mt-24 grid gap-16 lg:grid-cols-2">


        <?php


        if ( have_posts() ) :
            while ( have_posts() ):
               the_post();


                ?>
                <article class="group">
                    <h2 class="text-lg font-semibold"><a href="<?php the_permalink();?>" class="hover:text-red-500 dark:hover:text-red-400"><?php the_title()?></a></h2>
                    <time class="text-sm text-zinc-500"><?php the_date()?></time>
                    <p class="mt-2 text-zinc-600 dark:text-zinc-400"><?php the_excerpt();?></p>
                </article>



            <?php

            endwhile;
        endif;
        ?>

    </div>
</main>




<?php get_footer()?>
