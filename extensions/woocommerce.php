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
 * WooCommerce multisend fields
 *
 * Add WooCommerce fields to multisend settings page.
 *
 * @param $multisend_option
 *
 * @since 1.4
 */
function multisend_sms_woocommerce_fields( $multisend_option ) {

	$plugin_name    = 'woocommerce/woocommerce.php';
	$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

	if ( in_array( $plugin_name, $active_plugins ) ) {

		?>
        <div class="postbox">

            <h2 class="hndle">
				<?php esc_html_e( 'WooCommerce Events', 'multisend-integration' ); ?>
            </h2>

            <div class="inside">

                <fieldset>
                    <label for="multisend_new_order">
                        <input type="checkbox" id="multisend_new_order" name="multisend_new_order"
                               value="1" <?php if ( isset( $multisend_option['multisend_new_order'] ) == "1" ) {
							echo 'checked';
						} ?>/>
                        <span><?php esc_html_e( 'Send SMS when new order created', 'multisend-integration' ); ?></span>
                    </label>
                </fieldset>

                <div class="multisend_new_order_content <?php if ( isset( $multisend_option['multisend_new_order'] ) != "1" ) {
					echo 'hidden';
				} ?>">
                    <table>
                        <tr>
                            <td>
                                <input name="multisend_new_order_customer"
                                       type="checkbox" <?php if ( isset( $multisend_option['multisend_new_order_customer'] ) == "1" ) {
									echo 'checked';
								} ?>
                                       id="multisend_new_order_customer"
                                       value="1"/>
								<?php esc_html_e( 'Send SMS to customer:', 'multisend-integration' ); ?>
                            </td>
                            <td>
								<textarea id="multisend_new_order_customer_content"
                                          name="multisend_new_order_customer_content" cols="80" rows="3"
                                          class="all-options"><?php if ( $multisend_option['multisend_new_order_customer_content'] ) {
										echo $multisend_option['multisend_new_order_customer_content'];
									} ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input name="multisend_new_order_customer_manager"
                                       type="checkbox" <?php if ( isset( $multisend_option['multisend_new_order_customer_manager'] ) == "1" ) {
									echo 'checked';
								} ?>
                                       id="multisend_new_order_customer_manager"
                                       value="1"/>
								<?php esc_html_e( 'Send SMS to site manager:', 'multisend-integration' ); ?>
                            </td>
                            <td>
								<textarea id="multisend_new_order_customer_manager_content"
                                          name="multisend_new_order_customer_manager_content" cols="80"
                                          rows="3"
                                          class="all-options"><?php if ( $multisend_option['multisend_new_order_customer_manager_content'] ) {
										echo $multisend_option['multisend_new_order_customer_manager_content'];
									} ?></textarea>
                            </td>
                        </tr>

                    </table>
                </div>

                <hr>

                <fieldset>
                    <label for="multisend_order_complete">
                        <input name="multisend_order_complete" type="checkbox"
                               id="multisend_order_complete" <?php if ( isset( $multisend_option['multisend_order_complete'] ) == "1" ) {
							echo 'checked';
						} ?>
                               value="1"/>
                        <span><?php esc_html_e( 'Send SMS when order status is completed', 'multisend-integration' ); ?></span>
                    </label>
                </fieldset>

                <div class="multisend_order_complete_content <?php if ( $multisend_option['multisend_order_complete'] != '1' ) {
					echo 'hidden';
				} ?>">
                    <table>
                        <tr>
                            <td><?php esc_html_e( 'Send SMS to customer:', 'multisend-integration' ); ?></td>
                            <td><textarea id="multisend_order_complete_sms" name="multisend_order_complete_sms"
                                          cols="80" rows="3"
                                          class="all-options"><?php if ( $multisend_option['multisend_order_complete_sms'] ) {
										echo $multisend_option['multisend_order_complete_sms'];
									} ?></textarea>
                            </td>
                        </tr>
                    </table>

                </div>

                <hr>

                <fieldset>
                    <label for="multisend_order_cancel">
                        <input name="multisend_order_cancel" type="checkbox"
                               id="multisend_order_cancel" <?php if ( isset( $multisend_option['multisend_order_cancel'] ) == "1" ) {
							echo 'checked';
						} ?>
                               value="1"/>
                        <span><?php esc_html_e( 'Send SMS when order status is pending payment order received (unpaid)', 'multisend-integration' ); ?></span>
                    </label>
                </fieldset>

                <div class="multisend_order_cancel_content <?php if ( isset( $multisend_option['multisend_order_cancel'] ) != '1' ) {
					echo 'hidden';
				} ?>">
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="multisend_order_cancel_manager"
                                       name="multisend_order_cancel_manager" value="1"
									<?php if ( isset( $multisend_option['multisend_order_cancel_manager'] ) == 1 ) {
										echo 'checked';
									} ?> >
								<?php esc_html_e( 'Send SMS to site manager:', 'multisend-integration' ); ?></td>
                            <td><textarea id="multisend_order_cancel_sms" name="multisend_order_cancel_sms"
                                          cols="80" rows="3"
                                          class="all-options"><?php if ( $multisend_option['multisend_order_cancel_sms'] ) {
										echo $multisend_option['multisend_order_cancel_sms'];
									} ?></textarea>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="multisend_order_cancel_content <?php if ( isset( $multisend_option['multisend_order_cancel'] ) != '1' ) {
					echo 'hidden';
				} ?>">
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="multisend_order_cancel_customer"
                                       name="multisend_order_cancel_customer" value="1"
									<?php if ( isset( $multisend_option['multisend_order_cancel_customer'] ) == 1 ) {
										echo 'checked';
									} ?> >

								<?php esc_html_e( 'Send SMS to customer:', 'multisend-integration' ); ?></td>
                            <td><textarea id="multisend_order_cancel_sms_customer" name="multisend_order_cancel_sms_customer"
                                          cols="80" rows="3"
                                          class="all-options"><?php if ( $multisend_option['multisend_order_cancel_sms_customer'] ) {
										echo $multisend_option['multisend_order_cancel_sms_customer'];
									} ?></textarea>
                            </td>
                        </tr>
                    </table>

                </div>

                <hr>
                <fieldset>
                    <label for="multisend_order_custom"><?php esc_html_e( 'Dynamic Status:', 'multisend-integration' ); ?></label>
					<?php
					$statuses = wc_get_order_statuses();

					unset( $statuses['wc-processing'] );
					unset( $statuses['wc-completed'] );
					unset( $statuses['wc-cancelled'] );
					if ( isset( $multisend_option['multisend_custom'] ) ):
						foreach ( $multisend_option['multisend_custom'] as $key => $status ):
							unset( $statuses[ $key ] );
						endforeach;
					endif;
					?>
                    <select name="multisend_order_custom" id="multisend_order_custom">
						<?php foreach ( $statuses as $key => $item ) { ?>
                            <option value="<?php echo $key; ?>"
                                    data-name="<?php echo $item; ?>"><?php echo $item; ?></option>
						<?php } ?>
                    </select>
                    <a href="#"
                       class="multisend_add_custom_status"><?php esc_html_e( 'Add Status', 'multisend-integration' ); ?></a>
                </fieldset>

                <div class="customs_rules">
                    <table>
						<?php if ( isset( $multisend_option['multisend_custom'] ) ):
							foreach ( $multisend_option['multisend_custom'] as $key => $status ): ?>
                                <tr>
                                    <td><span class="remove_status"
                                              title="Remove status">X</span> <?php echo wc_get_order_status_name( $key ) ?>
                                    </td>
                                    <td>
                                        <textarea id="multisend_order_<?php echo $key; ?>"
                                                  name="multisend_custom[<?php echo $key; ?>]" cols="80" rows="3"
                                                  class="multisend_custom_text"><?php echo $status; ?></textarea>
                                    </td>
                                </tr>
							<?php endforeach; endif; ?>
                    </table>
                </div>

                <hr>

                <fieldset>
                    <label for="multisend_new_order">
                        <input type="checkbox" id="multisend_comment_sms" name="multisend_comment_sms" value="1"
	                        <?php if ( isset( $multisend_option['multisend_comment_sms'] ) == "1" ) {
		                        echo 'checked';
	                        } ?>>
                        <span><?php esc_html_e( 'Send SMS to the customer from order page - In order note window', 'multisend-integration' ); ?></span>
                    </label>
                </fieldset>

            </div>

        </div>
		<?php
	}

}

