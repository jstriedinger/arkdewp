<?php
/**
 * BuddyBoss - Users Profile
 *
 * @since BuddyPress 3.0.0
 * @version 3.0.0
 */

$profile_link = trailingslashit( bp_displayed_user_domain() . bp_get_profile_slug() );
?>

<div class="bp-profile-wrapper <?php echo ( bp_is_user_profile() && ( ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() ) ) ? esc_attr( 'need-separator' ) : ''; ?>">
	<?php /*
	if ( bp_is_user_profile_edit() || bp_is_user_change_avatar() || bp_is_user_change_cover_image() ) {
		bp_get_template_part( 'members/single/parts/item-subnav' );
	}*/
	?>

	<div class="bp-profile-content">

		<?php bp_nouveau_member_hook( 'before', 'profile_content' ); ?>

		<div class="profile <?php echo esc_attr( bp_current_action() ); ?>">

			<?php
			switch ( bp_current_action() ) :

				// Edit.
				case 'edit':
					bp_get_template_part( 'members/single/profile/edit' );
					break;

				// Change Avatar.
				case 'change-avatar':
					bp_get_template_part( 'members/single/profile/change-avatar' );
					break;

				// Change Cover Image.
				case 'change-cover-image':
					bp_get_template_part( 'members/single/profile/change-cover-image' );
					break;

				// Compose.
				case 'public':
					// Display XProfile.
					if ( bp_is_active( 'xprofile' ) ) {
						bp_get_template_part( 'members/single/profile/profile-loop' );

					// Display WordPress profile (fallback).
					} else {
						bp_get_template_part( 'members/single/profile/profile-wp' );
					}

					break;

				// Any other.
				default:
					bp_get_template_part( 'members/single/plugins' );
					break;
			endswitch;
			?>
		</div><!-- .profile -->

		<?php bp_nouveau_member_hook( 'after', 'profile_content' ); ?>

	</div>

</div>
