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
	<meta name="facebook-domain-verification" content="qtkj1h0bu1uopx6inpvml2jouchksl" />

	<?php
if ( is_singular( array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic' ) ) ) :
	?>
		<script src="//code.jivosite.com/widget/E7FAbcDoaC" async></script>
	<?php
endif;
?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>  data-currency="<?php echo get_woocommerce_currency(); ?>" data-theme="">
<?php wp_body_open(); ?>
<?php
if ( is_singular( 'sfwd-courses' ) && ! is_user_logged_in() ) :
	learndash_load_login_modal_html();
endif;
?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'arkdewp' ); ?></a>
	<?php do_action( THEME_HOOK_PREFIX . 'before_header' ); ?>

	<?php if ( ! bp_is_register_page() ) : ?>
	<header id="masthead" class="site-header <?php echo ( is_singular( array( 'sfwd-courses', 'career' ) ) || is_front_page() || is_archive( array( 'sfwd-courses' ) ) || str_contains( get_page_template_slug(), 'aboutus' ) ) ? 'is-transparent' : ''; ?>">
		<?php do_action( THEME_HOOK_PREFIX . 'nav' ); ?>
	</header><!-- #masthead -->
	<?php endif; ?>
	<?php do_action( THEME_HOOK_PREFIX . 'after_header' ); ?>

	<?php do_action( THEME_HOOK_PREFIX . 'before_content' ); ?>
