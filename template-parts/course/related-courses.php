<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$related_courses = $args[0];
?>
<div class="is-hidden-touch">
	<div class="mb-6"></div>
	<h3 class="subtitle is-size-4 has-text-weight-bold pt-4"><?php esc_html_e( 'Cursos parecidos', 'arkdewp' ); ?></h3>
	<div class="columns is-multiline is-variable is-6">
		<?php
		foreach ( $related_courses as $course ) :
			$permalink         = get_permalink( $course );
			$course_price_type = learndash_get_course_meta_setting( $course->ID, 'course_price_type' );
			?>
			<div class="column is-one-third">
				<div class="card course-card-mini">
					<div class="card-header" data-href="<?php echo $permalink; ?>" >
						<?php if ( 'free' === $course_price_type || 'open' === $course_price_type ) : ?>
								<span class="tag is-success is-light is-medium"><?php echo esc_html__( 'Gratis', 'arkdewp' ); ?></span>
						<?php	endif; ?>
						<?php echo get_the_post_thumbnail( $course->ID, 'full' ); ?>
					</div>
					<div class="card-content mb-0">
						<?php
						get_template_part(
							'template-parts/course/course',
							'rating',
							array(
								'course_id' => $course->ID,
								'size'      => 'fa-xs',
							)
						);
						?>
						<a href="<?php echo $permalink; ?>" class="is-size-5 is-size-6-desktop has-text-weight-bold mb-3"><?php echo $course->post_title; ?></a>
					</div>
				</div>	
			</div>
		<?php endforeach; ?>
	</div>
</div>
