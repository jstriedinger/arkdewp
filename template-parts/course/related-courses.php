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
		<?php foreach ( $related_courses as $course ) : ?>
			<div class="column is-one-third">
				<div class="card course-card-mini">
					<div class="card-header" data-href="<?php echo $permalink; ?>" >
						<?php if ( $course_price_type == 'free' || $course_price_type == 'open' ) : ?>
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
								'course' => $course->ID,
								'size'   => 'fa-xs',
							)
						);
						?>
						<a href="<?php echo $permalink; ?>" class="is-size-5 is-size-6-desktop has-text-weight-bold mb-3"><?php echo $course->post_title; ?></a>
						<?php get_template_part( 'template-parts/cards/course', 'teachers', array( 'teachers' => $teachers ) ); ?>
					</div>
				</div>	
			</div>
		<?php endforeach; ?>
	</div>
</div>
