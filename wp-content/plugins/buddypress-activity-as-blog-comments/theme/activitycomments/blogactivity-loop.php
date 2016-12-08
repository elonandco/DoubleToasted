<?php

	// Reverse Comment Order to show newest at top.
	global $activities_template;
	if ($activities_template->activities[0]->children) {
		$activities_template->activities[0]->children = array_reverse($activities_template->activities[0]->children);
	}

?>

<?php while ( bp_activities() ) : bp_the_activity(); ?>

	<div class="dt-side-com-wrap">

		<!-- ac-form-<?php //bp_activity_id() ?> Removed this from ID field of form -->
		<form action="<?php bp_activity_comment_form_action() ?>" method="post" id="dt-sidebar-reply" class="ac-form"<?php bp_activity_comment_form_nojs_display() ?>>
			<textarea id="ac-input-<?php bp_activity_id() ?>" class="ac-input" name="ac_input_<?php bp_activity_id() ?>"></textarea>
			<input id="dt-side-sub" class="button" type="submit" name="ac_form_submit" value="POST" />
			<input type="hidden" name="comment_form_id" value="<?php bp_activity_id() ?>" />
			<input name="<?php bp_activity_id(); ?>" type="hidden" id="side-activityID" />
			<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ) ?>
		</form>
	
		<div class="activity-comments" id="<?php bp_activity_id(); ?>">
				<?php bp_activity_comments() ?>
		</div>
		
	</div>

<?php endwhile; ?>