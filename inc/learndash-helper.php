<?php
/**
 * LearnDash Helper Functions
 *
 */


use LearnDash_Settings_Section;

/**
	 * Get all the URLs of current course ( lesson, topic, quiz )
	 *
	 * @param        $course_id
	 * @param        $lession_list
	 * @param string $course_quizzes_list
	 *
	 * @return array | string
	 */
	function arkdewp_ld_custom_continue_url_arr( $course_id, $lession_list, $course_quizzes_list = '' ) {
		global $post;

		$course_price_type = learndash_get_course_meta_setting( $course_id, 'course_price_type' );
		if ( $course_price_type == 'closed' ) {
			$courses_progress = arkdewp_get_courses_progress( get_current_user_id() );
			$user_courses     = learndash_user_get_enrolled_courses( get_current_user_id() );
			$course_progress  = isset( $courses_progress[ $course_id ] ) ? $courses_progress[ $course_id ] : null;
			if ( $course_progress <= 0 && ! in_array( $course_id, $user_courses ) ) {
				return get_the_permalink( $course_id );
			}
		}

		$navigation_urls = [];
		if ( ! empty( $lession_list ) ) :

			foreach ( $lession_list as $lesson ) {

				$lesson_topics = learndash_get_topic_list( $lesson->ID );

				$course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );
				$completed       = ! empty( $course_progress[ $course_id ]['lessons'][ $lesson->ID ] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson->ID ];

				$navigation_urls[] = [
					'url'      => learndash_get_step_permalink( $lesson->ID, $course_id ),
					'complete' => $completed ? 'yes' : 'no',
				];

				if ( ! empty( $lesson_topics ) ) :
					foreach ( $lesson_topics as $lesson_topic ) {

						$completed = ! empty( $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ];

						$navigation_urls[] = [
							'url'      => learndash_get_step_permalink( $lesson_topic->ID, $course_id ),
							'complete' => $completed ? 'yes' : 'no',
						];

						$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID );

						if ( ! empty( $topic_quizzes ) ) :
							foreach ( $topic_quizzes as $topic_quiz ) {
								$navigation_urls[] = [
									'url'      => learndash_get_step_permalink( $topic_quiz['post']->ID, $course_id ),
									'complete' => learndash_is_quiz_complete( get_current_user_id(), $topic_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
								];
							}
						endif;

					}
				endif;

				$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID );

				if ( ! empty( $lesson_quizzes ) ) :
					foreach ( $lesson_quizzes as $lesson_quiz ) {
						$navigation_urls[] = [
							'url'      => learndash_get_step_permalink( $lesson_quiz['post']->ID, $course_id ),
							'complete' => learndash_is_quiz_complete( get_current_user_id(), $lesson_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
						];
					}
				endif;
			}

		endif;

		$course_quizzes = learndash_get_course_quiz_list( $course_id );
		if ( ! empty( $course_quizzes ) ) :
			foreach ( $course_quizzes as $course_quiz ) {
				$navigation_urls[] = [
					'url'      => learndash_get_step_permalink( $course_quiz['post']->ID, $course_id ),
					'complete' => learndash_is_quiz_complete( get_current_user_id(), $course_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
				];
			}
		endif;

		$key = array_search( 'no', array_column( $navigation_urls, 'complete' ) );
		if ( '' !== $key && isset( $navigation_urls[ $key ] ) ) {
			return $navigation_urls[ $key ]['url'];
		}

		return '';
	}

	function arkdewp_ld_course_resume( $course_id ) {

		if ( is_user_logged_in() ) {
			if ( ! empty( $course_id ) ) {
				$user           = wp_get_current_user();
				$step_course_id = $course_id;
				$course         = get_post( $step_course_id );

				$lession_list = learndash_get_course_lessons_list( $course_id );
				$lession_list = array_column( $lession_list, 'post' );
				$url          = arkdewp_ld_custom_continue_url_arr( $course_id, $lession_list );

				if ( isset( $course ) && 'sfwd-courses' === $course->post_type ) {
					//$last_know_step = get_user_meta( $user->ID, 'learndash_last_known_course_' . $step_course_id, true );
					$last_know_step = '';

					// User has not hit a LD module yet
					if ( empty( $last_know_step ) ) {

						if ( isset( $url ) && '' !== $url ) {
							return $url;
						} else {
							return '';
						}
					}

					//$step_course_id = 0;
					// Sanity Check
					if ( absint( $last_know_step ) ) {
						$step_id = $last_know_step;
					} else {
						if ( isset( $url ) && '' !== $url ) {
							return $url;
						} else {
							return '';
						}
					}

					$last_know_post_object = get_post( $step_id );

					// Make sure the post exists and that the user hit a page that was a post
					// if $last_know_page_id returns '' then get post will return current pages post object
					// so we need to make sure first that the $last_know_page_id is returning something and
					// that the something is a valid post
					if ( null !== $last_know_post_object ) {

						$post_type        = $last_know_post_object->post_type; // getting post_type of last page.
						$label            = get_post_type_object( $post_type ); // getting Labels of the post type.
						$title            = $last_know_post_object->post_title;

						if ( function_exists( 'learndash_get_step_permalink' ) ) {
							$permalink = learndash_get_step_permalink( $step_id, $step_course_id );
						} else {
							$permalink = get_permalink( $step_id );
						}

						return $permalink;
					}
				}
			}
		} else {
			$course_price_type = learndash_get_course_meta_setting( $course_id, 'course_price_type' );
			if ( $course_price_type == 'open' ) {

				$lession_list = learndash_get_course_lessons_list( $course_id );
				$lession_list = array_column( $lession_list, 'post' );
				$url          = arkdewp_ld_custom_continue_url_arr( $course_id, $lession_list );

				return $url;
			}
		}

		return '';
	}

	function arkdewp_get_courses_progress( $user_id, $sort_order = 'desc' ) {
		$course_completion_percentage = [];

		if ( ! $course_completion_percentage = wp_cache_get( $user_id, 'ld_courses_progress' ) ) {
			$course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );

			if ( ! empty( $course_progress ) && is_array( $course_progress ) ) {

				foreach ( $course_progress as $course_id => $coursep ) {
					// We take default progress value as 1 % rather than 0%
					$course_completion_percentage[ $course_id ] = 1;//

					if ( $coursep['total'] == 0 ) {
						continue;
					}

					$course_steps_count     = learndash_get_course_steps_count( $course_id );
					$course_steps_completed = learndash_course_get_completed_steps( $user_id, $course_id, $coursep );

					$completed_on = get_user_meta( $user_id, 'course_completed_' . $course_id, true );
					if ( ! empty( $completed_on ) ) {

						$coursep['completed'] = $course_steps_count;
						$coursep['total']     = $course_steps_count;

					} else {
						$coursep['total']     = $course_steps_count;
						$coursep['completed'] = $course_steps_completed;

						if ( $coursep['completed'] > $coursep['total'] ) {
							$coursep['completed'] = $coursep['total'];
						}
					}

					// cannot divide by 0
					if ( $coursep['total'] == 0 ) {
						$course_completion_percentage[ $course_id ] = 0;
					} else {
						$course_completion_percentage[ $course_id ] = ceil( ( $coursep['completed'] * 100 ) / $coursep['total'] );
					}
				}
			}

			//Avoid running the queries multiple times if user's course progress is empty
			$course_completion_percentage = ! empty( $course_completion_percentage ) ? $course_completion_percentage : 'empty';

			wp_cache_set( $user_id, $course_completion_percentage, 'ld_courses_progress' );
		}

		$course_completion_percentage = 'empty' !== $course_completion_percentage ? $course_completion_percentage : [];

		if ( ! empty( $course_completion_percentage ) ) {
			// Sort.
			if ( 'asc' == $sort_order ) {
				asort( $course_completion_percentage );
			} else {
				arsort( $course_completion_percentage );
			}
		}

		return $course_completion_percentage;
	}

