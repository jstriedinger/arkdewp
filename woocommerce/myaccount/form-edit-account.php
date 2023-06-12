<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<div class="wc-MyAccount-inner-content">
		<div class="woocommerce-account-fields content">
			<h2 class="title is-size-4"><?php _e( 'Tu perfil', 'arkdewp' ); ?></h2>
			<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<label for="account_first_name"><?php esc_html_e( 'Nombre', 'arkdewp' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php esc_html_e( 'Nombre', 'arkdewp' ); ?>" />
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
				<label for="account_last_name"><?php esc_html_e( 'Apellido', 'arkdewp' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php esc_html_e( 'Apellido', 'arkdewp' ); ?>" />
			</p>

			<div class="clear"></div>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="account_display_name"><?php esc_html_e( 'Nombre de usuario', 'arkdewp' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> 
			</p>

			<div class="clear"></div>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="account_email"><?php esc_html_e( 'Email', 'arkdewp' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php esc_html_e( 'Email', 'arkdewp' ); ?>" />
			</p>

			<fieldset>
				<h3 class="subtitle is-5 mb-1 mt-4"><?php esc_html_e( 'Cambiar contraseña', 'arkdewp' ); ?></h3>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password_current"><?php esc_html_e( 'Contraseña actual (deja en blanco para no hacer cambios)', 'arkdewp' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" placeholder="<?php esc_html_e( 'Contraseña actual', 'arkdewp' ); ?>" autocomplete="off" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password_1"><?php esc_html_e( 'Nueva contraseña (deja en blanco para no hacer cambios)', 'arkdewp' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" placeholder="<?php esc_html_e( 'Nueva contraseña', 'arkdewp' ); ?>" autocomplete="off" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password_2"><?php esc_html_e( 'Confirmar nueva contraseña', 'arkdewp' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" placeholder="<?php esc_html_e( 'Confirma nueva contraseña', 'arkdewp' ); ?>" autocomplete="off" />
				</p>
			</fieldset>
			<div class="clear"></div>

			<?php do_action( 'woocommerce_edit_account_form' ); ?>

			<p class="woocommerce-account-fields__ctrls-wrapper mt-4">
				<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Guardar cambios', 'arkdewp' ); ?>"><?php esc_html_e( 'Guardar cambios', 'arkdewp' ); ?></button>
				<input type="hidden" name="action" value="save_account_details" />
			</p>

			<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
