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
 * CREATE COMMENT BUTTON IGNORE LINK IN CONTAINER
 * param string $text
 * @param string $comment_author
 * @param int $comment_ID
 * @return type
 */
function cks_cib( $comment_ID ) {
    
    $button_html = '' ;

    //apply only on posts with open comment threads
    if ( is_single() && comments_open() ) {        
        
    //get comment author if modified by external function
    $comment_author = esc_html( get_comment_author( $comment_ID ) );
    $comment = get_comment( $comment_ID, OBJECT ) ;
    $ca_done = get_comment_author_done( $comment_author ) ;
    $ignore_button_class =  $ca_done . '-ignore-button' ;

    $button_html = '<!-- CIB CONTAINER -->' ;
    $button_html .= '<div class="cib-container">' ;

    $button_html .= '<a href="#" '
            . 'data-id="' . $comment_ID 
            . '" data-name="'. $comment_author
            . '" data-do="' . $ca_done . '-ignore" id="'  
            . $ca_done . '-' . $comment_ID . '" class="' 
            . cks_ignore_class( $comment ) . ' cks-cib ' 
            . $ignore_button_class . ' '
            . cks_ignore_button_class( $comment ) 
            . '" title="'. cks_ignore_title( $comment ) . ' ' . $comment_author 
            . '"  ><span class="cib-button-text">' . cks_ignore_label( $comment )
            . '</span></a>' ;

    $button_html .= '</div>' ;

    //option to add ignore label
    $ignored_message_label_default = esc_html( __( 'Ignored', 'cks_cib' ) );

    $ignored_message_label = apply_filters( 
            'cib_ignored_message_label', $ignored_message_label_default 
            ) ;

    if ( $ignored_message_label ) {

        $button_html   .= '<div class="commenter-ignored-msg">'
                . '<span class="ignored-text">' 
                . $ignored_message_label . '</span></div>' ;

    }


    $button_html .= '<!-- END CIB CONTAINER -->' ;

    }
    
    $html = apply_filters( 'cks_cib_container', $button_html, $comment_ID ) ;
	
    return $html ;
  
}
/**
 * BUTTON PLACEMENT
 */
function cks_cib_placement() {
    
    $options = get_option( 'cks_cib_options') ;
    
    $option = isset($options['placement']) ? $options['placement'] : '' ;
    
    switch( $option ) {
        case 'author' :
            add_filter( 'get_comment_author_link', 'add_cib_after_author', 10, 3 ) ;
            add_filter( 'comment_reply_link_args', 'cib_reply_div' ) ;
            break;
        case 'datetime' :
            add_filter( 'wp_list_comments_args', 'ci_comment_callback') ;
            add_filter( 'comment_reply_link_args', 'cib_reply_div' ) ;
            break;
        case 'reply' :
            add_filter( 'comment_reply_link_args', 'add_cib_to_reply_button', 10, 2 ) ;
            break;
        case 'text' :
            add_filter( 'comment_text', 'add_cib_after_text', 10, 2 ) ;
            add_filter( 'comment_reply_link_args', 'cib_reply_div' ) ;
            break;
        default:
            return ;
        
    }
    
}
/**
 * ADDS DIV AROUND REPLY BUTTON
 * @param array $args
 * @return array
 */
function cib_reply_div( $args ) {

    $args['before'] .= '<div class="cib-reply">' ;

    $args['after'] .= '</div>' ;

    return $args ; 

}
/**
 * PLACE BUTTON AFTER AUTHOR LINK
 * @param string $return
 * @param string $author
 * @param int $comment_ID
 * @return string
 */
function add_cib_after_author( $return, $author, $comment_ID ) {
    
    $button_html = cks_cib( $comment_ID ) ;
    
    return $return . $button_html ;
    
}

/**
 * ADD CI COMMENT CALLBACK
 * for DateTime Placement Option
 * @param array $r wp_list_comments() arguments
 */
function ci_comment_callback( $r ) {
    
    $r['callback'] = 'ci_comment' ;
    
    return $r ;
    
}

/**
 * FOR "WITH REPLY BUTTON" OPTION
 * @param array $args
 * @param object $comment
 * @return array
 */
function add_cib_to_reply_button( $args, $comment ) {
    
    $comment_ID = $comment->comment_ID ;

    $button_html = cks_cib( $comment_ID ) ;

    $args['before'] .= '<div class="cib-reply-link">' ;

    $args['after'] .= $button_html . '</div>' ;

    return $args ; 

}
/**
 * FOR "AFTER COMMENT" OPTION
 * @param string $text
 * @param object $comment
 * @return string
 * use:
 * "add_filter( 'comment_text', 'add_cib_after_text', 10, 2 ) ;"
 */
