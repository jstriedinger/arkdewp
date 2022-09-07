<nav class="navbar" role="navigation" aria-label="main navigation">
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
			wp_nav_menu(
				array(
					'theme_location' 	=> 'navtop',
					'menu_id'        	=> 'primary-menu',
					'container'		 		=> false,
					'menu_class'			=> 'navbar-start',
					'items_wrap'      => '<div id="%1$s" class="%2$s">%3$s</div>',
					'walker'            => new Bulmawalker()
				)
			);
		?>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light">
            Log in
          </a>
        </div>
      </div>
    </div>
  </div>
</nav><!-- #site-navigation -->