<?php

/*
Modified loop to be able to handle search results for task (custom post type)
as well as users.

Expects extra GET parameters to be set along with just ?s, e.g.:
http://dev.passioeducation.com/?s&post_type=user

Parameters ($_GET):
----------
	- same as listed here: https://codex.wordpress.org/Class_Reference/WP_Query#Parameters
	- post_type [required] : either user or task


Helpful documentation:
https://codex.wordpress.org/Class_Reference/WP_Query
https://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query
https://digwp.com/2011/05/loops/

*/
?>

<?php

// NOTE: only users with filled out profiles (meta) will be displayed here
if ($_GET['post_type'] == 'user') {
	// The Query
	$user_query = get_users( ); ?>


    <?php if (!current_user_can('publish_posts') ) {
        echo '<p class="lead">You must login and have \'Client\' capabilities to view this area.</p>';
        return;
    } 
    ?>

	<h1><?php echo sprintf( __( '%s User Results ', 'html5blank' ), count($user_query) ); ?></h1>

	<?php
	// User Loop
	if ( ! empty( $user_query ) ) {
		foreach ( $user_query as $user ) { ?>
			<?php $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user->ID ) ); ?>

			<!-- article -->
			<article id="user-<?php echo $user->ID; ?>">

				<h2>
				<a href="<?php echo esc_url( get_author_posts_url( $user->ID )); ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a>
				</h2>
				<p> <?php echo $user_meta['description']; ?> </p>
			</article>
			<!-- /article -->

		<?php }
	} else {
		echo 'No users found.';
	}
} else if ($_GET['post_type'] == 'task') {

	global $current_user;

	// build a custom query for just 'task' type
	$args = array(
		'post_type' => $_GET['post_type'],
	);

	if ( isset ( $_GET['author'] ) ) {
		$args['post_status'] = array('publish', 'pending');
		$args['author'] = $_GET['author'];
	}
	if ( isset ( $_GET['s'] ) && $_GET['s'] != '' ) {
		$args['s'] = $_GET['s'];
	}


	$q = new WP_Query( $args );?>

	<h1><?php echo sprintf( __( '%s Task Results', 'html5blank' ), $q->found_posts ); ?></h1>

	<?php if ($q->have_posts()): while ($q->have_posts()) : $q->the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- post title -->
			<h2>
				<a href="<?php the_permalink(); ?>?action=view" title="<?php the_title(); ?>">
                <?php 
                $post_meta = get_post_meta( $post->ID );
                if (isset($post_meta['hired'][0])) {
                    echo '<i class="fa fa-user" aria-hidden="true"></i> ';
                } else if ($post->post_status == 'pending') {
                    echo '<i class="fa fa-trash-o" aria-hidden="true"></i> ';
                } 
               the_title(); ?>
                </a>
				<?php if (get_the_author_meta('ID') == $current_user->ID) {
					echo sprintf('<a href="/create-task/?task_id=%s" role="button" type="button" class="btn btn-info"><i class="fa fa-gear fa-lg"></i> Edit</a>', $post->ID);
				} ?>
			</h2>
			<!-- /post title -->


			<!-- post details -->
			<span class="date"><?php the_time('F j, Y'); ?> </span>
			<!-- /post details -->

			<?php edit_post_link(); ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>
	<?php endif;
} ?>
