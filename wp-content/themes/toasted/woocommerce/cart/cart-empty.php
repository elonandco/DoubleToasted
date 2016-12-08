<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

$userid = bp_loggedin_user_id();
$bpusername = bp_members_get_user_nicename( $userid );

?>

<p class="cart-empty" style="margin-bottom:100px;"><?php _e( 'If you\'re getting an error buying a subscription you might need to Renew instead. <a href="/members/'.$bpusername.'/settings/" title="Settings">Click here to go to the My Account page.</a> Otherwise ', 'woocommerce' ) ?> <a href="/membership/">click here to see our subscription plans.</a></p>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>