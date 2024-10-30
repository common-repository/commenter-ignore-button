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
 * PRINT A LIST OF IGNORED COMMENTERS
 */
function cks_cib_list_ignorables() {
      
    $ignorables_raw = filter_input( 
                            INPUT_COOKIE, 'ignorable_names', 
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS 
                        ) ;
    
    if ( $ignorables_raw ) {
        
        //will be cleaner if "undefined" is defined
        $ignorables_pre_arr = trim( $ignorables_raw );

        $ignorables_pre_sort = array_unique( 
                                explode( 
                                        ',', $ignorables_pre_arr 
                                        ) 
                                ) ;

        natcasesort( $ignorables_pre_sort ) ;

        $ignorable_names = implode( ', ', $ignorables_pre_sort ) ;

        $list_label_string = __( 'On Ignore:', 'cks_cib' ) ;
        
        $list_string = apply_filters( 'on_ignore_string', $list_label_string ) ;

        $list_html = '<!-- ON IGNORE LIST -->' ;
        $list_html .= '<div id="ignorables-list"><p>';
        $list_html .= '<span class="on-ignore">' . $list_string 
                   . '</span> ' . $ignorable_names . '</p></div>' ;
        $list_html .= '<!-- ON IGNORE LIST END -->' ;

        $ignorables_list = apply_filters( 
                'on_ignore_list', $list_html, $ignorable_names 
                ) ;

        echo $ignorables_list ;
    
    } else { 
        
       echo cib_get_guidelines() ;
        
    }
    
}
/**
 * GET HTML FOR GUIDELINES HEADER
 * @return string
 */
function cib_get_guidelines() {
    
    $options = get_option( 'cks_cib_options' ) ;
    
    $use_guidelines = isset( $options['use_guidelines']) ? $options['use_guidelines'] : '' ;
    
    if ( ! $use_guidelines ) {
        
        return '' ;
        
    }

    $guidelines_head_label = isset($options['guidelines_head_label']) ? $options['guidelines_head_label'] : '';
    $guidelines_string  = isset($options['guidelines']) ? $options['guidelines'] : '';
    $guidelines_link    = isset($options['guidelines_link']) ? $options['guidelines_link'] : '';
    $guidelines_label   = isset($options['guidelines_link_label']) ? $options['guidelines_link_label'] : '';
    $guidelines_cib     = isset($options['guidelines_cib']) ? $options['guidelines_cib'] : '';

    $guidelines_button  = '<a class="submit" href="' . $guidelines_link . '">' . $guidelines_label . '</a>' ;
    $button_image = '<img src="' . $guidelines_cib . '" >' ;
    
    if ($guidelines_link && $guidelines_label) { 
        
        $guidelines = str_replace( array('%COMMENTPOLICY%', '%BUTTONIMAGE%' ), array( $guidelines_button, $button_image) , $guidelines_string) ;
        
    } else {
             
        $guidelines = $guidelines_string ;
        
    }
    
    $guidelines_heading = '<span class="icon-span"></span>' . $guidelines_head_label ;

    $html = '<!-- COMMENTING GUIDELINES -->' ;
    $html .= '<div id="cib-guidelines">' ;
    $html .= '<a href="#" id="cib-guidelines-head">' ; 
    $html .= $guidelines_heading . '</a>';
    $html .= '<div id="cib-guidelines-body"><p>' . $guidelines ;
    $html .= '</p></div>' ;
    $html .= '</div>' ;
    $html .= '<!-- COMMENTING GUIDELINES END-->' ;
    
    $guidelines_html = apply_filters( 'cib_guidelines', $html ) ;

    return $guidelines_html ;

    }

/***
 * ADD CKS CREDIT BEFORE FOOTER
 * echoes html
 */
function cks_cib_credit_html() {
    
    $options = get_option( 'cks_cib_options' ) ;
    
    $option = isset( $options['add_credit'] ) ? $options['add_credit'] : 0 ;
    
    if ( $option && is_singular() && comments_open() ) {
        
        echo get_cks_credit() ;
        
    }
    
}
/**
 * GET CKS CREDIT HTML
 * @return html
 */
function get_cks_credit() {
    
        $html = '<div id="cks_cib-credit" '
                . 'style="width: 100%; '
                . 'text-align: right; '
                . 'margin-top: 1em; '
                . '" >'
                . '<a style="background-color: whitesmoke;'
                #. 'margin:12px auto; '
                . 'border: 1px dotted gray; '
                . 'opacity:.5;text-align:center; '
                . 'padding: 4px; '
                . 'font-family: Arial,Helvetica,sans-serif;font-size:.5em;" '
                . 'href="http://ckmacleod.com/wordpress-plugins/">'
                . '<img alt="' 
                . __( 'Commenter Ignore Button by CK\'s Plug-Ins', 'cks_cib') 
                . '" title="' 
                . __( 'Commenter Ignore Button by CK\'s Plug-Ins', 'cks_cib') 
                . '" style="vertical-align:middle" src="' 
                .  plugin_dir_url( __FILE__ ) 
                . 'images/cks_wp_plugins_80x16.jpg'  . '"></a></div>' ;
        
        return apply_filters( 'cks_cib_credit', $html ) ;

}