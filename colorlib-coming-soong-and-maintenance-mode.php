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
if ( !defined( 'ABSPATH' ) ) exit;

//loads the text domain for translation
function colorlib_coming_soon_load_plugin_textdomain() {
	load_plugin_textdomain( 'colorlib-coming-soon', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'colorlib_coming_soon_load_plugin_textdomain' );


//Loading Plugin Theme Customizer Options
require_once( 'templates/colorlib-customizer.php' );

/* Redirect code that checks if on WP login page */
add_action('init','colorlib_coming_soon_skip_redirect_on_login');
function colorlib_coming_soon_skip_redirect_on_login () {
	

	global $pagenow;
	if ('wp-login.php' == $pagenow) {
		return;
	} 
	else {
		add_action( 'template_redirect', 'colorlib_coming_soon_template_redirect' );
	}
}

/* Coming Soon Redirect to Template */
function colorlib_coming_soon_template_redirect() {
	global $wp_customize;
	if ( !is_user_logged_in() ||  isset( $wp_customize ) && get_theme_mod('colorlib_coming_soon_preview', '1') == 1 ) { //Checks for if user is logged in OR if customizer is open and customizer preview option is checked
		
     	$file = plugin_dir_path(__FILE__).'templates/colorlib-template.php'; //get path of our coming soon display page and redirecting
    	include($file);
		
  	exit(); }
}



add_action('admin_menu', 'colorlib_coming_soon_settings_link');
 
/**
* add external link to Tools area
*/
function colorlib_coming_soon_settings_link() {
    global $submenu;
    $url = site_url(). '/wp-admin/customize.php';
    $submenu['options-general.php'][] = array('Colorlib Coming Soon Settings', 'manage_options', $url);
}



