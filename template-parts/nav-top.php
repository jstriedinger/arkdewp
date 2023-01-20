<nav class="navbar " role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
	<?php
		the_custom_logo();
	?>
	<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar-top" id="navbar-burger">
	  <span aria-hidden="true"></span>
	  <span aria-hidden="true"></span>
	  <span aria-hidden="true"></span>
	</a>
  </div>

  <div id="navbar-top" class="navbar-menu">
		<?php
		if ( ! is_cart() && ! is_checkout() ) :
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
		<div class="navbar-item">
			<div class="buttons">
				<a class="button is-yellow">
				<strong>Sign up</strong>
				</a>
				<a class="button is-light">
				Log in
				</a>
			</div>
		</div>
		<?php
		if ( ! is_cart() && ! is_checkout() ) :
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
