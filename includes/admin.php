<?php

/**
 * Security check
 *
 * Prevent direct access to the file.
 *
 * @since 1.2
 */
if (!defined('ABSPATH'))
{
	exit;
}


/**
 * multisend Options Page
 *
 * Add options page for the plugin.
 *
 * @since 1.0
 */
function multisend_options_page()
{

	add_options_page(
		__('Multisend', 'multisend-integration'),
		__('Multisend', 'multisend-integration'),
		'manage_options',
		'multisend_sms',
		'multisend_options_page_ui'
	);
}

add_action('admin_menu', 'multisend_options_page');


/**
 * multisend Options Page UI
 *
 * The view of the options page.
 *
 * @since 1.0
 */
function multisend_options_page_ui()
{

	include 'admin-ui.php';
}


function multisend_update_option_page()
{

	$multisend_option = array();
	wp_parse_str($_POST['data'], $multisend_option);


	$multisend_option_param = array();
	foreach ($multisend_option as $key => $input)
	{
		$input = sanitize_textarea_field( $input );
		$input = htmlspecialchars($input, ENT_QUOTES);
		$multisend_option_param[$key] = $input;
	}

	if ($multisend_option['multisend_custom'])
	{
		$multisend_option_param['multisend_custom'] = $multisend_option['multisend_custom'];
	}
	update_option('multisend_sms_option', $multisend_option_param);
	die();
}

add_action('wp_ajax_multisend_update_option_page', 'multisend_update_option_page');


function multisend_update_account()
{

	$multisend_account = array();
	wp_parse_str($_POST['data'], $multisend_account);
	$sms_phone            = '0' . intval($multisend_account['sms_phone']);
	$sms_user_name        = sanitize_text_field($multisend_account['sms_user_name']);
	$sms_pass             = sanitize_text_field($multisend_account['sms_pass']);
	$sms_from             = sanitize_text_field($multisend_account['sms_from']);
	$multisend_account_param = array(
		'sms_user_name' => $sms_user_name,
		'sms_pass'      => $sms_pass,
		'sms_phone'     => $sms_phone,
		'sms_from'      => $sms_from
	);

	update_option('multisend_sms_account', $multisend_account_param);

	$sms     = new \multisend\sms_geteway();
	$balance = (array) $sms->multisend_get_balance();
	$arr     = array();
	if ($balance['success'] != true)
	{
		$arr = [
			'Message' => __('Username or password is incorrect', 'multisend-integration'),
			'Balance' => '0',
			'Status'  => -1
		];
	}
	elseif ($balance['success'] == true)
	{
		$arr = [
			'Message' => __('Username and password is correct', 'multisend-integration'),
			'Balance' => $balance['success'],
			'Status'  => 0
		];
	}

	//echo json_encode($arr);
	echo 	json_encode($arr);

	die();
}

add_action('wp_ajax_multisend_update_account', 'multisend_update_account');
