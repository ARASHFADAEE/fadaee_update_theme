<?php get_header()?>
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-8 mt-12">
        <div class="mx-auto max-w-2xl lg:max-w-5xl">

            <!-- Avatar near content -->
            <a href="/" class="block h-16 w-16 origin-left transition-transform hover:scale-105 mb-4 relative">
                <img src="<?php echo THEME_URL?>/assets/img/arashfadaee-640.BGHMnvoM.webp" class="h-16 w-16 rounded-full object-cover shadow-lg ring-4 ring-white/90 dark:ring-zinc-700" />
            </a>

            <h1 class="text-4xl font-black tracking-tight">Senior Web Developer & PHP Specialist</h1>
            <p class="mt-6 text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                Hi, I'm Arash Fadaei. I have many years of experience in web and PHP development, and I work on professional projects with a focus on minimal design and high performance.         </p>

            <!-- Social -->
            <div class="mt-8 flex gap-6">
                <a href="#" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                    <svg class="h-6 w-6" fill="currentColor"><path d="M12 2..."/></svg>
                </a>
            </div>

            <!-- Photo Gallery -->
            <div class="mt-20 overflow-hidden py-4">
                <div class="scroll-container gap-5 sm:gap-8">
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/1761889367151.jpeg" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                    <div class="photo-item w-44 sm:w-72 flex-none"><img src="<?php echo THEME_URL?>/assets/img/image-2.webp" class="photo-tilt aspect-9/10 w-full rounded-2xl object-cover shadow-lg sm:shadow-2xl" /></div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mt-24 grid gap-16 lg:grid-cols-2">
                <?php
                $the_query=new WP_Query(array(
                        'post_type'=>'post',
                         'post_status'=>'publish',
                          'posts_per_page'=>'4',
                ));

                if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ):
                $the_query->the_post();


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

        </div>
    </main>



<?php get_footer(); ?>