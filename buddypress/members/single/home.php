<?php
/**
 * BuddyBoss - Members Home
 *
 * @since BuddyPress   1.0.0
 * @version 3.0.0
 */


$bp                    = buddypress();
$grid_class            = '';
$user_full_template    = '';
$bp_nouveau_appearance = bp_get_option( 'bp_nouveau_appearance' );
$profile_cover_width   = buddyboss_theme_get_option( 'buddyboss_profile_cover_width' );
$current_user          = wp_get_current_user();
$display_name          = function_exists( 'bp_core_get_user_displayname' ) ? bp_core_get_user_displayname( $current_user->ID ) : $current_user->display_name;

if ( ! bp_is_user_front() && ! empty( $bp->template_message ) && ! empty( $bp->template_message_type ) && $bp->template_message_type == 'bp-sitewide-notice' ) {
	bp_nouveau_template_notices();
}

if ( ! bp_is_user_settings() && ! bp_is_user_messages() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() ) {
	$grid_class = 'bb-grid';
}

if ( bp_is_user_messages() || bp_is_user_settings() || bp_is_user_notifications() || bp_is_user_profile_edit() || bp_is_user_change_avatar() || bp_is_user_change_cover_image() ) {
	$user_full_template = 'bp-fullwidth-wrap';
}

$current_action = bp_current_action();
?>
<div class="container is-max-widescreen">
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
						<?php bp_displayed_user_avatar( 'type=full' ); ?>
						
					</div>
					<h1 class="is-size-5 has-text-weight-bold mb-0"><?php echo $display_name; ?></h1>
					<ul class="is-flex is-flex-direction-column is-align-items-stretch has-gap-10 profile-links">
						<li>
							<a href="<?php echo esc_url( wc_customer_edit_account_url() );?>" title="Perfil y contraseña"><?php esc_html_e( 'Perfil y contraseña', 'arkdewp' ); ?></a>
						</li>
						<li class="<?php echo 'change-avatar' === $current_action ? 'is-active has-text-weight-bold' : ''; ?>">
							<?php if ( 'change-avatar' != $current_action ) : ?>
								
								<a href="<?php bp_members_component_link( 'profile', 'change-avatar' ); ?>" title="<?php esc_html_e( 'Cambiar foto', 'arkdewp' ); ?>"><?php esc_html_e( 'Cambiar foto', 'arkdewp' ); ?></a>
							<?php else : ?>
								<?php esc_html_e( 'Cambiar foto', 'arkdewp' ); ?>
							<?php endif; ?>
						</li>
						<li>
							<a href="<?php echo esc_url(  wc_get_endpoint_url('orders', '', get_permalink(get_option('woocommerce_myaccount_page_id'))) );?>" title="Tus pedidos"><?php esc_html_e( 'Tus pedidos', 'arkdewp' ); ?></a>
						</li>
						
						
					</ul>
				</div>
			</div>
			
		</div>
		<div class="column">
		<?php
		if ( isset( $bp_nouveau_appearance['user_nav_display'] ) && $bp_nouveau_appearance['user_nav_display'] && is_active_sidebar( 'profile' ) && ! bp_is_user_settings() && ! bp_is_user_messages() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() && $profile_cover_width != 'default' ) {
			$grid_class = '';
			?>
				<div class="bb-grid bb-user-nav-display-wrap">
					<div class="bp-wrap-outer">
			<?php } ?>
	
			<div class="bp-wrap <?php echo $user_full_template; ?>">
				<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() && ! bp_is_user_messages() && ! bp_is_user_settings() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() ) : ?>
	
					<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>
	
				<?php endif; ?>		
	
				<div class="bb-profile-grid <?php echo $grid_class; ?>">
							<?php bp_nouveau_member_template_part(); ?>
					<?php
					if ( ( ! isset( $bp_nouveau_appearance['user_nav_display'] ) || ! $bp_nouveau_appearance['user_nav_display'] ) && is_active_sidebar( 'user_activity' ) && bp_is_user_activity() ) {
	
						ob_start();
						dynamic_sidebar( 'user_activity' );
						$sidebar = ob_get_clean();  // get the contents of the buffer and turn it off.
						if ( trim( $sidebar ) ) {
							?>
							<div id="user-activity" class="widget-area" role="complementary">
								<div class="bb-sticky-sidebar">
									<?php dynamic_sidebar( 'user_activity' ); ?>
								</div>
							</div>
							<?php
						}
					}
	
					if ( ( ! isset( $bp_nouveau_appearance['user_nav_display'] ) || ! $bp_nouveau_appearance['user_nav_display'] ) && is_active_sidebar( 'profile' ) && ! bp_is_user_settings() && ! bp_is_user_messages() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() && ! bp_is_user_front() && $profile_cover_width == 'full' ) {
	
						ob_start();
						dynamic_sidebar( 'profile' );
						$sidebar = ob_get_clean();  // get the contents of the buffer and turn it off.
						if ( trim( $sidebar ) ) {
							?>
							<div id="secondary" class="widget-area sm-grid-1-1 no-padding-top" role="complementary">
								<div class="bb-sticky-sidebar">
									<?php dynamic_sidebar( 'profile' ); ?>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
	
			</div><!-- // .bp-wrap -->
	
			<?php if ( isset( $bp_nouveau_appearance['user_nav_display'] ) && $bp_nouveau_appearance['user_nav_display'] && is_active_sidebar( 'profile' ) && ! bp_is_user_settings() && ! bp_is_user_messages() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() && ! bp_is_user_front() && $profile_cover_width != 'default' ) { ?>
					</div>
	
					<?php
					ob_start();
					dynamic_sidebar( 'profile' );
					$sidebar = ob_get_clean();  // get the contents of the buffer and turn it off.
					if ( trim( $sidebar ) ) {
						?>
						<div id="secondary" class="widget-area sm-grid-1-1 no-padding-top" role="complementary">
							<div class="bb-sticky-sidebar">
								<?php dynamic_sidebar( 'profile' ); ?>
							</div>
						</div>
						<?php
					}
					?>
	
				</div>
			<?php } ?>
	
			<?php bp_nouveau_member_hook( 'after', 'home_content' ); ?>
		</div>
	</div>
</div>

	

	
