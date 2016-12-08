<?php

/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<div class="large-12 columns">
<div class="item-list-tabs profile-subn no-ajax" id="subnav" role="navigation">
	<ul class="listless fl-right">
	
		<?php $bpusername = bp_members_get_user_nicename(bp_displayed_user_id()); ?>
		<!-- <li id="public-personal-li"><a id="public" href="/members/<?php echo $bpusername; ?>/profile/">Profile</a></li> -->
		
		<li id="public-personal-li"><a id="public" href="/members/<?php echo $bpusername; ?>/profile/?updates=just-me">Updates</a></li>
		<li id="public-personal-li"><a id="public" href="/members/<?php echo $bpusername; ?>/profile/?updates=favorites">Toasted</a></li>
				
		<?php

			if ( is_user_logged_in() && bp_is_home() ) {
			
				?>

				<li id="edit-personal-li"><a id="edit" href="/members/<?php echo $bpusername; ?>/profile/edit/">Edit Profile</a></li>
				<li id="change-avatar-personal-li"><a id="change-avatar" href="/members/<?php echo $bpusername; ?>/profile/change-avatar/">Change Avatar</a></li>

				<?php

			}

		?>				
				
	</ul>
</div><!-- .item-list-tabs -->

<?php if ($_GET['updates']) { ?>

	<div class="activity large-12 columns" role="main">
	
		<?php do_action( 'bp_before_activity_loop' ); ?>

		<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) . '&scope=' . $_GET['updates'] . '&action=activity_update,rtmedia_update,created_group,new_blog_post,bbp_reply_create,bbp_topic_create' ) ) : ?>
		
			<?php /* Show pagination if JS is not enabled, since the "Load More" link will do nothing */ ?>
			<noscript>
				<div class="pagination">
					<div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
					<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
				</div>
			</noscript>
		
			<?php if ( empty( $_POST['page'] ) ) : ?>
		
				<ul id="activity-stream" class="activity-list item-list listless">
		
			<?php endif; ?>
		
			<?php while ( bp_activities() ) : bp_the_activity(); ?>
		
				<?php bp_get_template_part( 'activity/entry' ); ?>
		
			<?php endwhile; ?>
		
			<?php if ( bp_activity_has_more_items() && bp_activities() ) : ?>
		
				<li class="load-more large-12 columns">
					<a href="#more"><?php _e( 'Load More', 'buddypress' ); ?></a>
				</li>
		
			<?php endif; ?>
		
			<?php if ( empty( $_POST['page'] ) ) : ?>
		
				</ul>
		
			<?php endif; ?>
		
			<?php else : ?>
			
				<div id="message" class="info">
					<p><?php _e( '<h3>Nothing yet. Womp womp.', 'buddypress' ); ?></p>
				</div>
			
			<?php endif; ?>
		
		<?php do_action( 'bp_after_activity_loop' ); ?>
		
		<form action="" name="activity-loop-form" id="activity-loop-form" method="post">
		
			<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>
		
		</form>

	</div><!-- .activity -->

<? } else { ?>

<?php do_action( 'bp_before_profile_content' ); ?>

<div class="profile" role="main">

<?php switch ( bp_current_action() ) :

	// Edit
	case 'edit'   :
		bp_get_template_part( 'members/single/profile/edit' );
		break;

	// Change Avatar
	case 'change-avatar' :
		bp_get_template_part( 'members/single/profile/change-avatar' );
		break;

	// Compose
	case 'public' :

		// Display XProfile
		if ( bp_is_active( 'xprofile' ) )
			bp_get_template_part( 'members/single/profile/profile-loop' );

		// Display WordPress profile (fallback)
		else
			bp_get_template_part( 'members/single/profile/profile-wp' );

		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch; ?>
</div><!-- .profile -->

<?php do_action( 'bp_after_profile_content' ); ?>

<?php } ?>
</div>