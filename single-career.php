<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ARKDE
 */

get_header();
$currency    = get_woocommerce_currency();
$meta        = get_fields();
$bg_video_id = $meta['bg_video_id'];
$career_icon = $meta['icon'];
$title_tech  = $meta['header']['tech'];
$title_name  = $meta['header']['name'];
$desc        = $meta['desc'];
$preview_url = $meta['career_video_preview'];
$courses     = $meta['courses'];
$num_courses = strval( count( $courses ) );
$duration    = $meta['duration'];
$wc_product  = $meta['wc_product'];
$num_topics  = $meta['num_topics'];
$bullets     = $meta['objectives'];
$reqs        = $meta['requirements'];
$teachers    = $meta['teachers'];
$reviews     = $meta['reviews'];

if ( matched_cart_items( $wc_product->ID ) > 0 ) {
	$in_cart = true;
} else {
	$in_cart = false;
}

$career_product = wc_get_product( $wc_product->ID );
if ( $currency === 'COP' ) {
	$price         = number_format( $career_product->get_price(), 0, ',', '.' );
	$regular_price = number_format( $career_product->get_regular_price(), 0, ',', '.' );
} else {
	$price         = number_format( $career_product->get_price() );
	$regular_price = number_format( $career_product->get_regular_price() );
}
$is_on_sale = $career_product->is_on_sale();
if ( $is_on_sale ) {
	$discount = strval( ceil( 100 - ( ( $price * 100 ) / $regular_price ) ) );
}

// Find num of students
$num_students    = 0;
$course_user_ids = array();
foreach ( $meta['courses'] as $course ) {

	$course_access_users = learndash_get_course_users_access_from_meta( $course->ID );
	$course_user_ids     = array_merge( $course_user_ids, $course_access_users );

	$course_groups_users = learndash_get_course_groups_users_access( $course_id );
	$course_user_ids     = array_merge( $course_user_ids, $course_groups_users );

	if ( ! empty( $course_user_ids ) ) {
		$course_user_ids = array_unique( $course_user_ids );
	}
}
$num_students = count( $course_user_ids );


get_template_part( 'template-parts/modals/course', 'preview', array( 'modal_id' => 'career-preview-modal' ) );
?>

