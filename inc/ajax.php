<?php
function get_courses_preview_info() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-arkde-nonce' ) ) {
		wp_send_json_error( 'Failed nonce check', 403 ); // received by JS as 'string'
	}
	if ( ! isset( $_POST['courseids'] ) ) {
		wp_send_json_error( 'Ids can not be empty', 403 );
	}

	$coursesIds      = sanitize_text_field( $_POST['courseids'] );
	$currency        = sanitize_text_field( $_POST['currency'] );
	$current_user_id = get_current_user_id();

	$args = array(
		'post_type'      => 'sfwd-courses',
		'posts_per_page' => -1,
		'post__in'       => explode( ',', $coursesIds ),
	);

	$loop         = new WP_Query( $args );
	$courses_info = array();
	$success      = false;

	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$preview_url = get_field( 'course_video_preview' );
			$success     = true;

			if ( isset( $preview_url ) ) {
				$course_info                = array();
				$course_info['preview_url'] = $preview_url;
				$course_id                  = get_the_ID();
				$course_info['id']          = $course_id;

				$course_info['title'] = get_the_title();
				$course_teachers      = array();

				// teachers.
				foreach ( get_field( 'teachers' ) as $teacher ) {
					$teacher_data          = array();
					$teacher_data['name']  = $teacher->post_title;
					$teacher_data['image'] = get_the_post_thumbnail_url( $teacher->ID );

					array_push( $course_teachers, $teacher_data );
				}
				$course_info['teachers'] = $course_teachers;
				$course_info['students'] = 0;
				$members_arr             = learndash_get_users_for_course( $course_id, array( 'number' => -1 ), false );
				if ( is_a( $members_arr, 'WP_User_Query' ) ) {
					$course_info['students'] = absint( $members_arr->total_users );
				}

				$course_info['description'] = get_field( 'course_description' );
				$course_info['level']       = get_the_terms( $course_id, 'level' )[0]->slug;
				$course_info['duration']    = get_field( 'course_duration' );

				$pricing_info               = array();
				$pricing_info['price_type'] = learndash_get_course_meta_setting( $course_id, 'course_price_type' );

				if ( $pricing_info['price_type'] !== 'free' ) {

					$course_product   = get_field( 'wc_product', $course_id );
					$course_product_id = $course_product->ID;
					$course_product   = wc_get_product( $course_product_id );

					$pricing_info['price']         = wc_get_price_to_display( $course_product, array( 'price' => $course_product->get_price() ) );
					$pricing_info['regular_price'] = wc_get_price_to_display( $course_product, array( 'price' => $course_product->get_regular_price() ) );
					$pricing_info['on_sale']       = $course_product->is_on_sale();

					// format the price depending on currency.
					if ( $currency === 'COP' ) {
						$pricing_info['price']         = number_format( $pricing_info['price'], 0, ',', '.' );
						$pricing_info['regular_price'] = number_format( $pricing_info['regular_price'], 0, ',', '.' );
					} else {
						$pricing_info['price']         = number_format( $pricing_info['price'] );
						$pricing_info['regular_price'] = number_format( $pricing_info['regular_price'] );
					}

					$pricing_info['product_id']  = $course_product_id;
					$course_info['pricing_info'] = $pricing_info;

				}

				if ( sfwd_lms_has_access( $course_id, $current_user_id )
						|| ( current_user_can( 'administrator' ) && LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Section_General_Admin_User', 'courses_autoenroll_admin_users' ) ) ) {
					$course_info['enrolled'] = true;
					// no need to get the price, bc link would to course.
					$next_topic = arkde_dashboard_continue_course( $current_user_id, $course_id );
					$course_info['cta_link'] = $next_topic ? $next_topic['link'] : get_the_permalink( $course_id );
					$course_info['cta_txt']  = esc_html__( 'Sigue con el curso', 'arkdewp' );
				} else {
					$course_info['enrolled'] = false;

					// lets check if its free.
					if ( $pricing_info['price_type'] === 'free' ) {
						// we need to check if user is loggedin but not registered.
						$course_info['cta_link'] = is_user_logged_in() ? get_the_permalink( $course_id ) : wp_login_url( get_the_permalink( $course_id ) );
						$course_info['cta_txt']  = esc_html__( 'Registrate ahora', 'arkdewp' );

					} else {
						// not enrolled and is a paid course
						$course_info['cta_txt'] = esc_html__( 'Compralo ahora', 'arkdewp' );
						if ( matched_cart_items( $course_product_id ) > 0 ) {
							$course_info['cta_link'] = wc_get_checkout_url();
						} else {
							$course_info['cta_link'] = '/?add-to-cart=' . $course_product_id;

						}
					}
				}
				$course_info['pricing_info'] = $pricing_info;
				array_push( $courses_info, $course_info );
			}
		}
	}
	wp_reset_postdata();
	echo wp_json_encode(
		array(
			'success' => $success,
			'data'    => $courses_info,
		)
	);
	wp_die();
}

/**
 * Ajax functions and stuff
 */
function setup_ajax_actions() {
	if ( in_array( 'sfwd-lms/sfwd_lms.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
		add_action( 'wp_ajax_nopriv_courses_preview_info', 'get_courses_preview_info' );
		add_action( 'wp_ajax_courses_preview_info', 'get_courses_preview_info' );
	}
}
setup_ajax_actions();

