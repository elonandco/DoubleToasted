<?php

/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_member_activity_content' ); ?>

<div style="padding-top:20px;">

<div class="activity large-4 medium-4 columns" role="main">

	<?php bp_get_template_part( 'members/single/member-sidebar' ); ?>

</div>

<?php do_action( 'bp_before_member_activity_post_form' ); ?>

<div class="activity large-8 medium-8 columns" role="main">

	<?php if ( !bp_is_my_profile() ) : ?>
		<h3 style="margin-bottom:0px;padding-bottom:10px;">Shoutout Wall</h3>

		<?php if ( is_user_logged_in() ) : ?>
			<div class="animate-post"><?php bp_get_template_part( 'activity/post-form-home' ); ?></div>
		<?php endif; ?>

	<?php else: ?>
		<h3 style="margin-bottom:5px;padding-bottom:15px;border-bottom:1px dashed #ccc;">Your Wall</h3>
	<?php endif; ?>

	<?php bp_get_template_part( 'members/activity/activity-loop-mentions' ); ?>

</div><!-- .activity -->

<?php do_action( 'bp_after_member_activity_post_form' ); ?>

<div class="activity large-8 medium-8 columns" role="main">

	<?php if ( is_user_logged_in() && bp_is_my_profile() ) : ?>
		<h3 style="margin-bottom:20px;margin-top:20px;" class="animate-post">Your Activity</h3>
		<div id="dt-profile-mid-update animate-post" style="margin-top:0px;"><?php bp_get_template_part( 'activity/post-form-home' ); ?></div>
	<?php else: ?>
		<h3 style="margin-bottom:10px;margin-top:15px;padding-bottom:15px;border-bottom:1px dashed #ccc;" class="animate-post">Recent Activity</h3>
	<?php endif; ?>

	<?php bp_get_template_part( 'members/activity/activity-loop' ); ?>

</div><!-- .activity -->

<?php do_action( 'bp_after_member_activity_content' ); ?>

</div>