add_action( 'multisend_sms_form_fields', 'multisend_sms_woocommerce_fields', 10, 1 );


/**
 * WooCommerce new order
 *
 * multisend SMS on WooCommerce new order.
 *
 * @param $order_id
 *
 * @since 1.0
 */
function multisend_sms_woocommerce_new_order( $order_id ) {
	$account = get_option( 'multisend_sms_account' );
	$option  = get_option( 'multisend_sms_option' );

	$billing_phone = get_post_meta( $order_id, '_billing_phone', true );
	$sms_customer  = $option['multisend_new_order_customer_content'];
	$sms_manager   = $option['multisend_new_order_customer_manager_content'];
	$sms           = new multisend\sms_geteway();

	if ( 1 == $option['multisend_new_order'] ) {

		if ( 1 == $option['multisend_new_order_customer'] ) {
			$sms_content = $sms->multisend_create_sms_content( $order_id, $sms_customer );
			$sms->multisend_send_sms( $sms_content, $billing_phone );
		}

		if ( 1 == $option['multisend_new_order_customer_manager'] ) {
			$sms_content = $sms->multisend_create_sms_content( $order_id, $sms_manager );
			$sms->multisend_send_sms( $sms_content, $account['sms_phone'] );
		}

	}

}

add_action( 'woocommerce_order_status_processing', 'multisend_sms_woocommerce_new_order', 10, 1 );


