<?php
/**
 * @package Frank
 */
/*
Template Name: Delete Spam Users
*/
?>

<?php get_header(); ?>

<div class="main single on-air show-simple-comments">
	<div class="content">
	<div class="large-12 columns" style="padding-bottom:50px;">
	
<?php

if ( have_posts() ) {
	while ( have_posts() ) {

		// Setup the post
		the_post(); 
		$users_to_delete = get_the_content();

		echo '<h1>Delete Users En Masse</h1>';

		if ( !empty($users_to_delete) ) {

			$message = "We just updated the database and removed these users:\r\n\r\n";

			// Get all activities in the last month (includes bumped activities)
			global $wpdb;
			require_once(ABSPATH.'wp-admin/includes/user.php' );

			$user_type 		= "slug"; // 'id' or 'slug'
			$users_array 	= explode(",", $users_to_delete);

			foreach ($users_array as $user ) {

				// Reset comment count
				$i = 0;

				// get user id
				$user_data = get_user_by( $user_type, $user );

				if ($user_data) {

					$sql = 'SELECT comment_ID
							FROM wp_comments
							WHERE user_id = "'.$user_data->data->ID.'"';

					

					$comments_to_delete = $wpdb->get_results( $sql, ARRAY_N );

					if ($comments_to_delete) {
						foreach ($comments_to_delete as $comment ) {
							wp_delete_comment($comment[0]);
							$i++;

						}
					}

					// delete user
					wp_delete_user( $user_data->data->ID );

					echo '<p>User #'.$id.' ('.$user.') and '.$i.' comments have been deleted.</p>';

				}

				else {

					echo '<p>User '.$user.' has already been deleted.</p>';

				}

			}
		} // end if the_content is empty

	} // end while
} // end if



?>

	</div></div></div>

<?php get_footer(); ?>