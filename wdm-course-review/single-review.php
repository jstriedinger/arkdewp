<?php
/**
 * This file is the template for showing a single review div.
 *
 * $review : Review Post Object.
 * $course_id : Course Post Object
 *
 * @package RatingsReviewsFeedback\Public\Reviews
 */

$rating = get_post_meta( $review->ID, 'wdm_course_review_review_rating', true );
if ( isset( $_COOKIE['rrf-query'] ) && is_user_logged_in() ) {
	$fetched_para = unserialize( base64_decode( urldecode( $_COOKIE['rrf-query'] ) ) );// phpcs:ignore
}
$helpful_count = get_post_meta( $review->ID, 'wdm_helpful_yes', true );
$hide          = 'hide';
$show          = '';
?>
<div class="review-comments-wrap">
	<div class="content-review-details">
		<div class="comment-review-inner">
			<div class="review-head is-align-items-flex-start">
				<div class="review-author-info">
					<span class="review-author-img-wrap">
						<?php echo get_avatar( get_the_author_meta( 'ID', $review->post_author ), 32 ); ?>
					</span>
					<div class="ml-2" style="font-size:0">
						<p class="is-size-14px has-text-weight-bold  mb-1 has-lh-one" title="<?php echo esc_attr( get_the_author_meta( 'display_name', $review->post_author ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $review->post_author ) ); ?></p>
						<span class="is-size-7 has-text-grey">
						<?php
						/* translators: %s : human-readable time difference */
						echo esc_html( sprintf( _x( 'Posted %s ago', '%s = human-readable time difference', 'wdm_ld_course_review' ), human_time_diff( get_the_time( 'U', $review ), current_time( 'timestamp' ) ) ) );
						?>
						</span>
					</div>
				</div> <!-- .review-author-info closing -->
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
				
			</div> <!-- .review-head closing -->
			<div class="review-body">
				<strong class="review-title"><?php echo esc_html( convert_smilies( $review->post_title ) ); ?></strong>
				<p class="has-text-justified is-size-14px"><?php echo convert_smilies( $review->post_content ); // WPCS : XSS ok. ?></p>
			</div> <!-- .review-body closing -->
			<div class="review-footer">
				<div class="review-meta-wrap">
					<span class="review-helpful-wrap">
						<span class="review-helpful-text"><?php esc_html_e( 'Helpful?', 'wdm_ld_course_review' ); ?></span>
						<span class="review-helpful-icon-wrap">
							<?php
							if ( isset( $fetched_para ) && $fetched_para['review_id'] == $review->ID ) {
								update_review_helpful_meta( $user_id, $review->ID, $fetched_para['was_review_helpful'] );
							}
							if ( $helpful_count > 0 && is_user_logged_in() ) {
								$user_rated_reviews = maybe_unserialize( get_user_meta( $user_id, 'wdm_helpful_answers', true ) );
								if ( ! empty( $user_rated_reviews ) && is_array( $user_rated_reviews ) ) {
									$exists = array_key_exists( $review->ID, $user_rated_reviews );
									if ( $exists ) {
										$hide = '';
										$show = 'hide';
									}
								}
							}
							$thumbs_filled = "<a href='#' class='likes wdm_helpful_no wdm_helpful_no_alt review-helpful-icon-wrap {$hide}' role='button' data-review_id='" . esc_attr( $review->ID ) . "'><img src='" . RRF_PLUGIN_URL . "/public/images/review-helpful-icon.svg' /></a>";
							$helpful_html  = "<a href='#' class='likes wdm_helpful_yes wdm_helpful_yes_alt review-helpful-icon-wrap {$show}' role='button' data-review_id='" . esc_attr( $review->ID ) . "'><img src='" . RRF_PLUGIN_URL . "/public/images/review-helpful-icon-empty.svg' /></a>";
							echo $thumbs_filled;// WPCS : XSS ok.
							echo $helpful_html; // WPCS : XSS ok.
							?>
						</span>
					</span>
					<?php
					$is_not_voted = '';
					if ( $helpful_count <= 0 ) {
						$is_not_voted = 'is-not-voted';
					}
					?>
					<span class="review-helpful-count review-helpful-count-m <?php echo esc_attr( $is_not_voted ); ?>">
						<?php
						$helpful_count = get_post_meta( $review->ID, 'wdm_helpful_yes', true );
						echo esc_html( rrf_get_helpful_message( intval( $helpful_count ) ) );
						?>
					</span>
					<?php
					if ( $is_review_comments_enabled ) {
						$review_link = get_permalink( $review->ID );
						?>
						<a class="reply_to_review_link" href="<?php echo esc_url( $review_link ); ?>" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i></a>
						<?php
					}
					?>
				</div> <!-- .review-meta-wrap closing -->
			</div> <!-- .review-footer closing -->
		</div><!-- .comment-review-inner closing -->
		<?php
		$review_comments = get_comments(
			array(
				'post_id' => $review->ID,
				'status'  => 'approve',
			)
		);
		?>
		<?php if ( count( $review_comments ) > 0 ) : ?>
			<div class="wdm-reply-comments" id="<?php echo esc_attr( 'wdm_review_id_' . $review->ID ); ?>">
				<div class='wdm-review-replies' id='<?php echo esc_attr( 'wdm_review_replies' . $review->ID ); ?>'>
					<?php
					wp_list_comments(
						array(
							'callback'          => 'rrf_load_custom_comment_template',
							'avatar_size'       => 32,
							'type'              => 'comment',
							'per_page'          => 10, // Allow comment pagination.
							'reverse_top_level' => false, // Show the oldest comments at the top of the list.
						),
						$review_comments
					);
					$count = count( $review_comments ) - 1;
					?>
					<?php if ( $count > 0 ) : ?>
						<div class="more-reply-wrap">
							<?php /* translators: %d : Comment replies count. */ ?>
							<a href="#" class="view-comment-alt comment-toggle-alt" data-review="<?php echo esc_attr( $count ); ?>"><?php echo sprintf( esc_html__( 'View %d more replies', 'wdm_ld_course_review' ), esc_html( $count ) ); ?></a>
							<a href="#" class="hide-comment-alt comment-toggle-alt hide" data-review="<?php echo esc_attr( $count ); ?>"><?php echo esc_html__( 'Show less replies', 'wdm_ld_course_review' ); ?></a>
						</div> <!-- .more-reply-wrap closing -->
					<?php endif; ?>
				</div> <!-- .wdm-review-replies closing -->
			</div> <!-- .wdm-reply-comments closing -->
		<?php endif; ?>
	</div> <!-- .content-review-details closing -->
</div><!-- .review-comments-wrap closing -->
