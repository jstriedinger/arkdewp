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
	get_template_part( 'template-parts/nav','top',array( ) );
}
add_action( THEME_HOOK_PREFIX . 'header', 'arkde_header' );



