<?php
/**
* Plugin Name: Coming Soon and Maintenance by Colorlib
* Plugin URI: https://colorlib.com/
* Description: Colorlib Coming Soon and Maintenance is a responsive coming soon WordPress plugin that comes with well designed coming soon page and lots of useful features including customization via Live Customizer, MailChimp integration, custom forms, and more.
* Version: 1.0.98
* Author: Colorlib
* Author URI: https://colorlib.com/
* Tested up to: 5.6
* Requires: 4.6 or higher
* License: GPLv3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 5.6
* Text Domain: colorlib-coming-soon-maintenance
* Domain Path: /languages
*
* Copyright 2018-2019 Colorlib support@colorlib.com
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 3, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
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
add_action( 'customize_controls_enqueue_scripts', 'ccsm_customizer_scripts', 30 );
add_action( 'customize_preview_init', 'ccsm_customizer_preview_scripts', 30 );
add_action( 'ccsm_header', 'ccsm_style_enqueue', 20 );
add_action( 'ccsm_header', 'wp_print_scripts' );
add_filter( 'ccsm_skip_redirect', 'ccsm_skip_redirect' );
add_filter( 'ccsm_force_redirect', 'ccsm_force_redirect' );

//loads the text domain for translation
function ccsm_load_plugin_textdomain() {
	load_plugin_textdomain( 'colorlib-coming-soon-maintenance', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

//add settings and support links on wordpress plugin page
function ccsm_add_settings_link( $actions, $plugin_file ) {

	static $plugin;

	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}
	if ( $plugin == $plugin_file ) {

		$settings  = array( 'settings' => '<a href="'.admin_url('options-general.php?page=ccsm_settings').'">' . __( 'Settings', 'colorlib-coming-soon-maintenance' ) . '</a>' );
		$site_link = array( 'support' => '<a href="https://colorlib.com/wp/forums" target="_blank">' . __( 'Support', 'colorlib-coming-soon-maintenance' ) . '</a>' );

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

function ccsm_skip_redirect($should_skip=false){
	return $should_skip;
}

function ccsm_force_redirect($should_force=false){
	return $should_force;
}

/* Coming Soon Redirect to Template */
function ccsm_template_redirect() {
    global $wp_customize;
    $ccsm_options = get_option('ccsm_settings');

    // allow plugins & themes to control whether to force the check, regardless of any other settings
    $force = apply_filters('ccsm_force_redirect', false);

    // Checks for if user is logged in and CCSM is activated  OR if customizer is open on CCSM customization panel
    $activated = (!is_user_logged_in() && $ccsm_options['colorlib_coming_soon_activation'] == 1 || is_customize_preview() && isset($_REQUEST['colorlib-coming-soon-customization'])) ? true : false;

    // If something "forced" it - but not in customizer -, or the default case was met, we might redirect
    if ($force && !is_customize_preview() || $activated) {

        // allow plugins & themes to skip the redirect (assuming force wasn't set)
        $skip = apply_filters('ccsm_skip_redirect', false);

        if ($force || !$skip) {
            $file = plugin_dir_path(__FILE__) . 'includes/colorlib-template.php'; //get path of our coming soon display page and redirecting
            include($file);
            exit();
        }
    }
}

