<?php

	// require POST request
	if ($_SERVER['REQUEST_METHOD'] != "POST") die;

	// Load Twilio
	require("php-helper/Twilio.php");

	// Load WP Database Classes
	include( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	require_wp_db();
	global $wpdb;

	// generate "random" 6-digit verification code
	$code = rand(100000, 999999);

	// Strip phone number down so we can test other numbers against it later
	$number = preg_replace('/[^0-9]/', '', esc_sql($_POST["auth_phone_number"]) );
  
	// If this is a 10 digit American number, lets add international prefix of 1 to be consistent with Twilios Auth System
	if(strlen($number) == 10) {
		$number = '1'.$number;
	}
	// if the user has entered 01 for the country code, lets remove the 0
	else if($number[0] == 0) {
		$number = ltrim ($number, '0');
	}

	// Check if the number has already been verified
	$is_phone = $wpdb->get_row( 'SELECT * FROM wp_phone_auth WHERE phone_number = "'.$number.'"', OBJECT );

	// If a user is already connect to this phone number
	if (!empty($is_phone) && $is_phone->user_id != 0) {
		$error = 'Error: That phone number is connected to an existing account.';
	}
	// If the number has already been verified but an account has not been created
	else if ($is_phone->verified == 1) {
		$error = 'This phone number has already been verified.';
		$code = 'verified';
	}
	// New number, lets go!
	else {

		if (!empty($is_phone)) {
		  // Update existing entry with new verification code
		  $wpdb->replace( 'wp_phone_auth', array( 'id' => $is_phone->ID,'phone_number' => $number, 'verification_code' => $code ), array( '%d', '%d', '%d' ) );
		}
		else {
		  // Else create a new entry with verification code
		  $wpdb->insert( 'wp_phone_auth', array( 'phone_number' => $number, 'verification_code' => $code ), array( '%s', '%d' ) );
		}

		// initiate phone call via Twilio REST API    
		// Set our AccountSid and AuthToken 
		$AccountSid = "ACcebdbbd7005f5059600c47badda8628c";
		$AuthToken = "4db7d4df3a60cc581b0596ca5c23dd88";

		// Instantiate a new Twilio Rest Client 
		$twilio = new Services_Twilio($AccountSid, $AuthToken);

		try {
		  // make call
		  $call = $twilio->account->calls->create(
			'5124568108',                // Verified Outgoing Caller ID or Twilio number
			$number,                       // The phone number you wish to dial
			'http://doubletoasted.com/wp-content/themes/toasted/modules/twilio/twiml.php' // The URL of twiml.php on your server
		  );
		} catch (Exception $e) {
		  $error = 'Error starting phone call: ' . $e->getMessage();
		}

	}

	// return verification code as JSON
	$json = array();
	$json["verification_code"] = $code;

	if ($error)
	$json["error"] = $error;

	header('Content-type: application/json');
	echo json_encode($json);

?>