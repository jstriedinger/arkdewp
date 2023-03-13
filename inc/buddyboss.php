<?php
/**
 * Main object to deregister styles and scripts from
 * buddyboss that  we don't use right now
 */

function deregister_buddyboss_stuff() {
	wp_deregister_style( 'buddyboss-theme-woocommerce' );
	wp_deregister_style( 'buddyboss-theme-learndash' );
	// jquery image ligthbox plugin.
	wp_deregister_style( 'buddyboss-theme-magnific-popup-css' );
	// font-awesome 4 in buddyboss.
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'buddyboss_legacy' );
	// wp_deregister_style( 'buddyboss-theme-learndash' );.
	wp_deregister_style( 'buddyboss-theme-template' );
	// wp_deregister_style('buddyboss-theme-fonts');.
	wp_deregister_style( 'buddyboss-theme-css' );

	// lets deregister some js plugins we are not gonna use
	wp_deregister_script( 'mousewheel-js' );
	wp_deregister_script( 'boss-jssocials-js' );
	wp_deregister_script( 'boss-slick-js' );
	wp_deregister_script( 'guillotine-js' );
	wp_deregister_script( 'boss-fitvids-js' );
	// wp_deregister_script( 'masonry' );
	// wp_deregister_script( 'buddyboss-theme-main-js' );
}
add_action( 'wp_enqueue_scripts', 'deregister_buddyboss_stuff', 9999 );

