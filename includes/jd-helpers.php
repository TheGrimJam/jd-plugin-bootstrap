<?php
/*
*  Functions that will come in useful on most sites
*
*
*
*
*
*/
require_once( ABSPATH . "wp-includes/pluggable.php" );

function loop_with_template_part($loop, $template_location) {
    // Display the result of a loop where a WP Query loop object is supplied
    // Alongside a get_template_part location call to populate the content of the loop
    if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
        get_template_part($template_location, 'none'); 
    endwhile; endif; 

    wp_reset_postdata();
}

function jd_live_edit($fields, $post_id = null) {
    // Simple wrapper for live edit to avoid cluttering template files with if's
    if(!function_exists("live_edit") || !is_user_logged_in()) { return ""; } 
    if ($post_id !== null) { return live_edit($fields,$post_id); }
    if ($post_id == null) { return live_edit($fields); }
}


function jd_image_fields($field, $value=False) {
    // Takes in an image field from ACF ( as an array of attributes, not a URL or ID) and outputs the alt, title, src and other tags from the image.
    // Optional parameter if the function should return the values and not print
    $attribute_string = "src='%s' alt='%s' title='%s'";
    $output = sprintf($attribute_string, $field['url'], $field['alt'], $field['title']);
    if ($value) { 
        return $output;
    } else {
        echo $output;
    }
}