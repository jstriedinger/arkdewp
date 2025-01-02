<?php

$learndash_certificate_link = learndash_get_course_certificate_link( $args['course_id'], $args['user_id'] );
$course_status              = learndash_course_status( $args['course_id'], $args['user_id'], true );

	// get course progres
$course_progress = get_user_meta( $args['user_id'], '_sfwd-course_progress', true );
if ( ! isset( $course_progress[  $args['course_id'] ] ) ) {
	// if is not on the meta then get it from db
	$course_progress = learndash_user_get_course_progress( $args['user_id'],  $args['course_id'] );
} else {
	$course_progress = $course_progress[ $args['course_id'] ];
}
$course_progress_num = (int) buddyboss_theme()->learndash_helper()->ld_get_progress_course_percentage($args['user_id'], $args['course_id'] );
?>
<article class="card is-small mt-6 with-shadows">
	<div class="card-content">
		<div class="is-flex is-align-items-center has-gap-16">
			<div class="course-progress is-small">
				<?php if (is_numeric($course_progress_num)) : ?>
				<svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
					<circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="transparent"></circle>
					<circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3"></circle>
					<circle class="donut-segment" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3" stroke-dasharray="<?php echo $course_progress_num . ' ' . ( 100 - $course_progress_num ); ?>" stroke-dashoffset="25"></circle>
				</svg>
				<i class="fa-solid fa-trophy"></i>
				<?php endif; ?>
			</div>
			
			<div>
				
<?php
if ( $course_status == 'completed' ) {
	// Completed course
	if ( function_exists( 'rrf_get_user_course_review_id' ) && ! current_user_can( 'administrator' ) ) {
		$user_course_review = rrf_get_user_course_review_id( $args['user_id'], $args['course_id'] );
		if ( empty( $user_course_review ) ) {
			// in order to download it, an user must review the course ?>
						<h5 class="mb-1"><?php echo sprintf( __( '%s%% completado. Ahora falta tu valiracion', 'arkdewp' ), esc_attr( $course_progress_num ) ); ?></h5>
						<p><?php esc_html_e( '¡Felicidades! Completaste todo el curso y ahora solo falta una pequeña cosa. Dejanos una reseña y valoración del curso y podrás descargar tu certificado. Las reseñas nos ayudan a seguir mejorando.', 'arkdewp' ); ?></p>
			<?php
		} else {
			?>
					<h5 class="mb-1"><?php echo sprintf( __( '%s%% completado. Descarga tu certificado', 'arkdewp' ), esc_attr( $course_progress_num ) ); ?></h5>
					<p><?php esc_html_e('¡Felicidades por completar el curso! Esperamos que hayas aprendido mucho. En el siguiente enlace podrás descargar tu certificado.','arkdewp');?></p>
					<a href="<?php echo $learndash_certificate_link; ?>" target="_blank" class="button is-primary is-simple">
						<span><?php esc_html_e('Haz clic aquí','arkdewp'); ?></span>
					</a>

			<?php
		}
	} else {
		// no review for some reason or is administrator, so lets just show the certificate
		?>
				<h5 class="mb-1"><?php echo sprintf( __( '%s%% completado. Descarga tu certificado', 'arkdewp' ), esc_attr( $course_progress_num ) ); ?></h5>
					<p><?php esc_html_e('¡Felicidades por completar el curso! Esperamos que hayas aprendido mucho. En el siguiente enlace podrás descargar tu certificado.','arkdewp');?></p>
					<a href="<?php echo $learndash_certificate_link; ?>" target="_blank" class="button is-primary is-simple">
						<span><?php esc_html_e('Haz clic aquí','arkdewp'); ?></span>
					</a>
		<?php
	}
} else {	?>
				<h5 class="mb-1"><?php echo sprintf( __( '%s%% completado. ¡Sigue así!', 'arkdewp' ), esc_attr( $course_progress_num ) ); ?></h5>
				<p><?php esc_html_e( 'Completa todo el contenido del curso (incluyendo esta lección), deja un reseña y podrás descargar tu certificado online.', 'arkdewp' ); ?></p>
<?php }
?>
			</div>
		</div>
	</div>
</article>
