<?php
/**
 * ARKDE functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ARKDE
 */


define( 'ARKDE_THEME_VERSION', '1.0.0' );
define( 'ARKDE_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'ARKDE_THEME_URI', trailingslashit( esc_url( get_stylesheet_directory_uri() ) ) );
define( 'THEME_HOOK_PREFIX', 'arkdewp_' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function arkdewp_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on ARKDE, use a find and replace
		* to change 'arkdewp' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'arkdewp', get_stylesheet_directory_uri() . '/languages' );

	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'navtop'   => esc_html__( 'Top navigation', 'arkdewp' ),
			'footer-1' => esc_html__( 'Footer #1', 'arkdewp' ),
			'footer-2' => esc_html__( 'Footer #2', 'arkdewp' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// deregister Buddyboss customizer
	remove_action( 'wp_head', 'buddyboss_customizer_css' );
}
add_action( 'after_setup_theme', 'arkdewp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function arkdewp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'arkdewp_content_width', 640 );
}
add_action( 'after_setup_theme', 'arkdewp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function arkdewp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'arkdewp' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'arkdewp' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'arkdewp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function arkdewp_scripts() {
	// following ASTRA good practice code.
	$file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
	$assets_uri  = ARKDE_THEME_URI . 'assets/';
	if ( file_exists( get_stylesheet_directory() . '/assets/arkdewp' . $file_prefix . '.css' ) ) {
		$v = ( filemtime( get_stylesheet_directory() . '/assets/arkdewp' . $file_prefix . '.css' ) );
	} else {
		$v = '';
	}

	wp_enqueue_style( 'arkdewp-css', $assets_uri . 'arkdewp' . $file_prefix . '.css', array(), $v, 'all' );
	wp_style_add_data( 'arkdewp-css', 'rtl', 'replace' );

	wp_enqueue_script( 'arkdewp-js', $assets_uri . 'arkdewp' . $file_prefix . '.js', array( 'jquery' ), $v, 'all' );
	wp_localize_script(
		'arkdewp-js',
		'arkde_ajax',
		array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			'nonce'   => wp_create_nonce( 'ajax-arkde-nonce' ),
		)
	);

	// wp_enqueue_script( 'arkdewp-navigation', get_stylesheet_directory_uri_uri() . '/js/navigation.js', array(), ARKDE_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'arkdewp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require __DIR__ . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require __DIR__ . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require __DIR__ . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require __DIR__ . '/inc/customizer.php';
/**
 * Add navigation helpers.
 */
require __DIR__ . '/inc/navigation.php';
/**
 * Add ajax theme functions.
 */
require __DIR__ . '/inc/ajax.php';

/**
 * Add learndash helper functions
 */
require __DIR__ . '/inc/learndash-helper.php';

/**
 * Buddyboss related stuff.
 */
require __DIR__ . '/inc/buddyboss.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require __DIR__ . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require __DIR__ . '/inc/woocommerce.php';
}

function meks_which_template_is_loaded() {
	global $template;
	print_r( $template );
	$result            = array();
	$result['scripts'] = array();
	$result['styles']  = array();

	// Print all loaded Scripts

	global $wp_scripts;
	foreach ( $wp_scripts->queue as $script ) :
		$result['scripts'][] = $script . ' - ' . $wp_scripts->registered[ $script ]->src . ';';
	endforeach;

	// Print all loaded Styles (CSS)

		echo '<pre>';
	global $wp_styles;
	foreach ( $wp_styles->queue as $style ) :
			$result['styles'][] = $style . ' - ' . $wp_styles->registered[ $style ]->src . ';';
	endforeach;
	echo '</pre>';
	var_dump( $result );

}

// add_action( 'wp_footer', 'meks_which_template_is_loaded' );


// Write to error log
if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}
