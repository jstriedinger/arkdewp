<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$course_id = $args['course_id'];
$size      = $args['size'] ? $args['size'] : '';
$avg_size  = $size ? ( $size === 'fa-xs' ? 'is-size-7' : ( $size === 'fa-sm' ? 'is-size-6' : '' ) ) : 'is-size-5';
if ( function_exists( 'rrf_get_course_rating_details' ) ) :
	$rating_details = rrf_get_course_rating_details( $course_id );
	$average_rating = floatval( $rating_details['average_rating'] );
	if ( intval( $rating_details['total_count'] ) > 0 ) :
		// get rating class.
		$average_rating_int = intval( $rating_details['average_rating'] );
		$is_half            = ( floor( $rating_details['average_rating'] ) < $average_rating ) ? 'rating-half' : '';
		echo "<div class='course-average-rating {$size} rating-{$average_rating_int} {$is_half} icon-text is-align-items-center has-gap-8 has-lh-one' >
			<span class='fa-regular arkde-rating-star '></span>
			<span class='fa-regular arkde-rating-star'></span>
			<span class='fa-regular arkde-rating-star'></span>
			<span class='fa-regular arkde-rating-star'></span>
			<span class='fa-regular arkde-rating-star'></span>
			<span class='has-text-weight-semibold " . $avg_size . "'>" . esc_html( round( $average_rating, 1 ) ) . '</span>';
		echo '</div>';

	endif;
endif;

