<?php
/**
* Plugin Name: Coming Soon and Maintenance by Colorlib
* Plugin URI: https://colorlib.com/
* Description: Colorlib Coming Soon and Maintenance is a responsive coming soon WordPress plugin that comes with well designed coming soon page and lots of useful features including customization via Live Customizer, MailChimp integration, custom forms, and more.
* Version: 1.3.0
* Author: Colorlib
* Author URI: https://colorlib.com/
* Tested up to: 7.0
* Requires at least: 6.0
* License: GPLv3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 7.4
* Text Domain: colorlib-coming-soon-maintenance
* Domain Path: /languages
*
* Copyright 2018-2026 Colorlib support@colorlib.com
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
define( 'CCSM_VERSION', '1.3.0' );

// PHP version check
if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
	add_action( 'admin_notices', function () {
		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			sprintf(
				/* translators: %s: current PHP version. */
				esc_html__( 'Coming Soon and Maintenance by Colorlib requires PHP 7.4 or higher. Your server is running PHP %s.', 'colorlib-coming-soon-maintenance' ),
				esc_html( PHP_VERSION )
			)
		);
	} );
	return;
}

add_action( 'plugins_loaded', 'ccsm_load_plugin_textdomain' );
add_filter( 'plugin_action_links', 'ccsm_add_settings_link', 10, 2 );
add_action( 'customize_controls_enqueue_scripts', 'ccsm_customizer_scripts', 30 );
add_action( 'customize_preview_init', 'ccsm_customizer_preview_scripts', 30 );
add_action( 'ccsm_header', 'ccsm_style_enqueue', 20 );
add_filter( 'ccsm_skip_redirect', 'ccsm_skip_redirect' );
add_filter( 'ccsm_force_redirect', 'ccsm_force_redirect' );
add_filter( 'rest_pre_dispatch', 'ccsm_rest_restrict', 10, 3 );

/*
 * The front-end guard has to run before core's own template_redirect callbacks.
 * redirect_canonical() (priority 10) answers /?p=N probes with a 301 to the
 * pretty permalink, and WP_Sitemaps renders wp-sitemap*.xml and exits — both
 * leak the site's content inventory before a default-priority callback runs.
 */
add_action( 'template_redirect', 'ccsm_template_redirect', 0 );
add_action( 'init', 'ccsm_guard_front_doors', 0 );
add_filter( 'robots_txt', 'ccsm_robots_txt', 10, 2 );

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
	if ( $plugin === $plugin_file ) {

		// The settings page is registered as a top-level menu, so it lives under
		// admin.php — options-general.php?page=… fails the capability check.
		$settings  = array( 'settings' => '<a href="'.esc_url( admin_url( 'admin.php?page=ccsm_settings' ) ).'">' . __( 'Settings', 'colorlib-coming-soon-maintenance' ) . '</a>' );
		$site_link = array( 'support' => '<a href="https://colorlib.com/wp/forums" target="_blank">' . __( 'Support', 'colorlib-coming-soon-maintenance' ) . '</a>' );

		$actions = array_merge( $settings, $actions );
		$actions = array_merge( $site_link, $actions );
	}

	return $actions;
}

function ccsm_skip_redirect($should_skip=false){
	return $should_skip;
}

function ccsm_force_redirect($should_force=false){
	return $should_force;
}

/**
 * Whether the coming soon page should replace the site for the current visitor.
 *
 * This is the single source of truth for every guard in the plugin (the
 * template redirect, the REST block and the entry points closed in
 * ccsm_guard_front_doors()), so they can never disagree about who is locked out.
 *
 * @return bool
 */
