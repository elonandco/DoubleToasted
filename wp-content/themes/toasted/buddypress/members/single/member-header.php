<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>

<?php $ismine = bp_is_my_profile(); ?>
<?php $user_id = bp_displayed_user_id(); ?>

<?php if ($ismine) : ?>

<div class="dt-member-edit-actions">

	<ul class="listless">

		<li><a class="edit" href="<?php echo bp_loggedin_user_domain(); ?>profile/edit/group/1/">Edit Profile</a></li>
		<li><a class="change-avatar" href="<?php echo bp_loggedin_user_domain(); ?>profile/change-avatar/">Change Avatar</a></li>
		<li><a class="change-cover" href="<?php echo bp_loggedin_user_domain(); ?>profile/change-cover/">Change Cover Photo</a></li>
		<li><a class="general" href="<?php echo bp_loggedin_user_domain(); ?>settings/">Subscription/Account Settings</a></li>
		<li><a class="notifications" href="<?php echo bp_loggedin_user_domain(); ?>settings/notifications/">Email Settings</a></li>

	</ul>

</div>

<?php endif; ?>

<div>

		<div id="item-header">

			<div class="dt-usr-cover-overlay"></div>

			<div class="usr-profile-header large-12 columns">

				<div class="dt-user-profile-actions fl-right">
				<?php

					// Friend/Status Actions
					if (!$ismine) {
					
						bp_add_friend_button( $potential_friend_id = 0, $friend_status = false );			
						echo '<a class="dt-usr-btn dt-btn-dkblue" href="' . bp_get_send_private_message_link() . '">Message</a>';
						echo kleo_get_online_status( bp_displayed_user_id() );

														
					}
					
				?>
				</div>
				
				<div id="item-buttons"><?php /* do_action( 'bp_member_header_actions' ); */ ?></div><!-- #item-buttons -->
				
				<div class="dt-member-info">

					<div id="item-header-avatar" class="rounded fl-left">
						<a href="<?php bp_displayed_user_link(); ?>"><?php echo bp_core_fetch_avatar( array( 'item_id' => $user_id, 'type' => 'full' ) ); ?></a>
					</div><!-- #item-header-avatar -->

					<div class="dt-user-names">
						<p class="user-nicename">
							<?php echo bp_get_displayed_user_fullname($user_id); ?><br />
							<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
								<span class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></span>
							<?php endif; ?>
							<p class="dt-user-follow">Following <?php echo bp_get_total_friend_count( $user_id ); ?> friends</p>
							<p class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></p>	
						</p>
					</div>

				</div>
							
			</div>

		</div>

		<div id="item-header-content" <?php if (isset($_COOKIE['bp-profile-header']) && $_COOKIE['bp-profile-header'] == 'small') {echo 'style="display:none;"';} ?>>
		
			<div class="user-profile-nav" id="item-meta">
		
				<?php do_action( 'bp_before_member_header_meta' ); ?>
		
				<?php do_action( 'bp_after_member_header' ); ?>	
		
				<div id="item-nav" class="clear">
				
					  <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
				
						<ul class="responsive-tabs listless" id="user-nav">
						
							 <?php bp_get_displayed_user_nav(); ?>
						  
						</ul>
				
					  </div>
				
				</div><!-- #item-nav -->
		
			</div>
		
		</div>

</div>