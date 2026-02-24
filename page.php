<?php get_header(); ?>

<?php
$page_id = get_queried_object_id();
$is_elementor_page = function_exists('arash_is_elementor_built') ? arash_is_elementor_built($page_id) : false;
?>

<?php if ($is_elementor_page): ?>
	<main class="flex-1">
		<?php
		if (have_posts()) :
			while (have_posts()) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</main>
<?php else: ?>
	<main class="mx-auto flex-1 pt-12 sm:pt-24 pb-16 sm:pb-32 px-4 sm:px-8">
		<div class="mx-auto max-w-2xl lg:max-w-5xl article-content content">
			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>
		</div>
	</main>
<?php endif; ?>

<?php get_footer(); ?>
