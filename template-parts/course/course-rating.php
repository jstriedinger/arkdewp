<?php
$course = $args['course'];
if ( function_exists( 'rrf_get_course_rating_details' ) ) :
	$rating_details = rrf_get_course_rating_details( $course->ID ); 
	$averageRating = floatval( $rating_details['average_rating'] );
	if(intval( $rating_details['total_count'] ) > 0 ) {
		//get rating class
		$averageRatingInt = intval($rating_details['average_rating']);
		$isHalf = (floor($rating_details['average_rating']) < $averageRating) ? 'rating-half' : '';
		echo "<div class='course-average-rating rating-{$averageRatingInt} {$isHalf} icon-text is-align-items-center has-gap-4 has-lh-one' >";
		echo "<span class='fa-regular arkde-rating-star'></span>";
		echo "<span class='fa-regular arkde-rating-star'></span>";
		echo "<span class='fa-regular arkde-rating-star'></span>";
		echo "<span class='fa-regular arkde-rating-star'></span>";
		echo "<span class='fa-regular arkde-rating-star'></span>";
		echo "<span class='has-text-weight-semibold'>".round($averageRating,1)."</span>";
		echo '</div>';

	}
endif; 
?>