function add_cib_after_text( $text, $comment = NULL ) {
    
    //avoid warnings when $comment_text filter in db rather than output context
    if ( $comment ) {    
        
        $comment_ID = $comment->comment_ID ;

        $button_html = cks_cib( $comment_ID ) ;
    
    } else {
        
        $button_html = '' ;
        
    }
    
    return $text . $button_html ;
    
}

/**
 * ADD AUTHOR AND IGNORE CLASSES TO COMMENTS
 * @global object $comment
 * @param array $classes
 * @param string $class
 * @param int $comment_id
 * @param object $comment
 * @return array
 */
function cks_cib_commenter_comment_class( $classes = array(), $class, $comment_id, $comment ) {

    //should work even if comment author has been adjusted in theme or template
    $comment_author = esc_html( get_comment_author( $comment_id ) ) ;

    $ignore_commenter_class = 
            get_comment_author_done( $comment_author ) . '-ignore' ;
    
    if ( is_ignorable( $comment ) ) {
        
        $classes[] = 'ignore-this-comment' ;
        
    } 

    $classes[] = $ignore_commenter_class ;

    return $classes;

}
/**
 * UTILITY FUNCTIONS
 * @param object $comment
 * @return string
 */
function cks_ignore_class( $comment ) {
    
    if ( is_ignorable( $comment ) ) {
        
        return 'un-ignore-commenter' ;
        
    } else {
        
        return 'ignore-commenter' ;
        
    }
    
}
function cks_ignore_title( $comment ) {
    
    if ( is_ignorable( $comment ) ) {
        
        return cks_cib_unignore_title_attr() ;
        
    } else {
        
        return cks_cib_ignore_title_attr() ;
        
    }
    
}
function cks_ignore_label( $comment ) {
    
    if ( is_ignorable( $comment ) ) {
        
       return cks_cib_unignore_label() ; 
        
    } else {
        
       return cks_cib_ignore_label() ; 
        
    }
    
}
function cks_cib_ignore_label() {
    
    $label = esc_html( __( 'x', 'cks_cib' ) ) ;
    
    return apply_filters( 'cib_ignore_label', $label ) ;
    
}
function cks_cib_ignore_title_attr() {
    
    $title = esc_html( __( 'Ignore', 'cks_cib' ) ) ;
    
    return apply_filters( 'cib_ignore_title_attr', $title ) ;
    
}
function cks_cib_unignore_label() {
    
    $label = esc_html( __( 'Un-Ignore', 'cks_cib' ) ) ;
    
    return apply_filters( 'cib_unignore_label', $label ) ;
    
}
function cks_cib_unignore_title_attr() {
    
    $title = esc_html( __( 'Un-Ignore', 'cks_cib' ) ) ;
    
    return apply_filters( 'cib_unignore_title_attr', $title ) ;
    
}
/**
 * ADD CLASS FOR IGNORE BUTTON VARYING WITH STATE
 * @param object $comment
 * @return string
 */
function cks_ignore_button_class( $comment ) {
    
    if ( is_ignorable( $comment ) ) {
        
        return 'cks-cib-unignore-button' ;
        
    } else {
        
        return 'cks-cib-ignore-button' ;
        
    }
    
}
/**
 * IS THIS COMMENT IGNORABLE?
 * @param object $comment
 * @return int
 */
function is_ignorable( $comment ) {

    $ignore_commenter_class = 
            get_comment_author_done( $comment->comment_author ) . '-ignore' ;
   
    $raw_ignore = filter_input( 
                            INPUT_COOKIE, 'ignorable', 
                            FILTER_SANITIZE_FULL_SPECIAL_CHARS 
                            ) ;
    
    $raw_ignore_array = explode( ',', $raw_ignore ) ;
    
    if ( in_array( $ignore_commenter_class, $raw_ignore_array )) {
        
        return 1 ;
        
    } else {
        
        return 0 ;
        
    }
    
}
/**
 * GET SANITIZED VERSION OF COMMENT AUTHOR NAME
 * @param string $comment_author
 * @return string
 */
function get_comment_author_done( $comment_author ) {
    
    $comment_author_done = preg_replace("/[^a-zA-Z]/", "", $comment_author )  ;
    
    return $comment_author_done ;
    
}
/**
 * PROVIDE FILE LOCATION FOR CUSTOM COMMENTS TEMPLATE OPTION
*@return URL
*/
function cib_custom_comments_template() {

    global $post;

    if ( ! ( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {

        return;

    }

    $file_location = plugin_dir_path( __FILE__ ) . 'templates/comments.php' ;
    
    return apply_filters( 'cib_comments_template_path', $file_location );
        
}
/**
 * OVERRIDE COMMENTS TEMPLATE WITH PLUG-IN'S
 */
function cks_cib_use_standard_template() {
    
    $options = get_option( 'cks_cib_options' ) ;
    $use_template = isset( $options['use_standard_template'] ) ? $options['use_standard_template'] : '' ;
    
    if ( $use_template ) {

        add_filter( 'comments_template', 'cib_custom_comments_template' );

    }
    
}
