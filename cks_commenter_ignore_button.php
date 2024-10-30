<?php

/*
 * Plugin Name: Commenter Ignore Button
 * Plugin URI: http://ckmacleod.com/wordpress-plugins/commenter_ignore_button
 * Description: Allows for easy temporary ignoring or muting of annoying commenters
 * Version: 1.0
 * Author: CK MacLeod
 * Author URI: http://ckmacleod.com/
 * License: GPL3, http://www.gnu.org/licenses/gpl.txt
 * Text Domain: cks_cib
 * Domain Path: /languages
 * 
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' ) ;

if ( ! defined( 'CKS_CIB_VERSION' ) ) {
    
    define( 'CKS_CIB_VERSION', '1.0' ) ;
    
}
/**
 * MAIN SETTINGS AND PROCESSES
 */
register_activation_hook( __FILE__, 'cks_cib_install' );
	
add_action( 'init', 'cks_cib_placement' ) ;
add_action( 'init', 'cks_cib_use_standard_template' ) ;
add_action( 'init', 'cks_cib_load_translation_file' ) ;
add_action( 'wp_head', 'cks_cib_page_header_output' ) ;	
add_action( 'admin_init', 'save_cks_cib_stylesheet_options' ) ;
add_action( 'admin_init', 'cks_cib_init_settings' ) ;
add_action( 'plugins_loaded', 'cks_cib_check_version' ) ;
add_action( 'admin_menu', 'cks_cib_add_menu' ) ;
add_action( 'admin_print_styles', 'cks_cib_admin_print_styles' ) ;
add_action( 'admin_notices', 'cks_cib_css_add__success' ) ;
add_action( 'comment_form_before', 'cks_cib_credit_html' ) ;
add_action( 'wp_enqueue_scripts', 'cks_cib_ignorer' );

$plugin = plugin_basename( __FILE__ ); 
add_filter( "plugin_action_links_$plugin", 'cks_cib_plugin_settings_link' );

add_filter( 'comment_class', 'cks_cib_commenter_comment_class', 10, 4 ) ; 

/**
* Initialize some custom settings
*/     
function cks_cib_init_settings() {
    
    register_setting( 'cks_cib', 'cks_cib_options', 'sanitize_cib_options') ;
    register_setting( 'cks_cib_stylesheet', 'cks_cib_stylesheet_options', 
            'sanitize_cib_stylesheet_options' ) ;
    
} 

//update current version if necessary
function cks_cib_check_version( ) {    
    
    $options = get_option( 'cks_cib_options') ;
    
    $version = isset( $options['version']) ? sanitize_text_field( $options['version'] ) : '' ;

    if ( CKS_CIB_VERSION !== $version ) {
        
        $options['version'] = CKS_CIB_VERSION ;

        update_option( 'cks_cib_options' , $options ) ;

    }

} 

/**
 * INSTALLATION AND MESSAGES
 */    		
 function cks_cib_install() {
            
   cks_cib_set_default_options() ;
        
} 
/** THE DEFAULTS **
 * separated provisionally for possible use with reset button
 */
function cks_cib_set_default_options() {

   $stylesheet_location = plugin_dir_path( __FILE__ ) 
           . 'css/cib_add_css.css' ;
   $stylesheet = file_get_contents( $stylesheet_location ) ;
   $use_plugin_styles = '' ;
   $stylesheet_options = array(
       
       'style' => $stylesheet,
       'use_plugin_styles' => $use_plugin_styles,
       
   ) ;
   
   $guidelines_text = get_guidelines_text() ;
   $guidelines_head = sprintf( __('Commenting at %s', 'cks_cib'), 
           get_bloginfo( 'name') ) ; 
   
   $default_array = array( 
       
        'placement'             => 'author' ,
        'use_dark_style'        =>  0,
        'use_standard_template' =>  0,
        'sill'                  =>  40,
        'fadein'                =>  2000,
        'delay'                 =>  1000,
        'fadeout'               =>  2000,
        'add_credit'            =>  0,
        'use_guidelines'        =>  0,
        'guidelines_head_label' =>  $guidelines_head,
        'guidelines'            =>  $guidelines_text,
        'guidelines_link_label' =>  __( 'Commenting Guidelines', 'cks_cib' ),
        'guidelines_link'       =>  home_url() 
                                    . __( '/commenting-policy', 'cks_cib' ),
        'guidelines_cib'        =>  plugins_url( 
                                    'images/ignore_x.png', __FILE__ ),

   );
 
    add_option( 'cks_cib_version', CKS_CIB_VERSION ) ;  
    add_option( 'cks_cib_stylesheet_options', $stylesheet_options ) ;
    add_option( 'cks_cib_options', $default_array ) ;
   
}
 
/**
 * GET DEFAULT GUIDELINES TEXT
 * @return string
 */
function get_guidelines_text() {
    
    $text = __( 'We are determined to encourage thoughtful discussion, '
            . 'so please be respectful to others. '
            . 'We also provide an "Ignore" button (%BUTTONIMAGE%) '
            . 'to help our users cope with "trolls" and other commenters '
            . 'whom they find annoying. '
            . 'Go to our %COMMENTPOLICY% page for more details, '
            . 'including how to report offensive and spam commenting.',
            'cks_cib' ) ; 
    
    return $text ;
    
}

