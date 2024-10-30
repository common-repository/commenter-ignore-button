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
 * OUTPUT "ADD CSS" TO PAGE HEADER
 */
function cks_cib_page_header_output() { 
    
   $options = get_option( 'cks_cib_stylesheet_options' ) ;
   
   $use_styles = isset( $options['use_plugin_styles'] ) ? $options['use_plugin_styles'] : '' ;
   $option = isset($options['style'] ) ? $options['style'] : '' ;

   if ( $use_styles && is_singular() && comments_open() ) {

       ?>

       <style type='text/css'>

           <?php

               echo $option;

           ?>

       </style>

       <?php 

    }

}

/**
*  INITIATE PROCESSOR WHEN SAVING OPTIONS
*/
function save_cks_cib_stylesheet_options() {

    add_action( 'admin_post_save_cks_cib_stylesheet_options', 
           'process_cks_cib_stylesheet_options' ) ;

}

/**
* COMPLETION MESSAGES FOR ADD CSS
*/
function cks_cib_css_add__success() {

    $message_text_applied = ' and Applied.' ;

    $class = 'notice notice-success is-dismissible' ;
    
    $page = filter_input( 
                INPUT_GET, 'page', 
                FILTER_SANITIZE_STRING 
                ) ;
    
    $message = filter_input( 
                INPUT_GET, 'message', 
                FILTER_SANITIZE_NUMBER_INT 
                ) ;
    
    $applied = filter_input( 
                INPUT_GET, 'applied', 
                FILTER_SANITIZE_STRING 
                ) ;

    if ( $page && $page  === 'cks_cib' 
            && $message && $message === '1' ) {

        $message_text = __( 'ADD CSS Saved', 'cks_cib') ;

        if ( $applied && 'a' === $applied ) {

            $message_text .= $message_text_applied ;

        }

        printf( '<div class="%1$s"><p><strong>%2$s</strong></p></div>', 
                $class, $message_text );

    } elseif ( 
            
            $page && $page === 'cks_cib' && 
            $message && $message === '2' ) { 

        $message_text = __( 'CSS Reset to Original Styles', 'cks_cib') ;

        if ( $applied && 'a' === $applied ) {

            $message_text .= $message_text_applied ;

        }

        printf( '<div class="%1$s"><p><strong>%2$s</strong></p></div>', 
                $class, $message_text );

    }

}
/**
 * PROCESS STYLESHEET OPTIONS
 */
function process_cks_cib_stylesheet_options() {
    
    $applied = '' ;
    
    $stylesheet_nonce = filter_input( 
                INPUT_POST, 'stylesheet_nonce', 
                FILTER_SANITIZE_STRING  
                ) ;
    
    $resetstyle = filter_input( 
                INPUT_POST, 'resetstyle', 
                FILTER_SANITIZE_STRING  
                ) ;
    
    $layout = filter_input( 
                INPUT_POST, 'layout', 
                FILTER_SANITIZE_STRING  
                ) ;
    
    $style = filter_input(
                INPUT_POST, 'style', FILTER_CALLBACK, array( 
                    'options' => 'tidystyle' 
                    )
                ) ;
    
    $use_plugin_styles = filter_input(
                INPUT_POST, 'use_plugin_styles',
                FILTER_VALIDATE_INT
                ) ;
    
    // Check that user has proper security level
    if ( 
            ! current_user_can( 'manage_options' ) || 
            ! wp_verify_nonce( $stylesheet_nonce, 'cks_cib_stylesheet')   
        ) {
        
        wp_die( 'Not allowed' ) ;
            
    }

    // Retrieve original plugin options array
    
    $options = get_option( 'cks_cib_stylesheet_options' ) ;

    if ( $resetstyle ) {
        
        $stylesheet_location = plugin_dir_path( __FILE__ ) 
                . 'css/cib_add_css.css' ;
        
        $sheet_option = file_get_contents( $stylesheet_location ) ;

        $message = 2;
        
    } elseif ( $layout ) {

        $sheet_option = $style ;

        $message = 1;

    }
    
    if ( $use_plugin_styles ) {
        
        $use_styles = $use_plugin_styles ;
        
        $applied = 'a' ;
        
    } else {
        
        $use_styles = 0 ;
        
    }
    
    if ( $sheet_option) {
        
        $options['style'] = $sheet_option ;
        
    }
    
    $options['use_plugin_styles'] = $use_styles ;
    
    update_option( 'cks_cib_stylesheet_options', $options ) ;

    // Redirect the page to the configuration form that was
    // processed
    wp_safe_redirect( 
            
        add_query_arg( 
            array( 
                
                'page' => 'cks_cib&tab=css_customization', 
                'message' => $message,
                'applied' => $applied,
            ), 
            admin_url( 'options-general.php' ) 
        ) 
            
    ) ;
    
    exit() ;
    
}

/* Belt and Suspenders
 * STYLESHEET ENTERED BY ADMIN ONLY, PROCESSED ONLY WITH SECURITY NONCE
 * So have to imagine very peculiar self-sabotage
 * But easy to throw in anyway on model of WP Core
 */
function tidystyle( $css ) {
    
    $css = str_replace( '/-moz-binding/', '', $css );
    $css = str_replace( '/expression/', '', $css );
    $css = str_replace( '/javascript/', '', $css );
    $css = str_replace( '/vbscript/', '', $css );
    $css = str_replace( '@import', '', $css ) ;
    $css = function_exists( '_sanitize_text_fields') ? _sanitize_text_fields( $css, TRUE ) : $css ;
    
    return $css; 
    
}