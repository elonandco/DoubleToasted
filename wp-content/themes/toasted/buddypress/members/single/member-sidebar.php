<?php

/**
 * BuddyPress - Profile Sidebar
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

	// Custom functions 
	// - defined in buddypress-functions.php
	$user_id = bp_displayed_user_id();
	
	// Users Standard Profile Info
	user_info_profile($user_id);

	// Users Fan Art/Photos
	user_recent_rt_images($user_id);

	// Users Recent Articles
	user_recent_articles($user_id);

	// User Favorite Posts
	user_recent_favorites($user_id);

?>