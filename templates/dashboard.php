<?php
/**
 * Template Name: Dashboard
 *
 * @package ARKDE
 */
if ( ! defined( 'ABSPATH' ) && ! is_user_logged_in() ) {
	exit;
}
get_header();
$user              = wp_get_current_user();
$user_id           = $user->ID;
$user_meta         = get_user_meta( $user_id );
$user_data         = get_userdata( $user_id );
$registered_since  = $user_data->user_registered;
$name              = $user->first_name;
$display_name      = function_exists( 'bp_core_get_user_displayname' ) ? bp_core_get_user_displayname( $user_id ) : $user->display_name;
$edit_profile_link = trailingslashit( bp_displayed_user_domain() . bp_get_profile_slug() . '/edit/group/' );

// get all courses IDs student have access to
$courses = learndash_user_get_enrolled_courses( $user_id, array(), true );

// lets get last accessed course.
$last_course_id = learndash_get_last_active_course( $user_id );
if ( 0 == $last_course_id ) {
	// lets just get last course.
	$last_course_id = end( $courses );
}

// get actual courses data.
if ( ! empty( $courses ) ) {
	$args    = array(
		'post__in'  => $courses,
		'post_type' => 'sfwd-courses',
		'posts_per_page' => -1,
	);
	$courses = ( new WP_Query( $args ) )->posts;
}


