<?php
/**
 * empty Cart Page
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="has-text-centered mt-6 mb-6">
		<h1 class="title is-size-2"><?php esc_html_e( 'Tu carrito está vacio :(', 'arkdewp' ); ?></h1>
		<br>
		<a href="<?php echo get_post_type_archive_link( 'sfwd-courses' ); ?>" class="button is-medium is-purple"><?php echo esc_html__( 'Mira todo los cursos', 'arkdewp' ); ?></a>
</div>
