<?php
/**
 * Luanch ajaxclass
 *
 * @package   launch-ajax-generic
 * @author    Christopher Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 8-27-2014 BAWD
 */

/**
 * ajaxclass class.
 *
 * @package Ajaxclass
 * @author  Christopher Churchill <churchill.c.j@gmail.com>
 */
class ccsm_ajax {
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "ajax-generic";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		add_action( 'wp_ajax_add_mailchimp', array( $this, 'ccsm_add_mailchimp' ) );
		add_action( 'wp_ajax_nopriv_add_mailchimp', array( $this, 'ccsm_add_mailchimp' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function ccsm_get_instance() {

		// If the single instance hasn"t been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function ccsm_add_mailchimp() {
		include( plugin_dir_path( __FILE__ ) . '/templates/post-subscribe.php' );
		die();
	}
}
