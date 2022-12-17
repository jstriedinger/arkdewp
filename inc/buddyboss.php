<?php /**
	   * Main object to deregister styles and scripts from
	   * buddyboss that  we don't use right now
	   */

function deregister_buddyboss_stuff() {
	wp_deregister_style( 'buddyboss-theme-woocommerce' );
	// jquery image ligthbox plugin.
	wp_deregister_style( 'buddyboss-theme-magnific-popup-css' );
	// font-awesome 4 in buddyboss.
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'buddyboss_legacy' );
	// wp_deregister_style( 'buddyboss-theme-learndash' );.
	wp_deregister_style( 'buddyboss-theme-template' );
	// wp_deregister_style('buddyboss-theme-fonts');.
	wp_deregister_style( 'buddyboss-theme-css' );
}
add_action( 'wp_enqueue_scripts', 'deregister_buddyboss_stuff', 9999 );

