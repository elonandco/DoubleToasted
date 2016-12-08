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

<div class="large-2 medium-2 columns usr-profile-header">

	<div id="item-header-avatar" class="rounded">
	
		<a href="<?php bp_displayed_user_link(); ?>">
	
			<?php bp_displayed_user_avatar( 'type=full' ); ?>
	
		</a>
	
	</div><!-- #item-header-avatar -->
	
	<div id="item-buttons">
	
		<?php /* do_action( 'bp_member_header_actions' ); */ ?>
	
	</div><!-- #item-buttons -->
	
	<?php $bpusername = bp_members_get_user_nicename(bp_displayed_user_id()); ?>

	<?php
	
		if (!$ismine) {
		
			echo kleo_get_online_status( bp_displayed_user_id() );			
			echo '<a class="dt-usr-btn dt-btn-dkblue" href="' . bp_get_send_private_message_link() . '">Message</a>';
			
			?>
	
		<?php
		
			bp_add_friend_button( $potential_friend_id = 0, $friend_status = false );
					
		}
		
		else { 
		
			?>
		
				<a class="dt-usr-btn dt-btn-orange" href="/members/<?php echo $bpusername; ?>/">My Friend Feed</a>
				<a class="dt-usr-btn dt-btn-dkblue" href="/members/<?php echo $bpusername; ?>/activity/groups/">My Group Feed</a>
				<a class="dt-usr-btn dt-btn-blue" href="/members/<?php echo $bpusername; ?>/activity/mentions/">My Wall</a>
				
				
				<ul class="listless dt-usr-sidenav">
					<li><h4>Messages</h4></li>
					<li><a href="/members/<?php echo $bpusername; ?>/messages/compose">Compose</a></li>
					<li><a href="/members/<?php echo $bpusername; ?>/messages/">Inbox</a></li>
					<li><a href="/members/<?php echo $bpusername; ?>/messages/sentbox">Sent</a></li>
				</ul>
				
				<ul class="listless dt-usr-sidenav">
					<li><h4>Notifications</h4></li>
					<li><a href="/members/<?php echo $bpusername; ?>/notifications/">Unread</a></li>
					<li><a href="/members/<?php echo $bpusername; ?>/notifications/read/">Read</a></li>
				</ul>	
		
		<?php
		
		}
		
	?>
	
</div>

<div class="large-10 medium-10 columns<?php if ($ismine) { echo ' is-usr-home'; } ?> dt-new-group-list-switch">

	<div class="large-12 columns">

	<div id="item-header-content" <?php if (isset($_COOKIE['bp-profile-header']) && $_COOKIE['bp-profile-header'] == 'small') {echo 'style="display:none;"';} ?>>
	
		<?php 
		
			if ($ismine) { 

			
				if(bp_current_action() == 'just-me') {
				
					echo '<h4 class="usr-feed-title"><strong>Friend</strong> Activity Feed</h4>';
					
				}
				
				else if (bp_current_action() == 'groups') {
			
					echo '<h4 class="usr-feed-title"><strong>Group</strong> Activity Feed</h4>';
					
				}
				
				else if (bp_current_action() == 'mentions') {
				
					echo '<h4 class="usr-feed-title"><strong>Wall</strong></h4>';
				
				}
				
				else { ?>
				
					<h4 class="user-nicename dt-orange"><a id="user-profile" href="/members/<?php echo $bpusername; ?>/" style="font-weight:bold;text-decoration:none;"><?php echo $bpusername; ?></a></h4>
				
				
				<?php
				
				}
		
			 } 
			 
			 else { 
			 
			 ?>
		
			<h4 class="user-nicename dt-orange"><a id="user-profile" href="/members/<?php echo $bpusername; ?>/" style="font-weight:bold;text-decoration:none;"><?php echo $bpusername; ?></a></h4>
		
		<?php } ?>
	
		<div id="item-meta">
	
			<?php do_action( 'bp_before_member_header_meta' ); ?>
	
			<?php do_action( 'bp_after_member_header' ); ?>	
	
			<div id="item-nav" class="clear">
			
				  <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
			
					<ul class="responsive-tabs listless" id="user-nav">
					
						 <?php bp_get_displayed_user_nav(); ?>
					  
					</ul>
					
					<div id="dt-object-two" class="fl-right">
						<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>					
					</div>
			
				  </div>
			
			</div><!-- #item-nav -->

			<div id="bp-message">
			
				<?php do_action( 'template_notices' ); ?>
					  
			</div>
	
	</div>
	
	</div>
	
	</div>