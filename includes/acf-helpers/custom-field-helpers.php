<?php

/*----------------------------------------------------------------------------------------------------------
Index:

1. Helper functions
2. 1 : 1 relationships
3. Custom content types
4. Custom fields
-----------------------------------------------------------------------------------------------------------*/

function get_field_escaped($field_key, $post_id = false, $format_value = true, $escape_method = 'esc_html'){
	/**
	 * Helper function to get escaped field from ACF
	 * and also normalize values.
	 *
	 * @param $field_key
	 * @param bool $post_id
	 * @param bool $format_value
	 * @param string $escape_method esc_html / esc_attr or NULL for none
	 * @return array|bool|string
	 */

    $field = get_field($field_key, $post_id, $format_value);
 
    /* Check for null and falsy values and always return space */
    if($field === NULL || $field === FALSE)
        $field = '';
 
    /* Handle arrays */
    if(is_array($field))
    {
        $field_escaped = array();
        foreach($field as $key => $value)
        {
            $field_escaped[$key] = ($escape_method === NULL) ? $value : $escape_method($value);
        }
        return $field_escaped;
    }
    else
        return ($escape_method === NULL) ? $field : $escape_method($field);

}

function the_field_escaped($field_key, $post_id = false, $format_value = true, $escape_method = 'esc_html'){
    /**
	 * Wrapper function for get_field_escaped() that echoes the value instead of returning it.
	 *
	 * @param $field_key
	 * @param bool $post_id
	 * @param bool $format_value
	 * @param string $escape_method esc_html / esc_attr or NULL for none
	 */

    $value = get_field_escaped($field_key, $post_id, $format_value, $escape_method );
 
    //Print arrays as comma-separated strings, as per get_field() behaviour.
    if( is_array($value) )
    {
        $value = @implode( ', ', $value );
    }
 
    //Echo result
    echo $value;
}

/* --------------------------------------------------------------------------------------------- */
/* ---------------      Two way relationships                                  ----------------- */
/* --------------------------------------------------------------------------------------------- */

function bidirectional_acf_update_value( $value, $post_id, $field  ) {
    /**
     * This function causes a relationship being assigned from one item, to be added from the other end as well
     * This allows us to have proper one to one relationships
     *
     * Used in combination with a hook, fields are auto filled. To reuse change the name= of the hook.
     *
     * @param $value
     * @param bool $post_id
     * @param bool $field 
     */

    // function and hook from the ACF folk. 
    // It causes a relationship from one side to be automagically recipricoated on the other end.
    $field_name = $field['name'];
    $field_key = $field['key'];
    $global_name = 'is_updating_' . $field_name;
    
    // bail early if this filter was triggered from the update_field() function called within the loop below
    // - this prevents an inifinte loop
    if( !empty($GLOBALS[ $global_name ]) ) return $value;
    
    // set global variable to avoid inifite loop
    // - could also remove_filter() then add_filter() again, but this is simpler
    $GLOBALS[ $global_name ] = 1;
    
    // loop over selected posts and add this $post_id
    if( is_array($value) ) {
    
        foreach( $value as $post_id2 ) {
            // load existing related posts
            $value2 = get_field($field_name, $post_id2, false);
            // allow for selected posts to not contain a value
            if( empty($value2) ) {
                $value2 = array();  
            }       
            // bail early if the current $post_id is already found in selected post's $value2
            if( in_array($post_id, $value2) ) continue;
            // append the current $post_id to the selected post's 'related_posts' value
            $value2[] = $post_id;
            // update the selected post's value (use field's key for performance)
            update_field($field_key, $value2, $post_id2);       
        }
    }
    // find posts which have been removed
    $old_value = get_field($field_name, $post_id, false);
    
    if( is_array($old_value) ) {
        
        foreach( $old_value as $post_id2 ) {
            
            // bail early if this value has not been removed
            if( is_array($value) && in_array($post_id2, $value) ) continue;
            // load existing related posts
            $value2 = get_field($field_name, $post_id2, false);
            // bail early if no value
            if( empty($value2) ) continue;
            // find the position of $post_id within $value2 so we can remove it
            $pos = array_search($post_id, $value2);
            // remove
            unset( $value2[ $pos] );
            // update the un-selected post's value (use field's key for performance)
            update_field($field_key, $value2, $post_id2);
            
        }
    }
    // reset global varibale to allow this filter to function as per normal
    $GLOBALS[ $global_name ] = 0;
    return $value;
    
}
// Change "attached_organisation" to the appropriate field.
// add_filter('acf/update_value/name=attached_organisation', 'bidirectional_acf_update_value', 10, 3);


function jd_sanitize_fields( $value ) {
    if( is_array($value) ) {
        return array_map('jd_sanitize_fields', $value);
    }
    return wp_kses_post( $value );
}

add_filter('acf/update_value', 'jd_sanitize_fields', 10, 1);