/**
 * WooCommerce order pending
 *
 * multisend SMS on WooCommerce order pending.
 *
 * @param $order_id
 *
 * @since 1.0
 */
function multisend_sms_woocommerce_order_pending( $order_id ) {

	$account = get_option( 'multisend_sms_account' );
	$option  = get_option( 'multisend_sms_option' );

	if ( 1 == $option['multisend_order_cancel'] ) {

		$sms = new multisend\sms_geteway();

		if ( 1 == $option['multisend_order_cancel_manager'] ) {
			$sms_manager = $option['multisend_order_cancel_sms'];
			$sms_content = $sms->multisend_create_sms_content( $order_id, $sms_manager );
			$sms->multisend_send_sms( $sms_content, $account['sms_phone'] );
		}

		if ( 1 == $option['multisend_order_cancel_customer'] ) {
			$billing_phone = get_post_meta( $order_id, '_billing_phone', true );
			$sms_customer  = $option['multisend_order_cancel_sms_customer'];
			$sms_content   = $sms->multisend_create_sms_content( $order_id, $sms_customer );
			$sms->multisend_send_sms( $sms_content, $billing_phone );
		}
	}

}

add_action( 'woocommerce_order_status_cancelled', 'multisend_sms_woocommerce_order_pending' );

/**
 * WooCommerce order complete
 *
 * multisend SMS on WooCommerce order completion.
 *
 * @param $order_id
 *
 * @since 1.0
 */
function multisend_sms_woocommerce_order_complete( $order_id ) {
	$option = get_option( 'multisend_sms_option' );

	$billing_phone = get_post_meta( $order_id, '_billing_phone', true );

	if ( 1 == $option['multisend_order_complete'] ) {
		$sms         = new multisend\sms_geteway();
		$sms_content = $sms->multisend_create_sms_content( $order_id, $option['multisend_order_complete_sms'] );
		$sms->multisend_send_sms( $sms_content, $billing_phone );
	}

}

add_action( 'woocommerce_order_status_completed', 'multisend_sms_woocommerce_order_complete' );


/**
 * @param $data
 * Send order customer note via sms
 */

function multisend_customer_note_sms( $data ) {

	$option        = get_option( 'multisend_sms_option' );
	if ( 1 == $option['multisend_comment_sms'] ) {

		$sms           = new multisend\sms_geteway();
		$order         = new WC_Order( $data['order_id'] );
		$billing_phone = $order->get_billing_phone();

		$sms->multisend_send_sms( $data['customer_note'], $billing_phone );
	}

}

add_action( 'woocommerce_new_customer_note', 'multisend_customer_note_sms', 10 );


function multisend_custom_order_status( $order_id ) {

	$option        = get_option( 'multisend_sms_option' );
	$billing_phone = get_post_meta( $order_id, '_billing_phone', true );

	$order = new WC_Order( $order_id );

	foreach ( $option['multisend_custom'] as $key => $status ) {
		if ( str_replace( 'wc-', '', $key ) == $order->get_status() ) {
			$sms         = new multisend\sms_geteway();
			$sms_content = $sms->multisend_create_sms_content( $order_id, $status );
			$sms->multisend_send_sms( $sms_content, $billing_phone );
		}
	}
}


$option = get_option( 'multisend_sms_option' );
if ( isset( $option['multisend_custom'] ) ) {
	foreach ( $option['multisend_custom'] as $key => $status ) {
		$status = str_replace( 'wc-', '', $key );
		add_action( 'woocommerce_order_status_' . $status, 'multisend_custom_order_status' );
	}
}

