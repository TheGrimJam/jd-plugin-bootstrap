<?php
/**
 * Plugin Name: Plugin Template
 * Plugin URI: 
 * Description: Template for plugin
 * Version: 0.6
 * Author: Gavin M ( Jam Digital )
 * Author URI: 
 * License: GPL2
 */ 
/* Contact: gavin.mccormack@gmail.com */
/* Ostensibly the purpose of this is to reduce the amount of code that needs to be written. */


// turkey batter
include_once(ABSPATH . 'wp-includes/pluggable.php'); // Initialize WP functionality

ob_start();
register_activation_hook(__FILE__, 'jd_plugin_activate');
function jd_plugin_activate() {
	//require any plugins.
    $required_plugins = is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
    if ( ! $required_plugins and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Parent Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}

$plugin_includes = array(
	'shortcodes' => 'includes/shortcodes.php',
	'custom_fields' => 'includes/custom_fields.php',
	'emails' => 'includes/emails.php',
	'assets' => 'includes/assets.php',
	'dashboard_changes' => 'includes/options/dashboard-changes.php',
	'remove_comments' => 'includes/options/remove-comments.php',
	'custom_options_page' => 'includes/options/options-page.php'
	);

add_action( 'init' , function() use ($plugin_includes) {
foreach ($plugin_includes as $include_id => $include_path ) {
	require_once( $include_path ); 
}
});


/*--------------------------------------------------------------------------------------------------
CSS / JS
---------------------------------------------------------------------------------------------------*/
function admin_styles() {
    wp_register_style( 'jd-admin-styles',  plugin_dir_url( __FILE__ ) . 'assets/css/back_end.css' );
    wp_enqueue_style( 'jd-admin-styles' );
}
add_action( 'admin_enqueue_scripts', 'admin_styles' );

function front_styles() {
    wp_register_style( 'jd-front-styles',  plugin_dir_url( __FILE__ ) . 'assets/css/front_end.css' );
    wp_enqueue_style( 'jd-front-styles' );
}
add_action( 'wp_enqueue_scripts', 'front_styles' );



/*--------------------------------------------------------------------------------------------------
 Submission handler.
---------------------------------------------------------------------------------------------------*/
// The submissions will all come in via the medium of acf's pre_save_post
// using the $handlers array, different types of post can be managed. 
//
//
// RESPE certificate handler provided as template

function example_form_handler( $post_id ) {
	// Performs all actions for the certificate form. returns a "post" object

	//Would be good to send an email to the user at this point.


	//send_email_from_template(); // Specific email to be sent; User should receive a copy of their certificate in email form.
	$post = array(
		'post_status' => 'publish',
		'post_title' => 'Example Form',
		'post_type' => 'post'
		);
	return $post;
}

function my_pre_save_post($post_id) {
	error_log("Pre Save post doesn't start. Or does it?");
	$handlers = array(
	'example_front_end_form' => 'example_form_handler'
	);
	$post_id = 'new';
	foreach ( $handlers as $handler => $handler_func ) {
		if(isset($_POST[$handler])) {  // If the front end form has a matching hidden field, it will be picked up.
			$post = $handler_func($post_id); // Potentially a problem here
			$post_id = wp_insert_post( $post ); 
		}
	}
	return $post_id;
}

add_filter('acf/pre_save_post' , 'my_pre_save_post', 10 , 1 );


/*-------------------------------------------------------------------------------------------------
Front end form handlers
---------------------------------------------------------------------------------------------------*/
add_action( 'init', 'acf_head_add' ); // May only want to init on specific pages, but this isn't performance oriented

function acf_head_add(){
    acf_form_head();
}


function jd_simple_front_form($customfield_id, $form_slug, $submission_button_text, $return_url) {
	/**  	
	* 		Simple front end form function; provides functionality for simple submission of custom post types
	*		A handler for the post type using the form_slug will also be required to save data
	*
	*		@param $customfield_id : Int or array of ID's for field groups to display.
	*		@param : form_slug : html suitable unique ID for form. 
	*		@param : Submission button text: 
	* 		@return url; URL to return to on completion of form
	*/
	acf_form(array(
		'html_before_fields' => '<input type="text" id="' . $form_slug . '" name="' . $form_slug . '" value="yes" style="display:none;">',
		'post_id'	=> 'new',
		'field_groups'	=> array ( $customfield_id ), 
		'submit_value'	=> $submission_button_text,
		'form_attributes' => array('autocomplete' => "off"),
		//'return' => $return_url
	));
}

