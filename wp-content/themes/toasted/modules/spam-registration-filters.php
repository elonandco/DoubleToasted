// These functions were used prior to phone authentication to combat registration spam
// 	- Currently nothing here is being loaded/used on the site

////////////////////////////////////////////////////////////////////////////////////////////////

// Add anti-spam checks to WooCommerce Checkout

//add_filter( 'woocommerce_checkout_fields', 'add_person_check_field' );
//add_action('woocommerce_checkout_after_customer_details' , 'dt_add_recaptcha_html',10,0);
//add_action('woocommerce_checkout_process', 'dt_verify_recaptcha' );

// Add a new checkout field
function add_person_check_field($fields){

	// We'll use the timestamp as the select value so its dynamic
	$timestamp = date( 'sHi', time());

	// These are our default answers
	$options = array( 'a-imana' => __( 'I\'m an alien' ), $timestamp => __( 'I\'m not an alien or a bot, I promise.' ), 'b' => __( 'I\'m an evil robot' ), 'c' => __( 'I\'m a computer algorothm' ),'d' => __( 'I\'m Robocop' ),'e' => __( 'I\'m a regular robot, just like you' ),'f' => __( 'I\'m a buddha robot' ),'g' => __( 'I\'m not a human being, thats for sure'),'h' => __( 'None of this matters. I\'m from Krypton' ) );

	// We're going to generate random correct answers to further confuse bots
	$correct_answers = array( 'I promise I\'m n&otilde;t an alien-lifeform or robo.', 'I\'m n&otilde;ne of these things', 'I\'m a pers&otilde;n', 'I\'m a h&ugrave;man' );
	shuffle($correct_answers); // mix them up

	// Build the randomized array
	$shuffled_options = array_keys($options);
	shuffle($shuffled_options);
	foreach($shuffled_options as $key) {
		$random_options[$key] = $options[$key];
	}
	
	// Add our random correct answer
	$random_options[$timestamp] = $correct_answers[0];
	
	// If the right answer is the first answer, too easy - lets make it at the bottom
	if (key($random_options) == $timestamp) {
		$random_options = array_reverse($random_options);
	}
	
    $fields['identity_fields'] = array(
            'what_are_you' => array(
					'type' 		=> 'select',
					'options' 	=> $random_options,
					'required'	=> false,
					'label' => __( 'What are you?' )
                ),
     //        'add_these_numbers' => array(
					// 'type' 		=> 'text',
					// //'options' 	=> $random_options,
					// 'required'	=> false,
					// 'label' => __( 'Whats the total of '.$number_1.' + '.$number_2.'?' )
     //            )
            );

    return $fields;
}

// Adds SweetCaptcha & "What are you?" to woocommerce registration
function dt_add_recaptcha_html() {

	echo '<div class="authentication" style="padding-top:25px;max-width:375px;">';
	echo '<h3 style="margin-bottom:20px;">Authentication</h3>';

	// SweetCaptcha
	require_once('modules/sweet/sweetcaptcha.php');
	echo $sweetcaptcha->get_html();

	// Who are you?
	$checkout = WC()->checkout();
    foreach ( $checkout->checkout_fields['identity_fields'] as $key => $field ) {
		woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
	}

	echo '</div>';

}

// Adds authentication of new fields to woocommerce registration
function dt_verify_recaptcha() {

	require_once('modules/sweet/sweetcaptcha.php');

	if ( is_numeric($_POST['what_are_you']) and isset($_POST['sckey']) and isset($_POST['scvalue']) and $sweetcaptcha->check(array('sckey' => $_POST['sckey'], 'scvalue' => $_POST['scvalue'])) == "true") {
		return;
	}
	else {
		wc_add_notice( __( 'Sweet robot tears! We cant authenticate your humanity :(' ), 'error' );
		//email_user_registration_info('declined');
	}

}

// Add SweetCaptcha to WordPress/BuddyPress registration
// add_action( 'register_form', 'dt_add_free_reg_catpcha' );
// add_filter( 'bp_signup_validate', 'dt_validate_free_reg_captcha' );

