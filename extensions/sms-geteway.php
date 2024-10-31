<?php
namespace multisend;



/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.2
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
 * SMS Gateway
 *
 * ...
 *
 * @since 1.0
 */
class sms_geteway {

    private $shop_manager_phone;

    private function multisend_user_access() {
        $account = get_option('multisend_sms_account');

        return $xml = '<User><Username>' . $account['sms_user_name'] . '</Username><Password>' . $account['sms_pass'] . '</Password></User>';

    }

    private function multisend_sms_content( $content, $phone_num ) {
        return $xml = '<destinations>
        <phone id="multisend">' . $phone_num . '</phone>
        </destinations>
        <message>' . $content . '</message>';
    }

    public function multisend_send_sms( $content, $phone_num ) {
        $account = get_option('multisend_sms_account');

        $xml = '<multiXML>' . $this->multisend_user_access() . '<send><Content Type="sms+tts"><Message>'.$content.'</Message></Content><Recipients><PhoneNumber>'.$phone_num .'</PhoneNumber></Recipients><Settings><Sender>'.$account['sms_from'].'</Sender><CustomerMessageID>1000002.5537.2202235</CustomerMessageID><DeliveryNotificationUrl>https://api.responder.live/paycall</DeliveryNotificationUrl><feedback>1</feedback></Settings></send></multiXML>';
           
        $this->multisend_sms_geteway($xml);
    }

    public function multisend_get_balance() {

        $account = get_option('multisend_sms_account');

            $baseurl = 'https://api.multisend.co.il/MultiSendAPI/balance&user='.$account['sms_user_name'].'&password=' . $account['sms_pass'];
           
            $params.= '&country_phone_code=972';
            $response = wp_remote_get( $baseurl.$params );
            $body     = wp_remote_retrieve_body( $response );
            
        return json_decode($body , true);
    }


    function multisend_sms_geteway( $xml ) {



        $body = array(
            'multiXML'    => $xml,
        );

        $args = array(
            'body'        => $body,
            'timeout'     => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(),
            'cookies'     => array(),
        );

        $response = wp_remote_post( 'https://api.multisend.co.il/MultiSendAPI/sendMultiXMLMessage', $args );

         if ( !empty( $error ) )
		 	error_log( sprintf( __( 'Error: %s', 'multisend-integration' ), $error ) );
         return json_decode($response, true);

    }

    public function multisend_create_sms_content( $order_id, $sms_customer ) {

        $order = new \ WC_Order( $order_id );

        $billing_first_name = get_post_meta( $order_id, '_billing_first_name', true );
        $billing_last_name  = get_post_meta( $order_id, '_billing_last_name',  true );
        $billing_address    = get_post_meta( $order_id, '_billing_address_1',  true );
        $billing_city       = get_post_meta( $order_id, '_billing_city',       true );
        $billing_email      = get_post_meta( $order_id, '_billing_email',      true );

        $sms_customer = str_replace( "[first name]",   $billing_first_name, $sms_customer );
        $sms_customer = str_replace( "[last name]",    $billing_last_name, $sms_customer  );
        $sms_customer = str_replace( "[order number]", $order_id, $sms_customer           );
        $sms_customer = str_replace( "[address]",      $billing_address, $sms_customer    );
        $sms_customer = str_replace( "[city]",         $billing_city, $sms_customer       );
        $sms_customer = str_replace( "[email]",        $billing_email, $sms_customer      );

        return $sms_customer;

    }

}
