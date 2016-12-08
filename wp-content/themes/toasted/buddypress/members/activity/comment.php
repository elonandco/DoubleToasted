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

<?php do_action( 'bp_before_activity_comment' ); ?>


	<li id="acomment-<?php bp_activity_comment_id(); ?>" class="animate-post">
		
			<div class="acomment-avatar rounded">
				<a href="<?php bp_activity_comment_user_link(); ?>">
					<?php bp_activity_avatar( 'type=thumb&user_id=' . bp_get_activity_comment_user_id() ); ?>
				</a>
			</div>

			<?php	

				//Checks depth of comment thread and adds reply link below if needed
				$can_comment = true;
				if ( get_option( 'thread_comments' ) && bp_activity_get_comment_depth() >= get_option( 'thread_comments_depth' ) ) {
					$can_comment = false;
				} 

			?>
			
			<div class="acomment-body">
				
				<div class="acomment-content fl-left">
					<p class="bp-activity-comment"><a href="<?php echo bp_get_activity_comment_user_link(); ?>"><?php  echo bp_get_activity_comment_name(); ?> </a></p>
					
					<?php 
					
						$actcontent = bp_get_activity_comment_content();
						$actcontent = str_replace('<p></p>', '', $actcontent ); 
						echo $actcontent;
						
					?>
				</div>
				
				
				<div class="accoment-meta clear fl-left">
				
					<?php if ( is_user_logged_in() && $can_comment ) : ?>
					
						<a href="#acomment-<?php bp_activity_comment_id(); ?>" class="single-acomment-reply bp-primary-action" id="acomment-reply-<?php bp_activity_id(); ?>-from-<?php bp_activity_comment_id(); ?>"><?php _e( 'Reply', 'buddypress' ); ?></a>
		
					<?php endif; ?>
				
					<?php if ( bp_activity_user_can_delete() ) : ?>
				
						 <a href="<?php bp_activity_comment_delete_link(); ?>" class="dt-side-com-del delete single-acomment-delete confirm bp-secondary-action" rel="nofollow">Delete</a>
				
					<?php endif; ?>
	
					<?php
					
						// Returns human readable timestamp for comments
						global $activities_template;
						echo '<a style="cursor:default;" class="time-since time-created">' . bp_core_time_since( $activities_template->activity->current_comment->date_recorded ) . '</a>';
						echo $time_since;
					
					?>
	
				</div>
				
				<?php 
				
					// Timestamp?
					//global $activities_template;
					//var_dump(get_comment_time());
				
				?>
				
			</div>
	
			<?php do_action( 'bp_activity_comment_options' ); ?>
	
		<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
		
	</li>

<?php do_action( 'bp_after_activity_comment' ); ?>
