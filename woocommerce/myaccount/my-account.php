<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */


global $wp, $pagename;
$bp                    = buddypress();
$request      = explode( '/', $wp->request );
$current_user = wp_get_current_user();
$display_name = function_exists( 'bp_core_get_user_displayname' ) ? bp_core_get_user_displayname( $current_user->ID ) : $current_user->display_name;

// If in My account dashboard page
if ( ( end( $request ) == 'my-account' && is_account_page() ) ) {
	$dashBoardClass = 'bsMyAccount--dashboard';
} else {
	$dashBoardClass = 'bsMyAccount--dashboard-inner';
}
?>

<div class="columns is-variable is-6 py-6">
	<div class="column is-4">
		<div class="card with-shadows">
			<div class="card-content is-flex flex-direction-column has-gap-16 is-align-items-center">
				<div class="arkde-member-avatar <?php echo ( bp_is_my_profile() && ! bp_disable_avatar_uploads() ) ? 'can-upload' : ''; ?>">
					<?php if ( bp_is_my_profile() && ! bp_disable_avatar_uploads() ) : ?>
						<a href="<?php bp_members_component_link( 'profile', 'change-avatar' ); ?>">
							<i class="fa-solid fa-camera has-text-white fa-xl"></i><br>
							<span class="has-text-white is-size-7"><?php esc_html_e( 'Cambiar imagen', 'arkdewp' ); ?></span>
						</a>
					<?php endif; ?>
					<?php echo get_avatar( get_current_user_id(), 125 ); ?>
				</div>
				<h1 class="is-size-5 has-text-weight-bold mb-0"><?php echo $display_name; ?></h1>
				<ul class="is-flex is-flex-direction-column is-align-items-stretch has-gap-10 profile-links">
					<li class="<?php echo ( isset( $request[1] ) && 'edit-account' === $request[1] ) ? 'is-active' : ''; ?>">
						<?php if ( ( ! isset( $request[1] ) || 'edit-account' !== $request[1] ) ) : ?>
							<a href="<?php echo esc_url( wc_customer_edit_account_url() ); ?>" title="<?php esc_html_e( 'Perfil y contraseña', 'arkdewp' ); ?>"><?php esc_html_e( 'Perfil y contraseña', 'arkdewp' ); ?></a>
						<?php else : ?>
							<?php esc_html_e( 'Perfil y contraseña', 'arkdewp' ); ?>
						<?php endif; ?>	
					</li>
					
					<li>
							<a href="<?php echo esc_url( home_url() . '/members/' . $current_user->nickname . '/profile/change-avatar' ); ?>" title="<?php esc_html_e( 'Editar perfil', 'arkdewp' ); ?>" title="<?php esc_html_e( 'Cambiar foto', 'arkdewp' ); ?>"><?php esc_html_e( 'Cambiar foto', 'arkdewp' ); ?></a>
					</li>
					<li class="<?php echo ( isset( $request[1] ) && 'orders' === $request[1] ) ? 'is-active' : ''; ?>">
						<?php if ( ( ! isset( $request[1] ) || 'orders' !== $request[1] ) ) : ?>
							<a href="<?php echo esc_url(  wc_get_endpoint_url( 'orders' ) ); ?>" title="<?php esc_html_e( 'Tus pedidos', 'arkdewp' ); ?>"><?php esc_html_e( 'Tus pedidos', 'arkdewp' ); ?></a>
						<?php else : ?>
							<?php esc_html_e( 'Tus pedidos', 'arkdewp' ); ?>
						<?php endif; ?>	
					</li>
				</ul>
			</div>
		</div>
		
	</div>
	<div class="column">
		<div class="bsMyAccount <?php echo $dashBoardClass; ?>">
			<div class="woocommerce-MyAccount-content m-5">
				<?php
				/**
				 * My Account content.
				 *
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_content' );
				?>
			</div>
		</div>
	</div>
</div>


