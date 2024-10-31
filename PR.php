<?php
/**
 * Plugin Name: Protected Registration
 * Plugin URI: http://www.eyetproductions.com/wordpress/plugins/protected-registration
 * Description: A powerful Password Protection plugin for your registration page ( can be implemented with lots of invitations plugins )
 * Version: 0.1
 * Author: Mostafa Kassem
 * Author URI: https://www.facebook.com/Zanzofily
 */

session_start();

define('PR_BATH', plugin_dir_url(__FILE__) );


//require_once( 'MGL_InstagramGalleryController.class.php' );

if( is_admin() ) {
    require('includes/PR_Admin.class.php');
} else {
    require('includes/PR_Frontend.php');

}
