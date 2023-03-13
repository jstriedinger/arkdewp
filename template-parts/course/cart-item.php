<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id = $args['product_id'];

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
// added stuff for better learndash
$course_id    = get_post_meta( $product_id, '_related_course' );
$args         = array(
	'post__in'  => $course_id[0],
	'post_type' => 'sfwd-courses',
	'posts_per_page' => -1,
);
$product_term         = get_the_terms( $product_id, 'product_cat' )[0];
if ( 'career' === $product_term->slug ) {
	$item_in_cart = get_field( 'career', $product_id );
	$courses = ( new WP_Query( $args ) )->posts;
} elseif ( 'course' === $product_term->slug ) {
	$item_in_cart = ( ( new WP_Query( $args ) )->posts )[0];
}
?>

<li class="cart-item <?php echo $product_term->slug == 'career' ? 'career' : 'single-course'; ?> is-flex is-align-items-flex-start py-5 has-gap-16">
	<div class="media">
		<?php echo get_the_post_thumbnail( $product_id , 'thumbnail' ); ?>
	</div>
	<div class="is-flex is-flex-direction-column is-align-self-center">
		<?php if ( 'career' === $product_term->slug ) : ?>
			<span class="is-size-7 has-text-gold has-text-weight-bold is-uppercase"><?php esc_html_e( 'Pack de cursos', 'arkdewp' ); ?></span>
			<p class="subtitle is-size-6 has-text-weight-bold mb-0"><?php echo $item_in_cart->get_title(); ?></p>
			<?php
			else :
				$resume_link = buddyboss_theme()->learndash_helper()->boss_theme_course_resume( $item_in_cart->ID );
				?>
				<a class="subtitle is-size-6 has-text-weight-bold mb-0" href="<?php echo esc_url( $resume_link ); ?>"><?php echo $item_in_cart->get_title(); ?></p>
		<?php endif; ?>
		<?php if ( 'career' === $product_term->slug ) : ?>
				<span class=" is-size-7 has-text-grey-light"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( count( $courses ) ) ); ?></span>
		<?php endif; ?>
	</div>
	<div class="price">
		<p>
		<?php echo '$' . number_format( $order->get_item_subtotal( $item ), 0, ',', '.' ) . ' ' . $order->get_currency(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</p>
	</div>
	
</li>
<?php if ( $product_term->slug == 'career' ) : ?>
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
				<a class="icon-text has-text-link is-size-14px mt-0" href="<?php echo esc_url( $resume_link ); ?>">
					<span><?php echo esc_html( $coursec->post_title ); ?></span>
					<span class="icon">
						<i class="fa-solid fa-arrow-up-right-from-square"></i>
					</span>
				</a>
			</div>
		</li>

		<?php
	}
	?>
</ul>
<?php endif; ?>