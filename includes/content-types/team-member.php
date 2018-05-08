<?php


function custom_post_TeamMember() {
    $labels = array(
    'name'               => _x( 'Team Members', 'post type general name' ),
    'singular_name'      => _x( 'Team Member', 'post type singular name' ),
    'add_Supercyte'            => _x( 'Add Team Member', 'Supercytes' ),
    'add_Supercyte_item'       => __( 'Add Team Member ' ),
    'edit_item'          => __( 'Edit Team Members' ),
    'Supercyte_item'           => __( 'Team Members' ),
    'all_items'          => __( 'View Team Members' ),
    'view_item'          => __( 'View Team Members' ),
    'search_items'       => __( 'Search Team Members' ),
    'not_found'          => __( 'No Team Members found' ),
    'not_found_in_trash' => __( 'No Team Members found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Team Members'
  );
  $args = array('labels'        => $labels,
    'description'   => 'Displays Team Members',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'menu_icon'           => 'dashicons-universal-access-alt');
  register_post_type( 'TeamMember', $args );
};
add_action( 'init', 'custom_post_TeamMember' );