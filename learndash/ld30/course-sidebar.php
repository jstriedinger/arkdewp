<?php

global $post;

$parent_course_data = learndash_get_setting( $post, 'course' );
if ( 0 === $parent_course_data ) {
	$parent_course_data = $course_id;
	if ( 0 === $parent_course_data ) {
		$course_id = buddyboss_theme()->learndash_helper()->ld_30_get_course_id( $post->ID );
	}
	$parent_course_data = learndash_get_setting( $course_id, 'course' );
}

$parent_course       = get_post( $parent_course_data );
$parent_course_link  = $parent_course->guid;
$parent_course_title = $parent_course->post_title;
$parent_course_review_lesson = get_field( 'review_lesson', $parent_course->ID );
$is_enrolled         = false;
$current_user_id     = get_current_user_id();
$get_course_groups   = learndash_get_course_groups( $parent_course->ID );
$course_id           = $parent_course->ID;
$admin_enrolled      = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Section_General_Admin_User', 'courses_autoenroll_admin_users' );
$certificate_link    = learndash_get_course_certificate_link( $parent_course->ID, $current_user_id );
$course_status       = learndash_course_status( $parent_course->ID, $current_user_id, true );
$is_admin            = current_user_can( 'administrator' );


// check if it has access.
if ( sfwd_lms_has_access( $course_id, $current_user_id ) || $is_admin ) {
	$is_enrolled = true;
} else {
	$is_enrolled = false;
}

// get course progres
$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );
if ( ! isset( $course_progress[ $course_id ] ) ) {
	// if is not on the meta then get it from db
	$course_progress = learndash_user_get_course_progress( $user_id, $course_id );
} else {
	$course_progress = $course_progress[ $course_id ];
}
$course_progress_num = buddyboss_theme()->learndash_helper()->ld_get_progress_course_percentage( $user_id, $course_id );
?>

