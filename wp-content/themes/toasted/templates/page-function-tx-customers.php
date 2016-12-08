<?php
/**
 * @package Frank
 */
/*
Template Name: Customer Database Output
*/
?>

<!-- Used for doing back-end clean up stuff -->
<?php get_header(); ?>

<div class="main single on-air show-simple-comments">
	<div class="content" style="margin-bottom:50px;">

<?php if ( current_user_can('administrator') ) { ?>

<h1>Export Texas Customer Data</h1>
<p>A link to a spreadsheet file will be emailed to you once the compile script has finished.</p>


<?php

	if (!$_GET['do']) { ?>
	
		<form action="<?php echo get_home_url() . $_SERVER["REQUEST_URI"] ?>" method="GET">
			<input type="hidden" name="do" value="file">
			<input type="text" name="email" placeholder="Your Email Address">
			<input class="button" type="submit" value="Compile Data">
		</form>
		
		<p>Please be patient, this could take 5-10 minutes.</p>

	
	<?php }

	if ($_GET['do'] == 'file') {
	
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT post_id FROM wp_postmeta WHERE meta_key = "_billing_state" AND meta_value ="TX"', OBJECT );

		foreach ($results as $order) {

			$status = $wpdb->get_results( 'SELECT post_status FROM wp_posts WHERE id = '.$order->post_id, OBJECT );
			
			if ($status[0]->post_status == 'wc-processing' || $status[0]->post_status == 'wc-completed' || $status[0]->post_status == 'publish') {

				$order_total = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_order_total"', OBJECT );			
			
				echo '<h2>'.$order->post_id.': '.$status[0]->post_status.': '.$order_total[0]->meta_value.'</h2>';
			
				if ($order_total[0]->meta_value !== '0.00') {
				
					//echo '<p><strong>ID: ' . $order->post_id . '</strong></p>';
					//echo '<p>Total: ' . $order_total[0]->meta_value . '</p>';
					
					$fname = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_billing_first_name"', OBJECT );	
					$lname = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_billing_last_name"', OBJECT );	
					$address = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_billing_address_1"', OBJECT );	
					$city = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_billing_city"', OBJECT );	
					$date = $wpdb->get_results( 'SELECT meta_value FROM wp_postmeta WHERE post_id = '.$order->post_id.' AND meta_key = "_paid_date"', OBJECT );	
					
					$data .= '"' . $date[0]->meta_value . '","' . $order_total[0]->meta_value . '","' .  $order->post_id . '","' .  $fname[0]->meta_value . '","' .  $lname[0]->meta_value . '","' . $address[0]->meta_value . '","' . $city[0]->meta_value . '","TX"' . PHP_EOL;
					
				}

			}

		}		
		
		file_put_contents('tx-customer-order-db.txt', $data);
		
		echo '<p>Script has been compiled!</p>';
	
	}

?>

<?php } ?>
	</div>
</div><!-- .single.main -->

<?php get_footer(); ?>