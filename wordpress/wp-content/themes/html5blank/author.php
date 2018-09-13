<?php get_header(); ?>

<?php $author = get_user_by( 'slug', get_query_var( 'author_name' ) ); ?>

	<main role="main">
		<!-- section -->
		<section>

			<!-- article -->
			<article>
				<?php yti_user_form($user_id=$author->ID); // function is defined in you-task-it.php (plugin file) ?>
			</article>
			<!-- /article -->

		</section>
		<!-- /section -->
	</main>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