// enqueue template styles
function ccsm_style_enqueue( $template_name ) {

	$global_styles = array(
		array(
			'name'     => 'animate',
			'location' => 'css/vendor/animate/animate.css',
		),
		array(
			'name'     => 'bootstrap',
			'location' => 'css/vendor/bootstrap/css/bootstrap.min.css',
		),
		array(
			'name'     => 'font-awesome',
			'location' => 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
			'font'     => 'true'
		),
		array(
			'name'     => 'select-2',
			'location' => 'css/vendor/select2/select2.min.css',
		),
		array(
			'name'     => 'iconic',
			'location' => 'https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css',
			'font'     => 'true'
		),
	);

	//styles based on each template
	$template_styles = array(
		'template_01' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css'
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css'
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700',
				'font'     => 'true'
			),
			array(
				'name'     => 'Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Lato:400,700',
				'font'     => 'true'
			)
		),
		'template_02' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700',
				'font'     => 'true'
			),
			array(
				'name'     => 'Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Lato:300,400,700',
				'font'     => 'true'
			)
		),
		'template_03' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Barlow',
				'location' => 'https://fonts.googleapis.com/css?family=Barlow:400,500,700',
				'font'     => 'true'
			)
		),
		'template_04' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Montserrat',
				'location' => 'https://fonts.googleapis.com/css?family=Montserrat:300,400,700,900',
				'font'     => 'true'
			)
		),
		'template_05' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Ubuntu',
				'location' => 'https://fonts.googleapis.com/css?family=Ubuntu:400,700',
				'font'     => 'true'
			)
		),
		'template_06' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'Aldrich',
				'location' => 'https://fonts.googleapis.com/css?family=Aldrich',
				'font'     => 'true'
			),
			array(
				'name'     => 'Util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700',
				'font'     => 'true'
			),
		),
		'template_07' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700',
				'font'     => 'true'
			),
			array(
				'name'     => 'Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Lato',
				'font'     => 'true'
			)
		),
		'template_08' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:300,400,700',
				'font'     => 'true'
			),
			array(
				'name'     => 'Playfair-Display',
				'location' => 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i',
				'font'     => 'true'
			)
		),
		'template_09' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:100,400,700,900',
				'font'     => 'true'
			)
		),
		'template_10' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins-Playfair',
				'location' => 'https://fonts.googleapis.com/css?family=Playfair+Display:400i,700,900i|Poppins:100,400,500,700,900',
				'font'     => 'true'
			)
		),
		'template_11' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Lato-Playrfair',
				'location' => 'https://fonts.googleapis.com/css?family=Lato:100,400|Playfair+Display:400i',
				'font'     => 'true'
			)
		),
		'template_12' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins-Playfair',
				'location' => 'https://fonts.googleapis.com/css?family=Playfair+Display:900i|Poppins:400,500',
				'font'     => 'true'
			)
		),
		'template_13' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Montserrat',
				'location' => 'https://fonts.googleapis.com/css?family=Montserrat:400,600',
				'font'     => 'true'
			),
			array(
				'name'     => 'Dancing-script',
				'location' => 'https://fonts.googleapis.com/css?family=Dancing+Script',
				'font'     => 'true'
			)
		),
		'template_14' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Poppins-Playfair',
				'location' => 'https://fonts.googleapis.com/css?family=Playfair+Display:400,900i|Poppins:400,500',
				'font'     => 'true'
			)
		),
		'template_15' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'css/util.css',
			),
			array(
				'name'     => 'Montserrat-Quantico',
				'location' => 'https://fonts.googleapis.com/css?family=Montserrat:100,400,700|Quantico',
				'font'     => 'true'
			)
		),
	);

	$global_scripts = array(
		array(
			'name'     => 'popper',
			'location' => 'js/vendor/bootstrap/js/popper.js',
			'template' => 'global',
		),
		array(
			'name'     => 'bootstrap',
			'location' => 'js/vendor/bootstrap/js/bootstrap.min.js',
			'template' => 'global'
		),
		array(
			'name'     => 'moment',
			'location' => 'js/vendor/countdowntime/moment.min.js',
			'template' => 'global'
		),
		array(
			'name'     => 'moment-timezone',
			'location' => 'js/vendor/countdowntime/moment-timezone.min.js',
			'template' => 'global'
		),
		array(
			'name'     => 'timezone',
			'location' => 'js/vendor/countdowntime/moment-timezone-with-data.min.js',
			'template' => 'global'
		),
		array(
			'name'     => 'tilt',
			'location' => 'js/vendor/tilt/tilt.jquery.min.js',
			'template' => 'global'
		),
	);

	if ( $template_name == 'template_06' || $template_name == 'template_15' ) {
		$global_scripts[] = array(
			'name'     => 'flipclock',
			'location' => 'js/vendor/countdowntime/flipclock.js',
			'template' => 'global'
		);
		$global_scripts[] = array(
			'name'     => 'coutdowntime-2',
			'location' => 'js/vendor/countdowntime/countdowntime-2.js',
			'template' => 'global'
		);
	} else {
		$global_scripts[] = array(
			'name'     => 'coutdowntime',
			'location' => 'js/vendor/countdowntime/countdowntime.js',
			'template' => 'global'
		);
	}

	// scripts based on each template
	$template_scripts = array(
		'template_01' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_02' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_03' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_04' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_05' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_06' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_07' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_08' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_09' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_10' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_11' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_12' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_13' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_14' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
		'template_15' => array(
			array(
				'name'     => 'main',
				'location' => 'js/main.js',
			),
		),
	);

	//check if template and get the template arrays
	if ( $template_name ) {
		$encript_styles  = $template_styles[ $template_name ];
		$encript_scripts = $template_scripts[ $template_name ];
	}

	//print global styles
	foreach ( $global_styles as $global_style ) {

		if ( isset( $global_style['font'] ) && $global_style['font'] == 'true' ) {
			wp_register_style( $global_style['name'], $global_style['location'] );
			wp_print_styles( $global_style['name'] );
		} else {
			wp_register_style( $global_style['name'], CCSM_URL . 'assets/' . $global_style['location'] );
			wp_print_styles( $global_style['name'] );
		}
	}

	//print wordpress default jquery
	wp_print_scripts( 'jquery' );

	//print global scripts
	foreach ( $global_scripts as $global_script ) {
		wp_register_script( $global_script['name'], CCSM_URL . 'assets/' . $global_script['location'] );
		wp_print_scripts( $global_script['name'] );
	}

	//print styles depending on template
	if ( $encript_styles != null && is_array( $encript_styles ) ) {
		foreach ( $encript_styles as $encript_style ) {
			if ( isset( $encript_style['font'] ) && $encript_style['font'] == 'true' ) {
				wp_register_style( $encript_style['name'], $encript_style['location'] );
				wp_print_styles( $encript_style['name'] );
			} else {
				wp_register_style( $template_name . '-' . $encript_style['name'], CCSM_URL . 'templates/' . $template_name . '/' . $encript_style['location'] );
				wp_print_styles( $template_name . '-' . $encript_style['name'] );
			}


		}
	}

	//print scripts depending on template
	foreach ( $encript_scripts as $encript_script ) {
		wp_register_script( $template_name . '-' . $encript_script['name'], CCSM_URL . 'templates/' . $template_name . '/' . $encript_script['location'] );
		wp_print_scripts( $template_name . '-' . $encript_script['name'] );
	}
}


