<?php
/*--------------------------------------------------------------------------------------------------
CSS / JS
---------------------------------------------------------------------------------------------------*/
function admin_styles() {
    wp_register_style( 'jd-admin-styles',  plugin_dir_url( __FILE__ ) . 'css/back_end.css' );
    wp_enqueue_style( 'jd-admin-styles' );

    
    wp_register_style( 'jd-admin-font',  'https://fonts.googleapis.com/css?family=Lato:700,900' );
    wp_enqueue_style( 'jd-admin-font' );
}
add_action( 'admin_enqueue_scripts', 'admin_styles' );

function front_styles() {
    wp_register_style( 'jd-front-styles',  plugin_dir_url( __FILE__ ) . 'css/front_end.css' );
    wp_enqueue_style( 'jd-front-styles' );
}
add_action( 'wp_enqueue_scripts', 'front_styles' );


function jd_login_stylesheet() {
    wp_register_style( 'jd-admin-login', 'https://fonts.googleapis.com/css?family=Lato:700,900' );
    wp_enqueue_style( 'jd-admin-login' );

}
add_action( 'login_head', 'jd_login_stylesheet' );

?>