/************************
 * SETTINGS PAGE SET-UP *
 ************************/
/**
 * Add a Settings Page
 */
function cks_cib_add_menu() {

    add_options_page( 
        'Commenter Ignore Button', 
        'Commenter Ignore Button', 
        'manage_options', 
        'cks_cib', 
        //?
        'cks_cib_plugin_settings_page' 
    );

} 
/**
* Settings Page Menu Callback
*/     
function cks_cib_plugin_settings_page() {

    if ( ! current_user_can( 'manage_options' ) ) {
            wp_die(__( 'You do not have sufficient permissions '
                    . 'to access this page.', 'cks_cib' ) );
    }

    cks_cib_options_page() ;
    
} 
/**
 * CSS Stylesheet for Settings Page
 */
function cks_cib_admin_print_styles() {

    wp_register_style( 
           'cib-styles', 
           plugins_url( 'css/cib-admin-styles.css'. '?v=' . 
                   CKS_CIB_VERSION, __FILE__ ) 
           );
    
    $page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) ;

    if ( isset( $page ) &&  $page === "cks_cib" )  {    

    wp_enqueue_style( 'cib-styles' );

   } 

}
/********************************
 **** REGISTER AND ENQUEUE ******
 * FRONT END SCRIPTS AND STYLES *
 ********************************/
function cks_cib_ignorer() {
            
    wp_register_script(
        'jquery-cookie',
        plugins_url('js/jquery.cookie.js',__FILE__),
        array( 'jquery' ),
        CKS_CIB_VERSION,
        FALSE 
    );
    
    wp_register_script(
        'ignorer',
        plugins_url('js/ignorer.js',__FILE__),
        array( 'jquery' ),
        CKS_CIB_VERSION,
        FALSE 
    );
    
    wp_register_style(
        'cks_cib_styles', 
        plugins_url( 'css/cks_cib_style.css', __FILE__ ), '',  
        CKS_CIB_VERSION 
    );

    // ENQUEUE ONLY ON SINGLE POSTS/PAGES WITH OPEN COMMENTS
    if ( is_single() && comments_open() ) { 
    
        wp_enqueue_script( 'jquery-cookie' );
        
        $ignore_title = cks_cib_ignore_title_attr() ;
        $ignore_label = cks_cib_ignore_label() ;
        $unignore_title = cks_cib_unignore_title_attr() ;
        $unignore_label = cks_cib_unignore_label() ;
    
        // Localize the script
        $translation_array = array(

            'unignore_text'     => __( 'Un-Ignore ', 'cks_cib' ),
            'ignore_title'      => $ignore_title,
            'ignore_label'      => $ignore_label,
            'unignore_title'    => $unignore_title,
            'unignore_label'    => $unignore_label,
            'removing'          => __( 'removing', 'cks_cib'),
            'adding'            => __( 'adding', 'cks_cib'),
            'from_list'         => __( 'from Ignore List', 'cks_cib')

        );

        wp_localize_script( 'ignorer', 'cib_titles', 
                    $translation_array );
        
        $options = get_option( 'cks_cib_options' ) ;
        
        $jquery_settings = array(
            
            'sill'              => $options['sill'],
            'delay'             => $options['delay'],
            'fadein'            => $options['fadein'],
            'fadeout'           => $options['fadeout'],
            
        ) ;
        
        wp_localize_script( 'ignorer', 'cib_options', $jquery_settings ) ;

        wp_enqueue_script( 'ignorer' );
    
        wp_enqueue_style( 'cks_cib_styles') ;
        
        $use_dark = isset( $options['use_dark_styles'] ) ? $options['use_dark_styles' ] : '' ;
        
        if ( $use_dark ) {
        
            $dark_img = plugins_url( 'images/ignore_unignore_dk.png', __FILE__ ) ;

            $custom_css = "

                .cks-cib{
                    background-image: url({$dark_img});  
    }
                .ignored-text {
                    color: pink; 
                    border: 1px solid pink;
                }.." ;

            wp_add_inline_style('cks_cib_styles', $custom_css ) ;
            
        }
            
    }
    
}
/**
 * LOAD TEXT DOMAIN 
 */
function cks_cib_load_translation_file() {
    
    // relative path to WP_PLUGIN_DIR where the translation files will sit:
    $plugin_path = plugin_basename( dirname( __FILE__ ) . '/languages' ) ;
    load_plugin_textdomain( 'cks_cib', '', $plugin_path ) ;
    
}
/**
 * LINK TO SETTINGS IN PLUGIN CONTENTS
 * @param array $links
 * @return array
 */
function cks_cib_plugin_settings_link( $links ) { 

    $settings_link = 
            '<a href="options-general.php?page=cks_cib">Settings</a>'; 

    array_unshift( $links, $settings_link ); 

    return $links; 

}
/**
 * INCLUDE MAIN FILES
 */
include_once( dirname( __FILE__ ) . '/cib-add-stylesheet.php' ) ;

include_once( dirname( __FILE__ ) . '/cib-template-tags.php' ) ; 

include_once( dirname( __FILE__ ) . '/cib-button.php' ) ;

include_once( dirname( __FILE__ ) . '/cib-settings.php' ) ;

include_once( dirname( __FILE__ ) . '/templates/comment.php' ) ;