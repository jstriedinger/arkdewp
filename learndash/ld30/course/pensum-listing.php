<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $lessons && ! empty( $lessons ) ) : ?>
	
	<div class="course-pensum">
	<?php
	foreach ( $lessons as $lesson ) :
		$lesson          = $lesson['post'];
		$topics          = ! empty( $lesson_topics ) && ! empty( $lesson_topics[ $lesson->ID ] ) ? $lesson_topics[ $lesson->ID ] : '';
		$is_free         = learndash_is_sample( $lesson );
		$lesson_duration = get_field( 'duration', $lesson->ID );
		?>
		<div class="lesson-row">
			<div class="lesson-row-header is-flex is-align-items-center is-clickable">
					<i class="fa-solid fa-chevron-down mr-3"></i>
					<span class="subtitle has-text-weight-bold is-size-6 mb-0 mr-3"><?php echo esc_html( $lesson->post_title ); ?></span>
					<?php
					if ( $is_free ) :
						?>
						<span class="tag is-primary is-light is-rounded mr-3"><?php esc_html_e( 'Gratis', 'arkdewp' ); ?></span>
						<?php
					endif;
					?>

					<span class="is-size-14px has-text-grey item-duration"><?php echo sprintf( __( '%1$s - %2$s clases', 'arkdewp' ), esc_attr( $lesson_duration ), esc_attr( count( $topics ) ) ); ?></span>
			</div>
			<div class="lesson-row-topics">
					<?php
					learndash_get_template_part(
						'lesson/pensum-listing.php',
						array(
							'topics' => $topics,
							'free'   => $is_free,
						),
						true
					);
					?>
			</div>
		</div>
		<?php
	endforeach;
	?>
	</div>
<?php endif; ?>
