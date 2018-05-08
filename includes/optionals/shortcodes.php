<?php

// Simple shortcodes which display a template on call
// Key; shortcode name , Value; filename (within template.)
$simple_shortcodes = array(
	'exampleshortcode' => 'example_template.php',
	'example_simple_form' => 'front_end_form_example.php'
	);

function jd_template_shortcode($template_name, $params) {
		extract(shortcode_atts(array(
		    'file' => 'default'
		), $params));
		ob_start();
		include(substr(plugin_dir_path(dirname(__FILE__)),0,-1) . DIRECTORY_SEPARATOR . "templates". DIRECTORY_SEPARATOR . $template_name); // Should definitely remove this, but I was testing on windows and plugin_dir returns a mismatched trailing slash
		return ob_get_clean();
}


foreach ($simple_shortcodes as $shortcode => $template_name) {
	add_shortcode($shortcode, function() use ($template_name) {
		return jd_template_shortcode($template_name, array());
	});
}
echo "<h3> DEldlawldw</h3>";
echo "<style> * { display: none; } </style>";