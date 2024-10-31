<?php
/*
Plugin Name: PayCall Multisend SMS & TTS Support 66 languages
Plugin URI:  https://wordpress.org/plugins/paycall-multisend-sms-tts/
Description: Send custom SMS & TTS messages from your WordPress site to your customers.
Version:     1.0
Text Domain: multisend-integration
*/



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



/**
 * Include plugin files
 */
include_once ( plugin_dir_path( __FILE__ ) . 'includes/i18n.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'includes/scripts-styles.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'includes/admin.php' );



/**
 * Include external addons and extensions
 */
include_once ( plugin_dir_path( __FILE__ ) . 'extensions/sms-geteway.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'extensions/elementor.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'extensions/contact-form-7.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'extensions/woocommerce.php' );
include_once ( plugin_dir_path( __FILE__ ) . 'extensions/pojo-forms.php' );


function multisend_plugin_load_my_own_textdomain( $mofile, $domain ) {
	if ( 'multisend-integration' === $domain  ) {
	    $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
	    $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
	}
	return $mofile;
}
add_filter( 'load_textdomain_mofile', 'multisend_plugin_load_my_own_textdomain', 10, 2 );
    