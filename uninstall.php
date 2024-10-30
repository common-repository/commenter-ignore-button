<?php

/**
 * @package: Commenter Ignore Button
 * @Since: 1.0
 * @Date: January 2017
 * @Author: CK MacLeod
 * @Author: URI: http://ckmacleod.com
 * @License: GPL3
 */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' ) ;

/** 
 * DELETE SETTINGS DATA ON FULL UNINSTALL
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    
    die;

}
/**
* CLEAN UP AFTER YOURSELF
*/
delete_option( 'cks_cib_options' ) ;
delete_option( 'cks_cib_stylesheet_options' );
delete_option( 'cks_cib_version' ) ;