function dt_add_free_reg_catpcha() {

	echo '<div class="authentication" style="padding-top:25px;max-width:375px;">';
	echo 	'<h3 style="margin-bottom:20px;">Authentication</h3>';

	// SweetCaptcha
	include 'modules/sweet/sweetcaptcha.php';
	echo $sweetcaptcha->get_html();

	// Add Custom Captcha Field

	// We'll use the timestamp as the select value so its dynamic
	$timestamp = date( 'sHi', time());

	// These are our default answers
	$options = array( 'a-imana' => __( 'I\'m an alien' ), $timestamp => __( 'I\'m not an alien or a bot, I promise.' ), 'b' => __( 'I\'m an evil robot' ), 'c' => __( 'I\'m a computer algorothm' ),'d' => __( 'I\'m Robocop' ),'e' => __( 'I\'m a regular robot, just like you' ),'f' => __( 'I\'m a buddha robot' ),'g' => __( 'I\'m not a human being, thats for sure'),'h' => __( 'None of this matters. I\'m from Krypton' ) );

	// We're going to generate random correct answers to further confuse bots
	$correct_answers = array( 'I promise I\'m n&otilde;t an alien-lifeform or robo.', 'I\'m n&otilde;ne of these things', 'I\'m a pers&otilde;n', 'I\'m a h&ugrave;man' );
	shuffle($correct_answers); // mix them up

	// Build the randomized array
	$shuffled_options = array_keys($options);
	shuffle($shuffled_options);
	foreach($shuffled_options as $key) {
		$random_options[$key] = $options[$key];
	}
	
	// Add our random correct answer
	$random_options[$timestamp] = $correct_answers[0];
	
	// If the right answer is the first answer, too easy - lets make it at the bottom
	if ( key($random_options) == $timestamp) {
		$random_options = array_reverse($random_options);
	}


	echo 	'<p style="margin-top:30px;">What are you?</p>';
	echo 	'<select name="what_are_you" id="what_are_you" style="margin-bottom:30px;">';

    foreach ( $random_options as $key => $field ) {
		echo 	'<option value="'.$key.'">'.$field.'</option>';
	}

	echo 	'</select>';
	echo '</div>';


}

function dt_validate_free_reg_captcha($bp) {

	global $bp;
	
	require_once('modules/sweet/sweetcaptcha.php');

	if ( is_numeric($_POST['what_are_you']) and isset($_POST['sckey']) and isset($_POST['scvalue']) and $sweetcaptcha->check(array('sckey' => $_POST['sckey'], 'scvalue' => $_POST['scvalue'])) == "true") {
		return;
	}
	else {
		$bp->signup->errors['signup_username'] = __( 'Sorry, we were unable to verify your humanity', 'buddypress' );
		//email_user_registration_info('declined');
	}
    
}

////////////////////////////////////////////////////////////////////////////////////////////////

// Used for testing new spam registrations
// add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

	foreach( $_POST as $stuff => $stuffing ) {
		if( is_array( $stuff ) ) {
			foreach( $stuff as $key => $value ) {
				$message .= $key . ": " . $value . "\r\n";
			}
		} else {
			$message .= $stuff . ": " . $stuffing . "\r\n";
		}
	}
	
	$message .= "\r\n";
	
	foreach( $_REQUEST as $stuffs => $stuffings ) {
		if( is_array( $stuffs ) ) {
			foreach( $stuffs as $keys => $values ) {
				$message .= $keys . ": " . $values . "\r\n\r\n";
			}
		} else {
			$message .= $stuffs . ": " . $stuffings . "\r\n";
		}
	}
	
	$headers = 'From: Double Toasted <spam@doubletoasted.com>' . "\r\n";
	wp_mail( 'mikelacourse@gmail.com', 'A new user has registered.', $message, $headers );

}

function email_user_registration_info($type) {

	if ($type = 'declined') {
		$headers = 'From: Double Toasted <spam@doubletoasted.com>' . "\r\n";
		$subject = 'An alien or killer robot just tried to register, and was swiftly declined.';
		$message = 'How squishy.';
		wp_mail( 'mikelacourse@gmail.com', $subject, $message, $headers );
	}
	else if ($type = 'registered') {
		$headers = 'From: Double Toasted <spam@doubletoasted.com>' . "\r\n";
		$subject = 'A new user has registered.';
		$message = 'Hopefully they\'re not spam but realistically it probably is.';
		wp_mail( 'mikelacourse@gmail.com', $subject, $message, $headers );
	}

}