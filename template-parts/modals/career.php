<?php
$career      = $args[0];
$meta        = get_fields( $career->ID );
$permalink   = esc_url( get_permalink( $career->ID ) );
$thumbnail   = esc_url( get_the_post_thumbnail_url( $career->ID, 'large' ) );
$icon        = esc_url( $meta['icon'] );
$num_courses = strval( count( $meta['courses'] ) );
$duration    = get_field( 'duration', $career->ID );

$wc_product = $meta['wc_product'];
$product    = wc_get_product( $wc_product->ID );
$discount = strval( ceil( 100 - ( ( $product->get_price() * 100 ) / $product->get_regular_price() ) ) );

?>
<div class="card career-card popup mb-5">
	<div class="card-background" style="background-image: url(<?php echo $thumbnail; ?>)"></div>
	<div class="card-content is-flex is-flex-direction-row has-gap-16 is-align-items-center is-justify-content-start">
		<img src="<?php echo $icon; ?>" alt="" width="100px" class="is-hidden-touch" >
		<div class="column is-two-thirds is-half-fullhd has-text-justified p-0">
			<span class="is-size-5 has-text-weight-bold"><?php echo sprintf( esc_html__( '¡Espera! Ahorra hasta %s%%', 'arkdewp' ), esc_attr( $discount ) ); ?></span>
			<p class="has-text-white is-size-14px pb-2"><?php echo sprintf( __( 'Adquiriendo el pack de cursos <strong>%1$s</strong> que contiene este y otros %2$s cursos mas.', 'arkdewp' ), esc_html( $career->post_title ), esc_html( $num_courses - 1 ) ); ?></p>
			<a href="<?php echo $permalink; ?>" class="has-text-primary is-size-14px has-text-weight-bold">
					<?php esc_html_e( 'Clic para más información', 'arkdewp' ); ?>
			</a>
		</div>
		
	</div>
	<button class="modal-close is-large close-button" aria-label="close"></button>
</div>
