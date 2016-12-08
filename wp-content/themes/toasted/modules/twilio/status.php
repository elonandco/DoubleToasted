<?php

  // require POST request
  if ($_SERVER['REQUEST_METHOD'] != "POST") die;

  // Load Twilio
  require("php-helper/Twilio.php");

  // Load WP Database Classes
  include( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
  require_wp_db();
  global $wpdb;

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

  // Get our phone info from the DB
  $sql = 'SELECT *
          FROM wp_phone_auth
          WHERE phone_number = "'.$number.'"';  

  $phone_info = $wpdb->get_row( $sql, OBJECT );

  $json = array();
  $json["status"] = "unverified";

  // Check if we need to update status
  if(!empty($phone_info)) {
    if ($phone_info->verified == "1") {
      $json["status"] = "verified";
    }
  }

  header('Content-type: application/json');
  echo(json_encode($json));

?>