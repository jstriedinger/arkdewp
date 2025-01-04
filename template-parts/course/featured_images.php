<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$white   = isset( $args['white'] ) ? $args['white'] : false;
$images = $args['featured_images'];
$course_content = get_the_content();
?>

<div class="pt-6"></div>
<h3 class="subtitle is-size-4 has-text-weight-bold pt-2 <?php echo $white ? 'has-text-white' : ''; ?>"><?php esc_html_e( 'Imágenes destacadas', 'arkdewp' ); ?></h3>
<div class="columns is-multiline is-desktop has-text-centered">
	<?php 
	foreach ( $images as $img ) :	?>
	<div class="column is-half-desktop">
		<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" style="max-width: 100%;" >
	</div>
	<?php endforeach;
	?>
</div>	
