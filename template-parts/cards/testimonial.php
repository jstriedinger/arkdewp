<?php
$testimonial = $args['testimonial'];
$with_course = $args['extra'];
if ( $testimonial ) :
	$txt = $testimonial->post_content;
	// lets get the author
	$user = get_user_by( 'id', $testimonial->post_author );
	$avatar = get_avatar_url( $testimonial->post_author );
	$user   = get_user_by( 'id', $testimonial->post_author );
	$user_country = get_user_meta($testimonial->post_author, 'billing_country', true);

	$name   = $user->first_name . ' ' . $user->last_name;
	$rating = get_post_meta( $testimonial->ID, 'wdm_course_review_review_rating' )[0];
	if ( $with_course ) {
		$course_name = get_the_title( get_post_meta( $testimonial->ID, 'wdm_course_review_review_on_course' )[0] );
	}

	$rating_float = floatval( $rating );
	$rating_int   = intval( $rating );
	$is_half      = floor( $rating_int < $rating_float ) ? 'rating-half' : '';
	?>

<div class="card testimonial-card">
	<div class="card-content">
		<p class="is-size-7-mobile is-size-14px"><?php echo esc_html( $txt ); ?></p>
		
	</div>
	<div class="card-footer pt-0">
			<div class="is-flex is-flex-direction-column has-gap-10">
				<div class='course-average-rating fa-xs rating-<?php echo esc_attr( $rating_int . ' ' . $is_half ); ?> icon-text has-gap-5 has-lh-one' >
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
				</div>
				<div>
					<span class="is-size-14px-mobile has-text-weight-bold has-lh-one"><?php echo esc_html( $name ); ?></span></span>
					<?php if ($user_country): ?>
						<span class="fp fp-rounded <?php echo esc_html(strtolower($user_country) ); ?>"></span>
					<?php endif; ?>

				</div>
				<?php	if ( $with_course ) : ?>
						<span class="is-size-7 is-italic has-lh-one">
							<?php echo esc_html( $course_name ); ?>
						</span>
				<?php endif; ?>
			</div>
	</div>
</div>
<?php endif; ?>
