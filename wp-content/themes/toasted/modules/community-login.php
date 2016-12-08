<div id="dt-side-login">	

	<h1>LOG IN</h1>
<!-- Have not implemented a facebook login solution as of yet.
	<h3 class="login-with-facebook-dt">Connect to Facebook</h3>
	<p>or</p>
 -->
	
	<?php $args = array(
        'echo' => true,
        'redirect' => site_url( $_SERVER['REQUEST_URI'] ), 
        'form_id' => 'loginform',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => NULL,
        'value_remember' => false ); ?>
	
	<?php
	
	$args = array('redirect' => get_permalink( get_page( $page_id_of_member_area ) ) );
	
	if ($GLOBALS[ 'isLoginFail' ]) {
		?>
			<div id="login-error">
				<p>Username/password incorrect.</p>
			</div>
		<?php
	}

	wp_login_form( $args );
	
	?>

	<hr class="sidebar-sep" />
	
	<p>Don't have a login?</p>
	<h1>TRY US FOR FREE</h1>
	<a class="button">START FREE TRIAL</a>
	<p>Full Access for 30 days</p>
	
	<p>by signing up for Double Toasted<br />
	your agree to our<br />
	<a href="#!">Terms of Service</a> & <a href="#!">Privacy Policy</a></p>
</div>