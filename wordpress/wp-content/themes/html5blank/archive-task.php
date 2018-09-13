<?php get_header();
$slug = ucwords(str_replace('/','',$_SERVER["REQUEST_URI"]));
// this page is called when visiting the slug /tasks/
?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php _e( $slug, 'html5blank' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
