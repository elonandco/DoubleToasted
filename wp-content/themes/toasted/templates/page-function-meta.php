<?php
/**
 * @package Frank
 */
/*
Template Name: Update Meta
*/
?>

<?php get_header(); ?>

<div class="main single on-air show-simple-comments">
	
<?php

	$message = "Hey Mike,\r\n\r\nWe just updated the database with updates reply and favorite counts:\r\n\r\n";

	// Get all activities in the last month (includes bumped activities)
	global $wpdb;
	$last_month = date( 'Y-m-d', strtotime("3 months ago") );

	$sql = 'SELECT id
			FROM wp_bp_activity
			WHERE type <> "last_activity"
			AND date_recorded > "'.$last_month.'"';

	$activities = $wpdb->get_results( $sql, ARRAY_N );

	foreach ($activities as $activity) {

		// Get favorite count thru BP Meta
		$fav_count = bp_activity_get_meta( $activity[0], 'favorite_count' );

		// Important to reset to 0 in case users have "un-favorited"
		if (!$fav_count >= 1) 
			$fav_count = 0;

		// Store the new count in WP Post Meta
		$update_fav_count = update_post_meta($activity[0], 'dt_post_favorite_count', $fav_count);

		// Find activity comments and count them
		$activity_comments = $wpdb->get_results( 'SELECT id FROM wp_bp_activity WHERE secondary_item_id = '.$activity[0], ARRAY_N ); // parent id is stored in secondary_item_id
		$comment_count = count($activity_comments);

		// Update WP Post Meta w/ the new reply count
		update_post_meta( $activity[0], 'dt_reply_count', $comment_count );

		// Add ID to our email
		$message .= $activity[0].', ';
		
	}

	// Send myself an email to confirm cron is running
	wp_mail( 'mikelacourse@gmail.com', 'Updated Toasted Activity Meta', 'Automatic scheduled email from WordPress. Updated: '.$message);

?>
</div><!-- .single.main -->

<?php wp_enqueue_script( 'dt-owl-script', get_template_directory_uri() . '/modules/scripts/carousel/owl.carousel.min.js', 'pound-basic-scripts-0507', '1.0.0', true ); ?>

<?php get_footer(); ?>