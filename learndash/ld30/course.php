<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * * Available Variables:

 * @package ARKDE
 * $course_id       : (int) ID of the course
 * $course      : (object) Post object of the course
 * $course_settings : (array) Settings specific to current course
 *
 * $courses_options : Options/Settings as configured on Course Options page
 * $lessons_options : Options/Settings as configured on Lessons Options page
 * $quizzes_options : Options/Settings as configured on Quiz Options page
 *
 * $user_id         : Current User ID
 * $logged_in       : User is logged in
 * $current_user    : (object) Currently logged in user object
 *
 * $course_status   : Course Status
 * $has_access  : User has access to course or is enrolled.
 * $materials       : Course Materials
 * $has_course_content      : Course has course content
 * $lessons         : Lessons Array
 * $quizzes         : Quizzes Array
 * $lesson_progression_enabled  : (true/false)
 * $has_topics      : (true/false)
 * $lesson_topics   : (array) lessons topics
 */

$members = learndash_get_users_for_course( $course_id, array( 'number' => -1 ), false );
if ( ( $members instanceof WP_User_Query ) && ( property_exists( $members, 'results' ) ) && ( ! empty( $members->results ) ) ) {
	$members = count( $members->get_results() );
}

// extra variables.
$meta            = get_fields();
$wc_product      = get_field( 'wc_product', $course_id );
$in_cart         = false;
$login_modal     = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Theme_LD30', 'login_mode_enabled' );
$login_url       = wp_login_url( get_the_permalink( $course_id ) );
$currency        = get_woocommerce_currency();
$preview_url     = $meta['course_video_preview'];
$course_image    = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$bullets         = $meta['info']['what_to_learn'];
$new_course      = $meta['info']['new_course'];
$reqs            = $meta['info']['requirements'];
$teachers        = $meta['teachers'];
$duration        = $meta['course_duration'];
$challenges      = $meta['info']['challenges'];
$level           = get_the_terms( $course, 'level' )[0];
$related_courses = isset( $meta['related_courses'] ) ?  $meta['related_courses'] : array();
$career          = $meta['career'];



if ( $has_access ) {
	$course_progress = buddyboss_theme()->learndash_helper()->ld_get_progress_course_percentage( $user_id, $course_id );
	$resume_link     = buddyboss_theme()->learndash_helper()->boss_theme_course_resume( $course_id );
} else {
	if ( matched_cart_items( $wc_product->ID ) > 0 ) {
		$in_cart = true;
	} else {
		$in_cart = false;
	}
	$product = wc_get_product( $wc_product->ID );
	if ( $currency === 'COP' ) {
		$price         = number_format( $product->get_price(), 0, ',', '.' );
		$regular_price = number_format( $product->get_regular_price(), 0, ',', '.' );
	} else {
		$price         = number_format( $product->get_price() );
		$regular_price = number_format( $product->get_regular_price() );
	}
	$is_on_sale = $product->is_on_sale();
	if ( $is_on_sale ) {
		$discount = strval( ceil( 100 - ( ( $price * 100 ) / $regular_price ) ) );
	}
}

// get nums of lessons
$num_topics = 0;
foreach ( $lesson_topics as $lesson_topic ) {
	$num_topics += count( $lesson_topic );
}
get_template_part( 'template-parts/modals/course', 'preview', array( 'modal_id' => 'course-preview-modal' ) );

