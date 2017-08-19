<?php
if( function_exists('acf_add_options_page') ) {
	// Adds an options page with your site title
    acf_add_options_page(array('page_title' => get_bloginfo() . ' Configuration'));
}

// Options can go here or be held within the ACF DB

/* ----------------------------------------------------
Example:


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5996e27e82343',
	'title' => 'Site Options',
	'fields' => array (
		array (
			'key' => 'field_5996e29065cf5',
			'label' => 'Site Contact',
			'name' => 'respe_options_site_contact',
			'type' => 'email',
			'instructions' => 'Site contact for emails to be sent to the system administrator, and also is the "from" address users will receive.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-' . get_bloginfo() . '-configuration',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

*/