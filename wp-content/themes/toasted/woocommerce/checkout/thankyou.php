<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Go to my accounts and select "pay" for your order to try again.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
	
		<?php
		
			// Used to display permalinks to shows
			$order = new WC_Order( $order->id );
			$items = $order->get_items();
			$item = array_values($items);
			$orderURL = get_post_meta( $item[0]['product_id'], '_lac0509_dt-product-url', true );

			if ($orderURL) {
				echo '<script type="text/javascript">';
				echo 'setTimeout(function() { location.href = "' . $orderURL . '"; }, 1500)';
				echo '</script>';
			}		
		
		?>

		<h2 style="margin-bottom:20px;">Thanks & enjoy the show!</h2> <p>Note: it may take 5-10 minutes for your subscription to be activated.</p>
		
		<a href="/all-shows/" style="margin-bottom:50px;display:block;">Click here to view all shows.</a>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
