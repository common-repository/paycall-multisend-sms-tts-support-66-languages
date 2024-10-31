<?php
/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$sms            = new \multisend\sms_geteway();
$balance        = $sms->multisend_get_balance();
$balanceSms        = isset( $balance['sms'] ) ? $balance['sms'] : '';
$balanceTts        = isset( $balance['tts'] ) ? $balance['tts']  : '';
$multisend_option  = get_option( 'multisend_sms_option' );
$multisend_account = get_option( 'multisend_sms_account' );
?>
<div class="wrap multisend_wrap">

    <h1><?php esc_html_e( 'PayCall Multisend SMS & TTS Support 66 languages', 'multisend-integration' ); ?></h1>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <!-- sidebar -->
            <div id="postbox-container-1" class="postbox-container">

                <div class="meta-box-sortables">

                    <div class="postbox">

                        <h2 class="hndle"><span><?php esc_html_e( 'General Info', 'multisend-integration' ); ?></span>
                        </h2>

                        <div class="inside">
                            <p><?php esc_html_e( 'SMS balance:', 'multisend-integration' ); ?> <span
                                        class="textme-balance"><?php echo $balanceSms; ?></span></p>
                        </div>


                        <div class="inside">
                            <p><?php esc_html_e( 'TTS balance:', 'multisend-integration' ); ?> <span
                                        class="textme-balance"><?php echo $balanceTts; ?></span></p>
                        </div>

                        <!-- .inside -->

                        <h2 class="hndle">
                            <span><?php esc_html_e( 'Purchase packages:', 'multisend-integration' ); ?></span>
                        </h2>
                        <div class="inside">
                            <p><a href="https://multisend.co.il/site/selfRegistration"
                                  target="_blank"><?php esc_html_e( 'Open a free trial account', 'multisend-integration' ); ?></a>
                            </p>
                            <!-- <p><a href="https://multisend.co.il/#packages"
                                  target="_blank"><?php //esc_html_e( 'Price list and packages purchase', 'multisend-integration' ); ?></a>
                            </p> -->
                            <p><a href="https://paycall.co.il/"
                                  target="_blank"><?php esc_html_e( 'Paycall website', 'multisend-integration' ); ?></a>
                            </p>

                        </div>

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables -->

            </div>

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <form action="" method="post" id="multisend_acount_form">

                        <div class="postbox">

                            <div class="notice multisend-success is-dismissible hidden">
                                <p><?php esc_html_e( 'Successfully updated.', 'multisend-integration' ); ?></p>
                            </div>

                            <h2 class="hndle">
                                <span><?php esc_html_e( 'Account details', 'multisend-integration' ); ?></span></h2>

                            <div class="inside">
                                <table>
                                    <tr>
                                        <td>
                                            <label for="sms_user_name"><?php esc_html_e( 'Acount username:', 'multisend-integration' ); ?></label>
                                        </td>
                                        <td>
                                            <input type="text" name="sms_user_name" id="sms_user_name" required
                                                   value="<?php if ( $multisend_account['sms_user_name'] ) {
												       echo $multisend_account['sms_user_name'];
											       } ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="sms_pass"><?php esc_html_e( 'Acount password:', 'multisend-integration' ); ?></label>
                                        </td>
                                        <td>
                                            <input type="password" name="sms_pass" id="sms_pass" required
                                                   value="<?php if ( $multisend_account['sms_pass'] ) {
												       echo $multisend_account['sms_pass'];
											       } ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="sms_phone"><?php esc_html_e( 'Site manager phone:', 'multisend-integration' ); ?></label>
                                        </td>
                                        <td>
                                            <input type="text" name="sms_phone" id="sms_phone" pattern=".{8,15}" required
                                                   title="<?php esc_html_e( '10 Digits', 'multisend-integration' ); ?>"
                                                   value="<?php if ( $multisend_account['sms_phone'] ) {
												       echo $multisend_account['sms_phone'];
											       } ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="sms_from"><?php esc_html_e( 'SMS name or number:', 'multisend-integration' ); ?></label>
                                        </td>
                                        <td>
                                            <input type="text" name="sms_from" id="sms_from" pattern="[a-zA-Z0-9-]+"
                                                   required
                                                   title="<?php esc_html_e( '10 Digits numbers or english letters', 'multisend-integration' ); ?>"
                                                   value="<?php if ( $multisend_account['sms_from'] ) {
												       echo $multisend_account['sms_from'];
											       } ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="button-primary" type="submit" id="multisend_acount" name="save"
                                                   value="<?php esc_attr_e( 'Save', 'multisend-integration' ); ?>">
                                        </td>
                                        <td>
                                            <div class="spinner"
                                                 style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <!-- .inside -->

                        </div>

                    </form>

                    <form id="multisend_option_form" action="" method="post">

						<?php do_action( 'multisend_sms_form_fields', $multisend_option ); ?>

                        <input class="button-primary" type="submit" id="multisend_submit" name="save"
                               value="<?php esc_attr_e( 'Save', 'multisend-integration' ); ?>"/>
                        <div class="spinner"
                             style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>

                    </form>

                </div>
                <!-- post-body-content -->

            </div>
            <!-- #post-body .metabox-holder .columns-2 -->

            <br class="clear">

        </div>
        <!-- #poststuff -->

    </div>
    <!-- .wrap -->
