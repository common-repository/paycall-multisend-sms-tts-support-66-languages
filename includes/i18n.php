<?php
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
 * Internationalization
 *
 * Load plugin translation files from api.wordpress.org.
 *
 * @since 1.2
 */
class multisend_i18n {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'multisend_load_textdomain' ) );

	}

	/**
	 * Load the text domain for translation
	 */
	public function multisend_load_textdomain() {

		load_plugin_textdomain( 'multisend-integration' );

	}

}
new multisend_i18n();
