<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ARKDE
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>  data-currency="<?php echo get_woocommerce_currency(); ?>">
<?php wp_body_open(); ?>
<?php
if ( is_singular( 'sfwd-courses' ) && ! is_user_logged_in() ) :
	learndash_load_login_modal_html();
endif;
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'arkdewp' ); ?></a>
	<?php do_action( THEME_HOOK_PREFIX . 'before_header' ); ?>

	<header id="masthead" class="site-header in-body <?php echo get_post_type() == 'sfwd-courses' ? 'is-colored' : ''; ?>">
		<?php do_action( THEME_HOOK_PREFIX . 'nav' ); ?>
	</header><!-- #masthead -->
	<?php do_action( THEME_HOOK_PREFIX . 'after_header' ); ?>

	<?php do_action( THEME_HOOK_PREFIX . 'before_content' ); ?>
