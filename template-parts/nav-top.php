<nav class="navbar <?php echo is_singular( array( 'sfwd-courses', 'career' ) ) ? 'is-full' : ''; ?>" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
		<a href="<?php echo esc_url( get_home_url() ); ?>">
			<?php
			$logo_id = buddyboss_theme_get_option( 'logo', 'id' );
			$logo    = wp_get_attachment_image( $logo_id, 'full', '' );
			echo $logo;
			?>
		</a>
	<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar-top" id="navbar-burger">
	  <span aria-hidden="true"></span>
	  <span aria-hidden="true"></span>
	  <span aria-hidden="true"></span>
	</a>
  </div>

  <div id="navbar-top" class="navbar-menu">
		<?php
		if ( is_singular( array( 'sfwd-lessons', 'sfwd-topic' ) ) ) :
			$lesson_data = $post;
			$course_id;
			if ( empty( $course_id ) ) {
				$course_id = learndash_get_course_id( $lesson_data->ID );

				if ( empty( $course_id ) ) {
					$course_id = buddyboss_theme()->learndash_helper()->ld_30_get_course_id( $lesson_data->ID );
				}
			}
			$course_name = get_the_title( $course_id );

			?>
		<div class="navbar-item"><?php echo esc_html( $course_name ); ?></div>
			<?php
		elseif ( ! is_cart() && ! is_checkout() ) :
			wp_nav_menu(
				array(
					'theme_location' => 'navtop',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'navbar-start',
					'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
					'walker'         => new Bulmawalker(),
				)
			);
	  endif;
		?>
	<div class="navbar-end">
		<?php if ( is_user_logged_in() ) : ?>
			<?php
				$current_user = wp_get_current_user();
				$user_link    = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( $current_user->ID ) : get_author_posts_url( $current_user->ID );
				$display_name = function_exists( 'bp_core_get_user_displayname' ) ? bp_core_get_user_displayname( $current_user->ID ) : $current_user->display_name;
			?>
				<div class="navbar-item  has-dropdown">
					<button class="navbar-link" aria-expanded="false">
						<?php echo $display_name; ?>
						<span class="mr-2"></span>
						<?php echo get_avatar( get_current_user_id(), 36 ); ?>
					</button>
					<div class="navbar-dropdown" >
						<?php
						if ( function_exists( 'bp_is_active' ) ) {
							$menu = wp_nav_menu(
								array(
									'theme_location' => 'header-my-account',
									'echo'           => false,
									'fallback_cb'    => '__return_false',
								)
							);
							if ( ! empty( $menu ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'header-my-account',
										'menu_id'        => 'header-my-account-menu',
										'container'      => false,
										'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
										'fallback_cb'    => '',
										'walker'         => new BulmaWalker(), // new BuddyBoss_SubMenuWrap(),
										'menu_class'     => 'bb-my-account-menu',
									)
								);
							} else {
								do_action( THEME_HOOK_PREFIX . 'header_user_menu_items' );
							}
						} else {
							do_action( THEME_HOOK_PREFIX . 'header_user_menu_items' );
						}
						?>
					</div>
				</div>
		<?php else : ?>
			<div class="navbar-item">
				<div class="buttons">
					<a class="button is-gold is-small" href="<?php echo wp_login_url(); ?>">
						<?php _e( 'Inicia sesión', 'arkdewp' ); ?>
					</a>
					<a class="button is-outlined is-white is-small" href="<?php echo wp_registration_url(); ?>">
						<?php _e( 'Registrate', 'arkdewp' ); ?>
					</a>
				</div>
			</div>

		<?php endif; ?>
		<?php
		if ( ! is_cart() && ! is_checkout() && class_exists( 'WooCommerce' ) ) :
			?>
		<div class="navbar-item">
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-cart-link notification-link">
			<i class="fa-solid fa-cart-shopping has-text-white fa-lg"></i>
				<?php
				if ( is_object( WC()->cart ) ) {
					$wc_cart_count = wc()->cart->get_cart_contents_count();
					if ( $wc_cart_count != 0 ) {
						?>
					<span class="count"><?php echo $wc_cart_count; ?></span>
						<?php
					}
				}
				?>
				</a>
		</div>
			<?php endif; ?>

	</div>
  </div>
</nav><!-- #site-navigation -->
