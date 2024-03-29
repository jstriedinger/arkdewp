<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

?>
<form class="woocommerce-cart-form mt-6" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
<?php
do_action( 'woocommerce_before_cart' );
		do_action( 'woocommerce_before_cart_table' );
?>
	<h1 class="title is-size-3 mb-2"><?php esc_html_e( 'Tu carrito de compras', 'arkdewp' ); ?></h1>
	<div class="columns is-multiline is-variable is-8 arkde-cart">
		<div class="column is-two-thirds">
				<ul class="">
					<?php
						// get if it has premiun sale benefits
						$current_user = wp_get_current_user();
						$currency     = get_woocommerce_currency();

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						$terms = get_the_terms( $product_id, 'product_cat' );

						$term = null;
						if ( ! empty( $terms ) ) {
							$term = array_values( $terms )[0];
						}

						$is_pack = false;
						$course  = null;
						$cid     = get_post_meta( $product_id, '_related_course' );
						$args    = array(
							'post__in'       => $cid[0],
							'post_type'      => 'sfwd-courses',
							'posts_per_page' => -1,
						);

						if ( 'career' == $term->slug ) {
							$is_pack      = true;
							$courses      = ( new WP_Query( $args ) )->posts;
							$item_in_cart = get_field( 'career', $product_id );
						} else {
							// only one course.
							$item_in_cart = get_post_meta( $product_id, '_related_course' )[0][0];

						}
						?>
							<li class='cart-item <?php echo $is_pack ? 'career' : ''; ?> is-flex is-align-items-flex-start py-5 has-gap-16'>
							<?php
							$price = wc_get_price_to_display( $_product, array( 'price' => $_product->get_price() ) );

							if ( $_product->is_on_sale() ) {
								$reg_price = wc_get_price_to_display( $_product, array( 'price' => $_product->get_regular_price() ) );
							}
							?>
							
							<div class="media">
							<?php echo get_the_post_thumbnail( $_product->get_id(), 'thumbnail' ); ?>
							</div>
							<div class="is-flex <?php echo $is_pack ? '' : 'has-gap-8'; ?> is-flex-direction-column is-align-self-center">
								<?php if ( $is_pack ) : ?>
									<span class="is-size-7 has-text-gold has-text-weight-bold is-uppercase"><?php esc_html_e( 'Pack de cursos', 'arkdewp' ); ?></span>
								<?php else : ?>
									<?php
									get_template_part(
										'template-parts/course/course',
										'rating',
										array(
											'course_id' => $item_in_cart,
											'size'      => 'fa-xs',
										)
									);
									?>
								<?php endif; ?>
								<p class="subtitle is-size-6 has-text-weight-bold mb-0"><?php echo get_the_title( $item_in_cart ); ?></p>
								<?php if ( $is_pack ) : ?>
										<div class="is-flex has-gap-8 is-align-items-center has-text-grey-light">
											<span class=" is-size-7"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( count( $courses ) ) ); ?></span>
											<span class="has-text-weight-bold">·</span>
											<span class=" is-size-7"><?php echo sprintf( esc_html__( '%s en video', 'arkdewp' ), esc_attr( get_field( 'duration', $item_in_cart->ID ) ) ); ?></span>
											
										</div>
								<?php else : ?>
									<span class="has-text-grey-light is-size-7"><?php echo sprintf( esc_html__( '%s+ en video', 'arkdewp' ), esc_attr( get_field( 'course_duration', $item_in_cart ) ) ); ?></span>
								<?php endif; ?>
								<div class="is-hidden-tablet price" style="padding-top:5px;">
									<?php
									if ( $_product->is_on_sale() ) {
										echo "<p><span class='before'>$" . number_format( $reg_price, 0, ',', '.' ) . '</span>';
										echo '  $' . number_format( $price, 0, ',', '.' ) . '<small>' . $currency . '</small></p>';
									} else {
										echo '<p>$' . number_format( $price, 0, ',', '.' ) . '<small>' . $currency . '</small></p>';
									}
									?>
								</div>
							</div>
							<div class="price is-flex has-gap-5 is-flex-direction-column is-align-items-flex-end">
								<?php
								if ( $_product->is_on_sale() ) {
									echo '<p class="has-text-weight-bold is-size-14px">$' . number_format( $price, 0, ',', '.' ) . '<small class="ml-1">' . $currency . '</small></p>';
									echo "<span class='is-line-through is-size-14px has-text-grey-light'>$" . number_format( $reg_price, 0, ',', '.' ) . '</span>';
								} else {
									echo '<p class="has-text-weight-bold is-size-14px">$' . number_format( $price, 0, ',', '.' ) . '<small class="ml-1">' . $currency . '</small></p>';
								}
								?>
							</div>
							<div class="product-remove">
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="fa-solid fa-trash-can" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								?>
							</div>
						</li>
	
						<?php
						if ( $is_pack ) {
							?>
						<ul class="pb-5 pt-2">
							<?php
							foreach ( $courses as $coursec ) {
								?>
								<li class="cart-item small is-flex is-align-items-flex-start py-2 has-gap-16">
									<div class="media">
										<?php echo get_the_post_thumbnail( $coursec->ID, 'thumbnail' ); ?>
									</div>
									<div class="is-flex is-flex-direction-column is-align-self-center has-gap-8">
										<?php
										get_template_part(
											'template-parts/course/course',
											'rating',
											array(
												'course_id' => $item_in_cart,
												'size' => 'fa-xs',
											)
										);
										?>
										<p class="subtitle is-size-14px mb-0"><?php echo $coursec->post_title; ?></p>
									</div>
								</li>
	
							<?php } ?>
						</ul>
	
							<?php
						}
					}
					?>
					
				</ul>
			
			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="coupon">
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button apply-coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php } ?>
			

			<?php /*<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button> */ ?>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			<p class="is-size-14px has-text-grey mb-2 mt-5"><?php esc_html_e( 'Medios de pago disponibles', 'arkdewp' ); ?></p>
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/cards.png" alt="metodos de pago arkde"  width="210px" style="padding-top:5px;">

		</div>
		<div class="column">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

					<?php
						/**
						 * Cart collaterals hook.
						 *
						 * @hooked woocommerce_cross_sell_display
						 * @hooked woocommerce_cart_totals - 10
						 */
						do_action( 'woocommerce_cart_collaterals' );
					?>
			
		</div>
	</div>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>


<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<?php do_action( 'woocommerce_after_cart' ); ?>
