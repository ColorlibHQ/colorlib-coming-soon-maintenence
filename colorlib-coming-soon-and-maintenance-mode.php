<?php
/*
  Plugin Name: Colorlib Coming Soon and Maintenance plugin for WordPress
  Plugin URI: https://colorlib.com/
  Description: Colorlib Coming Soon and Maintenance is a responsive coming soon WordPress plugin that comes with well designed coming soon page and lots of useful features including customization via Live Customizer, MailChimp integration, custom forms, and more.
  Version: 1.3.0
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

/*define( 'FBFW_VERSION', '3.0.14' );*/
define( 'CSMM_PATH', plugin_dir_path( __FILE__ ) );
define( 'CSMM_URL', plugin_dir_url( __FILE__ ) );
define( 'CSMM_PLUGIN_BASE', plugin_basename( __FILE__ ) );
/*define( 'FBFW_PREVIOUS_PLUGIN_VERSION', '3.0.10' );*/
define( 'CSMM_FILE_', __FILE__ );
/*define( 'PLUGIN_NAME', 'fancybox-for-wordpress' );*/

//loads the text domain for translation
function colorlib_coming_soon_load_plugin_textdomain() {
	load_plugin_textdomain( 'colorlib-coming-soon', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}

add_action( 'plugins_loaded', 'colorlib_coming_soon_load_plugin_textdomain' );


//Loading Plugin Theme Customizer Options
require_once( 'templates/colorlib-customizer.php' );

/* Redirect code that checks if on WP login page */
add_action( 'init', 'colorlib_coming_soon_skip_redirect_on_login' );
function colorlib_coming_soon_skip_redirect_on_login() {


	global $pagenow;
	if ( 'wp-login.php' == $pagenow ) {
		return;
	} else {
		add_action( 'template_redirect', 'colorlib_coming_soon_template_redirect' );
	}
}

/* Coming Soon Redirect to Template */
function colorlib_coming_soon_template_redirect() {
	global $wp_customize;
	if ( ! is_user_logged_in() || isset( $wp_customize ) && get_theme_mod( 'colorlib_coming_soon_preview', '1' ) == 1 ) { //Checks for if user is logged in OR if customizer is open and customizer preview option is checked

		$templateFile = get_theme_mod( 'colorlib_coming_soon_template_selection' );

		$file = plugin_dir_path( __FILE__ ) . 'templates/template_files/' . $templateFile . '/' . $templateFile . '.php'; //get path of our coming soon display page and redirecting
		include( $file );

		exit();
	}
}


add_action( 'admin_menu', 'colorlib_coming_soon_settings_link' );

/**
 * add external link to Tools area
 */
function colorlib_coming_soon_settings_link() {
	global $submenu;
	$url                              = site_url() . '/wp-admin/customize.php';
	$submenu['options-general.php'][] = array( 'Colorlib Coming Soon Settings', 'manage_options', $url );
}


function colorlibStyleEnqueue( $styles ) {
	if ( is_array( $styles ) ) {
		foreach ( $styles as $style ) {
			$fileLocation = $style['location'];
			$fileName     = $style['name'];
			$templateName = $style['template'];
			wp_enqueue_style( $templateName . '-' . $fileName, CSMM_URL . 'templates/template_files/' . $templateName . '/' . $fileLocation );
		}
	}
}

function colorlibScriptEnqueue( $scripts ) {
	if ( is_array( $scripts ) ) {
		foreach ( $scripts as $script ) {
			$fileLocation = $script['location'];
			$fileName     = $script['name'];
			$templateName = $script['template'];
			wp_enqueue_script( $templateName . '-' . $fileName, CSMM_URL . 'templates/template_files/' . $templateName . '/' . $fileLocation );
		}
	}
}

add_action( 'wp_enqueue_style', 'colorlibStyleEnqueue' );
add_action( 'wp_enqueue_scripts', 'colorlibScriptEnqueue' );

function colorlibCounterDates( $timerDate ) {

	$date = DateTime::createFromFormat( 'Y-m-d', $timerDate );

	$fDAte = new DateTime( $timerDate );
	$cDate    = new DateTime( date( 'Y-m-d H:i:s' ) );
	$interval = $cDate->diff( $fDAte );
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
		'year'  => $year,
		'month' => $month,
		'day'   => $day
	);

	return $dates;
}
