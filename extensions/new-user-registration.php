<?php
/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * New User Registration multisend fields
 *
 * Add New User Registration fields to multisend settings page.
 *
 * @param $multisend_option
 *
 * @since 1.4
 */
function multisend_sms_wordpress_new_user_registration_fields( $multisend_option ) {

	?>
	<div class="postbox">

		<h2 class="hndle">
			<?php esc_html_e( 'New User Registration Events', 'multisend-integration' ); ?>
		</h2>

		<div class="inside">

			<fieldset>
				<label for="multisend_new_user_registration">
					<input type="checkbox" id="multisend_new_user_registration" name="multisend_new_user_registration" value="1" <?php if ( $multisend_option['multisend_new_user_registration'] == "1" ) { echo 'checked'; } ?>/>
					<span><?php esc_html_e( 'Send SMS when new user is registered', 'multisend-integration' ); ?></span>
				</label>
			</fieldset>

		</div>

	</div>
	<?php

}
add_action( 'multisend_sms_form_fields', 'multisend_sms_wordpress_new_user_registration_fields', 10, 1 );



/**
 * WordPress new user registration
 *
 * multisend SMS on new user registration.
 *
 * @param $user_id The user ID.
 *
 * @since 1.4
 */
function multisend_sms_wordpress_new_user_registration( $user_id ) {

	$account = get_option( 'multisend_sms_account' );
	$option = get_option( 'multisend_sms_option' );

	if ( 1 == $option['multisend_new_user_registration'] ) {

		$user_data = get_userdata( $user_id );

		$content = sprintf(__( 'A new user "%1$s" was registered to the site (%2$s).', 'multisend-integration' ), $user_data->user_login , get_site_url());
		
		$sms_geteway = new \multisend\sms_geteway();
		$sms_geteway->multisend_send_sms( $content, $account['sms_phone'] );

	}

}
add_action( 'user_register', 'multisend_sms_wordpress_new_user_registration' );
