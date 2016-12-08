<?php

  // Load Twilio
  require("php-helper/Twilio.php");

  $response = new Services_Twilio_Twiml();
  
  if (empty($_POST["Digits"])) {
    $gather = $response->gather(array('numDigits' => 6));
    $gather->say("Hello, this is the Double Toasted phone robot. Please enter your verification code now.");
  }
  else {

	// Load WP Database Classes
	include( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	require_wp_db();
	global $wpdb;

	// Strip phone number down so we can test other numbers against it later
	$number = preg_replace('/[^0-9]/', '', esc_sql($_POST["Called"]) );
	
	// Get our phone info from the DB
	$sql = 'SELECT *
			FROM wp_phone_auth
			WHERE phone_number = "'.$number.'"';

	$phone_info = $wpdb->get_row( $sql, OBJECT );

	if(!empty($phone_info)) {
	
		if ($_POST["Digits"] == $phone_info->verification_code) {
			$wpdb->replace( 'wp_phone_auth', array( 'id' => $phone_info->ID, 'phone_number' => $phone_info->phone_number, 'verification_code' => $phone_info->verification_code, 'verified' => 1 ), array( '%d', '%d' ) );
			$response->say("Thank you! Your double toasted account has been verified.");
		}
		else {
			// if incorrect, prompt again
			$gather = $response->gather(array('numDigits' => 6));
			$gather->say("Verification code incorrect, please try again."); 
		}
	}
	else {
		// if incorrect, prompt again
		$gather = $response->gather(array('numDigits' => 6));
		$gather->say("There was an error processing your phone number. Click try again and re-enter your phone number."); 
	  }
}

  print $response;

?>