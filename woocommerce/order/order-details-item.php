<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
// added stuff for better learndash
$product_id = $product->get_id();
$cid        = get_post_meta( $product_id, '_related_course' );
$args       = array(
	'post__in'       => $cid[0],
	'post_type'      => 'sfwd-courses',
	'posts_per_page' => -1,
);

$term = get_the_terms( $product_id, 'product_cat' )[0];
if ( 'career' === $term->slug ) {
	$item_in_cart = get_field( 'career', $product_id );
	$courses      = ( new WP_Query( $args ) )->posts;
} elseif ( 'course' === $term->slug ) {
	$item_in_cart = ( ( new WP_Query( $args ) )->posts )[0];
}
?>

<li class="cart-item <?php echo $term->slug == 'career' ? 'career' : 'single-course'; ?> is-flex is-align-items-flex-start py-5 has-gap-16">
	<div class="media">
		<?php echo get_the_post_thumbnail( $product_id, 'thumbnail' ); ?>
	</div>
	<div class="is-flex is-flex-direction-column is-align-self-center">
		<?php if ( 'career' === $term->slug ) : ?>
			<span class="is-size-7 has-text-gold has-text-weight-bold is-uppercase"><?php esc_html_e( 'Pack de cursos', 'arkdewp' ); ?></span>
			<p class="subtitle is-size-6 has-text-weight-bold mb-0"><?php echo get_the_title( $item_in_cart ); ?></p>
			<?php
			else :
				$resume_link = buddyboss_theme()->learndash_helper()->boss_theme_course_resume( $item_in_cart->ID );
				?>
				<a class="subtitle is-size-6 has-text-weight-bold mb-0" href="<?php echo esc_url( $resume_link ); ?>"><?php echo $item_in_cart->get_title(); ?></p>
		<?php endif; ?>
		<?php if ( 'career' === $term->slug ) : ?>
				<span class=" is-size-7 has-text-grey-light"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( count( $courses ) ) ); ?></span>
		<?php endif; ?>
	</div>
	<div class="price">
		<p>
		<?php echo '$' . number_format( $order->get_item_subtotal( $item ), 0, ',', '.' ) . ' ' . $order->get_currency(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</p>
	</div>
	
</li>
<?php if ( $term->slug == 'career' ) : ?>
<ul class="pb-5 pt-2">
	<?php
	foreach ( $courses as $coursec ) {
		$resume_link = buddyboss_theme()->learndash_helper()->boss_theme_course_resume( $coursec->ID );
		?>
		<li class="cart-item small is-flex is-align-items-flex-start py-2 has-gap-16">
			<div class="media">
				<?php echo get_the_post_thumbnail( $coursec->ID, 'thumbnail' ); ?>
			</div>
			<div class="is-flex is-flex-direction-column is-align-self-center has-gap-8">
				<?php if ( $resume_link ) : ?>
					<a class="icon-text has-text-link is-size-14px mt-0" href="<?php echo esc_url( $resume_link ); ?>">
						<span><?php echo esc_html( $coursec->post_title ); ?></span>
						<span class="icon">
							<i class="fa-solid fa-arrow-up-right-from-square"></i>
						</span>
					</a>
				<?php else : ?>
					<p class="is-size-14px mt-0"><?php echo esc_html( $coursec->post_title ); ?></p>
				<?php endif; ?>
			</div>
		</li>

		<?php
	}
	?>
</ul>
<?php endif; ?>
