<?php


$email_configuration = array('site_contact' => 'example@example.com',
							 'default_subject' => get_bloginfo() . ' Message',
							 );


function wpdocs_set_html_mail_content_type() {
    return 'text/html'; // Email format to HTML
}



function set_email_variables ( $body, $replacements=array() ) {
	/**
	 * Reads in the content of an email template, and replaces the variable tags with their actual value.
	 *
	 *
	 * @param string $body
	 * @param a-array $replacements
	 * @return string processed body text
	 */
	foreach( $replacements as $key => $replacement ) {
		$body = str_ireplace('[' .$key .']',$replacement, $body);     // Replace the shortcode of [key] with it's value. 
	}
	return $body;
}

function add_site_logo() {
	$file = 'logo.png'; //phpmailer will load this file
	$uid = 'sc-logo'; //will map it to this UID
	$name = 'logo.jpg'; //this will be the file name for the attachment

	global $phpmailer;
	add_action( 'phpmailer_init', function(&$phpmailer)use($file,$uid,$name){
	    $phpmailer->SMTPKeepAlive = true;
	    $phpmailer->AddEmbeddedImage($file, $uid, $name);
	});
}


function send_site_email ( $post_id , $template_variables=array(), $subject=Null, $email_template="school_new.php" , $user_email=False) {
	/**
	 * Email handler
	 *
	 * Send an email with the details taken from a post. Links in with an email template, and also runs variable replacements on the content.
	 *
	 * @param int $post_id 
	 * @param string $title Email title
	 * @param array $template_variables Associative array with values and ID for templates 
	 * @param string $email_template Filename inside of plugin-folder/emails/
	 * @param string $user_email Send this email to the user, instead of the admin
	 */
	add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
	if ($subject == Null ) {
		$subject = $email_configuration['default_subject']; 
	}
    $attachments = array(); 

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'emails/' . $email_template;
	$template = ob_get_clean();
	$headers   = array('');
	//add_respe_logo();
	$body = set_email_variables ( $template , $template_variables );

	if ( $user_email == False ) { 
		$to = $email_configuration['site_contact'];

		//Developer duplicate emails:
		//wp_mail( "email", $subject, $body, $headers, $attachments);
	} 
    else { $to = $template_variables['email']; } 

    wp_mail( $to, $title, $body, $headers, $attachments);
    remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' ); // Remove html again, so the world is safe
}