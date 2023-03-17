<?php
/**
 * LearnDash LD30 Displays a topic.
 *
 * Available Variables:
 *
 * $course_id                 : (int) ID of the course
 * $course                    : (object) Post object of the course
 * $course_settings           : (array) Settings specific to current course
 * $course_status             : Course Status
 * $has_access                : User has access to course or is enrolled.
 *
 * $courses_options            : Options/Settings as configured on Course Options page
 * $lessons_options            : Options/Settings as configured on Lessons Options page
 * $quizzes_options            : Options/Settings as configured on Quiz Options page
 *
 * $user_id                    : (object) Current User ID
 * $logged_in                  : (true/false) User is logged in
 * $current_user               : (object) Currently logged in user object
 * $quizzes                    : (array) Quizzes Array
 * $post                       : (object) The topic post object
 * $lesson_post                : (object) Lesson post object in which the topic exists
 * $topics                     : (array) Array of Topics in the current lesson
 * $all_quizzes_completed      : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
 * $lesson_progression_enabled : (true/false)
 * $show_content               : (true/false) true if lesson progression is disabled or if previous lesson and topic is completed.
 * $previous_lesson_completed  : (true/false) true if previous lesson is completed
 * $previous_topic_completed   : (true/false) true if previous topic is completed
 *
 * @since 3.0.0
 *
 * @package LearnDash\Templates\LD30
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lesson_data = $post;

if ( empty( $course_id ) ) {
	$course_id = learndash_get_course_id( $lesson_data->ID );

	if ( empty( $course_id ) ) {
		$course_id = buddyboss_theme()->learndash_helper()->ld_30_get_course_id( $lesson_data->ID );
	}
}

$lession_list    = learndash_get_course_lessons_list( $course_id, null, array( 'num' => - 1 ) );
$lession_list    = array_column( $lession_list, 'post' );
$content_urls    = buddyboss_theme()->learndash_helper()->buddyboss_theme_ld_custom_pagination( $course_id, $lession_list );
$pagination_urls = arkde_theme_custom_next_prev_url( $content_urls );

if ( empty( $course ) ) {
	if ( empty( $course_id ) ) {
		$course = learndash_get_course_id( $lesson_data->ID );
	} else {
		$course = get_post( $course_id );
	}
}
$lesson_id = learndash_get_lesson_id( $lesson_data->ID );
$topics    = learndash_get_topic_list( $lesson_id, $course_id );

$lesson_no = 1;
foreach ( $lession_list as $les ) {
	if ( $les->ID == $lesson_id ) {
		break;
	}
	$lesson_no ++;
}

$topic_no = 1;
foreach ( $topics as $topic ) {
	if ( $topic->ID == $post->ID ) {
		break;
	}
	$topic_no ++;
}

// lets get the video
$matches = array();
preg_match( '#<div class="ld-video" (.*?)>(.*?)</div>#', $content, $matches );
if ( ! empty( $matches ) ) {
	echo 'video found!';
	$video = $matches[0];
	var_dump( $video );
}

// previous and next likns
$next = learndash_next_post_link( '', true );
$prev = learndash_previous_post_link( '', true );

// check if lesson sidebar is closed.
$sidebar_open_class = '';
if ( ( isset( $_COOKIE['coursesidebar'] ) && 'open' === $_COOKIE['coursesidebar'] ) ) {
	$sidebar_open_class = 'is-active';
}

?>

<div class="columns is-gapless">
	<div class="column course-sidebar left-side <?php echo esc_attr( $sidebar_open_class ); ?>" id="course-sidebar">
		<?php
		if ( ! empty( $course ) ) :
			include locate_template( '/learndash/ld30/course-sidebar.php' );
		endif;
		?>
	</div>

	<div class="column">
			<!-- video lesson -->
			
			<?php if ( isset( $video ) ) : ?>
				<div class="ld-video-wrapper">
					<?php if ( $prev ) : ?>
						<a href="<?php echo esc_url( $prev ); ?>" class="prev-topic is-flex is-align-items-center" title="Previous lesson">
							<i class="fa-solid fa-chevron-left fa-2xl mr-2"></i><span class="is-size-7"><?php esc_html_e( 'Anterior', 'arkdewp' ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a href="<?php echo esc_url( $next ); ?>" class="next-topic is-flex is-align-items-center" title="Next lesson">
							<span class="is-size-7  mr-2"><?php esc_html_e( 'Siguiente', 'arkdewp' ); ?></span><i class="fa-solid fa-chevron-right fa-2xl"></i>
						</a>
					<?php endif; ?>
						
					<?php echo $video; ?>
				</div>
			<?php endif; ?>
			<div class="container is-max-desktop">
				<div class="column is-fulll <?php echo isset( $video ) ? '' : 'mt-4'; ?>">
					<?php	if ( ! isset( $video ) ) : ?>
						<div class="is-flex is-align-items-center mb-5">
							<?php if ( $pagination_urls['prev'] ) : ?>
								<a href="<?php echo esc_url( $pagination_urls['prev'] ); ?>" class="prev-topic is-flex is-align-items-center no-video" title="Previous lesson">
									<i class="fa-solid fa-chevron-left fa-lg mr-2"></i><span class="is-size-7"><?php esc_html_e( 'Anterior', 'arkdewp' ); ?></span>
								</a>
							<?php endif; ?>
							<?php if ( $pagination_urls['next'] ) : ?>
								<a href="<?php echo esc_url( $pagination_urls['next'] ); ?>" class="next-topic is-flex is-align-items-center no-video" title="Next lesson">
									<span class="is-size-7  mr-2"><?php esc_html_e( 'Siguiente', 'arkdewp' ); ?></span><i class="fa-solid fa-chevron-right fa-lg"></i>
								</a>
							<?php endif; ?>

						</div>
					<?php endif; ?>
					<?php
					$can_complete = false;

					if ( $all_quizzes_completed && $logged_in && ! empty( $course_id ) ) :
						/** This filter is documented in themes/ld30/templates/lesson.php */
						$can_complete = apply_filters( 'learndash-lesson-can-complete', true, get_the_ID(), $course_id, $user_id );
					endif;

					if ( $can_complete ) :
						?>
					<div class="is-flex has-gap-16 is-justify-content-space-between is-align-items-center">
						<div>
							<p class="is-size-14px has-text-grey mb-0"><strong><?php esc_html_e( 'Modulo: ', 'arkdewp' ); ?></strong><?php echo get_the_title( $lesson_post->ID ); ?></p>
							<h1 class="title is-size-3 mt-1"><?php echo sprintf( esc_html__( '%1$s.%2$s %3$s', 'arkdewp' ), $lesson_no, $topic_no, get_the_title() ); ?></h1>
						</div>
						<div>
							
								<?php

								learndash_get_template_part(
									'modules/course-steps.php',
									array(
										'course_id'        => $course_id,
										'course_step_post' => $post,
										'all_quizzes_completed' => $all_quizzes_completed,
										'user_id'          => $user_id,
										'course_settings'  => isset( $course_settings ) ? $course_settings : array(),
										'context'          => 'topic',
										'can_complete'     => $can_complete,
									),
									true
								);
								?>
						</div>
					</div>
								<?php
					else :
						?>
					<p class="subtitle is-size-14px has-text-grey mb-0"><strong><?php esc_html_e( 'Modulo: ', 'arkdewp' ); ?></strong><?php echo get_the_title( $lesson_post->ID ); ?></p>
					<h1 class="title is-size-3 mt-1"><?php echo sprintf( esc_html__( '%1$s.%2$s %3$s', 'arkdewp' ), $lesson_no, $topic_no, get_the_title() ); ?></h1>
						<?php
					endif;
					?>
					<div class="content mt-5">

						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Might output HTML
						echo do_shortcode( $topic->post_content );
						?>
		
					</div>
					<div class="flex bb-position">
						
						<?php

						if ( learndash_lesson_hasassignments( $post ) && ! empty( $user_id ) ) :

							learndash_get_template_part(
								'assignment/listing.php',
								array(
									'user_id'          => $user_id,
									'course_step_post' => $post,
									'course_id'        => $course_id,
									'context'          => 'topic',
								),
								true
							);
							endif;
							$focus_mode         = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Theme_LD30', 'focus_mode_enabled' );
							$post_type          = get_post_type( $post->ID );
							$post_type_comments = learndash_post_type_supports_comments( $post_type );

						if ( is_user_logged_in() && 'yes' === $focus_mode && comments_open() ) {

							learndash_get_template_part(
								'focus/comments.php',
								array(
									'course_id' => $course_id,
									'user_id'   => $user_id,
									'context'   => 'focus',
								),
								true
							);

						} elseif ( true === $post_type_comments ) {
							if ( comments_open() ) :
								comments_template();
								endif;
						}

						if ( $show_content ) :



							if ( ! empty( $quizzes ) ) :

								learndash_get_template_part(
									'quiz/listing.php',
									array(
										'user_id'   => $user_id,
										'course_id' => $course_id,
										'quizzes'   => $quizzes,
										'context'   => 'topic',
									),
									true
								);
							endif;


							endif; // $show_content

						?>
					</div>

				</div>
			</div>
			

	</div>
</div>
