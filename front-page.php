<?php
/**
 * The template for displaying the front page
 *
 * @package ARKDE
 */

get_header();
$meta             = get_fields();
$featured_courses = $meta['featured_courses'];
$partners         = $meta['partners'];
$teachers         = $meta['teachers'];
$testimonials     = $meta['testimonials'];
$tagline          = $meta['tagline'];
$num_users        = count_users()['total_users'];
$bullets          = $meta['bullets'];
$vimeo_id         = $meta['vimeo_id']


?>

<main id="primary">
	<section class="section pb-0 pr-0 pl-0 background-gradient-purple has-image has-video" id="main-section" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>)">
		<?php if ( $vimeo_id != '' ) : ?>
			<div class="video-bg-wrapper">
				<iframe id="video-background" class="fitvidsignore" data-src="https://player.vimeo.com/video/<?php echo esc_attr( $vimeo_id ); ?>?background=1&autoplay=1&loop=1&byline=0&title=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>
			</div>
		<?php endif; ?>
		<div class="container columns is-centered has-text-centered pt-6 pb-5 mt-6 mb-6">
			<div class="column is-full is-three-quarters-widescreen" id="anim-top-section">
				<div class="hr-badge">
					<span>
						<hr>
					</span>
					<img src="<?php echo ARKDE_THEME_URI . 'assets/img/megagrants_white.png'; ?>" alt="epic mega grants recipient" width="70px" height="70px">
					<span>
						<hr>
					</span>
				</div>
				<h1 class="title is-uppercase is-size-2 is-size-1-desktop is-size-0 has-text-weight-bold has-text-white mt-4">
					<?php the_title(); ?>
				</h1>
				<?php if ( $tagline ) : ?>
					<p class="subtitle is-size-4 has-text-white"><?php echo esc_html( $tagline ); ?></p> 
				<?php endif; ?>
				<a href="<?php echo get_post_type_archive_link( 'sfwd-courses' ); ?>" class="button is-medium is-gold"><?php esc_html_e( 'Mira los cursos', 'arkdewp' ); ?></a>

			</div>

		</div>
		
		<img src="<?php echo ARKDE_THEME_URI . 'assets/img/main-section-bottom.svg'; ?>" alt="" class="woosh-svg">
	</section>
	<section class="section">
		<div class="container mb-6">
			<div class="columns is-multiline is-centered">
				<div class="column is-full has-text-centered">
					<h2 class="title is-size-3 has-text-weight-bold mb-4 "><?php echo esc_html__( 'Empieza a aprender hoy mismo', 'arkdewp' ); ?></h2>
				</div>
				<div class="column is-full is-11-fullhd">
					<div class="columns is-4 is-variable anim-bottom-top-children">
					<?php
					if ( $featured_courses ) {
						foreach ( $featured_courses as $course ) {
							?>
									<div class="column" >
							<?php	get_template_part( 'template-parts/cards/course', '', array( 'course' => $course ) ); ?>
									</div>
							<?php
						}
					}
					?>
	
					</div>

				</div>
					<div class="column is-full has-text-centered mt-3">
						<p class="is-size-6"><?php echo esc_html__( 'Instructores y estudiantes en increíbles empresas', 'ardekwp' ); ?></p>
						<div class="columns is-centered mt-2 is-vcentered">
							<div class="column is-two-thirds is-flex is-align-items-center is-flex-wrap-wrap has-gap-16 is-justify-content-center">
							<?php
							if ( $partners ) :
								foreach ( $partners as $partner ) :
									?>
										<img src="<?php echo esc_url( $partner['url'] ); ?>" alt="<?php echo esc_attr( $partner['alt'] ); ?>" style="max-width: 120px" >
									<?php
				  endforeach;
							endif;
							?>

							</div>
						</div>
						<a class="icon-text has-text-link has-text-weight-bold mt-0" href="<?php echo get_post_type_archive_link( 'sfwd-courses' ); ?>">
							<span><?php echo esc_html__( 'Mira todo los cursos', 'arkdewp' ); ?></span>
							<span class="icon">
								<i class="fas fa-chevron-right"></i>
							</span>
						</a>
					</div>
			</div>
		</div>
	</section>
	<section class="section ">
		<div class="container mt-6 mb-6">
			<div class="columns is-8  is-variable is-vcentered is-multiline">
				<div class="column is-full is-one-third-desktop">
					<h3 class="is-size-2 has-text-weight-bold"><?php echo esc_html__( 'Con profesionales de la industria', 'arkdewp' ); ?></h3>
					<p><?php echo esc_html__( 'Aprende directamente de desarrolladores y artistas trabajando en la industria latina y de habla hispana.', 'arkdewp' ); ?></p>
					<a class="icon-text has-text-link has-text-weight-bold mt-5" href="<?php echo get_home_url() . '/nosotros#instructores'; ?>">
						<span><?php echo esc_html__( 'Conoce a los instructores', 'arkdewp' ); ?></span>
						<span class="icon">
							<i class="fas fa-chevron-right"></i>
						</span>
					</a>
				</div>
				<div class="column is-full is-two-thirds-desktop">
							<div class="columns is-variable is-4 anim-right-left-children" >
							<?php
							if ( $teachers ) {
								foreach ( $teachers as $teacher ) {
									?>
												<div class="column is-5" >
									<?php	get_template_part( 'template-parts/cards/teacher', '', array( 'teacher' => $teacher ) ); ?>
												</div>
									<?php
								}
							}
							?>
							</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container mt-6">
			<div class="columns is-centered">
				<div class="column is-full is-6-desktop has-text-centered">
					<h3 class="title is-size-2 has-text-weight-bold"><?php echo sprintf( __( 'Nuestros cursos han ayudado a más de <span class="is-blue">%s estudiantes</span>', 'arkdewp' ), esc_attr( $num_users ) ); ?></h3>

				</div>
			</div>
		</div>
	</section>
	<div class="infinite-slider-columns is-centered mb-6 pb-6" id="arkde-infinite-slider">
		<?php
		for ( $i = 0; $i < count( $testimonials ); $i = $i + 2 ) :
			?>
			<div>
				<?php
					$t1 = $testimonials[ $i ];
					$t2 = $testimonials[ $i + 1 ];
					get_template_part(
						'template-parts/cards/testimonial',
						'',
						array(
							'testimonial' => $t1,
							'extra'       => true,
						)
					);
				if ( $t2 ) {
					get_template_part(
						'template-parts/cards/testimonial',
						'',
						array(
							'testimonial' => $t2,
							'extra'       => true,
						)
					);
				}
				?>
			</div>
	<?php	endfor; ?>
	</div>
	<section class="hero is-medium background-gradient-purple">
		<img src="<?php echo ARKDE_THEME_URI . 'assets/img/section-top.svg'; ?>" alt="" class="woosh-svg">
		<div class="container">
			<div class="hero-body">
				<div class="columns is-variable is-6 is-centered is-vcentered pb-4">
					<div class="column is-narrow has-text-centered">
						<div class="bullet-icons"></div>
					</div>
					<div class="column is-6 content has-text-centered-mobile">
						<p class="title is-size-3 has-text-weight-bold"><?php echo esc_html( $bullets[0]['header'] ); ?></p>
						<p><?php echo esc_html( $bullets[0]['txt'] ); ?></p>
					</div>
				</div>
				<div class="columns is-multiline is-variable is-6 is-centered is-vcentered mt-4 pt-6 pb-6">
					<div class="column is-6 is-vcentered">
						<div class="columns">
							<div class="column is-narrow">
								<div class="bullet-icons bullet-icon-industry is-small"></div>
							</div>
							<div class="column has-text-centered-mobile content">
									<p class="title is-size-4 has-text-weight-bold"><?php echo esc_html( $bullets[1]['header'] ); ?></p>
								<p><?php echo esc_html( $bullets[1]['txt'] ); ?></p>
							</div>
						</div>
					</div>
					<div class="column is-6">
						<div class="columns is-vcentered">
							<div class="column is-narrow">
								<div class="bullet-icons bullet-icon-awards is-small"></div>
							</div>
							<div class="column has-text-centered-mobile content">
								<p class="title is-size-4 has-text-weight-bold"><?php echo esc_html( $bullets[2]['header'] ); ?></p>
								<p><?php echo esc_html( $bullets[2]['txt'] ); ?></p>
							</div>
						</div>
					</div>
					
				</div>
				<div class="columns is-centered pt-6">
					<div class="column is-8 has-text-centered">
						<h3 class="title is-size-3 is-size-2-desktop"><?php echo esc_html__( '¿Qué estás esperando?', 'arkdewp' ); ?></h3>
						<p class="subtitle is-size-6 is-size-4-desktop"><?php echo esc_html__( 'Empieza con uno de nuestros cursos gratis', 'arkdewp' ); ?></p>
						<a href="<?php echo wp_registration_url(); ?>" class="button is-medium is-gold"><?php esc_html_e( 'Registrate aquí', 'arkdewp' ); ?></a>
					</div>
				</div>

			</div>
		</div>
	</section>
</main><!-- #main -->
<?php
get_template_part( 'template-parts/modals/course', 'card-preview' );
get_footer();
