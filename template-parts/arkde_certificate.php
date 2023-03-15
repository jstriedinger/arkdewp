<?php

$learndash_certificate_link = learndash_get_course_certificate_link( $args['course_id'], $args['user_id'] );
$course_status              = learndash_course_status( $args['course_id'], $args['user_id'], true );
if ( $course_status == 'completed' ) {
	// Completed course
	if ( function_exists( 'rrf_get_user_course_review_id' ) && ! current_user_can( 'administrator' ) ) {
		$user_course_review = rrf_get_user_course_review_id( $args['user_id'], $args['course_id'] );
		if ( empty( $user_course_review ) ) {
			// in order to download it, an user must review the course ?>
		<article class="message is-info bulma is-small ">
			<div class="message-body">
				<div class="flex-container">
					<div class="content">
						<h5>Deja una reseña y descarga tu certificado</h5>
						<p>
							¡Felicidades! Completaste todo el curso y esperamos que hayas aprendido mucho. Solo falta una pequeña cosa. 
							Dejanos un reseña con tu opinión y calificación del curso, actualiza esta pagina y podrás descargar tu certificado.
							</p>
					</div>
					<i class="icon is-huge">
						<span class="bb-icon-badge is-huge"></span>
					</i>
				</div>
				
			</div>
		</article>
			
			<?php
		} else {
			?>
			<article class="message bulma is-small is-primary">
				<div class="message-body">
					<div class="flex-container">
						<div class="content">
							<p>
								¡Felicidades por completar el curso! Esperamos que hayas aprendido mucho y te volvamos a ver en otro curso online de ARKDE.<br> En el siguiente enlace podrás descargar tu certificado.
							</p>
							<a href="<?php echo $learndash_certificate_link; ?>" target="_blank" class="button teal">
								<span class="icon">
									<i class="fas fa-download"></i>
								</span>
								<span>Descarga tu certificado aquí</span>
							</a>

						</div>
						<i class="icon is-huge">
							<span class="bb-icon-badge is-huge"></span>
						</i>
					</div>
					
				</div>
			</article>
			<?php
		}
	} else {
		// no review for some reason, so lets just show the certificate
		?>
		<article class="message bulma is-small is-primary">
			<div class="message-body">
				<div class="flex-container">
					<div class="content">
						<p>
							¡Felicidades por completar el curso! Esperamos que hayas aprendido mucho y te volvamos a ver en otro curso online de ARKDE.<br> En el siguiente enlace podrás descargar tu certificado.
						</p>
						<a href="<?php echo $learndash_certificate_link; ?>" target="_blank" class="button teal">
							<span class="icon">
								<i class="fas fa-download"></i>
							</span>
							<span>Descarga tu certificado aquí</span>
						</a>

					</div>
					<i class="icon is-huge">
						<span class="bb-icon-badge is-huge"></span>
					</i>
				</div>
				
			</div>
		</article>
		<?php
	}
} else {
	?>

<article class="message is-info bulma is-small ">
	<div class="message-body">
		<div class="flex-container">
			<div class="content">
				<h5>¡Estás cerca de tu certificado!</h5>
				<p>Completa todo el contenido del curso (incluyendo esta lección), dejanos una reseña del curso y podrás descargar tu certificado online.</p>
			</div>
			<i class="icon is-huge">
				<span class="bb-icon-badge is-huge"></span>
			</i>
		</div>
		
	</div>
</article>

<?php }
?>
