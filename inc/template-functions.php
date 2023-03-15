<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ARKDE
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function arkdewp_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'arkdewp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function arkdewp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'arkdewp_pingback_header' );

// ---------------------- ARKDE ------------------------------------//
function arkde_header() {
	// Mobile header check.
	get_template_part( 'template-parts/nav', 'top', array() );
}
add_action( THEME_HOOK_PREFIX . 'nav', 'arkde_header' );


// Remove pagination of courses archive page, show all by default
function arkde_no_pagintion_courses( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'sfwd-courses' ) && $query->is_main_query() ) {
		$query->set( 'posts_per_page', 2 );
		return;
	}
}
add_action( 'pre_get_posts', 'arkde_no_pagintion_courses', 1 );

add_action( 'wp_loaded', 'change_WISDMreview_selector' );
function change_WISDMreview_selector() {
	global $rrf_ratings_settings;
	$rrf_ratings_settings['selectors'] = apply_filters(
		'rrf_rating_selectors',
		array( 'span.ratings-here' )
	);
}

/**
 * Check to see if the current page is the login/register page.
 *
 * Use this in conjunction with is_admin() to separate the front-end
 * from the back-end of your theme.
 *
 * @return bool
 */
if ( ! function_exists( 'is_login_page' ) ) {
	function is_login_page() {
		return in_array(
			$GLOBALS['pagenow'],
			array( 'wp-login.php', 'wp-register.php' ),
			true
		);
	}
}

/**
 * CSS styles used for login page
 *
 * @return void
 */
function my_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

/**
 * Used to prevent acces to dashboard page when not logged in
 *
 * @return void
 */
function dashboard_redirect() {
	if ( is_page( 'dashboard' ) && ! is_user_logged_in() ) {
		wp_redirect( home_url() );
		die;
	}
}
add_action( 'template_redirect', 'dashboard_redirect' );

/**
 * Redirect all loggedin users to dashboard
 *
 * @return void
 */
function custom_login_redirect() {
	return 'home_url()/dashboard';
}

add_filter( 'login_redirect', 'custom_login_redirect' );

/**
 * Get the prev and next topics from buddyboss content urls, with no formatting
 *
 * @param array  $url_arr
 * @param string $current_url
 * @return void
 */
function arkde_theme_custom_next_prev_url( $url_arr = array(), $current_url = '' ) {

	if ( empty( $url_arr ) ) {
		return;
	}

	// Protocol
	$url = ( is_ssl() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	// Get current URL
	$current_url = trailingslashit( $url );
	if ( ! $query = parse_url( $current_url, PHP_URL_QUERY ) ) {
		$current_url = trailingslashit( $current_url );
	}

	$key = array_search( urldecode( $current_url ), $url_arr );

	$url = array();

	$next = current( array_slice( $url_arr, array_search( $key, array_keys( $url_arr ) ) + 1, 1 ) );
	$prev = current( array_slice( $url_arr, array_search( $key, array_keys( $url_arr ) ) - 1, 1 ) );

	$last_element = array_values( array_slice( $url_arr, - 1 ) )[0];

	$url['next'] = ( isset( $next ) && $last_element != $current_url ) ? $next : '';
	$url['prev'] = ( isset( $prev ) && $last_element != $prev ) ? $prev : '';

	return $url;
}



