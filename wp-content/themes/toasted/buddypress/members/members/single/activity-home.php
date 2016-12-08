<?php

/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_member_activity_post_form' ); ?>

<?php

// Modified below to show post updates on wall feature
// if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) )
// 	bp_get_template_part( 'activity/post-form-home' );

// if (!bp_is_my_profile()) {
// 	
// 	$about = bp_get_profile_field_data( 'field=About Me' );
// 	
// 	if ($about) {
// 		echo '<div class="dt-usr-mini-profile"><p>' . $about . ' <a href="#!">View Full Profile</a></p></div>';
// 	}
// 	
// }

if ( is_user_logged_in() )
	bp_get_template_part( 'activity/post-form-home' );

do_action( 'bp_after_member_activity_post_form' );

do_action( 'bp_before_member_activity_content' ); ?>

<div class="activity large-12 columns" role="main">

	<?php bp_get_template_part( 'activity/activity-loop-dash' ) ?>

</div><!-- .activity -->

<?php do_action( 'bp_after_member_activity_content' ); ?>
