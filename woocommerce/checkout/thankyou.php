<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order container is-max-desktop mt-6">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>
	
		<div class="woocommerce-order-over has-text-centered">

		<?php if ( $order->has_status( 'failed' ) || $order->has_status( 'epayco-failed' ) ) : ?>

			<i class="icon is-large has-text-danger">
				<span class="fa-solid fa-face-sad-tear is-size-1"></span>
			</i>
			<h1 class="order-result subtitle is-size-2 has-text-weight-bold"><?php esc_html_e( 'Tu pedido ha fallado', 'arkdewp' ); ?></h1>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Hubo un problema al procesar tu pago. Por favor intenta de nuevo o ponte en contacto con nosotros.', 'arkdewp' ); ?></p>
			
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay is-primary"><?php esc_html_e( 'Paga aquí', 'arkdewp' ); ?></a>
			
		<?php elseif ( $order->has_status( 'epayco-on-hold' ) ) : ?>
				<i class="icon is-large has-text-warning">
					<span class="fa-solid fa-triangle-exclamation is-size-1"></span>
				</i>
			<h1 class="order-result subtitle is-size-2 has-text-weight-bold"><i class="bb-icons bb-icon-alert-octagon"></i><?php esc_html_e( 'Tu pedido está pendiente', 'arkdewp' ); ?></h1>
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Tu pedido está en esta Pendiente hasta recibir confirmación con tu banco. Esto puede suceder por diferentes razones de validación. Te confirmaremos cuando el pago haya sido confirmado.', 'arkdewp' ); ?></p>

		<?php else : ?>
			<?php
				$current_user   = wp_get_current_user();
				$mycourses_link = ( function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( $current_user->ID ) : get_author_posts_url( $current_user->ID ) ) . 'cursos';
			?>
				<i class="icon is-large has-text-success">
					<span class="fa-solid fa-circle-check is-size-1"></span>
				</i>
				<h1 class="order-result subtitle is-size-2 has-text-weight-bold has-small-padding-top"><?php esc_html_e( 'Pedido confirmado', 'arkdewp' ); ?></h1>

				<?php
				$items = $order->get_items();
				?>

				
	
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details is-flex is-justify-content-space-between has-text-grey">
	
					<li class="woocommerce-order-overview__order order is-size-14px">
						<?php esc_html_e( 'Orden número:', 'arkdewp' ); ?><br>
						<span><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</li>
	
					<li class="woocommerce-order-overview__date date is-size-14px">
						<?php esc_html_e( 'Fecha:', 'arkdewp' ); ?><br>
						<span><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</li>
	
					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="woocommerce-order-overview__email email is-size-14px">
							<?php esc_html_e( 'Email:', 'buddyboss-theme' ); ?><br>
							<span><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</li>
					<?php endif; ?>
	
					<li class="woocommerce-order-overview__total total is-size-14px">
						<?php esc_html_e( 'Total:', 'buddyboss-theme' ); ?><br>
						<span><?php echo $order->get_formatted_order_total() . ' ' . $order->get_currency(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</li>
	
					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="woocommerce-order-overview__payment-method method is-size-14px">
							<?php esc_html_e( 'Metodo de pago:', 'arkdewp' ); ?><br>
							<span><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></span>
						</li>
					<?php endif; ?>
	
				</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		</div> <?php // woocommerce-order-over ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'buddyboss-theme' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

	<div class="pt-5 pb-6 has-text-centered">
		<h3 class="is-size-4 has-text-weight-bold"><?php _e( 'Gracias por tu compra!', 'arkdewp' ); ?></h3>
		<p ><?php _e( "Recibirás en tu correo una copia de conformación de tu compra", 'arkdewp' ); ?></p>
	</div>
</div>

