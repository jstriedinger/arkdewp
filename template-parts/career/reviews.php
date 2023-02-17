<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$reviews = $args[0];
if ( ! empty( $reviews ) ) :

	?>
<h3 class="subtitle is-size-4 has-text-weight-bold pt-4 has-text-white"><?php esc_html_e( 'Algunos testimonios', 'arkdewp' ); ?></h3>
<div class="is-flex is-flex-direction-column has-gap-16 career-reviews">

	<?php
	foreach ( $reviews as $key => $review ) :
		$rating = get_post_meta( $review->ID, 'wdm_course_review_review_rating', true );
		?>
		<div class="is-flex is-flex-direction-column has-gap-8">
			<div class="review-head is-flex is-align-items-flex-start">
				<div class="is-flex has-gap-16 is-align-items-center">
					<span class="review-author-img-wrap">
						<?php echo get_avatar( get_the_author_meta( 'ID', $review->post_author ), 64 ); ?>
					</span>
					<div class="is-flex has-gap-8 is-flex-direction-column">
						<div class="is-flex has-gap-16">
							<p class="is-size-6 has-text-weight-bold has-text-white has-lh-one" title="<?php echo esc_attr( get_the_author_meta( 'display_name', $review->post_author ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $review->post_author ) ); ?></p>
							<?php
									// get rating class.
									$average_rating_int = intval( $rating );
									echo "<div class='course-average-rating rating-{$average_rating_int} icon-text is-align-items-center has-gap-5 has-lh-one is-justify-content-center' >";
									echo "<span class='fa-regular arkde-rating-star fa-xs'></span>
									<span class='fa-regular arkde-rating-star fa-xs'></span>
									<span class='fa-regular arkde-rating-star fa-xs'></span>
									<span class='fa-regular arkde-rating-star fa-xs'></span>
									<span class='fa-regular arkde-rating-star fa-xs'></span>
									<span class='has-text-weight-semibold is-size-14px'>" . esc_html( $rating ) . '</span>';
									echo '</div>';
							?>
						</div>
						<p class="is-size-14px has-text-white is-italic">
						<?php
						$course_name = get_the_title( get_post_meta( $testimonial->ID, 'wdm_course_review_review_on_course' )[0] );
						/* translators: %s : human-readable time difference */
						echo esc_html( sprintf( esc_html( 'Curso:  %s', 'arkdewp' ), $course_name ) );
						?>
						</p>
					</div>
				</div> <!-- .review-author-info closing -->
				
			</div> <!-- .review-head closing -->
			<div class="review-body content">
				<strong class="review-title has-text-white"><?php echo esc_html( convert_smilies( $review->post_title ) ); ?></strong>
				<p class="has-text-justified has-text-white"><?php echo convert_smilies( $review->post_content ); // WPCS : XSS ok. ?></p>
			</div> <!-- .review-body closing -->
		</div>
		<?php
		if ( $key < count( $reviews ) - 1 ) :
			echo '<hr style="height:1px;opacity:0.6">';
		endif;
		?>

	<?php endforeach; ?>
</div>
	<?php
endif;
?>
