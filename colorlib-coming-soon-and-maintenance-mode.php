<?php
/*
  Plugin Name: Colorlib Coming Soon and Maintenance plugin for WordPress
  Plugin URI: https://colorlib.com/
  Description: Colorlib Coming Soon and Maintenance is a responsive coming soon WordPress plugin that comes with well designed coming soon page and lots of useful features including customization via Live Customizer, MailChimp integration, custom forms, and more.
  Version: 1.0.0
  Author: Colorlib
  Author URI: https://colorlib.com/
  License: GPL V3
  Text Domain: colorlib-coming-soon
  Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CCSM_PATH', plugin_dir_path( __FILE__ ) );
define( 'CCSM_URL', plugin_dir_url( __FILE__ ) );
define( 'CCSM_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'CCSM_FILE_', __FILE__ );

add_action( 'init', 'ccsm_skip_redirect_on_login' );
add_action( 'plugins_loaded', 'ccsm_load_plugin_textdomain' );
add_filter( 'plugin_action_links', 'ccsm_add_settings_link', 10, 5 );
add_action( 'customize_controls_enqueue_scripts', 'ccsm_customizer_scripts' );
add_action( 'customize_preview_init', 'ccsm_customizer_preview_scripts' );
//add_action( 'wp_footer', 'ccsm_remove_scripts' );
add_action( 'wp_enqueue_scripts', 'ccsm_style_enqueue' );
add_action( 'wp_enqueue_scripts', 'ccsm_script_enqueue' );


//loads the text domain for translation
function ccsm_load_plugin_textdomain() {
	load_plugin_textdomain( 'colorlib-coming-soon', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}

//add settings and support links on wordpress plugin page
function ccsm_add_settings_link( $actions, $plugin_file ) {

	static $plugin;

	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}
	if ( $plugin == $plugin_file ) {

		$settings  = array( 'settings' => '<a href="options-general.php?page=ccsm_settings">' . __( 'Settings', 'colorlib-coming-soon' ) . '</a>' );
		$site_link = array( 'support' => '<a href="http://colorlib.com" target="_blank">Support</a>' );

		$actions = array_merge( $settings, $actions );
		$actions = array_merge( $site_link, $actions );
	}

	return $actions;
}

/* Redirect code that checks if on WP login page */
function ccsm_skip_redirect_on_login() {

	global $pagenow;
	if ( 'wp-login.php' == $pagenow ) {
		return;
	} else {
		add_action( 'template_redirect', 'ccsm_template_redirect' );
	}
}

/* Coming Soon Redirect to Template */
function ccsm_template_redirect() {
	global $wp_customize;
	$ccsm_options = get_option( 'ccsm_settings' );

	//Checks for if user is logged in and CCSM is activated  OR if customizer is open on CCSM customization panel
	if ( ! is_user_logged_in() && $ccsm_options['colorlib_coming_soon_activation'] == 1 || is_customize_preview() && isset( $_REQUEST['colorlib-coming-soon-customization'] ) ) {

		$file = plugin_dir_path( __FILE__ ) . 'includes/colorlib-template.php'; //get path of our coming soon display page and redirecting
		include( $file );

		exit();
	}
}

//remove all enqueued styles and scripts
function ccsm_remove_scripts() {
	remove_all_actions( 'wp_header' );
	remove_all_actions( 'wp_footer' );
}

// enqueue template styles
function ccsm_style_enqueue( $styles ) {
	if ( is_array( $styles ) ) {
		foreach ( $styles as $style ) {
			$fileLocation = $style['location'];
			$fileName     = $style['name'];
			$templateName = $style['template'];

			if ( $templateName == 'global' ) {
				wp_enqueue_style( $templateName . '-' . $fileName, CCSM_URL . 'assets/' . $fileLocation );
			} else {
				wp_enqueue_style( $templateName . '-' . $fileName, CCSM_URL . 'templates/' . $templateName . '/' . $fileLocation );
			}

		}
	}
}

