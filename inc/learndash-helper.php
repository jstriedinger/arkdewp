<?php
/**
 * LearnDash Helper Functions
 */

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
		$progress = learndash_user_get_course_progress( $user_id, $course_id );

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

/**
 * Get the course certificate
 *
 * @param [type] $atts
 * @return void
 */
function check_ld_certificate( $atts ) {
	global $post;
	$id = $post->id;
	ob_start();
	get_template_part(
		'template-parts/arkde_certificate',
		null,
		array(
			'course_id' => learndash_get_course_id( $id ),
			'user_id'   => get_current_user_id(),
		)
	);
	return ob_get_clean();
	// return include(locate_template('template-parts/arkde_certificate.php'));
}
add_shortcode( 'arkde_certificate', 'check_ld_certificate' );


