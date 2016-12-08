<?php

/**
 * BuddyPress - Activity Stream Comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
		<li id="acomment-<?php bp_activity_comment_id(); ?>">
		
			<?php if ( bp_activity_user_can_delete() ) : ?>
				
				<div class="acomment-options">
		
					 <a href="<?php bp_activity_comment_delete_link(); ?>" class="dt-side-com-del icon-cancel delete acomment-delete confirm bp-secondary-action" rel="nofollow"></a>
		
				</div>
		
			<?php endif; ?>
		
			<div class="acomment-content">
				<p class="bp-activity-comment"><a href="<?php echo bp_get_activity_comment_user_link(); ?>"><?php  echo bp_get_activity_comment_name(); ?></a></p>
				<div class="comment-guts"><?php bp_activity_comment_content(); ?></div>
			</div>
		

				<?php do_action( 'bp_activity_comment_options' ); ?>
		
			<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
		</li>

<?php } else { ?>

	<li id="acomment-<?php bp_activity_comment_id(); ?>">
	
		<div class="acomment-content">
			<p class="bp-activity-comment"><a href="<?php echo bp_get_activity_comment_user_link(); ?>"><?php  echo bp_get_activity_comment_name(); ?> </a><?php bp_activity_comment_content(); ?></p>
		</div>
	
			<?php if ( bp_activity_user_can_delete() ) : ?>
			
					<div class="acomment-options">
	
				 <a href="<?php bp_activity_comment_delete_link(); ?>" class="delete acomment-delete confirm bp-secondary-action" rel="nofollow"> <?php _e( 'Delete', 'buddypress' ); ?></a>
	
			</div>
	
			<?php endif; ?>
	
			<?php do_action( 'bp_activity_comment_options' ); ?>
	
		<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
	</li>

<?php } ?> <!-- ends is_single() if else -->

<?php do_action( 'bp_after_activity_comment' ); ?>
