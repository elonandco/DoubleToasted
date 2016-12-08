<?php

/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">

	<div class="activity-content single-act-header large-12 columns">

		<div class="activity-meta">

			<?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>

				<a href="<?php bp_activity_thread_permalink(); ?>" class="button view bp-secondary-action" title="<?php _e( 'View Conversation', 'buddypress' ); ?>"><?php _e( 'View Conversation', 'buddypress' ); ?></a>

			<?php endif; ?>
		</div>
		
		<div class="activity-content">
		
		<div class="activity-header">

			<?php
				echo '<style>#act-sing-head p {font-size:20px;}</style>';
				echo '<h1 id="act-sing-head" style="text-transform:none;">';
			 		bp_activity_action(); 
			 	echo '</h1>';
			?>

		</div>

		<?php if ( bp_activity_has_content() ) : ?>

			<div class="activity-inner">

				<?php bp_activity_content_body(); ?>

			</div>

		<?php endif; ?>
    
	</div>
    
	</div>

	<?php if ( (  bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

		<div class="activity-comments">
		
			<?php if ( is_user_logged_in() ) : ?>

				<div id="dt-single-comment-form">
					<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form-single"<?php bp_activity_comment_form_nojs_display(); ?>>
						<div class="ac-reply-avatar rounded"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
						<div class="ac-reply-content">
							<div class="ac-textarea">
								<textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
							</div>
							<!-- This is where the bpfb code gets generated -->
							<div style="text-align:right;" id="dt-single-action">
								<input type="hidden" id="single-act-id" value="<?php bp_activity_id(); ?>" />
								<input type="hidden" id="single-com-id" value="0" />
								<a href="#" class="ac-reply-cancel"><?php _e( 'Cancel', 'buddypress' ); ?></a>
								<input type="submit" id="dt-single-sub" class="button" name="ac_form_submit_single" value="<?php _e( 'Comment', 'buddypress' ); ?>" />
								
							</div>
						</div>
	
						<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>
	
					</form>
				</div>

			<?php endif; ?>

			<?php 
							
				global $activities_template;
				$comment = $activities_template->activity;
				
				// Load comments into modified comments template & function
				bp_activity_recurse_comments__singleact_bypound($comment);			
				
			?>

		</div>

	<?php endif; ?>

<div class="activity-timeline"></div>

</li>
