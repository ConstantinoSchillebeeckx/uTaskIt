<?php
/**
 * Template Name: Task profile
 *
 * @package WordPress
 */
?>


<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php yti_task_form(); // function is defined in you-task-it.php (plugin file) ?>
			</article>
			<!-- /article -->

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
