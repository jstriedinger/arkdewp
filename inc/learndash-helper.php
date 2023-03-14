<?php
/**
 * LearnDash Helper Functions
 */


/**
 * Get all the URLs of current course ( lesson, topic, quiz )
 *
 * @param        $course_id
 * @param        $lession_list
 * @param string       $course_quizzes_list
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

	$navigation_urls = array();
	if ( ! empty( $lession_list ) ) :

		foreach ( $lession_list as $lesson ) {

			$lesson_topics = learndash_get_topic_list( $lesson->ID );

			$course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );
			$completed       = ! empty( $course_progress[ $course_id ]['lessons'][ $lesson->ID ] ) && 1 === $course_progress[ $course_id ]['lessons'][ $lesson->ID ];

			$navigation_urls[] = array(
				'url'      => learndash_get_step_permalink( $lesson->ID, $course_id ),
				'complete' => $completed ? 'yes' : 'no',
			);

			if ( ! empty( $lesson_topics ) ) :
				foreach ( $lesson_topics as $lesson_topic ) {

					$completed = ! empty( $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ] ) && 1 === $course_progress[ $course_id ]['topics'][ $lesson->ID ][ $lesson_topic->ID ];

					$navigation_urls[] = array(
						'url'      => learndash_get_step_permalink( $lesson_topic->ID, $course_id ),
						'complete' => $completed ? 'yes' : 'no',
					);

					$topic_quizzes = learndash_get_lesson_quiz_list( $lesson_topic->ID );

					if ( ! empty( $topic_quizzes ) ) :
						foreach ( $topic_quizzes as $topic_quiz ) {
							$navigation_urls[] = array(
								'url'      => learndash_get_step_permalink( $topic_quiz['post']->ID, $course_id ),
								'complete' => learndash_is_quiz_complete( get_current_user_id(), $topic_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
							);
						}
						endif;

				}
				endif;

			$lesson_quizzes = learndash_get_lesson_quiz_list( $lesson->ID );

			if ( ! empty( $lesson_quizzes ) ) :
				foreach ( $lesson_quizzes as $lesson_quiz ) {
					$navigation_urls[] = array(
						'url'      => learndash_get_step_permalink( $lesson_quiz['post']->ID, $course_id ),
						'complete' => learndash_is_quiz_complete( get_current_user_id(), $lesson_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
					);
				}
				endif;
		}

		endif;

	$course_quizzes = learndash_get_course_quiz_list( $course_id );
	if ( ! empty( $course_quizzes ) ) :
		foreach ( $course_quizzes as $course_quiz ) {
			$navigation_urls[] = array(
				'url'      => learndash_get_step_permalink( $course_quiz['post']->ID, $course_id ),
				'complete' => learndash_is_quiz_complete( get_current_user_id(), $course_quiz['post']->ID, $course_id ) ? 'yes' : 'no',
			);
		}
		endif;

	$key = array_search( 'no', array_column( $navigation_urls, 'complete' ) );
	if ( '' !== $key && isset( $navigation_urls[ $key ] ) ) {
		return $navigation_urls[ $key ]['url'];
	}

	return '';
}


/**
 * When topic is completed, autocomplete lesson (module) if needed
 */
add_action(
	'learndash_topic_completed',
	function( $topic_data ) {
		// May add any custom logic using $lesson_data
		$clase  = $topic_data['topic'];
		$modulo = $topic_data['lesson'];
		$course = $topic_data['course'];
		if ( $clase->ID == $modulo->ID ) {
			write_log( 'clase created wihtout modulo first' );
			return;
		}
		if ( ! learndash_is_lesson_complete( $topic_data['user']->ID, $modulo->ID, $course->ID ) && ! is_admin() ) {
			// lets check if, with this, all topics from lesson are completed. If so, then complete de lesson
			$topics = learndash_get_topic_list( $modulo->ID, $course->ID );
			if ( ! empty( $topics ) ) {
				$to_complete = true;
				foreach ( $topics as $topic ) {
					if ( $topic->ID != $clase->ID ) {
						if ( ! learndash_is_topic_complete( $topic_data['user']->ID, $topic->ID, $course->ID ) ) {
							// An uncompleted topic, therefore we cant autocomplete the lesson (module)
							$to_complete = false;
							break;
						}
					}
				}
				if ( $to_complete ) {
					learndash_process_mark_complete( $topic_data['user']->ID, $modulo->ID );
				}
			}
		}
	}
);

/**
 * Find the next topic for the user to continue the course
 *
 * @param [type] $user_id
 * @param [type] $course_id
 * @return Topic the next topic name and permalink
 */
function arkde_dashboard_continue_course( $user_id, $course_id ) {

	if ( empty( $user_id ) ) {
		if ( is_user_logged_in() ) {
			$user_id = wp_get_current_user()->ID;

		} else {
			return;
		}
	}
	if ( ! empty( $course_id ) ) {
		$progress    = learndash_user_get_course_progress( $user_id, $course_id );

		if ( 'in_progress' === $progress['status'] ) {

			$last_topic_id = $progress['last_id'];
			// now we must run through the topics to fidn the last one and what would be the next one then
			$found   = false;
			$nextone = false;
			// by default next lesson is first one if theres an error finding it
			$next_lesson = key( reset( $progress['topics'] ) );
			foreach ( $progress['topics'] as $lesson ) {

				while ( $current = current( $lesson ) ) {
					$key = key( $lesson );
					if ( $nextone ) {
						$next_lesson = $key;
						$found       = true;
					}
					if ( $key === $last_topic_id ) {
						$nextone = true;
					}
					$next = next( $lesson );
					if ( false !== $next && $nextone ) {
						$found       = true;
						$next_lesson = key( $lesson );
							break;
					}
				}
				if ( $found ) {
					break;
				}
			}
			if ( null !== $next_lesson ) {
				$l_title = get_the_title( $next_lesson );
				$l_link  = get_the_permalink( $next_lesson );
				return array(
					'title' => $l_title,
					'link'  => $l_link,
				);
			}
		} elseif ( 'not_started' === $progress['status'] ) {
			// lesson will be the first one
			$next_lesson = learndash_get_topic_list( learndash_get_lesson_list( $course_id )[0]->ID, $course_id );

			if ( null !== $next_lesson ) {
				$l_title = get_the_title( $next_lesson );
				$l_link  = get_the_permalink( $next_lesson );
				return array(
					'title' => $l_title,
					'link'  => $l_link,
				);
			}
		}
	}
	return null;
}


