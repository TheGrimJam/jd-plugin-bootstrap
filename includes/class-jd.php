<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}



class JamDigital {
  /* Using woocommerce as a guideline for this */

  public $version = '0.1.3';

  protected static $_instance = null; 

  public static function instance() { 
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    $this->define_constants();
    $this->includes();
    $this->init_hooks();
    do_action( 'jd_loaded' );
  }

  private function init_hooks() {
  }

  private function define_constants() {
    $this->define( 'JD_ABSPATH', dirname( JD_PLUGIN_FILE ) . '/' );
  }

  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }

  public function includes() {
    // You can use this as a map to see what functionality is enabled.
    $plugin_includes = array(
      //'shortcodes' => JD_ABSPATH . 'includes/optionals/shortcodes.php',
      //'emails' => JD_ABSPATH . 'includes/optionals/emails.php',
      'custom_field-helpers' =>  JD_ABSPATH . 'includes/acf-helpers/custom-field-helpers.php',
      'jamdiggy-helpers' => JD_ABSPATH . 'includes/jd-helpers.php',
      'assets' => JD_ABSPATH . 'assets/included_assets.php',

      //'dashboard' => JD_ABSPATH . 'includes/optionals/dashboard-changes.php',

      // Metabox code. For adding extra displays to the administrative interface
      //'alc-metabox' => JD_ABSPATH . 'includes/wpalchemy/MetaBox.php',
      //'alc-media' => JD_ABSPATH . 'includes/wpalchemy/MediaAccess.php',
      'remove_comments' => JD_ABSPATH . 'includes/optionals/remove-comments.php',
      'custom_options_page' => JD_ABSPATH . 'includes/optionals/options-page.php',

      // Team Member
      'team_member' => JD_ABSPATH . 'includes/content-types/team-member.php',


      // Functions specific to painfreedental
      'custom_helpers' => JD_ABSPATH . 'includes/helpers-custom.php'
    );

    add_action( 'registered_post_type' , function() use ($plugin_includes) {
        foreach ($plugin_includes as $include_id => $include_path ) {
            require_once( $include_path ); 
        }
    });

  }


} // end JD