<?php

/*--------------------------------------------------------------------------------------------------
 ACF front end form handling
---------------------------------------------------------------------------------------------------*/
/* 
  Using acf_form() to submit specific content types. $handlers can be defined for a custom post type in order
  to perform certain actions on update.
*/


function example_form_handler( $post_id ) {
  // Performs all actions for the form. returns a "post" object
  $post = array(
    'post_status' => 'publish',
    'post_title' => 'Example Form',
    'post_type' => 'post'
    );
  return $post;
}

function jd_pre_save_post($post_id) {
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

add_filter('acf/pre_save_post' , 'jd_pre_save_post', 10 , 1 );



/*-------------------------------------------------------------------------------------------------
  More helper methods
---------------------------------------------------------------------------------------------------*/

/* this is extra overhead for it to be run on every page */
add_action( 'init', 'acf_head_add' );
function acf_head_add(){
    acf_form_head();
}


function jd_simple_front_form($customfield_id, $form_slug, $submission_button_text, $return_url) {
  /**   
  *     Simple front end form function; provides functionality for simple submission of custom post types
  *   A handler for the post type using the form_slug will also be required to save data
  *
  *   @param $customfield_id : Int or array of ID's for field groups to display.
  *   @param : form_slug : html suitable unique ID for form. 
  *   @param : Submission button text: 
  *     @return url; URL to return to on completion of form
  */
  acf_form(array(
    'html_before_fields' => '<input type="text" id="' . $form_slug . '" name="' . $form_slug . '" value="yes" style="display:none;">',
    'post_id' => 'new',
    'field_groups'  => array ( $customfield_id ), 
    'submit_value'  => $submission_button_text,
    'form_attributes' => array('autocomplete' => "off"),
    //'return' => $return_url
  ));
}



