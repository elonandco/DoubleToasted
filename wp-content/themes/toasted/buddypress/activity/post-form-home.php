<?php

/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php 

	// Handles when and how the post update form should show by Pound
		
	$objectinput = false;
		
	if ( bp_is_group() ) {
	
		$objectinput = '<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups">';
		$postinput = '<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="' . bp_get_group_id() . '">';
		
		$postlink = '<a class="activity-greeting dt-usr-home-compose">Share something with the group.</a>';
		$sayhi = 'Share something';
		$showpost = true;

	}
	
	else if( !bp_is_home() && bp_is_user() ) {
	
		//$friend_status = friends_check_friendship_status( bp_loggedin_user_id(), bp_displayed_user_id() );	
		
		//if ( $friend_status == 'is_friend' ) {

			$bpusername = bp_members_get_user_nicename(bp_displayed_user_id());
			$postlink = '<a class="activity-greeting dt-usr-wall-post" user="' . $bpusername . '">Share something on their wall</a>';
			$sayhi = 'Say hi';
			$showpost = true;
			
		//}
		
	}
	
	else {

		global $bp;
		$scope = $bp->current_action;
		$ishome = bp_is_home();
		
		if ($scope == 'mentions' && $ishome ) {	
		
		}
		
		else {
		
			$postlink = '<a class="activity-greeting dt-usr-home-compose">Click here to share something</a>';
			$sayhi = 'Share something';
			$showpost = true;
		
		}
	
	} 
	
if ($showpost) : ?>

	<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form-home" name="whats-new-form" role="complementary">
	
		<?php echo $postlink; ?>
	
		<?php do_action( 'bp_before_activity_post_form' ); ?>
	
		<div id="home-post-update" class="">
		
			<div id="whats-new-textarea2">
			
				<p id="usr-post-hd"><?php echo $sayhi; ?></p>
				<button type="button" class="rtmedia-add-media-button" id="rtmedia-add-media-button-post-update" style="z-index: 1;"><i class="rtmicon-plus-circle"></i>Attach Files</button>
			
				<textarea name="whats-new" id="whats-new" cols="50" rows="10"><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_attr( $_GET['r'] ); ?> <?php endif; ?></textarea>
		
			</div>
	
			<div id="whats-new-submit2" class="fl-right">
			
				<?php if ($objectinput) { echo $objectinput; echo $postinput; } ?>
			
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" class="dt-bp-button-home" value="<?php _e( 'Share', 'buddypress' ); ?>" />
			
			</div>
				
			<?php if (bp_is_home() && $showpost) : ?>
	
					<div id="whats-new-options">
			
						<div class="fl-right">
						
							<?php if ( !bp_is_group() ) : ?>
				
								<div id="whats-new-post-in-box">
				
									<select id="whats-new-post-in" name="whats-new-post-in">
										<option selected="selected" value="0"><?php _e( 'In: Your activity feed.', 'buddypress' ); ?></option>
				
										<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0' ) ) :
											while ( bp_groups() ) : bp_the_group(); ?>
				
												<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>
				
											<?php endwhile;
										endif; ?>
				
									</select>
								</div>
								<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				
							<?php elseif ( bp_is_group_home() ) : ?>
				
								<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
								<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />
				
							<?php endif; ?>
				
							<?php do_action( 'bp_activity_post_form_options' ); ?>
							
						</div>
			
					</div><!-- #whats-new-options -->
			
			<?php endif; ?>
			
		</div><!-- #whats-new-content -->
		
		<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
		<?php do_action( 'bp_after_activity_post_form' ); ?>
	
	</form><!-- #whats-new-form -->

<?php endif; ?>