<?php
/**
 * Empty cart page
 *
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="mt-3"></div>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button is-primary is-medium is-fullwidth wc-forward">
	<span><?php esc_html_e( 'Comprar', 'arkdewp' ); ?></span>
	<span class="icon">
		<i class="fas fa-chevron-right"></i>
	</span>
</a>
