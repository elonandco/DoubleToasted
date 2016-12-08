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

<?php do_action( 'bp_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
	<div class="activity-content">
		<?php do_action( 'bp_activity_entry_content' ); ?>
		<div class="activity-meta fl-left">

			<?php if ( is_user_logged_in() ) : ?>
				<?php if ( bp_activity_can_comment() ) : ?>
					<a href="<?php bp_activity_comment_link(); ?>" class="acomment-reply bp-primary-action dt-new-post-box" id="acomment-comment-<?php bp_activity_id(); ?>">Click here to comment</a>
				<?php endif; ?>

				<?php do_action( 'bp_activity_entry_meta' ); ?>
				<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'bp_before_activity_entry_comments' ); ?>

    <div class="activity-comments">
        <?php bp_activity_comments(); ?>

        <?php if ( is_user_logged_in() ) : ?>
            <form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
                <div class="ac-reply-avatar rounded"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
                <div class="ac-reply-content">
                    <div class="ac-textarea">
                        <textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
                    </div>
                    <input type="submit" name="ac_form_submit" value="<?php _e( 'Post', 'buddypress' ); ?>" /> &nbsp; <a href="#" class="ac-reply-cancel"><?php _e( 'Cancel', 'buddypress' ); ?></a>
                    <input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
                </div>

                <?php do_action( 'bp_activity_entry_comments' ); ?>

                <?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>
            </form>
        <?php endif; ?>
    </div>

	<?php do_action( 'bp_after_activity_entry_comments' ); ?>
	<div class="activity-timeline"></div>
</li>

<?php do_action( 'bp_after_activity_entry' ); ?>