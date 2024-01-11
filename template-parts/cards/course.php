<?php
$course     = $args['course'];
$user_id    = get_current_user_id();
$has_access = sfwd_lms_has_access( $course->ID, $user_id );




if ( $has_access ) {
	// lets get all the info needed
	$course_progress = buddyboss_theme()->learndash_helper()->ld_get_progress_course_percentage( $user_id, $course->ID );
	$next_lesson     = arkde_dashboard_continue_course( $user_id, $course->ID );
}

if ( $course ) :
	$course_preview_url = get_field( 'course_video_preview', $course->ID );
	$teachers           = get_field( 'teachers', $course->ID );
	$permalink          = esc_url( get_permalink( $course->ID ) );
	$course_price_type  = learndash_get_course_meta_setting( $course->ID, 'course_price_type' );
	$course_cats        = get_the_terms( $course->ID, 'ld_course_category' );
	$course_cats_string = '';
	if ( $course_cats ) {
		$last_key = array_search( end( $course_cats ), $course_cats, true );
		foreach ( $course_cats as $key => $category ) {
			$course_cats_string .= $category->slug;
			if ( $key !== $last_key ) {
				$course_cats_string .= ',';
			}
		};
	}
	?>
	
	<div class="card course-card vertical-100" data-course="<?php echo esc_attr( $course->ID ); ?>" id="course-card-<?php echo esc_attr( $course->ID ); ?>" data-categories="<?php echo esc_attr( $course_cats_string ); ?>">
		
	<?php
	if ( 'closed' == $course_price_type ) {
		$wc_product = get_field( 'wc_product', $course->ID );
		$product    = wc_get_product( $wc_product->ID );
		if ( $product ) {
			$is_on_sale = $product->is_on_sale();
			if ( $is_on_sale ) {
				$discount = strval( ceil( 100 - ( ( $product->get_price() * 100 ) / $product->get_regular_price() ) ) );
				?>
				<div class="card-sale-badge">
					-<?php echo $discount;?>%
				</div>
<?php	}
		}
	}
	?>
		<div class="card-header" data-href="<?php echo $permalink; ?>" >
			<?php if ( $course_price_type == 'free' || $course_price_type == 'open' ) : ?>
					<span class="tag is-success is-light is-medium"><?php echo esc_html__( 'Gratis', 'arkdewp' ); ?></span>
			<?php	endif; ?>
			<?php echo get_the_post_thumbnail( $course->ID, 'full' ); ?>
			<?php if ( $has_access ) : ?>
				<progress class="progress is-primary is-small" value="<?php echo $course_progress; ?>" max="100"></progress>
			<?php endif; ?>
		</div>
		<div class="card-content">
			<?php
			get_template_part(
				'template-parts/course/course',
				'rating',
				array(
					'course_id' => $course->ID,
					'size'      => 'fa-sm',
				)
			);
			?>
			<a href="<?php echo $permalink; ?>" class="is-size-5 has-text-weight-bold mb-4 mt-1"><?php echo $course->post_title; ?></a>
			<?php get_template_part( 'template-parts/cards/course', 'teachers', array( 'teachers' => $teachers ) ); ?>
			<?php if ( $has_access && $next_lesson ) : ?>
				<p class="is-size-6 has-text-weight-bold has-text-grey mt-5 mb-2"><?php echo $course_progress; ?>% <?php esc_html_e( 'completado', 'arkdewp' ); ?></p>
				<a href="<?php echo esc_url( $next_lesson['link'] ); ?>" class="button is-purple is-small ">
					<?php esc_html_e( 'Continua con el curso', 'arkdewp' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>	
<?php endif; ?>
