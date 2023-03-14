<?php
/**
 * ARKDE Theme Customizer
 *
 * @package ARKDE
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function arkdewp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'arkdewp_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'arkdewp_customize_partial_blogdescription',
			)
		);
	}

	// add a secondary logo
	/*$wp_customize->add_setting( 'secondary_logo' );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'secondary_logo',
			array(
				'label'    => __( 'Logo for whites', 'arkdewp' ),
				'section'  => 'title_tagline',
				'settings' => 'secondary_logo',
				'priority' => 4,
			)
		)
	);*/
}
add_action( 'customize_register', 'arkdewp_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function arkdewp_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function arkdewp_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arkdewp_customize_preview_js() {
	wp_enqueue_script( 'arkdewp-customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), ARKDE_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'arkdewp_customize_preview_js' );