// enqueue template scripts
function ccsm_script_enqueue( $scripts ) {
	wp_enqueue_script( 'jquery' );

	if ( is_array( $scripts ) ) {
		foreach ( $scripts as $script ) {
			if ( $script['location'] != null ) {
				$fileLocation = $script['location'];
			}
			if ( $script['name'] != null ) {
				$fileName = $script['name'];
			}
			if ( $script['template'] != null ) {
				$templateName = $script['template'];
			}
			if ( $templateName != 'global' ) {
				wp_enqueue_script( $templateName . '-' . $fileName, CCSM_URL . 'templates/' . $templateName . '/' . $fileLocation );
			} else {
				wp_enqueue_script( $templateName . '-' . $fileName, CCSM_URL . 'assets/' . $fileLocation );
			}

		}
	}
}


function ccsm_customizer_preview_scripts() {
	wp_enqueue_script( 'colorlib-customizer-preview', CCSM_URL . 'assets/js/customizer-preview.js', array(
		'customize-preview',
		'jquery'
	) );

}


function ccsm_customizer_scripts() {
	wp_enqueue_editor();
	//wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
	wp_enqueue_script( 'colorlib-customizer-js', CCSM_URL . 'assets/js/customizer.js' );
	wp_enqueue_script( 'colorlib-cmmm-main-js', CCSM_URL . 'assets/js/main.js' );
	wp_enqueue_style( 'colorlib-custom-controls-css', CCSM_URL . 'assets/css/ccsm-custom-controls.css', array(), '1.0', 'all' );
	wp_localize_script(
		'colorlib-customizer-js', 'CCSurls', array(
			'siteurl' => get_option( 'siteurl' ),
		)
	);
}

// Timer and countdown date display function
function ccsm_counter_dates( $timerDate ) {

	if ( $timerDate ) {
		$date = DateTime::createFromFormat( 'Y-m-d H:i:s', $timerDate );
	} else {
		$date = DateTime::createFromFormat( 'Y-m-d H:i:s', date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ) );
	}

	$cDate    = new DateTime( date( 'Y-m-d H:i:s' ) );
	$interval = $cDate->diff( $date );


	//template needed info
	$days    = $interval->format( '%a' );
	$hours   = $interval->format( '%H' );
	$minutes = $interval->format( '%I' );
	$seconds = $interval->format( '%S' );
	//script needed info
	$year  = $date->format( 'Y' );
	$month = $date->format( 'm' );
	$day   = $date->format( 'd' );

	$dates['template'] = array(
		'days'    => $days,
		'hours'   => $hours,
		'minutes' => $minutes,
		'seconds' => $seconds
	);

	$dates['script'] = array(
		'year'   => $year,
		'month'  => $month,
		'day'    => $day,
		'hour'   => $hours,
		'minute' => $minutes,
		'second' => $seconds
	);


	return $dates;
}

//check if default settings are stored in db, else store them
register_activation_hook( __FILE__, 'ccsm_check_on_activation' );

function ccsm_check_on_activation() {
	if ( get_option( 'ccsm_settings' ) == null ) {
		$defaultSets = array(
			'colorlib_coming_soon_activation'         => '1',
			'colorlib_coming_soon_template_selection' => 'template_01',
			'colorlib_coming_soon_timer_option'       => date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
			'colorlib_coming_soon_plugin_logo'        => CCSM_URL . 'assets/images/logo.png',
			'colorlib_coming_soon_page_heading'       => 'Something <strong>really good</strong> is coming <strong>very soon</strong>',
			'colorlib_coming_soon_page_content'       => 'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching.',
			'colorlib_coming_soon_page_footer'        => 'And don\'t worry, we hate spam too! You can unsubscribe at any time.',
			'colorlib_coming_soon_social_facebook'    => 'https://facebook.com/',
			'colorlib_coming_soon_social_twitter'     => 'https://twitter.com/',
			'colorlib_coming_soon_social_youtube'     => 'https://youtube.com/',
			'colorlib_coming_soon_social_email'       => 'you@domain.com',
			'colorlib_coming_soon_social_pinterest'   => 'https://pinterest.com/',
			'colorlib_coming_soon_social_instagram'   => 'https://instagram.com/'

		);
		update_option( 'ccsm_settings', $defaultSets );
	}
}


//Loading Plugin Theme Customizer Options
require_once( 'includes/class_ccsm_customizer.php' );