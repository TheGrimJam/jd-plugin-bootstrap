<?php 
require_once(ABSPATH . 'wp-content/plugins/plugin-template/plugin-template.php');
?>

<?php
//$customfield_id, $form_slug, $submission_button_text, $return_url
jd_simple_front_form(4, 'example_front_end_form','Submit Example Form','/');
?>