function ccsm_is_active_for_visitor() {
	$ccsm_options = get_option( 'ccsm_settings' );

	if ( ! is_array( $ccsm_options ) ) {
		return false;
	}

	if ( ! isset( $ccsm_options['colorlib_coming_soon_activation'] ) || '1' !== $ccsm_options['colorlib_coming_soon_activation'] ) {
		return false;
	}

	if ( ! is_user_logged_in() ) {
		return true;
	}

	/**
	 * Filters the capability that lets a logged-in user through to the real site.
	 *
	 * The gate used to be a bare is_user_logged_in() check, so on a site with
	 * open registration every subscriber saw straight through it. Return
	 * 'read' to restore the old behaviour.
	 *
	 * @param string $capability Capability required to bypass the page.
	 */
	$capability = apply_filters( 'ccsm_bypass_capability', 'edit_posts' );

	return ! current_user_can( $capability );
}

/**
 * Return the configured display mode: 'coming_soon' (HTTP 200) or 'maintenance' (HTTP 503).
 *
 * @return string
 */
function ccsm_get_mode() {
	$ccsm_options = get_option( 'ccsm_settings' );
	$mode         = is_array( $ccsm_options ) && isset( $ccsm_options['colorlib_coming_soon_mode'] )
		? $ccsm_options['colorlib_coming_soon_mode']
		: 'coming_soon';

	return 'maintenance' === $mode ? 'maintenance' : 'coming_soon';
}

/**
 * Close the front-end entry points that never reach template_redirect.
 *
 * template_redirect only covers requests that go through the template loader.
 * XML-RPC, admin-ajax.php, admin-post.php and wp-links-opml.php bypass it
 * entirely and keep serving data while the site is supposed to be closed.
 */
function ccsm_guard_front_doors() {
	if ( ! ccsm_is_active_for_visitor() ) {
		return;
	}

	// Rendered from an init callback that exits before template_redirect runs.
	add_filter( 'wp_sitemaps_enabled', '__return_false' );

	// xmlrpc_enabled only gates the authenticated methods, so drop the pingback
	// ones as well: they are the SSRF / amplification surface.
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'xmlrpc_methods', 'ccsm_filter_xmlrpc_methods' );

	// wp-links-opml.php prints the blogroll and the WordPress version.
	if ( isset( $GLOBALS['pagenow'] ) && 'wp-links-opml.php' === $GLOBALS['pagenow'] ) {
		ccsm_deny_request();
	}

	// admin-ajax.php and admin-post.php both fire admin_init while logged out,
	// so any other plugin's nopriv handler stays reachable without this.
	add_action( 'admin_init', 'ccsm_guard_admin_entry_points', 0 );
}

/**
 * Remove the pingback XML-RPC methods while the site is closed.
 *
 * @param array $methods Registered XML-RPC methods.
 * @return array
 */
function ccsm_filter_xmlrpc_methods( $methods ) {
	unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );

	return $methods;
}

/**
 * Block logged-out admin-ajax.php / admin-post.php actions while the site is closed.
 */
function ccsm_guard_admin_entry_points() {
	if ( ! ccsm_is_active_for_visitor() ) {
		return;
	}

	$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	/**
	 * Filters the nopriv admin-ajax.php / admin-post.php actions that stay
	 * reachable for logged-out visitors while the coming soon page is active.
	 *
	 * @param array $actions Allowed action names.
	 */
	$allowed = apply_filters( 'ccsm_allowed_nopriv_actions', array() );

	if ( in_array( $action, (array) $allowed, true ) ) {
		return;
	}

	ccsm_deny_request();
}

/**
 * Send a 403 for a request that must not be served while the site is closed.
 */
function ccsm_deny_request() {
	nocache_headers();
	wp_die(
		esc_html__( 'Sorry, this content is restricted!', 'colorlib-coming-soon-maintenance' ),
		esc_html__( 'Restricted', 'colorlib-coming-soon-maintenance' ),
		array( 'response' => 403 )
	);
}

/**
 * Ask crawlers to stay away while the site is in maintenance mode.
 *
 * Coming soon mode keeps the default rules: that page is often meant to be
 * indexed. Maintenance mode is a temporary outage, so nothing should be crawled.
 *
 * @param string $output robots.txt content.
 * @param bool   $public Whether the site is asking to be indexed.
 * @return string
 */
