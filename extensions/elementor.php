<?php
/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Contact Form 7 multisend fields
 *
 * Add CF7 fields to multisend settings page.
 *
 * @param $multisend_option
 *
 * @since 1.4
 */
function multisend_sms_elementor_fields( $multisend_option ) {


	$plugin_name    = 'elementor-pro/elementor-pro.php';
	$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

	if ( in_array( $plugin_name, $active_plugins ) ) {
		?>
        <div class="postbox">

            <h2 class="hndle">
				<?php esc_html_e( 'Elementor forms Events', 'multisend-integration' ); ?>
            </h2>

            <div class="inside">

                <fieldset>
                    <label for="multisend_elementor">
                        <input type="checkbox" id="multisend_elementor" name="multisend_elementor"
                               value="1" <?php if ( isset( $multisend_option['multisend_elementor'] ) == "1" ) {
							echo 'checked';
						} ?>/>
                        <span><?php esc_html_e( 'Send SMS to site admin when form submitted', 'multisend-integration' ); ?></span>
                    </label>
                </fieldset>


                <fieldset>
                    <label for="multisend_elementor_user">
                        <input type="checkbox" id="multisend_elementor_user" name="multisend_elementor_user"
                               value="1" <?php if ( isset( $multisend_option['multisend_elementor_user'] ) == "1" ) {
							echo 'checked';
						} ?>/>
                        <span><?php esc_html_e( 'Send SMS to user when form submitted', 'multisend-integration' ); ?></span>
                    </label>
                    <div class="send_user_sms <?php if ( isset( $multisend_option['multisend_elementor_user'] ) != "1" ) {
						echo 'hidden';
					} ?>">
                        <table>
                            <tr>
                                <td>
                                    <span><?php esc_html_e( 'Content sent to user', 'multisend-integration' ); ?></span>
                                </td>
                                <td>
                                 <textarea id="multisend_elementor_user_content"
                                           name="multisend_elementor_user_content" cols="80"
                                           rows="3"
                                           class="all-options"><?php if ( isset( $multisend_option['multisend_elementor_user_content'] ) ) {
		                                 echo $multisend_option['multisend_elementor_user_content'];
	                                 } ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>

                </fieldset>


            </div>

        </div>
		<?php
	}

}

add_action( 'multisend_sms_form_fields', 'multisend_sms_elementor_fields', 10, 1 );


/**
 * Contact Form 7 mail sent
 *
 * multisend SMS on successful Contact Form 7 mail submission.
 *
 * @param $contact_form
 *
 * @since 1.0
 */
function multisend_sms_elementor( $record, $ajax_handler ) {


	$sms_geteway = new \multisend\sms_geteway();
	$account     = get_option( 'multisend_sms_account' );
	$option      = get_option( 'multisend_sms_option' );
	$fields      = $record->get( 'fields' );

	if ( 1 == $option['multisend_elementor'] ) {


		$sms = '';
		foreach ( $fields as $key => $field ) {

			$sms .= $field['title'] . ': ' . $field['value'] . " \n ";
		}

		$sms_geteway->multisend_send_sms( $sms, $account['sms_phone'] );
	}

	if ( 1 == $option['multisend_elementor_user'] ) {
		$phone = '';
		foreach ( $fields as $field ) {
			if ( $field['type'] == 'tel' ) {
				$phone = $field['value'];
			}
		}

		$sms_geteway->multisend_send_sms( $option['multisend_elementor_user_content'], $phone );
	}

}

add_action( 'elementor_pro/forms/validation', 'multisend_sms_elementor', 10, 2 );