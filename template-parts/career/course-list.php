<?php
$courses = $args[0];
?>
<h2 class="subtitle is-size-4 has-text-weight-bold has-text-white pt-4"><?php esc_html_e( 'Los cursos', 'arkdewp' ); ?></h2>
<ul class="is-flex is-flex-wrap-wrap bullet-points mb-6">
	<?php foreach ( $courses as $course ) : ?>
		<?php
			$permalink          = esc_url( get_permalink( $course->ID ) );
			$course_price_type  = learndash_get_course_meta_setting( $course->ID, 'course_price_type' );

		?>
		<li>
			<a class="card course-card-tiny is-flex has-gap-16" href="<?php echo $permalink; ?>">
				<div class="card-header">
					<?php echo get_the_post_thumbnail( $course->ID, 'thumbnail' ); ?>
				</div>
				<div class="card-content is-flex is-flex-direction-column has-gap-8">
					<div class="is-flex has-gap-5">
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
						<?php if ( $course_price_type == 'free' || $course_price_type == 'open' ) : ?>
								<span class="tag is-success is-light"><?php echo esc_html__( 'Gratis', 'arkdewp' ); ?></span>
						<?php	endif; ?>
					</div>
					<p class="is-size-6 has-text-white mb-0"><?php echo $course->post_title; ?></p>
					<span class="icon-text">
						<span class="is-size-7 has-text-primary has-text-weight-bold"><?php esc_html_e( 'Más información', 'arkdewp' ); ?></span>
						<span class="icon has-text-primary ml-0">
							<i class="fa-solid fa-chevron-right fa-sm"></i>
						</span>
					</span>
				</div>
			</a>	
		</li>
	<?php endforeach; ?>
</ul>
