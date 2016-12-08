<div id="buddypress">

	<?php do_action( 'bp_before_activation_page' ); ?>

	<div class="page" id="activate-page">

		<?php do_action( 'template_notices' ); ?>

		<?php do_action( 'bp_before_activate_content' ); ?>

		<?php if ( bp_account_was_activated() ) : ?>

			<?php if ( isset( $_GET['e'] ) ) : ?>
				<?php var_dump($_GET['e']); ?>
				<p style="margin-bottom:75px;"><?php _e( 'Your account was activated successfully! Your account details have been sent to you in a separate email.', 'buddypress' ); ?></p>
			<?php else : ?>
				<p style="margin-bottom:75px;"><?php printf( __( 'Your account has been activated! You can now log-in with your username and password.', 'buddypress' ), wp_login_url( bp_get_root_domain() ) ); ?> <a class="dt-toggle thickbox" href="/#TB_inline?width=800&height=500&inlineId=dt-login" id="dt-toggle-login">Click here to log-in.</a></p>
				 
			<?php endif; ?>

		<?php else : ?>
			
			<h1>ACCOUNT ACTIVATION</h1>
			<p style="margin-bottom:75px;"><?php _e( 'We couldn\'t detect an activation code. This might mean your account has already been activated or that you have not yet clicked the activation link in the activation email. If you haven\'t received the activation email, try checking your spam folder or ', 'buddypress' ); ?> <a class="dt-toggle thickbox" href="/#TB_inline?width=800&height=500&inlineId=dt-login" id="dt-toggle-login">click here to log-in.</a></p>

<!-- 
			<form action="" method="get" class="standard-form" id="activation-form">

				<label for="key"><?php _e( 'Activation Key:', 'buddypress' ); ?></label>
				<input type="text" name="key" id="key" value="" />

				<p class="submit">
					<input type="submit" name="submit" value="<?php _e( 'Activate', 'buddypress' ); ?>" />
				</p>

			</form>
 -->

		<?php endif; ?>

		<?php do_action( 'bp_after_activate_content' ); ?>

	</div><!-- .page -->

	<?php do_action( 'bp_after_activation_page' ); ?>

</div><!-- #buddypress -->