<?php
/**
 * BuddyBoss - Members Profile Loop
 *
 * @since   BuddyPress 3.0.0
 * @version 3.1.0
 */

$edit_profile_link = trailingslashit( bp_displayed_user_domain() . bp_get_profile_slug() . '/edit/group/' );
?>

<?php
bp_nouveau_xprofile_hook( 'before', 'loop_content' );
if ( bp_has_profile() ) :
	while ( bp_profile_groups() ) :
		bp_the_profile_group();

		if ( bp_profile_group_has_fields() ) :

			bp_nouveau_xprofile_hook( 'before', 'field_content' ); ?>
			<div class="group-separator-block">
				<header class="entry-header profile-loop-header profile-header flex align-items-center">
					<h1 class="entry-title bb-profile-title"><?php bp_the_profile_group_name(); ?></h1>

					<?php
					if ( bp_is_my_profile() ) {
						?>
						<a href="<?php echo esc_url( $edit_profile_link . bp_get_the_profile_group_id() ); ?>" class="push-right button outline small"><?php esc_attr_e( 'Edit', 'buddyboss-theme' ); ?></a>
						<?php
					}
					?>
				</header>
				<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">
					<table class="profile-fields bp-tables-user">

						<?php
						while ( bp_profile_fields() ) :
							bp_the_profile_field();

							if ( function_exists( 'bp_member_type_enable_disable' ) && false === bp_member_type_enable_disable() ) {
								if ( function_exists( 'bp_get_xprofile_member_type_field_id' ) && bp_get_the_profile_field_id() === bp_get_xprofile_member_type_field_id() ) {
									continue;
								}
							}

							bp_nouveau_xprofile_hook( 'before', 'field_item' );
							if ( bp_field_has_data() ) :
								?>

								<tr<?php bp_field_css_class(); ?>>

									<td class="label"><?php bp_the_profile_field_name(); ?></td>

									<td class="data"><?php bp_the_profile_field_value(); ?></td>

								</tr>

							<?php
							endif;

							bp_nouveau_xprofile_hook( '', 'field_item' );

						endwhile;

						bp_nouveau_xprofile_hook( 'after', 'field_items' );
						?>

					</table>
				</div>
			</div>

			<?php

			bp_nouveau_xprofile_hook( 'after', 'field_content' );

		endif;

	endwhile;

	bp_nouveau_xprofile_hook( '', 'field_buttons' );
else :
?>

	<div class="info bp-feedback">
		<span class="bp-icon" aria-hidden="true"></span>
		<p>
			<?php
			if ( bp_is_my_profile() ) {
				esc_html_e( 'You have not yet added details to your profile.', 'buddyboss-theme' );
			} else {
				esc_html_e( 'This member has not yet added details to their profile.', 'buddyboss-theme' );
			}
			?>
		</p>
	</div>

<?php
endif;
bp_nouveau_xprofile_hook( 'after', 'loop_content' );
