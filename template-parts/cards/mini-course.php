<?php
$course = $args['course'];
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
		<div class="card-header" data-href="<?php echo $permalink; ?>" >
			<?php if ( $course_price_type == 'free' || $course_price_type == 'open' ) : ?>
					<span class="tag is-success is-light is-medium"><?php echo esc_html__( 'Gratis', 'arkdewp' ); ?></span>
			<?php	endif; ?>
			<?php echo get_the_post_thumbnail( $course->ID, 'full' ); ?>
		</div>
		<div class="card-content">
			<?php get_template_part( 'template-parts/course/course', 'rating', array( 'course_id' => $course->ID, 'size' => 'fa-sm' ) ); ?>
			<a href="<?php echo $permalink; ?>" class="is-size-5 has-text-weight-bold mb-4 mt-1"><?php echo $course->post_title; ?></a>
			<?php get_template_part( 'template-parts/cards/course', 'teachers', array( 'teachers' => $teachers ) ); ?>
			<br>
			<a href="<?php echo $permalink; ?>"><?php esc_html__( 'Más información', 'arkdewp' ); ?></a>
		</div>
	</div>	
<?php endif; ?>