function ccsm_robots_txt( $output, $public ) {
	if ( ! ccsm_is_active_for_visitor() || 'maintenance' !== ccsm_get_mode() ) {
		return $output;
	}

	return "User-agent: *\nDisallow: /\n";
}

/* Coming Soon Redirect to Template */
function ccsm_template_redirect() {

    // robots.txt and favicon.ico have to keep working: crawlers need the former
    // to read the Disallow rules added while the site is closed.
    if ( is_robots() || is_favicon() ) {
        return;
    }

    // allow plugins & themes to control whether to force the check, regardless of any other settings
    $force = apply_filters('ccsm_force_redirect', false);

    // Checks whether CCSM is activated for this visitor OR the customizer is open on the CCSM panel
    $in_customizer = is_customize_preview() && isset( $_REQUEST['colorlib-coming-soon-customization'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $activated     = ccsm_is_active_for_visitor() || $in_customizer;

    // If something "forced" it - but not in customizer -, or the default case was met, we might redirect
    if ($force && !is_customize_preview() || $activated) {

        // allow plugins & themes to skip the redirect (assuming force wasn't set)
        $skip = apply_filters('ccsm_skip_redirect', false);

        if ($force || !$skip) {

            // Never let a page cache or CDN keep serving the placeholder after
            // the site reopens.
            nocache_headers();

            // A maintenance window is a temporary outage: 503 + Retry-After keeps
            // search engines from treating the placeholder as the site's content.
            if ( 'maintenance' === ccsm_get_mode() && ! $in_customizer ) {
                status_header( 503 );

                /**
                 * Filters the Retry-After header (seconds) sent in maintenance mode.
                 *
                 * @param int $seconds Defaults to one hour.
                 */
                header( 'Retry-After: ' . (int) apply_filters( 'ccsm_retry_after', HOUR_IN_SECONDS ) );
            }

            $file = plugin_dir_path(__FILE__) . 'includes/colorlib-template.php'; //get path of our coming soon display page and redirecting
            include($file);
            exit();
        }
    }
}

/**
 * Restrict REST API access to non-logged-in users when coming soon mode is active.
 *
 * Uses rest_pre_dispatch to block all REST API requests before endpoint callbacks run,
 * preventing information exposure via public endpoints like wp/v2/posts and wp/v2/pages.
 *
 * @param  mixed            $result   Response to replace the requested version with.
 * @param  WP_REST_Server   $server   Server instance.
 * @param  WP_REST_Request  $request  Request used to generate the response.
 *
 * @return WP_Error|mixed
 */
function ccsm_rest_restrict( $result, $server, $request ) {
	// If already handled by another filter, pass through
	if ( ! empty( $result ) ) {
		return $result;
	}

	if ( ccsm_is_active_for_visitor() ) {
		return new WP_Error(
			'rest_forbidden',
			__( 'Sorry, this content is restricted!', 'colorlib-coming-soon-maintenance' ),
			array( 'status' => 403 )
		);
	}

	return $result;
}

// enqueue template styles
function ccsm_style_enqueue( $template_name ) {

	$global_styles = array(
		array(
			'name'     => 'ccsm-frontend',
			'location' => 'css/ccsm-frontend.css',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true'
			),
			array(
				'name'     => 'Poppins-Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700|Lato:400,700',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'Poppins-Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700|Lato:300,400,700',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'name'     => 'Aldrich-Poppins',
				'location' => 'https://fonts.googleapis.com/css?family=Aldrich|Poppins:400,700',
				'font'     => 'true'
			),
			array(
				'name'     => 'Util',
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
		),
		'template_07' => array(
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
			),
			array(
				'name'     => 'util',
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'Poppins-Lato',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:400,700|Lato',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'Poppins-Playfair',
				'location' => 'https://fonts.googleapis.com/css?family=Poppins:300,400,700|Playfair+Display:400,400i',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'Montserrat-DancingScript',
				'location' => 'https://fonts.googleapis.com/css?family=Montserrat:400,600|Dancing+Script',
				'font'     => 'true'
			)
		),
		'template_14' => array(
			array(
				'name'     => 'util',
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'main',
				'location' => 'css/main.css',
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
				'location' => 'assets/css/ccsm-util.css',
				'shared'   => 'true',
			),
			array(
				'name'     => 'Montserrat-Quantico',
				'location' => 'https://fonts.googleapis.com/css?family=Montserrat:100,400,700|Quantico',
				'font'     => 'true'
			)
		),
	);

	// Single vanilla front-end script (no jQuery). Handles form validation,
	// the background slideshow, the subscribe modal, the tilt effect and the
	// countdown timer, each feature-detected so it only runs where present.
	$global_scripts = array(
		array(
			'name'     => 'ccsm-frontend',
			'location' => 'js/ccsm-frontend.js',
		),
	);

	// Per-template JS is now handled by the single shared ccsm-frontend.js
	// global script, so only template-specific styles remain.
	$encript_styles = array();
	if ( $template_name && isset( $template_styles[ $template_name ] ) ) {
		$encript_styles = $template_styles[ $template_name ];
	}

	// Preconnect to the Google Fonts hosts (fonts are loaded per template below).
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

	//print global styles
	foreach ( $global_styles as $global_style ) {

		if ( isset( $global_style['font'] ) && $global_style['font'] === 'true' ) {
			wp_register_style( $global_style['name'], $global_style['location'] . '&display=swap', array(), null );
			wp_print_styles( $global_style['name'] );
		} else {
			wp_register_style( $global_style['name'], CCSM_URL . 'assets/' . $global_style['location'], array(), CCSM_VERSION );
			wp_print_styles( $global_style['name'] );
		}
	}

	//register global scripts (printed before </body> by ccsm_footer_scripts)
	foreach ( $global_scripts as $global_script ) {
		wp_register_script( $global_script['name'], CCSM_URL . 'assets/' . $global_script['location'], array(), CCSM_VERSION, true );
	}

	//print styles depending on template
	if ( ! empty( $encript_styles ) ) {
		foreach ( $encript_styles as $encript_style ) {
			if ( isset( $encript_style['font'] ) && $encript_style['font'] === 'true' ) {
				wp_register_style( $encript_style['name'], $encript_style['location'] . '&display=swap', array(), null );
				wp_print_styles( $encript_style['name'] );
			} elseif ( isset( $encript_style['shared'] ) && 'true' === $encript_style['shared'] ) {
				// One shared copy for every template, resolved from assets/.
				wp_register_style( 'ccsm-' . $encript_style['name'], CCSM_URL . $encript_style['location'], array(), CCSM_VERSION );
				wp_print_styles( 'ccsm-' . $encript_style['name'] );
			} else {
				wp_register_style( $template_name . '-' . $encript_style['name'], CCSM_URL . 'templates/' . $template_name . '/' . $encript_style['location'], array(), CCSM_VERSION );
				wp_print_styles( $template_name . '-' . $encript_style['name'] );
			}
		}
	}

}

/**
 * Print the front-end script before </body>.
 *
 * It used to be printed from the ccsm_header action, and wp_print_scripts()
 * with an explicit handle emits immediately, so the $in_footer flag on the
 * registration was ignored and 6.5 KB of parser-blocking JS sat in the <head>.
 */
function ccsm_footer_scripts() {
	wp_print_scripts( 'ccsm-frontend' );
}
add_action( 'ccsm_footer', 'ccsm_footer_scripts' );

/**
 * Preload the background image the active template is about to use.
 *
 * The image is applied through an inline style attribute deep in the body, so
 * without this hint the browser only discovers the LCP image once the CSS has
 * parsed.
 *
 * @param array $ccsm_options Plugin settings.
 */
function ccsm_preload_background( $ccsm_options ) {
	if ( ! ccsm_template_has_background_image() ) {
		return;
	}

	$bcg_url = isset( $ccsm_options['colorlib_coming_soon_background_image'] ) ? $ccsm_options['colorlib_coming_soon_background_image'] : '';

	if ( '' === $bcg_url ) {
		return;
	}

	if ( is_ssl() ) {
		$bcg_url = str_replace( 'http://', 'https://', $bcg_url );
	}

	printf( '<link rel="preload" as="image" href="%s">' . "\n", esc_url( $bcg_url ) );
}


function ccsm_customizer_preview_scripts() {
	wp_register_script( 'colorlib-ccsm-customizer-preview', CCSM_URL . 'assets/js/customizer-preview.js', array(
		'jquery',
		'customize-preview'
	), CCSM_VERSION, true );
	wp_enqueue_script( 'colorlib-ccsm-customizer-preview' );
	wp_enqueue_script( 'customize-selective-refresh' );
}


function ccsm_customizer_scripts() {
	wp_enqueue_editor();
	wp_register_script( 'colorlib-ccsm-customizer-js', CCSM_URL . 'assets/js/customizer.js', array( 'jquery', 'customize-controls' ), CCSM_VERSION, true );
	wp_enqueue_script( 'colorlib-ccsm-customizer-js' );
	wp_register_style( 'colorlib-ccsm-custom-controls-css', CCSM_URL . 'assets/css/ccsm-custom-controls.css', array(), CCSM_VERSION, 'all' );
	wp_enqueue_style( 'colorlib-ccsm-custom-controls-css' );
	wp_localize_script(
		'colorlib-ccsm-customizer-js', 'CCSMurls', array(
			'siteurl' => get_option( 'siteurl' ),
		)
	);
}

/**
 * Return an inline SVG icon, replacing the old Font Awesome / Material icon-font glyphs.
 *
 * The SVG inherits its color via fill="currentColor" and scales with font-size
 * (width/height are 1em), so the templates' existing fs-* / cl* utility classes
 * keep working when forwarded through $classes. Path data: Simple Icons (brands,
 * 24x24) and Bootstrap Icons (UI, 16x16).
 *
 * @param string $name    Icon key (matches the old fa-/zmdi- names).
 * @param string $classes Extra CSS classes to add to the <svg> element.
 * @return string SVG markup, or an empty string for an unknown icon.
 */
/**
 * Tags allowed when printing the inline SVG returned by ccsm_icon().
 *
 * The markup is generated from a hard-coded table, but templates echo it, so
 * run it through wp_kses() with this allowlist to keep the output escaped.
 *
 * @return array
 */
function ccsm_svg_allowed_html() {
	return array(
		'svg'  => array(
			'class'       => true,
			'viewbox'     => true,
			'width'       => true,
			'height'      => true,
			'fill'        => true,
			'role'        => true,
			'aria-label'  => true,
			'aria-hidden' => true,
			'focusable'   => true,
		),
		'path' => array(
			'd'    => true,
			'fill' => true,
		),
	);
}

function ccsm_icon( $name, $classes = '' ) {
	$icons = array(
		'facebook'          => array( 24, 'M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z' ),
		'twitter'           => array( 24, 'M21.543 7.104c.015.211.015.423.015.636 0 6.507-4.954 14.01-14.01 14.01v-.003A13.94 13.94 0 0 1 0 19.539a9.88 9.88 0 0 0 7.287-2.041 4.93 4.93 0 0 1-4.6-3.42 4.916 4.916 0 0 0 2.223-.084A4.926 4.926 0 0 1 .96 9.167v-.062a4.887 4.887 0 0 0 2.235.616A4.928 4.928 0 0 1 1.67 3.148 13.98 13.98 0 0 0 11.82 8.292a4.929 4.929 0 0 1 8.39-4.49 9.868 9.868 0 0 0 3.128-1.196 4.941 4.941 0 0 1-2.165 2.724A9.828 9.828 0 0 0 24 4.555a10.019 10.019 0 0 1-2.457 2.549z' ),
		'youtube'           => array( 24, 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z' ),
		'pinterest'         => array( 24, 'M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z' ),
		'instagram'         => array( 24, 'M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077' ),
		'envelope'          => array( 16, 'M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z' ),
		'paper-plane'       => array( 16, 'M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z' ),
		'close'             => array( 16, 'M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z' ),
		'play'              => array( 16, 'm11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393' ),
		'long-arrow-right'  => array( 16, 'M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8' ),
		'card-giftcard'     => array( 16, 'M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9z' ),
	);

	// Aliases for the old icon-font name variants.
	$aliases = array(
		'facebook-official' => 'facebook',
		'twitter-square'    => 'twitter',
		'youtube-play'      => 'youtube',
		'envelope-square'   => 'envelope',
	);
	if ( isset( $aliases[ $name ] ) ) {
		$name = $aliases[ $name ];
	}

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	list( $size, $path ) = $icons[ $name ];

	// Human label for screen readers; UI/decorative glyphs stay hidden.
	$labels = array(
		'facebook'  => 'Facebook',
		'twitter'   => 'Twitter',
		'youtube'   => 'YouTube',
		'pinterest' => 'Pinterest',
		'instagram' => 'Instagram',
		'envelope'  => 'Email',
	);
	$label = isset( $labels[ $name ] ) ? $labels[ $name ] : '';

	$a11y = ( '' !== $label )
		? ' role="img" aria-label="' . esc_attr( $label ) . '"'
		: ' aria-hidden="true" focusable="false"';

	return sprintf(
		'<svg class="%s" viewBox="0 0 %d %d" width="1em" height="1em" fill="currentColor"%s><path d="%s"/></svg>',
		esc_attr( trim( 'ccsm-icon ' . $classes ) ),
		$size,
		$size,
		$a11y,
		$path
	);
}

// Timer and countdown date display function
function ccsm_counter_dates( $timerDate ) {
	if ( $timerDate ) {
		$date = DateTime::createFromFormat( 'Y-m-d H:i:s', $timerDate );
	} else {
		$date = DateTime::createFromFormat( 'Y-m-d H:i:s', gmdate( 'Y-m-d H:i:s', strtotime( '+1 month' ) ) );
	}

	// createFromFormat() returns false on a malformed stored timer value;
	// passing false to DateTime::diff() is a fatal TypeError on PHP 8+.
	if ( ! $date instanceof DateTime ) {
		$date = new DateTime( gmdate( 'Y-m-d H:i:s', strtotime( '+1 month' ) ) );
	}

	$cDate = new DateTime( gmdate( 'Y-m-d H:i:s' ) );

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
		$minute = $date->format('i');
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
	if ( false === get_option( 'ccsm_settings' ) ) {
		update_option( 'ccsm_settings', ccsm_defaults() );
	}
}

/**
 * Default value for every setting the plugin reads.
 *
 * @return array
 */
function ccsm_defaults() {
	return array(
		'colorlib_coming_soon_activation'            => '1',
		'colorlib_coming_soon_mode'                  => 'coming_soon',
		'colorlib_coming_soon_noindex'               => '',
		'colorlib_coming_soon_timer_activation'      => '1',
		'colorlib_coming_soon_subscribe'             => '',
		'colorlib_coming_soon_template_selection'    => 'template_01',
		'colorlib_coming_soon_timer_option'          => gmdate( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
		'colorlib_coming_soon_plugin_logo'           => CCSM_URL . 'assets/images/logo.jpg',
		'colorlib_coming_soon_page_heading'          => 'Something <strong>really good</strong> is coming <strong>very soon</strong>',
		'colorlib_coming_soon_page_content'          => 'If you have something new you\'re looking to launch, you\'re going to want to start building a community of people interested in what you\'re launching.',
		'colorlib_coming_soon_page_footer'           => 'And don\'t worry, we hate spam too! You can unsubscribe at any time.',
		'colorlib_coming_soon_social_facebook'       => '',
		'colorlib_coming_soon_social_twitter'        => '',
		'colorlib_coming_soon_social_youtube'        => '',
		'colorlib_coming_soon_social_email'          => '',
		'colorlib_coming_soon_social_pinterest'      => '',
		'colorlib_coming_soon_social_instagram'      => '',
		'colorlib_coming_soon_page_custom_css'       => '',
		'colorlib_coming_soon_background_image'      => CCSM_URL . 'assets/images/logo.jpg',
		'colorlib_coming_soon_background_color'      => '',
		'colorlib_coming_soon_text_color'            => '',
		'colorlib_coming_soon_google_analytics_id'   => '',
		'colorlib_coming_soon_subscribe_form_url'    => '',
		'colorlib_coming_soon_subscribe_form_other'  => ''
	);
}

/**
 * Read the settings with every key guaranteed to exist.
 *
 * Templates read a dozen keys directly. On a site upgraded from an older
 * version, or after a partial update_option(), the missing ones raised PHP 8
 * warnings that leaked absolute paths when display_errors was on.
 *
 * @return array
 */
function ccsm_get_options() {
	$options = get_option( 'ccsm_settings' );

	if ( ! is_array( $options ) ) {
		$options = array();
	}

	return wp_parse_args( $options, ccsm_defaults() );
}

/**
 * Sanitize a value for use in a CSS color context.
 *
 * esc_html()/esc_attr()/wp_kses_post() are HTML escapers: none of them touch
 * ";", "{" or "}", so a stored value could inject whole CSS rules. Anything
 * that is not a plain hex color is dropped.
 *
 * @param mixed $value Stored color value.
 * @return string Hex color, or '' when the value is unusable.
 */
function ccsm_hex_color( $value ) {
	if ( ! is_string( $value ) || '' === $value ) {
		return '';
	}

	$color = sanitize_hex_color( $value );

	return is_string( $color ) ? $color : '';
}

/**
 * The template slugs the plugin ships.
 *
 * Single source of truth for the settings sanitizer and the include guard in
 * includes/colorlib-template.php.
 *
 * @return array
 */
function ccsm_allowed_templates() {
	return array(
		'template_01', 'template_02', 'template_03', 'template_04', 'template_05',
		'template_06', 'template_07', 'template_08', 'template_09', 'template_10',
		'template_11', 'template_12', 'template_13', 'template_14', 'template_15',
	);
}

function ccsm_get_selected_template() {
	$ccsm_options = get_option( 'ccsm_settings' );
	if ( ! is_array( $ccsm_options ) || ! isset( $ccsm_options['colorlib_coming_soon_template_selection'] ) ) {
		return 'template_01';
	}
	return $ccsm_options['colorlib_coming_soon_template_selection'];
}

function ccsm_template_has_content() {
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
	return in_array( ccsm_get_selected_template(), $template_has_content, true );
}

function ccsm_template_has_footer() {
	$template_has_footer = array(
		'template_01',
		'template_03',
		'template_04',
		'template_06',
		'template_07'
	);
	return in_array( ccsm_get_selected_template(), $template_has_footer, true );
}


function ccsm_template_has_background_image() {
	$template_has_no_background_image = array(
		'template_04',
		'template_05'
	);
	return ! in_array( ccsm_get_selected_template(), $template_has_no_background_image, true );
}

function ccsm_template_has_background_color() {
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
	return in_array( ccsm_get_selected_template(), $template_has_background_color, true );
}

function ccsm_template_has_text_color() {
	$template_has_no_text_color = array(
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
	return ! in_array( ccsm_get_selected_template(), $template_has_no_text_color, true );
}

function ccsm_template_has_logo() {
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
	return in_array( ccsm_get_selected_template(), $template_has_logo, true );
}

function ccsm_template_has_social() {
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
	return in_array( ccsm_get_selected_template(), $template_has_social, true );
}

function ccsm_template_has_timer() {
	$template_has_no_timer = array(
		'template_12',
		'template_14'
	);
	return ! in_array( ccsm_get_selected_template(), $template_has_no_timer, true );
}

function ccsm_template_has_subscribe_form() {
	$template_has_no_subscribe_form = array(
		'template_15',
		'template_09',
		'template_11',
	);
	return ! in_array( ccsm_get_selected_template(), $template_has_no_subscribe_form, true );
}

function ccsm_template_has_subscribe_signup() {
	$template_has_subscribe_signup = array(
		'template_09',
		'template_10',
		'template_11',
		'template_13'
	);
	return in_array( ccsm_get_selected_template(), $template_has_subscribe_signup, true );
}

function ccsm_check_for_review() {

	require_once CCSM_PATH . 'includes/class-ccsm-review.php';

	CCSM_Review::get_instance( array(
		'slug' => 'colorlib-coming-soon-maintenance',
	) );
}

add_action( 'admin_init', 'ccsm_check_for_review' );
/**
 * Notice for Google Analytics
 *
 * @return void
 */
function ccsm_google_analytics_notice() {
	if ( ! current_user_can( 'manage_options' ) || ! ccsm_should_show_ga_notice() ) {
		return;
	}

	$message = sprintf( __('For security reasons we have changed the Google Analytics setting. Please update your settings <a href="%s">here</a> in order to correctly use the Google Analytics script.', 'colorlib-coming-soon-maintenance'), esc_url( admin_url( 'customize.php?autofocus[panel]=colorlib_coming_soon_general_panel' ) ));
	printf('<div id="ccsm-ga-notice" class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
}

/**
 * Whether the legacy Google Analytics migration notice still applies.
 *
 * @return bool
 */
function ccsm_should_show_ga_notice() {
	if ( get_option( 'ccsm_ga_notice' ) ) {
		return false;
	}

	$options = get_option( 'ccsm_settings' );

	return is_array( $options )
		&& isset( $options['colorlib_coming_soon_google_analytics'] )
		&& '' !== $options['colorlib_coming_soon_google_analytics'];
}
add_action( 'admin_notices', 'ccsm_google_analytics_notice' );

/**
 * AJAX script
 *
 * @since 1.0.99
 */
function ccsm_ajax_dismiss_script() {

	// Only the users who can see (and act on) the notice need its nonce.
	if ( ! current_user_can( 'manage_options' ) || ! ccsm_should_show_ga_notice() ) {
		return;
	}

	$ajax_nonce = wp_create_nonce( 'ccsm-ga-notice' );

	?>

	<script type="text/javascript">
        jQuery( document ).ready( function( $ ){

            $(document).on('click','#ccsm-ga-notice .notice-dismiss', function( ){
                var data = {
                    action: 'ccsm-ga-notice_dismiss',
                    security: '<?php echo esc_js( $ajax_nonce ); ?>',
                };

                $.post( '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', data, function( response ) {
                    $( '#ccsm-ga-notice' ).slideUp( 'fast', function() {
                        $( this ).remove();
                    } );
                });

            } );

        });
	</script>

	<?php
}
add_action( 'admin_print_footer_scripts', 'ccsm_ajax_dismiss_script' );

/**
 * Dismiss and update option for notice
 *
 * @return void
 * @since 1.0.99
 */
function ccsm_ajax_dismiss_ga() {

	check_ajax_referer( 'ccsm-ga-notice', 'security' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( -1, 403 );
	}

	update_option('ccsm_ga_notice', true );
	wp_die( 'ok' );

}
add_action( 'wp_ajax_ccsm-ga-notice_dismiss', 'ccsm_ajax_dismiss_ga' );

//Loading Plugin Theme Customizer Options
require_once( 'includes/class-ccsm-customizer.php' );