?>
	<section class="hero is-medium background-gradient-purple has-image mb-0" style="background-image: url(<?php echo $course_image; ?>)" id="course-top-section">
		<div class="hero-body">
			<div class="container">
				<div class="columns is-variable is-8">
					<div class="column is-6 ">
						<div class="level mb-2 is-mobile">
							<div class="level-left">
								<div class="level-item">
									<?php get_template_part( 'template-parts/course/course', 'rating', array( 'course_id' => $course->ID ) ); ?>
								</div>
								<?php if ( $members > 10 ) : ?>
									<div class="level-item">
										<span class="icon-text has-text-white">
											<span class="icon">
												<i class="fa-solid fa-users"></i>
											</span>
											<span><?php echo sprintf( esc_html__( '%s+ estudiantes', 'arkdewp' ), esc_attr( strval( $members ) ) ); ?></span>
										</span>
									</div>
								<?php endif; ?>
								<?php if ( $new_course ) : ?>
									<div class="level-item">
										<span class="tag is-primary is-light is-rounded"><?php esc_html_e( '¡Nuevo!', 'arkdewp' ); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<h1 class="title has-text-white is-size-2 is-size-1-fullhd mt-0 has-text-weight-bold"><?php the_title(); ?></h1>
						<p class="is-size-6 has-text-white mb-5 has-text-justified"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
						<?php
						if ( $has_access ) :
							?>
							<div class="mb-3">
								<span class="is-size-6 has-text-white mb-1"><?php echo sprintf( esc_html__( '%s%% completado', 'arkdewp' ), esc_attr( $course_progress ) ); ?></span>
								<progress class="progress is-primary is-small" value="<?php echo esc_attr( strval( $course_progress ) ); ?>" max="100"><?php echo esc_html( $course_progress ); ?>%</progress>
							</div>
							<?php
							if ( $course_progress < 100 ) :
								?>
							<a href="<?php echo esc_url( $resume_link ); ?>" class="button is-primary is-medium"><?php esc_html_e( 'Continua el curso', 'arkdewp' ); ?></a>
								<?php
							else :
								?>
								<a href="<?php echo esc_url( $resume_link ); ?>" class="button is-primary is-medium"><?php esc_html_e( 'Ir al curso', 'arkdewp' ); ?></a>
								<?php
							endif;
						else :
							if ( 'free' === $course_settings['course_price_type'] ) {
								?>
								<p class="is-size-3 has-text-weight-bold mb-2">$0 <span class="is-size-5"> (<?php esc_html_e( 'Gratis!', 'arkdewp' ); ?>)</span></p>
								<?php
								if ( ! is_user_logged_in() ) :
									?>
									<div class="learndash_join_button">
										<a href="<?php echo esc_url( $login_url ); ?>"
												class="button is-primary is-medium"><?php esc_html_e( 'Empieza el curso', 'arkdewp' ); ?></a>
									</div>
									<?php
								else :
									?>
									<div class="learndash_join_button">
										<form method="post">
												<input type="hidden" value="<?php echo esc_attr( $course_id ); ?>" name="course_id"/>
												<input type="hidden" name="course_join"
																value="<?php echo wp_create_nonce( 'course_join_' . $user_id . '_' . $course_id ); ?>"/>

												<button type="submit" class="button is-primary is-medium"><?php esc_html_e( 'Empieza ahora', 'arkdewp' ); ?></button>
										</form>
									</div>
										<?php
								endif;
							} else {
								// not free and does not have access. Show options
								?>
								<p class="is-size-3 has-text-weight-bold mb-1">$<?php echo esc_html( $price ); ?><small class="ml-1 is-size-4"><?php echo esc_html( $currency ); ?></small> 
								<?php
								if ( $is_on_sale ) :
									?>
									<span class="is-size-5 is-line-through has-text-weight-normal has-text-grey-light">$<?php echo esc_html( $regular_price ); ?></span>
									<?php
								endif;

								?>
								</p>

								<?php
								if ( ! $in_cart ) {
									echo apply_filters(
										'woocommerce_loop_add_to_cart_link',
										sprintf(
											'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button is-primary is-medium %s product_type_%s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											$product->is_purchasable() ? 'add_to_cart_button' : '',
											esc_attr( $product->get_type() ),
											esc_html__( 'Compra ahora', 'arkdewp' )
										),
										$product
									);
								} else {
									?>
									<div class="icon-text mb-2 has-text-white">
										<span class="icon">
											<i class="fa-solid fa-circle-check"></i>
										</span>
										<span class="is-size-14px"><?php esc_html_e( 'Ya está en tu carrito', 'arkdewp' ); ?></span>
									</div>
								<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button is-primary is-medium" ><?php esc_html_e( 'Termina tu compra', 'arkdewp' ); ?></a>

									<?php
								}
							}
							?>

							<?php
							endif;
						?>
					</div>
					<div class="column">
						<div class="card course-preview" style="background-image: url(<?php echo esc_attr( $course_image ); ?>)" id="course-preview-launcher" data-preview="<?php echo esc_attr( $preview_url ); ?>">
							<video id="background-video" autoplay loop muted poster="<?php echo esc_attr( $course_image ); ?>">
							<source src="https://assets.codepen.io/6093409/river.mp4" type="video/mp4">
							</video>
							<i class="fa-regular fa-circle-play has-text-white"></i>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>

	<section class="section mt-0" id="course-content">
		<div class="container">
			<div class="columns is-variable is-8 is-multiline">
				<div class="column is-full is-8-widescreen">
					
					<?php
					if ( $career ) {
						get_template_part( 'template-parts/modals/career', '', array( $career ) );
					}
					get_template_part( 'template-parts/course/bulletpoints', '', array( 'bullets' => $bullets ) );
					get_template_part( 'template-parts/course/description', '' );
					?>
					<h3 class="subtitle is-size-4  has-text-weight-bold pt-4"><?php esc_html_e( 'Temario del curso', 'arkdewp' ); ?></h2>
					
					<?php
					learndash_get_template_part(
						'course/pensum-listing.php',
						array(
							'lessons'       => $lessons,
							'lesson_topics' => ! empty( $lesson_topics ) ? $lesson_topics : array(),
						),
						true
					);
					get_template_part( 'template-parts/course/req', '', array( $reqs ) );
					do_action( 'learndash-course-content-list-after', $course_id, $user_id );
					get_template_part( 'template-parts/course/teachers', '', array( $teachers ) );
					echo do_shortcode( '[rrf_course_review course_id="{$course_id}""]' );
					if ( ! empty( $related_courses ) ) {
						get_template_part( 'template-parts/course/related-courses', '', array( $related_courses ) );

					}
					do_action( 'learndash-course-content-list-after', $course_id, $user_id );
					do_action( 'learndash-course-after', get_the_ID(), $course_id, $user_id );
					?>

					
				</div>
				<div class="column is-full is-4-widescreen ">
					<div class="card bb-sticky-sidebar with-shadows">
						<div class="card-content">
							<div class="is-flex is-flex-direction-column">
								<?php
								if ( $has_access ) :
									?>
											<span class="is-size-6 mb-1"><?php echo sprintf( esc_html__( '%s%% completado', 'arkdewp' ), esc_attr( $course_progress ) ); ?></span>
											<progress class="progress is-primary is-small" value="<?php echo esc_attr( strval( $course_progress ) ); ?>" max="100"><?php echo esc_html( $course_progress ); ?>%</progress>
										<?php
										if ( $course_progress < 100 ) :
											?>
										<a href="<?php echo esc_url( $resume_link ); ?>" class="button is-primary is-medium is-fullwidth"><?php esc_html_e( 'Continua el curso', 'arkdewp' ); ?></a>
											<?php
										else :
											?>
											<a href="<?php echo esc_url( $resume_link ); ?>" class="button is-primary is-medium is-fullwidth"><?php esc_html_e( 'Ir al curso', 'arkdewp' ); ?></a>
											<?php
										endif;
									else :
										if ( 'free' === $course_settings['course_price_type'] ) {
											?>
											<p class="is-size-3 has-text-weight-bold mb-2">$0 <span class="is-size-5"> (<?php esc_html_e( 'Gratis!', 'arkdewp' ); ?>)</span></p>
											<?php
											if ( ! is_user_logged_in() ) :
												?>
												<div class="learndash_join_button">
													<a href="<?php echo esc_url( $login_url ); ?>"
															class="button is-primary is-medium"><?php esc_html_e( 'Empieza el curso', 'arkdewp' ); ?></a>
												</div>
												<?php
											else :
												?>
												<div class="learndash_join_button">
													<form method="post">
															<input type="hidden" value="<?php echo esc_attr( $course_id ); ?>" name="course_id"/>
															<input type="hidden" name="course_join"
																			value="<?php echo wp_create_nonce( 'course_join_' . $user_id . '_' . $course_id ); ?>"/>

															<button type="submit" class="button is-primary is-medium"><?php esc_html_e( 'Empieza ahora', 'arkdewp' ); ?></button>
													</form>
												</div>
													<?php
											endif;
										} else {
											// not free and does not have access. Show options
											?>
											<div class="is-flex is-align-items-flex-end mb-4">
												<div class="is-flex is-flex-direction-column">
													<?php
													if ( $is_on_sale ) :
														?>
														<span class="is-size-5 is-line-through has-text-weight-normal has-text-grey-light ml-2 mb-0">$<?php echo esc_html( $regular_price ); ?></span>
														<?php
													endif;
													?>
													<span class="is-size-3 has-text-weight-bold has-lh-one">$<?php echo esc_html( $price ); ?><small class="ml-1 is-size-4"><?php echo esc_html( $currency ); ?></small> </span>
													
												</div>
													<?php
													if ( $is_on_sale ) :
														?>
														<span class="tag is-danger is-light is-rounded has-text-weight-bold ml-2"><?php echo sprintf( esc_html( '%s%% Dcto' ), esc_attr( strval( $discount ) ) ); ?></span>
														<?php
													endif;
													?>
											</div>

											<?php
											if ( ! $in_cart ) {
												echo apply_filters(
													'woocommerce_loop_add_to_cart_link',
													sprintf(
														'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button is-primary is-medium %s product_type_%s">%s</a>',
														esc_url( $product->add_to_cart_url() ),
														esc_attr( $product->get_id() ),
														esc_attr( $product->get_sku() ),
														$product->is_purchasable() ? 'add_to_cart_button' : '',
														esc_attr( $product->get_type() ),
														esc_html__( 'Compra ahora', 'arkdewp' )
													),
													$product
												);
											} else {
												?>
												<div class="icon-text mb-2 has-text-grey">
													<span class="icon">
														<i class="fa-solid fa-circle-check"></i>
													</span>
													<span class="is-size-14px"><?php esc_html_e( 'Ya está en tu carrito', 'arkdewp' ); ?></span>
												</div>
											<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button is-primary is-medium" ><?php esc_html_e( 'Termina tu compra', 'arkdewp' ); ?></a>

												<?php
											}
										}
										?>

										<?php
										endif;
									?>
									<div class="is-flex mt-5 pt-1">
										<ul>
											<li>
												<div class="icon mr-1">
													<i class="fa-solid fa-video"></i>
												</div>
												<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s+ en video', 'arkdewp' ), esc_attr( $duration ) ); ?></span>
											</li>
											<li class="mt-2">
												<div class="icon mr-1">
													<i class="fa-solid fa-book"></i>
												</div>
												<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s clases', 'arkdewp' ), esc_attr( $num_topics ) ); ?></span>
											</li>
											<?php if ( $challenges ) : ?>
												<li class="mt-2">
													<div class="icon mr-1">
														<i class="fa-solid fa-feather"></i>
													</div>
													<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s desafios', 'arkdewp' ), esc_attr( $challenges ) ); ?></span>
												</li>
											<?php endif; ?>
											<li class="mt-2">
												<div class="icon mr-1">
													<span class="course-level-icon level-<?php echo esc_attr( $level->slug ); ?> mr-1">
														<div class="level-bar"></div>
														<div class="level-bar"></div>
														<div class="level-bar"></div>
													</span>
												</div>
												<span class="is-size-14px"><?php echo sprintf( esc_html__( 'Nivel: %s', 'arkdewp' ), esc_attr( $level->name ) ); ?></span>
											</li>
											<li class="mt-2">
												<div class="icon mr-1">
													<i class="fa-solid fa-award "></i>
												</div>
												<span class="is-size-14px"><?php echo esc_html__( 'Certificado de finalización', 'arkdewp' ); ?></span>
											</li>
											<li class="mt-2">
												<div class="icon mr-1">
													<i class="fa-solid fa-users  m"></i>
												</div>
												<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s+ estudiantes', 'arkdewp' ), esc_attr( strval( $members ) ) ); ?></span>
											</li>
										</ul>
									</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
