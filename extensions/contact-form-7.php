<?php
/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.3
 */
if (!defined('ABSPATH')) {
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
function multisend_sms_cf7_fields($multisend_option)
{


    $plugin_name = 'contact-form-7/wp-contact-form-7.php';
    $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (in_array($plugin_name, $active_plugins)) {
        ?>
        <div class="postbox">

            <h2 class="hndle">
                <?php esc_html_e('Contact Form 7 Events', 'multisend-integration'); ?>
            </h2>

            <div class="inside">

                <fieldset>
                    <label for="multisend_cf7">
                        <input type="checkbox" id="multisend_cf7" name="multisend_cf7"
                               value="1" <?php if (isset($multisend_option['multisend_cf7']) == "1") {
                            echo 'checked';
                        } ?>/>
                        <span><?php esc_html_e('Send SMS to site admin when CF7 form submitted', 'multisend-integration'); ?></span>
                    </label>
                </fieldset>


                <fieldset>
                    <label for="multisend_cf7_user">
                        <input type="checkbox" id="multisend_cf7_user" name="multisend_cf7_user"
                               value="1" <?php if (isset($multisend_option['multisend_cf7_user']) == "1") {
                            echo 'checked';
                        } ?>/>
                        <span><?php esc_html_e('Send SMS to user when CF7 form submitted', 'multisend-integration'); ?></span>
                    </label>
                    <div class="send_user_sms <?php if (isset($multisend_option['multisend_cf7_user']) != "1") { echo 'hidden'; } ?>">
                        <table>
                            <tr>
                                <td>
                                    <span><?php esc_html_e('Contact form 7 phone field name (ex your-phone)', 'multisend-integration'); ?></span>
                                </td>
                                <td>
                                    <input type="text" id="multisend_cf7_phone_field" name="multisend_cf7_phone_field"
                                           value="<?php if ($multisend_option['multisend_cf7_phone_field']) {
                                               echo $multisend_option['multisend_cf7_phone_field'];
                                           } ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span><?php esc_html_e('Content sent to user', 'multisend-integration'); ?></span>
                                </td>
                                <td>
                                 <textarea id="multisend_cf7_user_content"
                                           name="multisend_cf7_user_content" cols="80"
                                           rows="3"
                                           class="all-options"><?php if ($multisend_option['multisend_cf7_user_content']) {
                                         echo $multisend_option['multisend_cf7_user_content'];
                                     } ?>
                    </textarea>

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

add_action('multisend_sms_form_fields', 'multisend_sms_cf7_fields', 10, 1);


/**
 * Contact Form 7 mail sent
 *
 * multisend SMS on successful Contact Form 7 mail submission.
 *
 * @param $contact_form
 *
 * @since 1.0
 */
function multisend_sms_cf7_mail_sent($contact_form)
{

    $sms_geteway = new \multisend\sms_geteway();
    $account = get_option('multisend_sms_account');
    $option = get_option('multisend_sms_option');
    $submission = WPCF7_Submission::get_instance()->get_posted_data();


    if (1 == $option['multisend_cf7']) {

        unset($submission['_wpcf7']);
        unset($submission['_wpcf7_version']);
        unset($submission['_wpcf7_locale']);
        unset($submission['_wpcf7_unit_tag']);
        unset($submission['_wpcf7_is_ajax_call']);
        unset($submission['mc4wp_checkbox']);
	    unset($submission['g-recaptcha-response']);
	    unset($submission['_wpcf7_container_post']);


        $sms = '';


        foreach ($submission as $key => $row) {

            $sms .= $key . ': ' . $row . " \n ";
        }


        $sms_geteway->multisend_send_sms($sms, $account['sms_phone']);
       
    }

    if (1 == $option['multisend_cf7_user']) {

        $sms_geteway->multisend_send_sms($option['multisend_cf7_user_content'], $submission[$option['multisend_cf7_phone_field']]);
    }

}

add_action('wpcf7_mail_sent', 'multisend_sms_cf7_mail_sent');
