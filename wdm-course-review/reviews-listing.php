<?php
/**
 * This file is the template for showing reviews on the course single page.
 *
 * @package RatingsReviewsFeedback\Public\Reviews
 */

global $reviews_query;
$page_no = 1;
$sort_by = 'date';
if ( isset( $_REQUEST['orderby'] ) ) {
	$sort_by = sanitize_key( $_REQUEST['orderby'] );
}
$review_args = array(
	'posts_per_page' => apply_filters( 'rrf_number_of_reviews_per_page', get_option( 'posts_per_page', 10 ) ),
	// 'posts_per_page'	=> 1,
	'orderby'        => $sort_by,
);
if ( isset( $_REQUEST['filterby'] ) && -1 != sanitize_key( $_REQUEST['filterby'] ) ) {
	$review_args['meta_query']   = array(
		array(
			'key'     => 'wdm_course_review_review_on_course',
			'value'   => $course_id,
			'compare' => '=',
		),
	);
	$review_args['meta_query'][] = array(
		array(
			'key'     => 'wdm_course_review_review_rating',
			'value'   => sanitize_key( $_REQUEST['filterby'] ),
			'compare' => '=',
		),
	);
	// $review_args['meta_query']['relation'] = 'AND';
}
$reviews   = rrf_get_all_course_reviews(
	$course_id,
	$review_args
);
$max_count = $reviews_query->max_num_pages;

?>
<div class="wdm_course_rating_reviews">
	<input type="hidden" value="<?php echo esc_attr( $page_no ); ?>" class="current_page_no" data-course_id="<?php echo esc_attr( $course_id ); ?>" />
	<input type="hidden" value="<?php echo esc_attr( $max_count ); ?>" class="max_page_no" data-course_id="<?php echo esc_attr( $course_id ); ?>" />
	<div class="review_listing">
		<?php
		do_action( 'rrf_before_course_reviews' );
		if ( ! empty( $reviews ) ) {
			foreach ( $reviews as $review ) {
				include \ns_wdm_ld_course_review\Review_Submission::get_template( 'single-review.php' );
			}
		} else {
			?>
			<div><?php esc_html_e( 'No Reviews Found!', 'wdm_ld_course_review' ); ?> </div>
			<?php
		}
		do_action( 'rrf_after_course_reviews' );
		?>
	</div><!-- .review_listing closing -->
	<a href="#" class="has-text-weight-bold load_more_reviews" data-course_id="<?php echo esc_attr( $course_id ); ?>"><span><?php esc_html_e( 'Leer más reseñas ', 'arkdewp' ); ?></span><i class="fa-solid fa-chevron-down"></i></a>
</div> <!-- .wdm_course_rating_reviews closing -->
