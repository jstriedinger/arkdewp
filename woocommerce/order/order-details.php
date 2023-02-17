<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<div class="woocommerce-order-details-wrapper">
	<section class="woocommerce-order-details arkde-cart">
		<?php
		do_action( 'woocommerce_order_details_before_order_table', $order );
		// here we put the courses info
		?>

		<div class="card with-shadows p-5 mt-5">
			<h2 class="woocommerce-order-details__title is-size-4 mb-0"><?php esc_html_e( 'Resumen de tu compra', 'buddyboss-theme' ); ?></h2>
			<p class="is-size-14px mb-3"><?php esc_html_e( '(Haz clic en los cursos para empezar)', 'arkdewp' ); ?></p>
			<ul>
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template(
						'order/order-details-item.php',
						array(
							'order'              => $order,
							'item_id'            => $item_id,
							'item'               => $item,
							'show_purchase_note' => $show_purchase_note,
							'product'            => $product,
						)
					);
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				?>
			</ul>
	
			<table class="woocommerce-table woocommerce-table--order-details shop_table order_details order_details_total table is-fullwidth has-text-right" style="background: transparent">
				<tbody>
					<?php
					foreach ( $order->get_order_item_totals() as $key => $total ) {
						?>
							<tr>
								<th scope="row" class="has-text-right" style="width:70%"><?php echo esc_html( $total['label'] ); ?></th>
								<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							</tr>
							<?php
					}
					?>
				</tbody>
			</table>
	
			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
			
		</div>
	</section>

</div>