function ccsm_customizer_preview_scripts() {
	wp_register_script( 'colorlib-ccsm-customizer-preview', CCSM_URL . 'assets/js/customizer-preview.js', array(
		'jquery',
		'customize-preview'
	), '', true );
	wp_enqueue_script( 'colorlib-ccsm-customizer-preview' );
	wp_enqueue_scripts( 'customize-selective-refresh' );
}


function ccsm_customizer_scripts() {
	wp_enqueue_editor();
	wp_register_script( 'colorlib-ccsm-customizer-js', CCSM_URL . 'assets/js/customizer.js', array( 'customize-controls' ) );
	wp_enqueue_script( 'colorlib-ccsm-customizer-js' );
	wp_register_style( 'colorlib-ccsm-custom-controls-css', CCSM_URL . 'assets/css/ccsm-custom-controls.css', array(), '1.0', 'all' );
	wp_enqueue_style( 'colorlib-ccsm-custom-controls-css' );
	wp_localize_script(
		'colorlib-ccsm-customizer-js', 'CCSMurls', array(
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

	$cDate = new DateTime( date( 'Y-m-d H:i:s' ) );

	$interval = $cDate->diff( $date );

	if ( $date > $cDate ) {

		//template needed info
		$days    = $interval->format( '%a' );
		$hours   = $interval->format( '%H' );
		$minutes = $interval->format( '%I' );
		$seconds = $interval->format( '%S' );
		//script needed info
		$year  = $date->format( 'Y' );
		$month = $date->format( 'm' );
		$day   = $date->format( 'd' );
		$hour = $date->format('H');
		$minute = $date->format('I');
        $second = $date->format('s');

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
			'hour'   => $hour,
			'minute' => $minute,
			'second' => $second
		);


	} else {
		$dates['template'] = array(
			'days'    => '0',
			'hours'   => '0',
			'minutes' => '0',
			'seconds' => '0'
		);
		$dates['script']   = false;

	}

	return $dates;
}

//check if default settings are stored in db, else store them
register_activation_hook( __FILE__, 'ccsm_check_on_activation' );

function ccsm_check_on_activation() {
	if ( get_option( 'ccsm_settings' ) == null ) {
		$defaultSets = array(
			'colorlib_coming_soon_activation'            => '1',
			'colorlib_coming_soon_timer_activation'      => '1',
			'colorlib_coming_soon_subscribe'             => '',
			'colorlib_coming_soon_template_selection'    => 'template_01',
			'colorlib_coming_soon_timer_option'          => date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
			'colorlib_coming_soon_plugin_logo'           => CCSM_URL . 'assets/images/logo.jpg',
			'colorlib_coming_soon_page_heading'          => 'Something <strong>really good</strong> is coming <strong>very soon</strong>',
			'colorlib_coming_soon_page_content'          => 'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching.',
			'colorlib_coming_soon_page_footer'           => 'And don\'t worry, we hate spam too! You can unsubscribe at any time.',
			'colorlib_coming_soon_social_facebook'       => 'https://facebook.com/',
			'colorlib_coming_soon_social_twitter'        => 'https://twitter.com/',
			'colorlib_coming_soon_social_youtube'        => 'https://youtube.com/',
			'colorlib_coming_soon_social_email'          => 'you@domain.com',
			'colorlib_coming_soon_social_pinterest'      => 'https://pinterest.com/',
			'colorlib_coming_soon_social_instagram'      => 'https://instagram.com/',
			'colorlib_coming_soon_subscribe_form_url '   => ' ',
			'colorlib_coming_soon_page_custom_css'       => '',
			'colorlib_coming_soon_background_image'      => CCSM_URL . 'assets/images/logo.jpg',
			'colorlib_coming_soon_background_color'      => '',
			'colorlib_coming_soon_text_color'            => '',
			'colorlib_coming_soon_subscribe_form_url'    => '',
			'colorlib_coming_soon_subscribe_form_other ' => ''
		);
		update_option( 'ccsm_settings', $defaultSets );
	}
}

function ccsm_template_has_content() {
	$ccsm_options         = get_option( 'ccsm_settings' );
	$template_has_content = array(
		'template_02',
		'template_04',
		'template_05',
		'template_06',
		'template_08',
		'template_10',
		'template_12',
		'template_14'
	);
	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_content ) ) {
		return true;
	}

	return false;
}

