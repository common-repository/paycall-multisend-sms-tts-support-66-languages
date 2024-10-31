<?php
/**
 *
 * Prevent direct access to the file.
 *
 * @since 1.3
 */
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Pojo Form multisend fields
 *
 * Add pojo fields to multisend settings page.
 *
 * @param $multisend_option
 *
 * @since 1.4
 */
function multisend_pojo_sms_fields($multisend_option)
{
    $plugin_name = 'pojo-forms/pojo-forms.php';
    $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (in_array($plugin_name, $active_plugins)) { ?>
        <div class="postbox">

            <h2 class="hndle">
                <?php esc_html_e('Pojo forms integration', 'multisend-integration'); ?>
            </h2>

            <div class="inside">

                <fieldset>
                    <label for="multisend_pojo_admin">
                        <input type="checkbox" id="multisend_pojo_admin" name="multisend_pojo_admin"
                               value="1" <?php if ($multisend_option['multisend_pojo_admin'] == "1") {
                            echo 'checked';
                        } ?>/>
                        <span><?php esc_html_e('Send SMS to site admin when pojo form form submitted', 'multisend-integration'); ?></span>
                    </label>
                </fieldset>


                <fieldset>
                    <label for="multisend_pojo_user">
                        <input type="checkbox" id="multisend_pojo_user" name="multisend_pojo_user"
                               value="1" <?php if ($multisend_option['multisend_pojo_user'] == "1") {
                            echo 'checked';
                        } ?>/>
                        <span><?php esc_html_e('Send SMS to user when pojo form form submitted', 'multisend-integration'); ?></span>
                    </label>
                    <div class="send_pojo_user_sms <?php if ($multisend_option['multisend_pojo_user'] != "1") {
                        echo 'hidden';
                    } ?>">
                        <table>
                            <tr>
                                <td>
                                    <span><?php esc_html_e('pojo form phone field title (ex phone)', 'multisend-integration'); ?></span>
                                </td>
                                <td>
                                    <input type="text" id="multisend_pojo_phone_field" name="multisend_pojo_phone_field"
                                           value="<?php if ($multisend_option['multisend_pojo_phone_field']) {
                                               echo $multisend_option['multisend_pojo_phone_field'];
                                           } ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span><?php esc_html_e('Content sent to user', 'multisend-integration'); ?></span>
                                </td>
                                <td>
                                 <textarea id="multisend_pojo_user_content"
                                           name="multisend_pojo_user_content" cols="80"
                                           rows="3"
                                           class="all-options"><?php if ($multisend_option['multisend_pojo_user_content']) {
                                         echo $multisend_option['multisend_pojo_user_content'];
                                     } ?>
                    </textarea>

                                </td>
                            </tr>
                        </table>
                    </div>

                </fieldset>


            </div>

        </div>
    <?php }
}

add_action('multisend_sms_form_fields', 'multisend_pojo_sms_fields', 10, 1);

/**
 * pojo forms mail sent
 *
 * multisend SMS on successful pojo forms mail submission.
 *
 * @param $contact_form
 *
 * @since 1.0
 */

function multisend_sms_pojo_forms_mail_sent($form_id, $field_values)
{

    $account = get_option('multisend_sms_account');
    $option = get_option('multisend_sms_option');

    if (1 == $option['multisend_pojo_admin']) {
        $msg = "";
        foreach ($field_values as $field) {
            $msg .= $field['title'] . ' : ' . $field['value'];
            $msg .= "\n";
        }
        $sms_geteway = new \multisend\sms_geteway();
        $sms_geteway->multisend_send_sms($msg, $account['sms_phone']);
    }

    if(1 == $option['multisend_pojo_user']){
        $phone = '';
        foreach ($field_values as $field) {
            if($field['title']==$option['multisend_pojo_phone_field']){
                $phone =  $field['value'];
            }
        }
        $sms_geteway = new \multisend\sms_geteway();
        $sms_geteway->multisend_send_sms($option['multisend_pojo_user_content'], $phone);
    }

}

add_action('pojo_forms_mail_sent', 'multisend_sms_pojo_forms_mail_sent', 20, 3);

