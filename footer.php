<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ARKDE
 */

?>
<?php if ( ! is_cart() && ! is_checkout() && ! is_singular( array( 'sfwd-lessons', 'sfwd-topic', 'llms_my_certificate' ) ) && ! bp_is_register_page() ) : ?>
	<footer class="footer">
		<div class="container">
			<div class="columns is-variable is-6-widescreen">
				<div class="column is-one-quarter">
					<?php
						$logo_id = buddyboss_theme_get_option( 'logo', 'id' );
						$logo    = wp_get_attachment_image( $logo_id, 'full', '' );
						echo $logo;
					?>
					<img src="<?php echo ARKDE_THEME_URI . 'assets/img/Epic_MegaGrants_Recipient_logo_horizontal.png'; ?>" class="mt-1 mb-2" style="display:block" alt="epic mega grants recipient" width="200px">
					<p class="mb-1 is-size-14px">©<?php echo Date( 'Y' ); ?> - <?php esc_html_e( 'Todos los derechos reservados', 'arkdewp' ); ?></p>
					<p class="is-size-14px">
						<?php
							printf( esc_html__( 'Creado por %1$s', 'arkdewp' ), '<a href="https://www.jstriedinger.com">Jose Striedinger</a>' );
						?>
					</p>
				</div>
				<div class="column is-one-quarter">
					<h4 class="is-size-5 has-text-weight-bold mb-3"><?php esc_html_e( 'Cursos online', 'arkdewp' ); ?></h4>
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-1',
								'menu_id'        => 'footer-nav-1',
								'container'      => false,
								'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'add_li_class'   => 'mb-2 is-size-14px',
							)
						);
					?>
				</div>
				<div class="column is-one-quarter">
					<h4 class="is-size-5 has-text-weight-bold mb-3"><?php esc_html_e( 'Otros enlaces', 'arkdewp' ); ?></h4>
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-2',
								'menu_id'        => 'footer-nav-2',
								'container'      => false,
								'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'add_li_class'   => 'mb-2 is-size-14px',
							)
						);
					?>
				</div>
				<div class="column is-one-quarter has-text-right-desktop">
					<div class="level is-mobile mb-2">
						<!-- Right side -->
						<div class="level-left is-hidden-touch"></div>
						<div class="level-right">
							<p class="level-item">
								<a class="icon" href="https://facebook.com/arkdecol" aria-label="<?php esc_html_e( 'ARKDE facebook page', 'arkdewp' ); ?>">
									<i class="fa-brands fa-facebook-f fa-lg"></i>
								</a>
							</p>
							<p class="level-item">
								<a class="icon" href="https://twitter.com/arkdecol" aria-label="<?php esc_html_e( 'ARKDE twitter page', 'arkdewp' ); ?>">
									<i class="fa-brands fa-twitter fa-lg"></i>
								</a>
							</p>
							<p class="level-item">
								<a class="icon" href="https://instagram.com/arkdecol" aria-label="<?php esc_html_e( 'ARKDE instagram page', 'arkdewp' ); ?>">
									<i class="fa-brands fa-instagram fa-lg"></i>
								</a>
							</p>
							<p class="level-item">
								<a class="icon" href="https://www.linkedin.com/company/arkde/" aria-label="<?php esc_html_e( 'ARKDE linkedin page', 'arkdewp' ); ?>">
									<i class="fa-brands fa-linkedin fa-lg"></i>
								</a>
							</p>
						</div>
					</div>
					<p class="is-size-14px"><?php esc_html_e( 'Dudas? Escribenos a ', 'arkdewp' ); ?><a href="mailto:info@arkde.com">info@arkde.com</a></p>
					
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
<?php endif; ?>

<?php wp_footer(); ?>
<?php
if ( is_singular( array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic' ) ) ) :
	?>
		<script src="code.jivosite.com/widget/C9bfrgBJMN" async></script>
	<?php
endif;
?>

</body>
</html>