<div class="lms-topic-sidebar-wrapper sidebar-wrapper" >
	<button class="course-sidebar-toggle is-clickable" id="course-sidebar-toggle"></button>
	<div class="lms-topic-sidebar-data">
		<!--<di class="bb-elementor-header-items">
			<a href="#" id="bb-toggle-theme">
				<span class="sfwd-dark-mode" data-balloon-pos="down" data-balloon="<?php esc_attr_e( 'Dark Mode', 'arkdewp' ); ?>"><i class="bb-icon-rl bb-icon-moon"></i></span>
				<span class="sfwd-light-mode" data-balloon-pos="down" data-balloon="<?php esc_attr_e( 'Light Mode', 'arkdewp' ); ?>"><i class="bb-icon-l bb-icon-sun"></i></span>
			</a>
		</div> -->

		<div class="is-flex is-align-items-center py-3 px-4 has-gap-16">
			<div class="course-progress is-small">
				<svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
					<circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="transparent"></circle>
					<circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3"></circle>
					<circle class="donut-segment" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3" stroke-dasharray="<?php echo $course_progress_num . ' ' . ( 100 - $course_progress_num ); ?>" stroke-dashoffset="25"></circle>
				</svg>
				<i class="fa-solid fa-trophy"></i>
			</div>
			<div>
				<p class="has-text-weight-bold is-size-6"><?php echo $course_progress_num; ?>% <?php esc_html_e( 'completado', 'arkdewp' ); ?></p>
				<?php
				if ( 'completed' !== $course_progress['status'] && $course_progress_num < 30 ) :
					?>
					<p class="is-size-6"><?php esc_html_e( '¡Sigue así!', 'arkdewp' ); ?></p>
					<?php else : ?>
						<?php
						$learndash_certificate_link = learndash_get_course_certificate_link( $course_id, $current_user_id );
						$user_course_review         = rrf_get_user_course_review_id( $current_user_id, $course_id );
						if ( $user_course_review ) {
							// he has a review, you can download certificate
							?>
							<a href="<?php echo esc_url( $learndash_certificate_link ); ?>" target="_blank" class="button is-primary is-small is-simple mt-1">
								<span><?php esc_html_e( 'Tu certificado', 'arkdewp' ); ?></span>
								<span class="icon">
									<i class="fas fa-download"></i>
								</span>
							</a>
							
							<?php
						} elseif($parent_course_review_lesson) {
							?>
							<a class="button is-small is-purple is-simple" href="<?php echo esc_url(get_post_permalink($parent_course_review_lesson ) ) ;?>">
								<?php echo esc_html( 'Deja una reseña', 'arkdewp' ); ?>
						</a>
							<?php
						}
						?>
				<?php endif; ?>
			</div>

		</div>

		<div class="lms-lessions-list">
			<?php
			if ( ! empty( $lession_list ) ) :
				$sections = learndash_30_get_course_sections( $parent_course->ID );
				?>
				<ol class="bb-lessons-list">
					<?php
					foreach ( $lession_list as $lesson ) {

						$lesson_topics  = learndash_get_topic_list( $lesson->ID, $parent_course->ID );
						$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID, get_current_user_id(), $course_id );
						$lesson_sample  = learndash_get_setting( $lesson->ID, 'sample_lesson' ) == 'on' ? 'bb-lms-is-sample' : '';

						$is_sample            = learndash_is_sample( $lesson );
						$bb_lesson_has_access = sfwd_lms_has_access( $lesson->ID, $user_id );
						$bb_available_date    = learndash_course_step_available_date( $lesson->ID, $course_id, $user_id, true );
						$locked_class         = apply_filters( 'learndash_quiz_row_atts', ( ( isset( $bb_lesson_has_access ) && ! $bb_lesson_has_access && ! $is_sample ) || ( ! empty( $bb_available_date ) && ! $is_sample ) ? 'lms-is-locked' : 'lms-not-locked' ) );

						if ( $bb_lesson_has_access || ( ! $bb_lesson_has_access && apply_filters( 'bb_theme_ld_show_locked_lessons', true ) ) ) {
							?>
							<li class="lms-lesson-item <?php echo $lesson->ID === $post->ID ? esc_attr( 'current' ) : esc_attr( 'lms-lesson-turnover' ); ?> <?php echo esc_attr( $lesson_sample . ' ' . $locked_class ); ?> <?php echo ( ! empty( $lesson_topics ) || ! empty( $lesson_quizzes ) ) ? '' : esc_attr( 'bb-lesson-item-no-topics' ); ?>">

								<div class="lesson-header is-flex has-gap-16 is-align-items-center <?php echo $lesson->ID === $post->ID ? esc_attr( 'current' ) : ''; ?>">
									<?php
									if ( isset( $sections[ $lesson->ID ] ) ) :
										learndash_get_template_part(
											'lesson/partials/section.php',
											array(
												'section' => $sections[ $lesson->ID ],
												'course_id' => $course_id,
												'user_id' => $user_id,
											),
											true
										);
									endif;

									?>
	
										<?php
										$lesson_progress = buddyboss_theme()->learndash_helper()->learndash_get_lesson_progress( $lesson->ID, $course_id );
										$completed       = ! empty( $course_progress['lessons'][ $lesson->ID ] ) && 1 === $course_progress['lessons'][ $lesson->ID ];
										
										if ( ! $is_enrolled && ! $is_sample ) :
											?>
											<i class="fa-solid fa-lock has-text-grey-darker"></i>
											<?php
											elseif ( $completed ) :
												?>
											<i class="fa-solid fa-circle-check has-text-primary"></i>

									<?php	else : ?>

											<i class="fa-solid fa-circle-check has-text-grey-lighter"></i>
									<?php endif; ?>
										<a class="is-size-14px" href="<?php echo esc_url( get_permalink( $lesson->ID ) ); ?>">
											<?php echo $lesson->post_title; ?>
										</a>
										
											<?php

											if ( $is_sample ) :
												?>
										<span class="tag is-primary is-light is-rounded" style="margin-left:auto"><?php esc_html_e( 'Gratis', 'arkdewp' ); ?></span>
												<?php
										endif;


											$ld_lesson     = array( 'post' => $lesson );
											$content_count = learndash_get_lesson_content_count( $ld_lesson, $course_id );

											if ( ! empty( $lesson_topics ) && count( $lesson_topics ) > 0 && $content_count['quizzes'] > 0 ) {
												?>
											<span class="bb-lesson-sidebar-ld-sep">| </span>
												<?php
											}
											if ( $content_count['quizzes'] > 0 ) :
												?>
											
												<?php
										endif;
											?>
										<div class="lms-toggle-lesson is-clickable">
											<span class=""></span>
										</div>
								</div>

								<div class="lms-lesson-content" <?php echo $lesson->ID === $post->ID ? '' : 'style="display: none;"'; ?>>
											<?php
											if ( ! empty( $lesson_topics ) ) :
												?>
										<ol class="bb-type-list is-flex is-flex-direction-column">
													<?php
													foreach ( $lesson_topics as $lesson_topic ) {
														$bb_topic_has_access = sfwd_lms_has_access( $lesson_topic->ID, $user_id );
														if ( $bb_topic_has_access || ( ! $bb_topic_has_access && apply_filters( 'bb_theme_ld_show_locked_topics', true ) ) ) {

															$topic_settings       = learndash_get_setting( $lesson_topic );
															$lesson_video_enabled = isset( $topic_settings['lesson_video_enabled'] ) ? $topic_settings['lesson_video_enabled'] : null;
															$completed            = ! empty( $course_progress['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress['topics'][ $lesson->ID ][ $lesson_topic->ID ];
															$is_assignment        = get_field( 'is_assignment', $lesson_topic->ID );

															$icon = 'fa-circle fa-xs';
															if($is_assignment) {
																$icon = 'fa-feather';
															}
															elseif(has_term('review', 'ld_topic_category',$lesson_topic->ID))
															{
																$icon = 'fa-heart';
															}
															elseif(has_term('certificate', 'ld_topic_category',$lesson_topic->ID))
															{
																$icon = 'fa-trophy';
															}
															?>
													<li class="lms-topic-item is-flex has-gap-16 is-align-items-center <?php echo $lesson_topic->ID === $post->ID ? esc_attr( 'current' ) : ''; ?>">
															<?php if ( $is_sample || $is_enrolled ) : ?>
																		<?php if ( $lesson_topic->ID === $post->ID ) : ?>
																			
																				<i class="fa-solid <?php echo ( $icon); ?> <?php echo ( $completed ? 'has-text-primary' : 'has-text-grey-lighter' ); ?>"></i>
																				<span class="is-size-14px has-text-weight-bold <?php echo $completed ? esc_attr( 'is-line-through' ) : ''; ?>"><?php echo $lesson_topic->post_title; ?></span>

																		<?php else : ?>
																			<a class="is-flex has-gap-16 is-align-items-center bb-title bb-lms-title-wrap is-size-14px is-flex-grow-1" href="<?php echo esc_url( get_permalink( $lesson_topic->ID ) ); ?>" title="<?php echo esc_attr( $lesson_topic->post_title ); ?>">
																				<i class="fa-solid <?php echo ( $icon); ?> <?php echo ( $completed ? 'has-text-primary' : 'has-text-grey-lighter' ); ?> "></i>
																				<span class="is-size-14px <?php echo $completed ? esc_attr( 'is-line-through' ) : ''; ?>"><?php echo $lesson_topic->post_title; ?></span>	
																			</a>
																		<?php endif; ?>
															<?php else : ?>
																<?php if ( ! $is_enrolled ) : ?>
																	<i class="fa-solid fa-lock has-text-grey-darker fa-xs"></i>
																	<span class="is-size-14px"><?php echo $lesson_topic->post_title; ?></span>
																<?php endif; ?>
															<?php endif; ?>
																<?php
																$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID, get_current_user_id(), $course_id );
																if ( ! empty( $topic_quizzes ) ) :
																	?>
															
																	<?php
																endif;
																?>
													</li>
															<?php
														}
													}
													?>
										</ol>
												<?php
									endif;

											$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID, get_current_user_id(), $course_id ); ?>
											
								</div><?php /*lms-lesson-content*/ ?>
							</li>
											<?php
						}
					}
					?>
				</ol>
			<?php endif; ?>
		</div>
	</div>
</div>
