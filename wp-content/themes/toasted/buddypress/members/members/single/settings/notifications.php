
<div class="" id="gen-notifications">

	<?php do_action( 'bp_before_member_settings_template' ); ?>
	
	<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications'; ?>" method="post" class="standard-form" id="settings-form">
		<h3 style="margin-bottom:10px;padding-top:10px;clear:both;"><?php _e( 'Send an email notice when:', 'buddypress' ); ?></h3>
	
		<?php do_action( 'bp_notification_settings' ); ?>
	
		<?php do_action( 'bp_members_notification_settings_before_submit' ); ?>
	
		<div class="submit">
			<input type="submit" name="submit" value="<?php _e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="button" />
		</div>
	
		<?php do_action( 'bp_members_notification_settings_after_submit' ); ?>
	
		<?php wp_nonce_field('bp_settings_notifications' ); ?>
	
	</form>
	
	<?php do_action( 'bp_after_member_settings_template' ); ?>
</div>