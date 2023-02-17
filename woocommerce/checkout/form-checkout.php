<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section">
	<div class="container is-max-widescreen">
		<h1 class="title is-size-3 mb-2"><?php esc_html_e( 'Checkout', 'arkdewp' ); ?></h1>
		<?php
		if ( $checkout->is_registration_required() && ! is_user_logged_in() ) {
			?>
			<div class="notification">
				<h3 class="is-size-5"><?php esc_html_e( '¡Espera un momento!', 'arkdewp' ); ?></h3>
				<?php esc_html_e( 'Debes iniciar sesión o crear una cuenta para poder comprar cursos online. Afortunadaemnte, es MUY facil!', 'arkdewp' ); ?>
			</div>
			<?php
			do_action( 'oa_social_login' );
			return;
		}
		do_action( 'woocommerce_before_checkout_form', $checkout );

		// If checkout registration is disabled and not logged in, the user cannot checkout.
		?>
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		
			<?php if ( $checkout->get_checkout_fields() ) : ?>
		
				<div class="columns is-multiline is-variable is-8">
					<div class="column is-7" id="customer_details">
						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
						<?php do_action( 'woocommerce_checkout_billing' ); ?>

					</div>
					<div class="column">
						<div class="card with-shadows">
							<div class="card-content">
								<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
								<h4 id="order_review_heading" class="subtitle is-size-4 has-text-weight-bold mb-4"><?php esc_html_e( 'Tu orden', 'arkdewp' ); ?></h4>
								<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
								<div id="order_review" class="woocommerce-checkout-review-order">
									<?php do_action( 'woocommerce_checkout_order_review' ); ?>
								</div>
								<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

							</div>
						</div>

					</div>
				</div>
		
			<?php endif; ?>
		
		</form>
		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
	</div>
</section>
