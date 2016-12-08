<?php do_action( 'template_notices' ); ?>

<h3 style="padding-top:10px;clear:both;">Purchase History</h3>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php //wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); 
?>

<hr style="margin-bottom:30px" />

<p style="margin-bottom:30px;">To change your payment plan you must cancel your existing membership and select a new plan. <a href="//doubletoasted.com/membership/">Click here to select a new payment plan</a>.</p>

<hr style="margin-bottom:30px" />

<h3>General Account Settings</h3>

<div class="profile-general">

<?php do_action( 'bp_before_member_settings_template' ); ?>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

	<div id="gen-change">
		<div>
		
			<h4>Email Address</h4>
			<input style="max-width:400px;" type="text" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" />
	
			<h4>Change Password</h4>
			<input style="max-width:400px;" type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small" />
			<label for="pass1"><?php _e( 'Confirm new password', 'buddypress' ); ?></label>
			<input style="max-width:400px;" type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small" />
		
		</div>
	</div>
	
	<div>
		<div id="gen-confirm">
			<?php if ( !is_super_admin() ) : ?>
				<h4>Current password (required)</h4>
		
				<input style="max-width:400px;" type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" />

				<hr style="margin-bottom:30px;" />

				<div class="submit">
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Update Account', 'buddypress' ); ?>" id="submit" class="auto button" />
				</div>

		
			<?php endif; ?>
	
		</div>
	</div>
	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>

<?php do_action( 'bp_after_member_settings_template' ); ?>

</div>

<hr style="margin-bottom:30px" />

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<a style="margin-bottom:30px;display:inline-block;" href="/my-account/edit-address/billing">Edit</a>

<?php do_action( 'woocommerce_after_my_account' ); ?>

<hr style="margin-bottom:30px;" />

<?php do_action( 'bp_core_general_settings_before_submit' ); ?>

<a class="button delete-dt-account" href="delete-account/">Delete Account</a>

<?php do_action( 'bp_core_general_settings_after_submit' ); ?>

