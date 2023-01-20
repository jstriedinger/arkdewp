<?php
/**
 * This file is the template for showing reviews on the course single page.
 *
 * @package RatingsReviewsFeedback\Public\Reviews
 */

global $post;
if ( empty( $course_id ) ) {
	$course_id = $post->ID;
}
$course_ratings = rrf_get_course_rating_details( $course_id );
$review_split = rrf_get_bar_values( $course_ratings );
$is_review_comments_enabled = get_option( 'wdm_course_review_setting', 1 );
$rating_args = array(
	'size'          => 'xs',
	'show-clear'    => false,
	'show-caption'  => false,
	'readonly'      => true,
);
$can_submit_rating = false;
$review_prompt_text = sprintf( '<span>%s</span>', __( 'Deja tu valoración de este curso', 'wdm_ld_course_review' ) );
$class              = '';
if ( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$can_submit_rating  = rrf_can_user_post_reviews( $user_id, $course_id );
	$show_submission        = false;
	if ( $can_submit_rating ) {
		$show_submission        = true;
		$user_ratings   = rrf_get_user_course_review_id( $user_id, $course_id );
		if ( empty( $user_ratings ) ) {
			$course_ratings['user_rating']  = 0.0;
			$review_btn_text                    = __( 'Deja una reseña', 'arkdewp' );
			$class                          = 'not-rated';
		} else {
			$course_ratings['user_rating']  = intval( get_post_meta( $user_ratings->ID, 'wdm_course_review_review_rating', true ) );
			$review_btn_text                    = __( 'Cambia tu reseña', 'arkdewp' );
			$class                          = 'already-rated';
			$draft_additional_message = '';
			if ( 'pending' == $user_ratings->post_status ) {
				$draft_additional_message = __( 'Estamos procesando tu reseña.', 'wdm_ld_course_review' );
			}
			$review_prompt_text = sprintf( '<span>%s</span><br/><span><small>%s</small></span>%s', __( 'Tu valoración', 'arkdewp' ), $draft_additional_message, rrf_get_star_html_struct( $course_id, $course_ratings['user_rating'], $rating_args ) );
		}
	} else {
		$class              = 'not-allowed';
	}
}
?>
<div id="course-reviews-section" class="course-reviews-section p-0 ">
	<h3 class="subtitle is-size-4  has-text-weight-bold mb-3 has-text-left pt-4"><?php esc_html_e( 'Valoraciones', 'wdm_ld_course_review' ); ?></h2>
	<div class="arkde-reviews-course is-flex is-align-items-center has-gap-64 responsive-gap is-flex-wrap-wrap">
		<div >
				<p class="title is-size-big-4  has-text-centered has-text-weight-bold mb-4">
					<?php echo number_format( $course_ratings['average_rating'], 1 ); ?>
				</p>
					<?php
					$average_rating = floatval( $course_ratings['average_rating'] );
					if ( intval( $course_ratings['total_count'] ) > 0 ) {
						// get rating class.
						$average_rating_int = intval( $course_ratings['average_rating'] );
						$is_half            = ( floor( $course_ratings['average_rating'] ) < $average_rating ) ? 'rating-half' : '';
						echo "<div class='course-average-rating rating-{$average_rating_int} {$is_half} icon-text is-align-items-center has-gap-5 has-lh-one is-justify-content-center' >
						<span class='fa-regular arkde-rating-star fa-lg'></span>
						<span class='fa-regular arkde-rating-star fa-lg'></span>
						<span class='fa-regular arkde-rating-star fa-lg'></span>
						<span class='fa-regular arkde-rating-star fa-lg'></span>
						<span class='fa-regular arkde-rating-star fa-lg'></span>";
						echo '</div>';

					}
					?>
				<div class="reviews-avg-label mt-4">
					<?php esc_html_e( 'Rating promedio', 'arkdewp' ); ?>
				</div>
		</div>
		<div>
			<?php for ( $i = count( $review_split ); $i > 0; $i-- ) : ?>
			<div class="review-split-wrap is-flex">
				<div class="review-split-title"><?php echo esc_html( $i ); ?></div>
				<div class="review-split-percent is-flex-grow-1">
						<div class="review-split-percent-inner review-split-percent-inner-1"></div>
						<div class="review-split-percent-inner review-split-percent-inner-2" style="width:<?php echo esc_attr( $review_split[ $i ]['percentage'] ); ?>%;"></div>
				</div><!-- .review-split-percent closing -->
				<div class="review-split-count"><?php echo esc_html( $review_split[ $i ]['value'] ); ?></div>
			</div>
			<?php endfor; ?>
		</div>
		<?php
		if ( ! is_user_logged_in() ) {
			?>
			<div class="has-text-centered">
				<p class="subtitle is-size-14px mb-2">
					<?php
					echo $review_prompt_text; // WPCS : XSS ok.
					?>
				</p>
				<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="login-to-enroll button is-small is-purple">
						<?php echo esc_html__( 'Inicia sesión', 'wdm_ld_course_review' ); ?>
				</a>
			</div>
			<?php
		}
		if ( $can_submit_rating ) {
			?>
			<div class="has-text-centered">
				<p class="subtitle is-size-14px mb-2">
					<?php
					echo $review_prompt_text; // WPCS : XSS ok.
					?>
				</p>
				<button class="write-a-review button is-small is-purple" data-course_id="<?php echo esc_attr( $course_id ); ?>">
					<?php echo esc_html( $review_btn_text ); ?>
				</button>
			</div>
				<?php
		}
		?>
	</div><!-- .review-top-section closing -->
	<div class="filter-options">
		<div class="select">
			<select class="select-text sort_results" required>
				<option value="date" selected><?php esc_html_e( 'Most Recent', 'wdm_ld_course_review' ); ?></option>
				<option value="meta_value_num"><?php esc_html_e( 'Top Ratings', 'wdm_ld_course_review' ); ?></option>
			</select>
			<span class="select-highlight"></span>
			<span class="select-bar"></span>
			<label class="select-label"><?php esc_html_e( 'Sort by', 'wdm_ld_course_review' ); ?></label>
		</div> <!-- first .select closing -->
		<div class="select">
			<select class="select-text filter_results" required>
				<option value="-1" selected><?php esc_html_e( 'All Stars', 'wdm_ld_course_review' ); ?></option>
				<option value="5"><?php esc_html_e( '5 star only', 'wdm_ld_course_review' ); ?></option>
				<option value="4"><?php esc_html_e( '4 star only', 'wdm_ld_course_review' ); ?></option>
				<option value="3"><?php esc_html_e( '3 star only', 'wdm_ld_course_review' ); ?></option>
				<option value="2"><?php esc_html_e( '2 star only', 'wdm_ld_course_review' ); ?></option>
				<option value="1"><?php esc_html_e( '1 star only', 'wdm_ld_course_review' ); ?></option>
			</select>
			<span class="select-highlight"></span>
			<span class="select-bar"></span>
			<label class="select-label"><?php esc_html_e( 'Filter by', 'wdm_ld_course_review' ); ?></label>
		</div> <!-- second .select closing. -->
	</div> <!-- .filter-options closing -->
	<div class="loader hide"><img src="<?php echo esc_url( RRF_PLUGIN_URL . '/public/images/loader.gif' ); ?>"></div>
	<div class="reviews-listing-wrap" id="reviews-listing-wrap">
		<?php include \ns_wdm_ld_course_review\Review_Submission::get_template( 'reviews-listing.php' ); ?>
	</div><!-- .reviews-listing-wrap closing. -->
	<?php
	if ( ! is_user_logged_in() ) {
		?>
			<div class="write-review-wrap">
				<p class="subtitle is-size-14px mb-2">
					<?php
					echo $review_prompt_text; // WPCS : XSS ok.
					?>
				</p>
				<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="login-to-enroll button is-small is-purple">
					<?php echo esc_html__( 'Login to Review', 'wdm_ld_course_review' ); ?>
				</a>
			</div><!-- .write-review-wrap closing -->
		<?php
	}
	if ( $can_submit_rating ) {
		?>
			<div class="write-review-wrap">
				<p class="subtitle is-size-14px mb-2">
					<?php
					echo $review_prompt_text; // WPCS : XSS ok.
					?>
				</p>
				<button class="write-a-review <?php echo esc_attr( $class ); ?>" data-course_id="<?php echo esc_attr( $course_id ); ?>">
					<?php echo esc_html( $review_btn_text ); ?>
				</button>
			</div><!-- .write-review-wrap closing -->
			<?php
	}
	?>
</div> <!-- .course-reviews-section closing -->