<main id="primary" class="site-main">
<?php
while ( have_posts() ) :
	the_post();
	?>
	<section class="section pr-0 pl-0 background-gradient-purple background-career has-image has-video" id="main-section" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>)">
		<?php if ( $bg_video_id != '' ) : ?>
			<div class="video-bg-wrapper">
				<iframe id="video-background" class="fitvidsignore" data-src="https://player.vimeo.com/video/<?php echo esc_attr( $bg_video_id ); ?>?background=1&autoplay=1&loop=1&byline=0&title=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>
			</div>
		<?php endif; ?>
		<div class="container columns is-centered has-text-centered pt-6 pb-5 mt-6 mb-6">
			<div class="column is-full is-three-quarters-desktop is-half-fullhd" id="anim-top-section">
				<div class="hr-badge is-gold">
					<span>
						<hr>
					</span>
					<img src="<?php echo esc_url( $career_icon ); ?>" alt="carrera arkde curso online" width="80px" height="80px">
					<span>
						<hr>
					</span>
				</div>
				<h1 class="title is-uppercase is-size-2 is-size-1-desktop is-size-0 has-text-light-gold mt-4 has-text-weight-light mb-0">
					<span><?php echo esc_html( $title_tech ); ?></span><br>
					<span class="has-text-weight-bold"><?php echo esc_html( $title_name ); ?></span>
				</h1>
				<div class="tags is-rounded  is-centered mt-2">
					<div class="tag is-rounded is-ligth">
						<span class="icon ml-1">
							<i class="fa-solid fa-layer-group"></i>
						</span>
						<span class="mr-1"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( $num_courses ) ); ?></span>
							
					</div>
					<div class="tag is-rounded is-ligth">
						<span class="icon ml-1">
							<i class="fa-solid fa-clock"></i>
						</span>
						<span class="mr-1"><?php echo esc_html( $duration ); ?></span>
					</div>
					<div class="tag is-rounded is-ligth">
						<span class="icon ml-1">
							<i class="fa-solid fa-users"></i>
						</span>
						<span class="mr-1"><?php echo sprintf( esc_html__( '%s+ estudiantes', 'arkdewp' ), esc_attr( $num_students ) ); ?></span>
					</div>
				</div>
				<p class="subtitle is-size-6 has-text-white pt-3 mb-6"><?php echo esc_html( $desc ); ?></p> 
				<div>
					<a href="" id="career-preview-launcher" data-preview="<?php echo esc_attr( $preview_url ); ?>">
						<i class="fa-solid fa-circle-play has-text-light-gold"></i>
					</a>
					<p class="has-text-white is-size-6 mt-1"><?php esc_html_e( 'Clic para mirar el trailer', 'arkdewp' ); ?></p>
				</div>
			</div>

		</div>
	</section>
	<section class="section" id="course-content">
		<div class="container">
			<div class="columns is-variable is-8 is-multiline">
				<div class="column is-full is-8-widescreen">
					<?php
						get_template_part(
							'template-parts/course/bulletpoints',
							'',
							array(
								'bullets' => $bullets,
								'white'   => true,
							)
						);
						get_template_part( 'template-parts/career/course-list', '', array( $courses ) );
						get_template_part( 'template-parts/course/description', '', array( true ) );
						get_template_part( 'template-parts/course/req', '', array( $reqs, true ) );
						get_template_part( 'template-parts/course/teachers', '', array( $teachers, true ) );
						get_template_part( 'template-parts/career/reviews', '', array( $reviews ) );
					?>
				</div>
				<div class="column is-full is-4-widescreen">
					<div class="card bb-sticky-sidebar">
						<div class="card-content">
							<div class="is-flex is-flex-direction-column">
								<div class="is-flex is-align-items-flex-end mb-4">
									<div class="is-flex is-flex-direction-column">
										<?php
										if ( $is_on_sale ) :
											?>
											<span class="is-size-5 is-line-through has-text-weight-normal has-text-grey-light mb-0">$<?php echo esc_html( $regular_price ); ?></span>
											<?php
										endif;
										?>
										<span class="is-size-3 has-text-weight-bold has-lh-one">$<?php echo esc_html( $price ); ?><small class="ml-1 is-size-6"><?php echo esc_html( $currency ); ?></small> </span>
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
											esc_url( $career_product->add_to_cart_url() ),
											esc_attr( $career_product->get_id() ),
											esc_attr( $career_product->get_sku() ),
											$career_product->is_purchasable() ? 'add_to_cart_button' : '',
											esc_attr( $career_product->product_type ),
											esc_html__( 'Compra ahora', 'arkdewp' )
										),
										$career_product
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
								?>
								<div class="is-flex mt-5 pt-1 ">
									<ul>
										<li>
											<div class="icon mr-1">
												<i class="fa-solid fa-layer-group"></i>
											</div>
											<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( $num_courses ) ); ?></span>
										</li>
										<li class="mt-2">
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
										<li class="mt-2">
											<div class="icon mr-1">
												<i class="fa-solid fa-award "></i>
											</div>
											<span class="is-size-14px"><?php echo esc_html__( 'Certificado en cada curso', 'arkdewp' ); ?></span>
										</li>
										<li class="mt-2">
											<div class="icon mr-1">
												<i class="fa-solid fa-users  m"></i>
											</div>
											<span class="is-size-14px"><?php echo sprintf( esc_html__( '%s+ estudiantes', 'arkdewp' ), esc_attr( strval( $num_students ) ) ); ?></span>
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
	

	<?php
endwhile; // End of the loop.
?>

</main><!-- #main -->

<?php
get_footer();
