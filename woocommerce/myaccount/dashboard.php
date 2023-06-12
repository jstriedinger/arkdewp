<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<div class="MyAccount-content--dashboard">
	<div class="wc-MyAccount-sub-heading">
		<h2 class="title is-3">
		<?php
		printf(
			__( 'Hola %1$s', 'arkdewp' ),
			'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
			esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
		);
		?>
		</h2>
		<p>
			<?php _e('Esta es tu cuenta. En está sección puedes ver tus pedido recientes, cambiar tu perfil publico, cambiar tu imagen y tu contraseña.')?>
		</p>
	</div>
	<div class="wc-MyAccount-inner-content">
		
		<div class="wc-MyAccount-dashboard-block">
		<?php

		$my_orders_columns = apply_filters(
			'woocommerce_my_account_my_orders_columns',
			array(
				'order-number'  => __( 'Pedido', 'arkdewp' ),
				'order-date'    => __( 'Fecha', 'arkdewp' ),
				'order-status'  => __( 'Estado', 'arkdewp' ),
				'order-total'   => __( 'Total', 'arkdewp' ),
				'order-actions' => '&nbsp;',
			)
		);

		$customer_orders = get_posts(
			apply_filters(
				'woocommerce_my_account_my_orders_query',
				array(
					'numberposts' => 3,
					'meta_key'    => '_customer_user',
					'meta_value'  => get_current_user_id(),
					'post_type'   => wc_get_order_types( 'view-orders' ),
					'post_status' => array_keys( wc_get_order_statuses() ),
				)
			)
		);

		if ( $customer_orders ) :
			?>
			<h3 class="subtitle is-4 pt-6 mb-3"><?php _e('Pedido recientes','arkdewp'); ?></h3>
			<div class="wc-MyAccount-inner-content">
				<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table account-orders-table-dashboard">
			
					<thead>
						<tr>
							<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
								<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
							<?php endforeach; ?>
						</tr>
					</thead>
			
					<tbody>
						<?php
							$i = 0;
						foreach ( $customer_orders as $customer_order ) :
							if ( $i >= 3 ) {
								break;
							} else {
								$order      = wc_get_order( $customer_order );
								$item_count = $order->get_item_count();
								?>
							<tr class="order">
								<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
									<td class="<?php echo esc_attr( $column_id ); ?>  pt-4" data-title="<?php echo esc_attr( $column_name ); ?>">
										<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
											<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>
			
										<?php elseif ( 'order-number' === $column_id ) : ?>
											<span>
												#<?php echo $order->get_order_number(); ?>
											</span>
			
										<?php elseif ( 'order-date' === $column_id ) : ?>
											<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
			
										<?php elseif ( 'order-status' === $column_id ) : ?>
											<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
			
										<?php elseif ( 'order-total' === $column_id ) : ?>
											<?php
											/* translators: 1: formatted order total 2: total order items */
											printf( _n( '%1$s por %2$s curso', '%1$s por %2$s cursos', $item_count, 'arkdewp' ), $order->get_formatted_order_total(), $item_count );
											?>
			
										<?php elseif ( 'order-actions' === $column_id ) : ?>
											<?php
											$actions = wc_get_account_orders_actions( $order );

											if ( ! empty( $actions ) ) {
												foreach ( $actions as $key => $action ) {
													echo '<a href="' . esc_url( $action['url'] ) . '" class="button is-small is-outlined is-purple ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
												}
											}
											?>
										<?php endif; ?>
									</td>
								<?php endforeach; ?>
							</tr>
								<?php
								$i++;
							}
							?>
							 
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		</div>
		
		
	</div>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