function ccsm_template_has_footer() {
	$ccsm_options        = get_option( 'ccsm_settings' );
	$template_has_footer = array(
		'template_01',
		'template_03',
		'template_04',
		'template_06',
		'template_07'
	);
	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_footer ) ) {
		return true;
	}

	return false;
}


function ccsm_template_has_background_image() {
	$ccsm_options                  = get_option( 'ccsm_settings' );
	$template_has_background_image = array(
		'template_04',
		'template_05'
	);
	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_background_image ) ) {
		return false;
	}

	return true;
}

function ccsm_template_has_background_color() {
	$ccsm_options                  = get_option( 'ccsm_settings' );
	$template_has_background_color = array(
		'template_02',
		'template_03',
		'template_09',
		'template_10',
		'template_11',
		'template_12',
		'template_13',
		'template_14'
	);
	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_background_color ) ) {
		return true;
	}

	return false;
}

function ccsm_template_has_text_color() {
	$ccsm_options            = get_option( 'ccsm_settings' );
	$template_has_text_color = array(
		'template_04',
		'template_05',
		'template_03',
		'template_06',
		'template_07',
		'template_08',
		'template_12',
		'template_14',
		'template_15'
	);
	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_text_color ) ) {
		return false;
	}

	return true;
}

function ccsm_template_has_logo() {
	$ccsm_options      = get_option( 'ccsm_settings' );
	$template_has_logo = array(
		'template_01',
		'template_03',
		'template_06',
		'template_07',
		'template_09',
		'template_10',
		'template_11',
		'template_12',
		'template_13',
		'template_14',
		'template_15'
	);

	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_logo ) ) {
		return true;
	} else {
		return false;
	}
}

function ccsm_template_has_social() {
	$ccsm_options        = get_option( 'ccsm_settings' );
	$template_has_social = array(
		'template_01',
		'template_03',
		'template_06',
		'template_07',
		'template_09',
		'template_10',
		'template_11',
		'template_12',
		'template_13',
		'template_14',
		'template_15'
	);

	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_social ) ) {
		return true;
	} else {
		return false;
	}

}

function ccsm_template_has_timer() {

	$ccsm_options       = get_option( 'ccsm_settings' );
	$template_has_timer = array(
		'template_12',
		'template_14'
	);

	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_timer ) ) {
		return false;
	} else {
		return true;
	}

}

function ccsm_template_has_subscribe_form() {
	$ccsm_options                = get_option( 'ccsm_settings' );
	$template_has_subscribe_form = array(
		'template_15',
		'template_09',
		//'template_10',
		'template_11',
		//'template_13'
	);

	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_subscribe_form ) ) {
		return false;
	} else {
		return true;
	}
}

function ccsm_template_has_subscribe_signup() {
	$ccsm_options                  = get_option( 'ccsm_settings' );
	$template_has_subscribe_signup = array(
		'template_09',
		'template_10',
		'template_11',
		'template_13'
	);

	if ( in_array( $ccsm_options['colorlib_coming_soon_template_selection'], $template_has_subscribe_signup ) ) {
		return true;
	} else {
		return false;
	}
}

function ccsm_check_for_review() {
	if ( ! is_admin() ) {
		return;
	}
	require_once CCSM_PATH . 'includes/class-ccsm-review.php';

	CCSM_Review::get_instance( array(
		'slug' => 'colorlib-coming-soon-maintenance',
	) );
}

ccsm_check_for_review();

//Loading Plugin Theme Customizer Options
require_once( 'includes/class-ccsm-customizer.php' );