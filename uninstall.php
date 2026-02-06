<?php

/**
 * The code in this file runs when a plugin is uninstalled from the WordPress dashboard.
 */

/* If uninstall is not called from WordPress exit. */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/* Remove plugin options and transients. */
delete_option( 'ccsm_settings' );
delete_option( 'ccsm_ga_notice' );
delete_transient( 'ccsm_review' );