?>
<main id="primary">
	<section class="section">
		<div class="container">
			<h1 class="title is-2 has-text-weight-bold mb-6 pt-6"><?php echo sprintf( __( '¡Hola %s! ', 'arkdewp' ), esc_attr( $name ) ); ?>👋</h1>
			<div class="columns is-multiline is-variable is-6">
				<?php
				if ( $last_course_id != 0 && ! empty( $courses ) ) :

					// get last course data
					$last_course = null;
					foreach ( $courses as $c ) {
						if ( $c->ID === $last_course_id ) {
							$last_course = $c;
							break;
						}
					}
					// get % progress
					$course_progress = buddyboss_theme()->learndash_helper()->ld_get_progress_course_percentage( $user_id, $last_course_id );
					$next_lesson     = arkde_dashboard_continue_course( $user_id, $last_course_id );
					?>
					<div class="column is-full pb-0">
						<h2 class="title is-4 has-text-weight-bold"><?php echo esc_html_e( 'Sigue aprendiendo', 'arkdewp' ); ?></h1>
					</div>
					<div class="column is-8">
						<div class="card continue-course with-shadows vertical-100" >
							<div class="card-header">
								<?php echo get_the_post_thumbnail( $last_course->ID ); ?>
								<div class="course-progress">
									<svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
										<circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="transparent"></circle>
										<circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="2"></circle>
										<circle class="donut-segment" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="2" stroke-dasharray="<?php echo $course_progress . ' ' . ( 100 - $course_progress ); ?>" stroke-dashoffset="25"></circle>
									</svg>
									<i class="fa-solid fa-trophy"></i>
									<p class="has-text-weight-bold"><?php echo $course_progress; ?>% <?php esc_html_e( 'completado', 'arkdewp' ); ?></p>
								</div>
							</div>
							<div class="card-content">
								<p class="title is-size-4 pb-5 has-text-weight-bold"><?php echo $last_course->post_title; ?></p>
								<?php if ( $next_lesson ) : ?>
									
									<p class="subtitle is-size-5 mb-2 has-lh-1-5">
										<strong><?php echo esc_html_e( 'Siguiente lección:', 'arkdewp' ); ?></strong><br>
										<span><i class="fa-solid fa-circle-play mr-2"></i><?php echo $next_lesson['title']; ?></span>
									</p>
									<div class="card-footer">
											<a href="<?php echo esc_url( $next_lesson['link'] ); ?>" class="button is-purple">
												<?php esc_html_e( 'Continua con el curso', 'arkdewp' ); ?>
											</a>
									</div>
								<?php endif; ?>
							</div>
						</div>

					</div>
						
				<?php endif; ?>
					<div class="column <?php echo empty( $courses ) ? 'is-5' : 'is-4'; ?>">
						<div class="card with-shadows vertical-100">
								<div class="card-content no-flex has-text-centered">
									<?php echo get_avatar( $user_id, 96, '', '', array( 'class' => 'is-centered' ) ); ?>
									<p class="title is-size-5 pt-2 mb-1"><?php echo $display_name; ?></p>
									<p class="has-text-grey is-size-14px">
									<?php
									printf( __( 'Miembro desde %s', 'arkdewp' ), esc_attr( date( 'M Y', strtotime( $registered_since ) ) ) );
									?>
									</p>

									<a class="button is-outlined is-purple mt-5 is-small" href="<?php echo esc_url( wc_customer_edit_account_url() );?>" title="<?php esc_html_e( 'Editar perfil', 'arkdewp' ); ?>"><?php esc_html_e( 'Editar perfil', 'arkdewp' ); ?></a>
								</div>
						</div>
					</div>
			</div>
			<h2 class="title is-4 has-text-weight-bold mb-4 mt-6"><?php echo esc_html_e( 'Mis cursos', 'arkdewp' ); ?></h2>
			<div class="columns">
				<?php if ( empty( $courses ) ) : ?>
					<div class="column is-full">
						<div class="card">
							<div class="card-content is-align-items-center has-text-centered">
								<i class="icon is-large">
									<span class="fa-solid fa-face-sad-tear is-size-1"></span>
								</i>
								<p class="title is-size-3 mt-3"><?php esc_html_e( 'No tienes acceso a ningun curso', 'arkdewp' ); ?></p>
								<a class="icon-text has-text-link has-text-weight-bold mt-2" href="<?php echo get_post_type_archive_link( 'sfwd-courses' ); ?>">
									<span><?php echo esc_html__( 'Mira todo los cursos', 'arkdewp' ); ?></span>
									<span class="icon">
										<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="column is-full arkde-course-grid anim-bottom-top-children">
					<?php
					foreach ( $courses as $course ) {
						get_template_part( 'template-parts/cards/course', '', array( 'course' => $course ) );
					}
					?>
				</div>
			</div>
			<p class="title is-4 has-text-weight-bold mb-4 mt-6"><?php echo esc_html_e( 'Haz parte de la comunidad', 'arkdewp' ); ?>❤️</p>
			<div class="columns is-variable is-6 mb-6">
					<div class="column is-half">
						<div class="card with-shadows is-horizontal">
							<div class="card-content">
								<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_discord.png" alt="servidos discord ARKDE" width="140px" height="140px" >
								<div style="flex:1">
									<p class="subtitle is-size-5 has-text-weight-bold mb-4"><?php esc_html_e( 'Servidor de Discord', 'arkdewp' ); ?></p>
									<p class="is-size-14px mb-2">El hub principal de nuestra comunidad. Conectate con otros estudiantes, resuelve duda y muchos más.</p>
									<a href="https://discord.com/invite/jGbWRujHXQ" class="has-text-link has-text-weight-bold">Ingresa aquí</a>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-half">
						<div class="card with-shadows">
							<div class="card-content">
								<p class="subtitle is-size-5 has-text-weight-bold mb-4"><?php esc_html_e( 'Redes sociales', 'arkdewp' ); ?></p>
								<div class="is-flex is-flex-wrap-wrap is-justify-content-space-between">
									<a href="https://www.youtube.com/@arkde" title="arkde youtube">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_youtube.png" alt="youtube arkde" width="72px" height="72px" >
									</a>
									<a href="https://www.instagram.com/arkdecol" title="arkde instagram">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_instagram.png" alt="instagram arkde" width="72px" height="72px" >
									</a>
									<a href="https://www.facebook.com/arkdecol" title="arkde facebook">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_fb.png" alt="facebook arkde" width="72px" height="72px" >
									</a>
									<a href="https://www.twitter.com/arkdecol" title="arkde twitter">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_twitter.png" alt="twitter arkde" width="72px" height="72px" >
									</a>
									<a href="https://www.linkedin.com/company/arkde" title="arkde linkedin">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/img/icons_linkedin.png" alt="linkedin arkde" width="72px" height="72px" >
									</a>

								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

