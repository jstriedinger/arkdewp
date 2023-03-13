<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2
 */

defined( 'ABSPATH' ) || exit;

$discount_total = 0;
foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
	$product = $values['data'];
	if ( $product->is_on_sale() ) {
		$regular_price   = $product->get_regular_price();
		$sale_price      = $product->get_sale_price();
		$discount        = ( (float) $regular_price - (float) $sale_price ) * (int) $values['quantity'];
		$discount_total += $discount;
	}
}

?>
<div class="card with-shadows">
	<div class="card-content cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
		<h4 class="subtitle is-size-4 has-text-weight-bold mb-4"><?php esc_html_e( 'Resumen', 'arkdewp' ); ?></h4>
		<table cellspacing="0" class="shop_table shop_table_responsive">
			<tr class="cart-subtotal is-size-14px">
				<td class="has-text-left"><?php esc_html_e( 'Subtotal', 'arkdewp' ); ?></td>
				<td class="has-text-right" data-title="<?php esc_attr_e( 'Subtotal', 'arkdewp' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount is-size-14px coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<td class="has-text-left"><?php wc_cart_totals_coupon_label( $coupon ); ?></td>
				<td class="has-text-right" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee is-size-14px">
				<td class="has-text-left"><?php echo esc_html( $fee->name ); ?></td>
				<td class="has-text-right" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<tr class="is-size-14px tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<td class="has-text-left"><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<td class="has-text-right" data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total is-size-14px">
					<td class="has-text-left"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
					<td class="has-text-right" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>
		<tr class="order-discounts is-size-14px">
			<td class="has-text-left"><?php esc_html_e( 'Descuentos', 'woocommerce' ); ?></td>
			<td class="has-text-right" data-title="<?php esc_attr_e( 'Descuentos', 'woocommerce' ); ?>">
											  <?php	echo '-'.wc_price( $discount_total ); ?>
			 </td>
		</tr>
		<tr class="order-total is-size-4 has-text-weight-bold">
			<td class="has-text-left"><?php esc_html_e( 'Total', 'woocommerce' ); ?></td>
			<td class="has-text-right" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php echo WC()->cart->get_cart_total() . '<small>' . get_woocommerce_currency() . '</small>'; ?></td>
		</tr>
	</table>
	<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>
</div>
