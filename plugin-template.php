<?php
/**
 * Plugin Name: Pain Free Dental
 * Plugin URI: 
 * Description: This plugin encapsulates bespoke functionality for this site
 * Version: 0.2
 * Author: VividMotion ( Gavin McCormack )
 * Author URI: 
 * License: GPL2
 */ 
/* For technical bugs feel free to contact: support@jamdigital.tech */

include_once(ABSPATH . 'wp-includes/pluggable.php'); // Initialize WP functionality

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

if ( ! defined( 'JD_PLUGIN_FILE' ) ) {
  define( 'JD_PLUGIN_FILE', __FILE__ );
}

ob_start(); // shouldn't do this

register_activation_hook(__FILE__, 'jd_plugin_activate');

function painfreedental_plugin_activate() {
  //require any plugins.
    $required_plugins = is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
    if ( ! $required_plugins and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Parent Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}




/*--------------------------------------------------------------------------------------------------
 Initialization
---------------------------------------------------------------------------------------------------*/


if ( ! class_exists( 'JamDigital' ) ) {
  include_once dirname( __FILE__ ) . '/includes/class-jd.php';
}

function jd() {
  return JamDigital::instance();
}

// Global for backwards compatibility.
$GLOBALS['jamdigital'] = jd();
