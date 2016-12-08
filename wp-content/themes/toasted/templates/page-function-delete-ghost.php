<?php
/**
 * @package Frank
 */
/*
Template Name: Delete Ghost Users
*/
?>

<?php get_header(); ?>

<div class="main single on-air show-simple-comments">
	<div class="content">
	<div class="large-12 columns" style="padding-bottom:50px;">
	
<?php


/**
 * Remove user and optionally reassign posts and links to another user.
 *
 * If the $reassign parameter is not assigned to a User ID, then all posts will
 * be deleted of that user. The action 'delete_user' that is passed the User ID
 * being deleted will be run after the posts are either reassigned or deleted.
 * The user meta will also be deleted that are for that User ID.
 *
 * @since 2.0.0
 *
 * @param int $id User ID.
 * @param int $reassign Optional. Reassign posts and links to new User ID.
 * @return bool True when finished.
 */

global $wpdb;

$id = 9146;
$reassign = null;

do_action( 'delete_user', $id, $reassign );

echo 'made it here'; 

if ( null === $reassign ) {
	$post_types_to_delete = array();
	foreach ( get_post_types( array(), 'objects' ) as $post_type ) {
		if ( $post_type->delete_with_user ) {
			$post_types_to_delete[] = $post_type->name;
		} elseif ( null === $post_type->delete_with_user && post_type_supports( $post_type->name, 'author' ) ) {
			$post_types_to_delete[] = $post_type->name;
		}
	}

	echo 'made it here too'; 


	/**
	 * Filter the list of post types to delete with a user.
	 *
	 * @since 3.4.0
	 *
	 * @param array $post_types_to_delete Post types to delete.
	 * @param int   $id                   User ID.
	 */
	$post_types_to_delete = apply_filters( 'post_types_to_delete_with_user', $post_types_to_delete, $id );
	$post_types_to_delete = implode( "', '", $post_types_to_delete );
	$post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_author = %d AND post_type IN ('$post_types_to_delete')", $id ) );
	if ( $post_ids ) {
		foreach ( $post_ids as $post_id )
			wp_delete_post( $post_id );
	}

	echo 'made it here 4'; 


	// Clean links
	$link_ids = $wpdb->get_col( $wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_owner = %d", $id) );

	if ( $link_ids ) {
		foreach ( $link_ids as $link_id )
			wp_delete_link($link_id);
	}
} else {
	$post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_author = %d", $id ) );
	$wpdb->update( $wpdb->posts, array('post_author' => $reassign), array('post_author' => $id) );
	if ( ! empty( $post_ids ) ) {
		foreach ( $post_ids as $post_id )
			clean_post_cache( $post_id );
	}
	$link_ids = $wpdb->get_col( $wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_owner = %d", $id) );
	$wpdb->update( $wpdb->links, array('link_owner' => $reassign), array('link_owner' => $id) );
	if ( ! empty( $link_ids ) ) {
		foreach ( $link_ids as $link_id )
			clean_bookmark_cache( $link_id );
	}
}

echo 'made it here 5'; 

// FINALLY, delete user
if ( is_multisite() ) {
	remove_user_from_blog( $id, get_current_blog_id() );
} else {
	$meta = $wpdb->get_col( $wpdb->prepare( "SELECT umeta_id FROM $wpdb->usermeta WHERE user_id = %d", $id ) );
	foreach ( $meta as $mid )
		delete_metadata_by_mid( 'user', $mid );

	$wpdb->delete( $wpdb->users, array( 'ID' => $id ) );
}

echo 'made it here 6'; 

// assuming the cache has been cleared and this is not an issue
//clean_user_cache( $user );

echo 'made it here 7'; 

/**
 * Fires immediately after a user is deleted from the database.
 *
 * @since 2.9.0
 *
 * @param int      $id       ID of the deleted user.
 * @param int|null $reassign ID of the user to reassign posts and links to.
 *                           Default null, for no reassignment.
 */
do_action( 'deleted_user', $id, $reassign );

echo 'made it here 8'; 

// if ( have_posts() ) {
// 	while ( have_posts() ) {

// 		// Setup the post
// 		the_post(); 
// 		$users_to_delete = get_the_content();

// 		echo '<h1>Delete Users En Masse</h1>';

// 		if ( !empty($users_to_delete) ) {

// 			$message = "We just updated the database and removed these users:\r\n\r\n";

// 			// Get all activities in the last month (includes bumped activities)
// 			global $wpdb;
// 			require_once(ABSPATH.'wp-admin/includes/user.php' );

// 			$user_type 		= "slug"; // 'id' or 'slug'
// 			$users_array 	= explode(",", $users_to_delete);

// 			foreach ($users_array as $user ) {

// 				// Reset comment count
// 				$i = 0;

// 				// get user id
// 				$user_data = get_user_by( $user_type, $user );

// 				if ($user_data) {

// 					$sql = 'SELECT comment_ID
// 							FROM wp_comments
// 							WHERE user_id = "'.$user_data->data->ID.'"';

					

// 					$comments_to_delete = $wpdb->get_results( $sql, ARRAY_N );

// 					if ($comments_to_delete) {
// 						foreach ($comments_to_delete as $comment ) {
// 							wp_delete_comment($comment[0]);
// 							$i++;

// 						}
// 					}

// 					// delete user
// 					wp_delete_user( $user_data->data->ID );

// 					echo '<p>User #'.$id.' ('.$user.') and '.$i.' comments have been deleted.</p>';

// 				}

// 				else {

// 					echo '<p>User '.$user.' has already been deleted.</p>';

// 				}

// 			}
// 		} // end if the_content is empty

// 	} // end while
// } // end if


// echo '<h1>Send Mike Some IPs</h1>';

// $ips = 'SELECT meta_value
// 		FROM wp_usermeta
// 		WHERE meta_key = "signup_ip"
// 		LIMIT 500';

// global $wpdb;
// $ip_ads = $wpdb->get_results( $ips, ARRAY_N );
// natsort($ip_ads);

// var_dump($ip_ads);

// foreach($ips as $ip) {


// }


?>

	</div></div></div>

<?php get_footer(); ?>