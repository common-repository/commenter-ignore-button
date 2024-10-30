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
 * SET UP SETTINGS PAGE
 */
function cks_cib_options_page() {
    
    $version = CKS_CIB_VERSION ;
   
?>
    
    <div class="wrap cks_plugins">

        <div id="cks_plugins-main">   

            <h1>COMMENTER IGNORE BUTTON</h1>

            <?php 
            
            $tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING ) ;
            
            $active_tab = isset( $tab )  ? $tab : 'main'; ?>

            <h2 class="nav-tab-wrapper">
                <a class="nav-tab <?php echo $active_tab == 'main' ? 'nav-tab-active' : ''; ?>" href="?page=cks_cib&tab=main">MAIN</a>

                <a class="nav-tab <?php echo $active_tab == 'css_customization' ? 'nav-tab-active' : ''; ?> " href="?page=cks_cib&tab=css_customization">ADD CSS</a>
            </h2>

            <div id="cks_plugins-sections">

                <?php 

                if ( $active_tab == 'main') { cks_cib_main_section() ; }
                if ( $active_tab == 'css_customization' ) { cks_cib_css_section() ; } 

                ?>

            </div>

        </div>
        
        <?php cks_cib_sidebar( $version ) ; ?>

        <?php cks_cib_plugins_footer( $version ) ; ?> 
        
    </div>

<?php   }

/**
 * MAIN SETTINGS SECTION
 */
function cks_cib_main_section() {
    
    ?>

    <section>
        
        <form method="post" action="options.php">   

            <?php settings_fields('cks_cib');  ?>

            <?php do_settings_fields('cks_cib',''); ?>

            <?php cks_cib_usage_notes() ; ?>

            <?php cks_cib_placement_options_form() ; ?>

        </form>
    
    </section>

<?php 

}
/**
 * ADD CSS PAGE
 */
function cks_cib_css_section() {
    
    echo '<section>' ;   
    
    cks_cib_css_form();

    cks_cib_css() ;
    
    echo '</section>' ;

}
/**
* USAGE NOTES - INTRO
*/
function cks_cib_usage_notes() {

    ?>

    <p id="goto-menu-top" class="goto-menu">
        <?php printf( __('<a href="%s">Placement</a> | <a href="%s">For Dark Themes</a> | <a href="%s">Standardized</a> | <a href="%s">(Un-)Ignoring Action</a> | <a href="%s">"On Ignore" List</a> | <a href="%s">Commenting Guidelines</a> | <a href="%s">Credit</a> | <a href="%s">Filter Hooks</a>', 'cks_lpa'), 
                '#placement', 
                '#dark-themes',
                '#standardized',
                '#jquery', 
                '#ignore', 
                '#guidelines',
                '#credit',
                '#filter-hooks' ) ; ?>
    </p>

    <div id="cks_cib-usage-notes" class="ck-usage-notes">

        <h3><?php _e( 'Getting Started', 'cks_cib') ; ?></h3>
        
        <p>
            <?php _e( 'If you are using a standard WordPress comment template or close variation, then, upon activation, Commenter Ignore Button (CIB) will add a small button to every comment on your site, appearing next to each comment author\'s name. This 30-second video shows how it works using default settings and the "Twenty-Seventeen" theme:', 'cks_cib' ) ; ?>
        </p>
        
        <div id="cks_cib-usage-ills">
            
            <iframe width="560" height="315" style="display:block; margin:20px auto;border:1px solid gray;" src="https://www.youtube.com/embed/FE7jWG0w50s" frameborder="0" allowfullscreen></iframe>
            
        </div>
        
        <p>
            <?php _e( 'If you want or need to customize CIB further, on this page you can adjust button placement and action, configure a switchable Guidelines Header/"On Ignore" List, and get instructions on further customizing the plugin\'s output. On the "ADD CSS" page you will find further options for modifying the button\'s appearance, and you will also find a reference table of available CSS selectors.', 'cks_cib' ) ; ?>
        </p>
        <p style="padding: 12px 20px; margin:20px; border: 2px solid gray;">
            <?php _e( 'CIB is designed with standard WordPress comments templates in mind, and also includes some additional adjustments for many common variations. The basic settings work as intended with well over 90% of "Popular" and "Featured" WordPress themes tested, but will not work with 3rd Party comment plug-ins like Disqus or Facebook Comments, and it may require careful adjustment to work with themes and plug-ins that modify standard WordPress comments substantially.', 'cks_cib' ) ; ?> 
        </p>
        <p><?php _e( 
                'Even if you\'re satisfied with the default appearance and action, there\'s no harm in trying out the alternatives below, or in checking out the text-button version produced by the "ADD CSS" stylesheet on the next page.', 'cks_cib' ) ; ?>
        </p>
        
        <p><?php printf(__( 
            
            ' Visit the %sCommenters Ignore Button home pages%s '
            . 'for more examples and for tips on using '
            . 'the plug-in\'s filters and function tags, '
            . 'or to share your experiences and feedback!', 'cks_cib' ), 
            '<a href="http://ckmacleod.com/wordpress'
            . '-plugins/commenter-ignore-button/">',
            '</a>' ) ; 
        ?></p>

    </div>

    <?php
        
}
/**
 * SET BUTTON PLACEMENT OPTIONS
 */
function cks_cib_placement_options_form() {

    echo '<div id="cks_plugins-radio_buttons" class="ck-usage-notes" >' ;
    
    cks_cib_adjustment() ;
    
    echo '<hr>' ;
    
    cib_filter_hooks() ;
    
    echo '</div>' ;
    
    ?>
    
    <p id="goto-menu-bottom" class="goto-menu">
        <?php printf( __('<a href="%s">Placement</a> | <a href="%s">For Dark Themes</a> | <a href="%s">Standardized</a> | <a href="%s">(Un-)Ignoring Action</a> | <a href="%s">"On Ignore" List</a> | <a href="%s">Commenting Guidelines</a> | <a href="%s">Credit</a> | <a href="%s">Filter Hooks</a>', 'cks_lpa'), 
                '#placement', 
                '#dark-themes',
                '#standardized',
                '#jquery', 
                '#ignore', 
                '#guidelines',
                '#credit',
                '#filter-hooks' ) ; ?>
    </p>
    
    <?php
}
/**
 * MAIN PAGE ADJUSTMENT OPTIONS
 */
function cks_cib_adjustment() {
    
    $options = get_option( 'cks_cib_options' ) ;
    
    ?>

    <h3 id="adjustments"><?php _e( 'Adjustments', 'cks_cib' ) ; ?></h3>
    
    <?php 

    cks_cib_placement_buttons( $options ) ;
    
    echo '<hr>' ;
    
    cks_cib_dark_themes( $options ) ;
    
    echo '<hr>' ;
    
    cks_cib_template_option( $options ) ;
    
    submit_button() ;
    
    echo '<hr>' ;
    
    cks_cib_jquery_options( $options ) ;
    
    submit_button() ;
    
    echo '<hr>' ;
    
    cks_cib_function_tags( $options ) ;
    
    submit_button() ;
    
    echo '<hr>' ;
    
    cks_cib_add_credit_link( $options ) ;
    
}
/**
 * BUTTON PLACEMENT OPTIONS
 * @param array $options 
 */
function cks_cib_placement_buttons( $options ) {
    
    $cks_cib_placement = $options['placement'] ;
    
     submit_button( __('Save Changes', 'cks_cib'), 'primary top', 'cib-button', false );  
    
    ?>

    <h4 id="placement" style="font-size: 1.2em;"><?php  _e( 'Placement', 'cks_cib' ) ; ?></h4>
    
    <p><?php _e( 'See sidebar for example images.', 'cks_cib' ) ; ?></p>
    
    <p class="admin-radio">
        <input id="cks_plugins_use_authort" type="radio" name="cks_cib_options[placement]" title="<?php _e( 'After Comment Author Name', 'cks_cib' ) ; ?>" value="author" <?php if ( $cks_cib_placement === 'author' ) { echo 'checked="checked"'; } ?> /><?php _e( 'After Comment Author (Default)', 'cks_cib' ) ; ?>
        <span class="description"><?php _e( 'Display the Commenter Ignore Button after Author Name.', 'cks_cib' ) ; ?></span>
    </p>
     <p class="admin-radio">
         <input id="cks_plugins_use_datetime" type="radio" name="cks_cib_options[placement]" title="<?php _e( 'After Comment Datetime', 'cks_cib' ) ; ?>" value="datetime" <?php if ( $cks_cib_placement === 'datetime' ) { echo 'checked="checked"'; } ?> /><?php _e( 'After Comment Datetime', 'cks_cib' ) ; ?>
         <span class="description"><?php _e( 'Display the Commenter Ignore Button after the DateTime. ', 'cks_cib' ) ; ?><strong><?php _e( 'This setting will also substitute some standardized comment formatting for your theme\'s. The difference may in some cases be substantial.', 'cks_cib') ; ?></strong></span>
    </p>
    <p class="admin-radio">
        <input id="cks_plugins_use_comment" type="radio" name="cks_cib_options[placement]" title="<?php _e( 'After Comment Text', 'cks_cib' ) ; ?>" value="text" <?php if ( $cks_cib_placement === 'text' ) { echo 'checked="checked"'; } ?>/><?php _e( 'After Comment Text', 'cks_cib' ) ; ?>
        <span class="description"><?php _e( 'Display the Commenter Ignore Button after the Comment Text.', 'cks_cib' ) ; ?></span>
    </p>
    <p class="admin-radio">
        <input id="cks_plugins_use_reply" type="radio" name="cks_cib_options[placement]" title="<?php _e( 'With Reply Button', 'cks_cib' ) ; ?>" value="reply" <?php if ( $cks_cib_placement === 'reply' ) { echo 'checked="checked"'; } ?>/><?php _e( 'After Reply Link', 'cks_cib' ) ; ?>
        <span class="description"><?php _e( 'Display the Commenter Ignore Button after the Comment Reply Link - ', 'cks_cib' ) ; ?><strong><?php _e( 'for nested threads only.', 'cks_cib' ) ; ?></strong></span>
    </p>
    <p class="admin-radio">
        <input id="cks_plugins_use_manual" type="radio" name="cks_cib_options[placement]" title="<?php _e( 'Manual Placement', 'cks_cib' ) ; ?>" value="none" <?php if ( $cks_cib_placement === 'none' ) { echo 'checked="checked"'; } ?>/><?php _e( 'Place Manually', 'cks_cib' ) ; ?>
        <span class="description"><?php printf( __('For Advanced Users: Add %smanually to template or via filter hook%s where the Comment\'s ID is available or derivable: Use <code>cks_cib( $comment_ID )</code> to return the button.</code>.', 'cks_cib' ), '<a href="http://ckmacleod.com/http://ckmacleod.com/wordpress-plugins/commenter-ignore-button/cib-customization/#manual-placement" title="CIB Customization" >', '</a>' ) ; ?></span>
    </p>
    
    <?php
    
}
/**
 * OPTION TO SUBSTITUTE STANDARDIZED COMMENTS TEMPLATE
 * @param array $options
 */
function cks_cib_template_option( $options ) {
    
    $use_template = isset( $options['use_standard_template'] ) ? $options['use_standard_template'] : '' ;
    
    ?>
    
    <h4 style="font-size:1.2em;clear: both;" id="standardized"><?php _e( 'Use Standardized Comments Template', 'cks_cib' ) ; ?></h4>
     
     <p><?php printf( __( 'This alternative - which is different from, but can be used with, the "datetime" placement option above - can be tried if your theme and CIB do not work well together: In some cases the change - from your theme\'s comments template to one based on WordPress Twenty Seventeen - will not be noticeable, but in many cases additional custom coding may be necessary or desirable. This standardized template also adds the Ignore List/Commenting Guidelines tag, as well as an %s"Unbounded Replies"%s feature.', 'cks_cib'), '<a href="http://ckmacleod.com/wordpress-plugins/wordpress-nested-comments-unbound/" >', '</a>' ) ; ?></p>
            
     <p><input type="checkbox" name="cks_cib_options[use_standard_template]" value="1" <?php checked( $use_template, 1 ) ; ?>" />
         <span style="font-weight:700"><?php _e( 'Check this box to substitute a standardized comments template for your theme\'s.', 'cks_cib' ) ; ?></span>
    </p>

     <?php
    
}
    /**
 * APPLY STYLES FOR DARK BACKGROUND THEMES
 * @param array $options
 */
function cks_cib_dark_themes( $options ) { 
    
    $use_dark_styles = isset( $options['use_dark_styles'] ) ? $options['use_dark_styles'] : 0 ;
    
    ?>
    
    <h4 id="dark-themes" style="font-size: 1.2em;"><?php  _e( 'Button Style for Dark Themes', 'cks_cib' ) ; ?></h4>
    
    <p><?php _e( 'Commenter Ignore Button has been tested with over 100 WordPress Themes. A small minority utilize black or very dark backgrounds. If the default styling does not blend with your theme, you can try this option.', 'cks_cib' ) ; ?>
    
    <p>
        <input type="checkbox" name="cks_cib_options[use_dark_styles]" value="1" <?php checked( $use_dark_styles, 1 ) ; ?>" />
         <span style="font-weight:700"><?php _e( 'Check this box to apply alternative button images and "Ignored" text-box for themes with dark backgrounds.', 'cks_cib' ) ; ?></span>
    </p>
    
    <p><?php printf( __( 'If you still are not getting satisfactory results, check %sCustomizing CIB%s in the plugin documentation for additional suggestions.', 'cks_cib'), '<a href="http://ckmacleod.com/wordpress-plugins/commenter-ignore-button/cib-customization/">' ,'</a>' ) ; ?>
    </p>
    
    <?php

}
/**
 * JQUERY BUTTON ACTION OPTIONS
 * @param array $options
 */
function cks_cib_jquery_options( $options ) {
    
    ?>
    
    <h4 id="jquery" style="font-size:1.2em;clear: both;"><?php  _e( 'Ignoring/Unignoring Action', 'cks_cib' ) ; ?></h4>  
    
    <table class="form-table" id="cib_jquery-settings">

        <tbody>
            <tr>
                <td width="20%" class="label"><?php _e( 'Offset After Ignore', 'cks_cib' ) ; ?></td>
                <td width="20%"><input type="number" name="cks_cib_options[sill]" value="<?php echo esc_attr($options['sill']) ; ?>" />
                </td>
                <td width="60%" class="jq-descr">
                <?php _e( 'Adjust the compensation, in pixels, after button action. By default, the action returns to approximately the last spot in the screen where the button was selected. Default: 40.', 'cks_cib' ) ; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Fade In', 'cks_cib' ) ; ?></td>
                <td><input type="text" name="cks_cib_options[fadein]" value="<?php echo esc_attr($options['fadein']) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'Adjust the time it takes, in milliseconds, for  "ignore/unignore" messages to fade in. Default: 2000.', 'cks_cib' ) ; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Delay', 'cks_cib' ) ; ?></td>
                <td><input type="text" name="cks_cib_options[delay]" value="<?php echo esc_attr($options['delay']) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'Adjust the time, in milliseconds, that the "ignore/unignore" messages remains fully visible. Default: 1000.', 'cks_cib' ) ; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Fade Out', 'cks_cib' ) ; ?></td>
                <td><input type="text" name="cks_cib_options[fadeout]" value="<?php echo esc_attr($options['fadeout']) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'Adjust the time it takes, in milliseconds, for the "ignore/unignore" messages to fade out. Default: 2000.', 'cks_cib' ) ; ?>    
                </td>
            </tr>
            
        </tbody>
    </table>
                
    
    <?php
    
}
/**
 * CK'S PLUGINS CREDIT LINK
 * @param array $options
 */
function cks_cib_add_credit_link( $options ) {
    
    $option = isset( $options['add_credit'] ) ? $options['add_credit'] : '' ;
    
    ?>
    
     <h3 style="font-size:1.2em;clear: both;" id="credit"><?php _e( 'CIB Signature Link', 'cks_cib' ) ; ?></h3>
     
     <p><?php _e( 'Adding a credit-link is a way to thank the developer and to show you support WordPress development, and also to help others find the tool and learn how to use it. The image-link is set to appear flush right above the comment reply form, discreetly at half opacity:') ?></p>
        
     <div id="admin-credit-link-example" 
        <a href="http://ckmacleod.com/wordpress-plugins/commenter-ignore-button"  title="Commenter Ignore Button by CK's Plugins" style="
            display: block;
            margin: 12px auto;
            width: 100px;" >
         <img 
            src="<?php echo plugins_url( 'images/ck_plugins_credit_link.jpg', __FILE__ ) ; ?>"  >
         </a>
    </div>
            
     <p>
         <input type="checkbox" name="cks_cib_options[add_credit]" value="1" <?php checked( $option, 1 ) ; ?>" />
         <span style="font-weight:700"><?php _e( 'Check this box to add the Commenter Ignore Button credit-link.', 'cks_cib' ) ; ?></span>
    </p>
       
     
     <?php
     
}

/**
 * GUIDELINES/IGNORE LIST
 * @param array $options
 */
function cks_cib_function_tags( $options ) {
    
    $use_guidelines         =   isset( $options['use_guidelines'] )         ? $options['use_guidelines'] : 0 ;
    $guidelines_head_label  =   isset( $options['guidelines_head_label'] )  ? $options['guidelines_head_label'] : '' ;
    $guidelines             =   isset( $options['guidelines'] )             ? $options['guidelines'] : '' ;
    $guidelines_link        =   isset( $options['guidelines_link'] )        ? $options['guidelines_link'] : '' ;
    $guidelines_link_label  =   isset( $options['guidelines_link_label'] )  ? $options['guidelines_link_label'] : '' ;
    $cib_image              =   isset( $options['guidelines_cib'] )         ? $options['guidelines_cib'] : '' ;
    
    ?>
    
<!--    <div id="cks_cib-template-tags" class="ck-usage-notes">-->
        
        <h3><?php _e( 'On Ignore/Commenting Guidelines Header', 'cks_cib') ; ?></h3>
        
        <div class="cks_usage-ills">       

            <iframe style="display:block; margin:20px auto;border:1px solid gray;" width="560" height="315" src="https://www.youtube.com/embed/6gQgZcPMjQY" frameborder="0" allowfullscreen></iframe>
            
            
        </div>
            
        <p>
            <?php _e( 'By placing a function or "tag" in your theme\'s comments.php template (or by choosing to use the plug-in\'s commenting template above), you can provide a user with an informational header that will either slide open to show information on your commenting guidelines, or will display a list of commenters the user has placed "On Ignore."', 'cks_cib') ; ?>
        </p>
        
        <h4 id="ignore" style="font-size: 1.2em"><?php _e( '"On Ignore" List', 'cks_cib') ; ?></h4>
        
        <p>
            
            <?php _e( 'Added to a comments template (typically "comments.php", possibly at the top of the comments list before the opening "&lt;ol&gt;" or "&lt;ul&gt;"), this tag produces the "On Ignore" list for a particular user - only after at least one name has been added to it. ', 'cks_cib') ; ?> </p>
            
        <p>
            <code>cks_cib_list_ignorables()</code>
        </p>
        <p>
            <?php printf( __( 'Always follow correct WordPress/PHP procedure - i.e., wrap the tags in a %sfunction_exists() conditional%s to avoid fatal errors if the plug-in is de-activated or removed - so: ', 'cks_cib' ), '<a href="http://www.wpbeginner.com/wp-themes/best-practice-check-if-function-exists-when-adding-in-wordpress-theme/">', '</a>' ) ; ?>
            
        </p>
        <p>
            <code>&lt;?php if ( function_exists( 'cks_cib_list_ignorables' ) ) { cks_cib_list_ignorables() ; } ?&gt;</code>
        </p>
        <p>
            <?php printf( __('(For beginners: Doing it "the WordPress way" will also mean performing the alteration on a %sChild Theme.%s It will make no functional difference whether you write the code on a single line, as above, or lay it out as in the sidebar illustration.)', 'cks_ cib' ), '<a href="https://codex.wordpress.org/Child_Themes">', '</a>' ) ; ?>
        </p>

        <h4 id="guidelines" style="font-size: 1.2em"><?php _e( 'Commenting Guidelines', 'cks_cib') ; ?></h4>
           <p>
            <?php _e( 'You can also use the "On Ignore" function tag to display a heading for users who have not placed anyone on ignore. Depending on the settings below, you can summarize your Commenting policy, offer instructions, or link to your Policy page - or include anything else you\'d like to have where the On Ignore list would otherwise go. Note also that the default text assumes you have a Commenting Policy page already set at the default link.', 'cks_cib') ; ?>
        </p>
    
    <table class="form-table" id="cib_guidelines">
         
        <tbody>
            <tr>
                <td width="20%" class="label"><?php _e( 'Use Guidelines Heading', 'cks_cib' ) ; ?></td>
                <td width="40%"><input type="checkbox" name="cks_cib_options[use_guidelines]" value="1" <?php checked( $use_guidelines, 1 ) ; ?>" />
                </td>
                <td width="40%" class="jq-descr">
                <?php _e( 'Check this box to add the Commenting Guidelines Heading.', 'cks_cib' ) ; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Heading Label', 'cks_cib' ) ; ?></td>
                <td><input type="text" name="cks_cib_options[guidelines_head_label]" value="<?php echo esc_html( $guidelines_head_label ) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'The Title or Label for the Guidelines Heading.', 'cks_cib' ) ; ?>
                    
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Guidelines Text', 'cks_cib' ) ; ?></td>
                <td ><textarea name="cks_cib_options[guidelines]" rows="11" style="font-family:Consolas,Monaco,monospace;width:100%;"><?php echo esc_textarea($guidelines) ; ?></textarea>
                </td>
                <td class="jq-descr">
                <?php _e( 'The text that will show when the Guidelines heading is clicked. <code>%COMMENTPOLICY%</code> will be replaced with the Commenting Policy link and label, <code>%BUTTONIMAGE%</code> by the button image, as set below. ', 'cks_cib' ) ; ?>
                <small><?php _e( '(Default Text: "' . get_guidelines_text() . '")', 'cks_cib') ; ?></small>
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Commenting Policy Link Label', 'cks_cib' ) ; ?></td>
                <td><input type="text" name="cks_cib_options[guidelines_link_label]" value="<?php echo esc_html( $guidelines_link_label ) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'Text label for <code>%COMMENTPOLICY%</code>.', 'cks_cib' ) ; ?>
                    
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Commenting Policy Link', 'cks_cib' ) ; ?></td>
                <td><input type="url" name="cks_cib_options[guidelines_link]" value="<?php echo esc_url($guidelines_link) ; ?>" />
                </td>
                <td class="jq-descr">
                    <?php _e( 'URL for <code>%COMMENTPOLICY%</code>.', 'cks_cib' ) ; ?>
                    
                </td>
            </tr>
            <tr>
                <td class="label"><?php _e( 'Button Image Location', 'cks_cib' ) ; ?></td>
                <td><input type="url" name="cks_cib_options[guidelines_cib]" value="<?php echo esc_url( $cib_image ) ; ?>" />
                </td>
                <td class="jq-descr">
                    <p><?php _e( 'URL for <code>%BUTTONIMAGE%</code>). ', 'cks_cib' ) ; ?>
                    
                    <small><?php _e( '(Default: ' . plugins_url( 'images/ignore_x.png', __FILE__ ) . ')' , 'cks_cib' )  ; ?></small></p>
                </td>
            </tr>
            
        </tbody>
    </table>
        
<?php }
/**
 * OUTPUT THE TABLE OF FILTER HOOKS
 */
function cib_filter_hooks() { 
            
    ?>

    <h3 id="filter-hooks">
        <?php _e( 'Filter Hooks:', 'cks_cib' ) ; ?>
    </h3>
        
    <p>
        <?php _e( '(For advanced users.)', 'cks_cib' ) ; ?>
    </p>

    <table id="cks_cib-filters-table" class="form-table">
        <thead>
            <th>Tag</th>
            <th>Purpose</th>
            <th>Default/Note</th>
        </thead>
        <tr>
            <td>
                'cks_cib_container', $button_html, $comment_ID
            </td>
            <td>
                Full html for the ignore/unignore button
            </td>
            <td>
                See "cib-button.php"
            </td>
        </tr>
        <tr>
            <td>
                'cib_ignore_label', $label'
            </td>
            <td>
                Text for the Ignore Button
            </td>
            <td>
                 Non-displayed "x"
            </td>
        </tr>
        <tr>
            <td>
                'cib_ignore_title_attr', $title'
            </td>
            <td>
                Text for the Ignore Button Title Attribute
            </td>
            <td>
                 "Ignore"
            </td>
        </tr>
        <tr>
            <td>
                'cib_unignore_label', $label'
            </td>
            <td>
                Text for the Un-Ignore Button"
            </td>
            <td>
                "Un-Ignore"
            </td>
        </tr>
        <tr>
            <td>
                'cib_unignore_title_attr', $title'
            </td>
            <td>
                Text for the Un-Ignore Button Title Attribute
            </td>
            <td>
                 "Un-Ignore"
            </td>
        </tr>
        <tr>
            <td>
                'cib_ignored_message_label', $ignored_message_label_default
            </td>
            <td>
                Text for label indicating comment is ignored
            </td>
            <td>
                "Ignored"
            </td>
        </tr>
        <tr>
            <td>
                'on_ignore_list', $list_html, $ignorable_names 
            </td>
            <td>
               The html for the "On Ignore" List
            </td>
            <td>
               See "cib-template-tags.php"
            </td>
        </tr>
        <tr>
            <td>
                'on_ignore_string', $list_label_string
            </td>
            <td>
                Text for the heading for the list of ignored commenters (added by template tag)
            </td>
            <td>
                "On Ignore"
            </td>
        </tr>
        <tr>
            <td>
               'cib_guidelines', $html 
            </td>
            <td>
                html for the commenting guidelines, heading + text
            </td>
            <td>
                See "cib-template-tags.php" (Contents configurable on settings page)
            </td>
        </tr>
        <tr>
            <td>
                'cks_cib_credit', $html
            </td>
            <td>
                The optional "signature" credit-link
            </td>
            <td>
               See "cib-template-tags.php" 
            </td>
        </tr>
        <tr>
            <td>
                'cib_says', $says_default
            </td>
            <td>
                Text following commenter name
            </td>
            <td>
               Used in custom comment template ("templates/comment.php")
            </td>
        </tr>
        <tr>
            <td>
                 'cib_comments_template_path', $file_location
            </td>
            <td>
                Location of alternative comments template
            </td>
            <td>
               Default: "<?php echo plugin_dir_path( __FILE__ ) . 'templates/comments.php' ; ?>"
            </td>plugin_dir_path
        </tr>
         <tr>
            <td>
                'cib_pagination_prev', $prev_html
            </td>
            <td>
                Pagination "previous" html
            </td>
            <td>
                See templates/comments.php
            </td>
        </tr>
        <tr>
            <td>
                'cib_pagination_next', $prev_html
            </td>
            <td>
                Pagination "next" html
            </td>
            <td>
                See templates/comments.php
            </td>
        </tr>
    </table>

    <?php
        
}
/**
 * ADD CUSTOM STYLESHEET
 * output to page head
 */
function cks_cib_css_form( ) {
    
    $options = get_option( 'cks_cib_stylesheet_options' ) ;
    
    $option = isset($options['style']) ? $options['style'] : '' ;
    
    $use_styles = isset($options['use_plugin_styles']) ? $options['use_plugin_styles'] : '' ;
    
    $check_message = $use_styles ? 
        __( 'Un-check to save or reset without applying the above styles.', 
                'cks_cib' ) : 
        __( 'Apply the saved styles.', 
                'cks_cib' ) ;
   
    ?>       
        
    <div id="cks_plugins-add-css" class="ck-usage-notes" >

        <h3><?php _e( 'CSS Customization', 'cks_cib') ; ?></h3>
        
        <p>
            <?php printf( __( 'Check %sthe checkbox below%s, and save, to apply these styles or any others, either in additon or as replacements. The code initially provided here will produce an alternative button format using a text-based rather than image-based button.','cks_cib'), '<a href="#apply-css">','</a>' ) ; ?>
        </p>

        <p>
            <?php printf( __( 'You don\'t need to be a CSS (or PHP) expert to adapt CIB to your theme: See %s"Customizing CIB"%s in the Plug-In Documentation for some examples of simple alterations.','cks_cib'), '<a href="http://ckmacleod.com/wordpress-plugins/commenter-ignore-button/cib-customization/">', '</a>' ) ; ?>
            <b><?php _e( 'Feel free to experiment: You can always reset to the original by clicking Reset Styles - and you can separately un-apply the added CSS by un-checking the checkbox. In other words, you can save your work without applying it. ','cks_cib') ; ?>
            </b>
        </p>
        
        <form name="cks_cib_stylesheet_options_form" method="post" action="admin-post.php">

        <input type="hidden" name="action" value="save_cks_cib_stylesheet_options" />

        <?php wp_nonce_field( 'cks_cib_stylesheet', 'stylesheet_nonce' ) ; ?>

        <textarea name="style" rows="72" 
                  style="font-family:Consolas,Monaco,monospace;width:100%;"><?php 
                  echo esc_textarea( stripslashes( $option ) ) ; ?>
        </textarea>
        <p id="apply-css" style="margin: -1em 0 0; height: 1em;">&nbsp;</p>
        <p id="apply-css-checkbox">
            <input type="checkbox" value="1" name="use_plugin_styles" 
                <?php checked( $use_styles, 1 ) ; ?> >
            <label><strong><?php echo $check_message ; ?></strong></label>
        </p>
        <p id="save-or-reset-css">
            <input type="submit" value="Save CSS" name="layout" 
                   class="button-primary" />
            <input type="submit" value="Reset Styles" name="resetstyle" 
                   onclick="return confirm( 
                   '<?php _e( 'Are you sure you want to reset Additional CSS '
                           . 'to plug-in defaults?', 'cks_cib' ) ?>' )"
                   class="button-secondary" />
        </p>

        </form>

    </div>

<?php }
/**
 * CSS USAGE NOTES
 */
function cks_cib_css() {
    
    ?>
    <div id="cks_cib-customization" class="ck-usage-notes" style="overflow:auto;display:block;">
        
        <h3>
            <?php _e( 'CSS Reference', 'cks_cib' ) ; ?>
        </h3>
        
        <p>
        <?php printf( __( 'You can find the default CIB stylesheet at %s<code>%s</code>%s. It also can be viewed in %sCIB Documentation.%s.', 'cks_cib'), '<a href="' . plugin_dir_url( __FILE__ ) . 'css/cks_cib_style.css" >', plugin_dir_url( __FILE__ ) . 'css/cks_cib_style.css','</a>', '<a href="http://ckmacleod.com/wordpress-plugins/commenter-ignore-button/cib-css">', '</a>' ) ; ?>
        </p>
        <p>
        <?php printf( __( 'Note that common comment formatting selectors and alternatives (#commentlist as well as #comment-list, #comments as well as #comments-area, .comment-content, etc. ) are also used in CIB. If the results of your modifications are not as expected, one likely explanation is that the styles are being overridden by specifically targeted theme or plug-in styles. The other likely explanation is that your theme employs unique selectors and %swill have to be coded specifically to target them.%s', 'cks_cib'), '<a href="http://ckmacleod.com/wordpress-plugins/commenter-ignore-button/cib-customization/#bootstrapped">','</a>' ) ; ?>
        </p>
        
        <h4>
            <?php _e( 'CIB CSS Selectors:', 'cks_cib' ) ; ?>
        </h4>
        
        <table id="cks_cib-css-table" class="form-table">
            <thead>
                <th>Selector(s)</th>
                <th>Purpose</th>
                <th>Note</th>
            </thead>
            <tr>
                <td>
                    .cib-container
                </td>
                <td>
                    The div containing the button
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    .cks-cib
                </td>
                <td>
                    Styles the button regardless of "state"
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    .cks-cib-ignore-button
                </td>
                <td>
                    Styles the button when "ignore" not invoked
                </td>
                <td>
                    The default styles use CSS background positioning to produce the button image
                </td>
            </tr>
            <tr>
                <td>
                    .cks-cib-unignore-button
                </td>
                <td>
                    Styles the button when "ignore" not invoked
                </td>
                <td>
                    The default styles use CSS background positioning to produce the button
                </td>
            </tr>
            <tr>
                <td>
                    .cib-button-text
                </td>
                <td>
                    Styles a text button
                </td>
                <td>
                    By default set to non-display - alternative styles includes with "ADD CSS"
                </td>
            </tr>
            <tr>
                <td>
                    .ignore-this-comment
                </td>
                <td>
                    Added to the main comment heading to produce "ignored" stylings
                </td>
                <td>
                    The default styles use CSS background positioning to produce the button image
                </td>
            </tr>
            <tr>
                <td>
                    .ignore-[commenter-name]
                </td>
                <td>
                    Added to the main comment heading to produce "ignored" stylings for particular commenter
                </td>
                <td>
                    Used by jQuery
                </td>
            </tr>
            <tr>
                <td>
                    .ignore-[commenter-name]-button
                </td>
                <td>
                    Added to the CIB to produce "ignored" stylings for particular commenter
                </td>
                <td>
                    Used by jQuery
                </td>
            </tr>
            <tr>
                <td>
                    .commenter-ignored-msg
                </td>
                <td>
                    Styles the "ignored" div added to ignored comments, within the CIB "container"
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    .ignored-text
                </td>
                <td>
                    Styles the text specifically within the "ignored" div
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    .adding-to-ignore, .removing-from-ignore
                </td>
                <td>
                    Style the messages that fade in and out when the ignore button is clicked
                </td>
                <td>
                    Added by jQuery
                </td>
            </tr>
            <tr>
                <td>
                    #ignorables-list
                </td>
                <td>
                    Style the list of commenters currently on Ignore for user
                </td>
                <td>
                    Shows only if commenter is actually ignoring anyone, added by template function tag
                </td>
            </tr>
            <tr>
                <td>
                    .on-ignore
                </td>
                <td>
                    Styles the prefix/title of the "On Ignore:" List
                </td>
                <td>
                    Default: "On Ignore:"
                </td>
            </tr>
            <tr>
                <td>
                    #cib-guidelines
                </td>
                <td>
                    Styles the entire "Commenting at.." div
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    #cib-guidelines-head
                </td>
                <td>
                    Styles the "Commenting at" Header
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    #cib-guidelines-body
                </td>
                <td>
                    Styles the "Commenting at" text
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    .adding-to-list, .removing-from-list
                </td>
                <td>
                    Style the temporary additions or subtractions from the "On Ignore" list if present
                </td>
                <td>
                    Added by jQuery
                </td>
            </tr>
            <tr>
                <td>
                    .cib-reply
                </td>
                <td>
                    Added to comment reply link to enable styling in "reply" placement option
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    #cks_cib-credit
                </td>
                <td>
                    Styles the div containing the optional CIB credit-link
                </td>
                <td>
                    
                </td>
            </tr>
        </table>

<?php

}
/**
 * ADDS VERSION INFO TO SIDEBAR
 * @param string $version
 */
function cks_cib_sidebar( $version ) {

    ?>

    <div id="cks_plugins-sidebar" style="position: relative; height:100%; display: block;overflow: auto;">

        <?php cks_cib_illustrations() ; ?>
        
        <?php cks_cib_tip_jar() ; ?>
        
        <div id="cks_plugins-version" class="sidebar-version" >

            <p>Commenter Ignore Button<br>Version <?php 
                echo $version ; 
            ?><br><i>by CK MacLeod</i></p>

        </div>

    </div>

<?php  

}
/**
 * CK'S DONATION FORM
 * Outputs Paypal "Tip Jar"
 */
function cks_cib_tip_jar() {
    
    ?> 
    
    <div class="ck-donation">
                
        <p><?php _e( 'If you think this plug-in saved you time, or work, '
                . 'or anxiety,<br>or money, or anyway<br>'
                . 'you\'d like to see more work like this...', 'cks_cib' ) ; 
        ?></p>

        <div id="sos-button">

            <form id="sos-form" action="https://www.paypal.com/cgi-bin/webscr" 
                  method="post" target="_top">
                
                <input name="cmd" type="hidden" value="_xclick" />
                <input name="business" type="hidden" 
                       value="ckm@ckmacleod.com" />
                <input name="lc" type="hidden" value="US" />
                <input name="item_name" type="hidden" value="Tip CK!" />
                <input name="item_number" type="hidden" 
                       value="Commenter Ignore Button" />
                <input name="button_subtype" type="hidden" value="services" />
                <input name="no_note" type="hidden" value="0" />
                <input name="cn" type="hidden" 
                       value="Add special instructions or message:" />
                <input name="no_shipping" type="hidden" value="1" />
                <input name="currency_code" type="hidden" value="USD" />
                <input name="weight_unit" type="hidden" value="lbs" />

                <div id="ck-donate-submit-line">
                    
                    <input id="sos-amount" 
                           title="Confirm or not when you get there..." 
                           name="amount" type="text" value="" 
                           placeholder="$xx.xx" />
                    <input id="sos-submit" title="Any amount is very cool..." 
                           alt="Go to Paypal to complete" 
                           name="submit" type="submit" value="<?php _e( 
                                   '...tip me!', 'cks_cib' ) 
                                   ?>" />
                </div>

            </form>

        </div>

    </div>
    
    <?php
}
/**
 * SIDEBAR ILLUSTRATIONS
 * captions and images change 
 * depending on display mode of image replacements
 * @param array $options
 */
function cks_cib_illustrations() {
    
    ?>
    
    <div class="ck-illustrations">
        
         <p class="cks_plugins_admin-ill-head cks_plugins_admin-ill-head-top"><?php _e( '"Before" - "Twenty Seventeen" Theme - Author Link Placement (Default):', 'cks_cib' ) ; 
        ?></p>
        
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_pre_author_style.jpg" alt="<?php _e( '"Before" - "Twenty Seventeen" Theme - Author Link Placement (Default)', 'cks_cib' ) ; 
        ?>" >

        <p class="cks_plugins_admin-ill-head"><?php _e( '"After" - Author Link Placement (Default):', 'cks_cib' ) ; 
        ?></p> 

        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_post_author_style.jpg" alt="<?php _e( 'After (Default)', 'cks_cib') ; 
        ?>" > 
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Comment Datetime Placement:', 'cks_cib' ) ; 
        ?></p> 

        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_comment_datetime.jpg" alt="<?php _e( 'Comment Datetime Placement', 'cks_cib') ; 
        ?>" > 
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Comment Text Placement:', 'cks_cib' ) ; 
        ?></p>
                
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_comment_text.jpg" alt="<?php _e( 'Comment Text Placement', 'cks_cib' ) ; 
        ?>" >
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Reply Link Placement:', 'cks_cib' ) ; 
        ?></p>
                
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_reply.jpg" alt="<?php _e( 'Reply Link Placement', 'cks_cib' ) ; 
        ?>" >
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Alternative Style for Dark Backgrounds ("Eleganto" Theme):', 'cks_cib' ) ; 
        ?></p>
        
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_eleganto_author_link_dark.jpg" alt="<?php _e( 'Alternative Style for Dark Backgrounds', 'cks_cib' ) ; 
        ?>" >
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Alternative Text Style, "Twenty Seventeen":', 'cks_cib' ) ; 
        ?></p>
        
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_2017_alternative_style.jpg" alt="<?php _e( 'Alternative Text Style', 'cks_cib' ) ; 
        ?>" >
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Adding "On Ignore" Function Tag:', 'cks_cib' ) ; 
        ?></p>
        
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/adding_ignorables_tag.jpg" alt="<?php _e( 'Adding On Ignore/Guidelines Function Tag', 'cks_cib' ) ; 
        ?>" >
        
        <p class="cks_plugins_admin-ill-head"><?php _e( 'Credit Link in Thread:', 'cks_cib' ) ; 
        ?></p>
        
        <img src="<?php echo plugin_dir_url( __FILE__ ) ; 
        ?>images/_credit_link_in_thread.jpg" alt="<?php _e( 'Credit Link in Thread', 'cks_cib' ) ; 
        ?>" >

    </div>
    
    <?php
    
}
/**
 * CK'S PLUGINS FOOTER
 * @param string $version
 */
function cks_cib_plugins_footer( $version ) {
    
    $plugin_home_page = 'http://ckmacleod.com/wordpress-plugins/'
            . 'commenter-ignore-button/'; 
    
    ?>
    
    <div id="cks_plugins_admin-footer">

        <a target="_blank" id="link-to-cks-plugins" 
           href="http://ckmacleod.com/wordpress-plugins/"><img src="<?php 
           echo plugin_dir_url( __FILE__ ) ; 
           ?>images/cks_wp_plugins_200x40.jpg"></a>
        
        <a target="_blank" id="link-to-cks-plugins-text" 
           href="http://ckmacleod.com/wordpress-plugins/">All CK's Plug-Ins</a>
        
        <a target="_blank" id="ck-home" href="<?php 
        echo $plugin_home_page ; 
        ?>">Plug-In Home Page</a>
        
        <a target="_blank" id="ck-faq" href="<?php 
        echo $plugin_home_page ; 
        ?>faq/">FAQ</a>
        
        <a target="_blank" id="ck-style" href="<?php 
        echo $plugin_home_page ; 
        ?>/download-includes-installation-instructions-changelog/">Changelog</a>
        
        <a target="_blank" id="ck-help" href="<?php 
        echo $plugin_home_page ; 
        ?>support/">Requests<br>(Contact CK)</a>
        
        <a id="ck-support" class="<?php 
        echo ($version < 1 ) ? 'pre-wp-beta' : 'wordpress-link' ; ?>" 
           href="<?php echo 
           ($version < 1) ? '#" title="Beta: Not Yet at Wordpress.org"' : 
           'http://wordpress.org/support/plugin/commenter-ignore-button/" '
                   . 'target="_blank"' 
                   ?>">Support at Wordpress</a>
        
        <a id="ck-rate" class="last-link<?php echo ($version < 1 ) ? 
        ' pre-wp-beta' : ' wordpress-link' ; ?>" href="<?php echo 
        ($version < 1) ? '#" title="Beta: Not Yet at Wordpress.org"' : 
                'http://wordpress.org/support/view/plugin-reviews/'
                . 'commenter-ignore-button/" target="_blank"' ; 
        ?>" >&#9733; &#9733; &#9733; &#9733; &#9733;<br>Rate CIB!</a> 

    </div>
    
    <?php
    
}
/**
 * SANITIZE MAIN PAGE OPTIONS
 * @param array $options
 * @return array
 */
function sanitize_cib_options( $options ) {
    
    $options['placement']   =   esc_html( 
            $options['placement']) ;  
    $options['guidelines']              =   sanitize_text_field( 
            $options['guidelines'] ) ;                  //content under the header
    $options['guidelines_head_label']   =   sanitize_text_field( 
            $options['guidelines_head_label']) ;        //header label
    $options['guidelines_link_label']   =   sanitize_text_field( 
            $options['guidelines_link_label']) ;        //header link label
    $options['guidelines_link']         =   esc_url( 
            $options['guidelines_link']) ;              //url for guidelines page
    $options['guidelines_cib']          =   esc_url( 
            $options['guidelines_cib']) ;               //ignore button image url
    $options['sill'] =   isset( $options['sill'] ) ?  
            intval( $options['sill']) : 0 ;
    $options['delay']          =   isset( $options['delay'] ) ?  
            intval( $options['delay']) : 0 ;
    $options['fadein'] =   isset( $options['fadein'] ) ?  
            intval( $options['fadein']) : 0 ;
    $options['fadeout'] =   isset( $options['fadeout'] ) ?  
            intval( $options['fadeout']) : 0 ;
    $options['add_credit'] =   isset( $options['add_credit'] ) ?  
            intval( $options['add_credit']) : 0 ;
    $options['use_guidelines']          =   isset( $options['use_guidelines'] ) ?  
            intval( $options['use_guidelines']) : 0 ;   //whether to use header
    $options['use_standard_template']          =   isset( $options['use_standard_template'] ) ?  
            intval( $options['use_standard_template']) : 0 ;   
    $options['use_dark_styles']          =   isset( $options['use_dark_styles'] ) ?  
            intval( $options['use_dark_styles']) : 0 ;
    
    return $options ;
    
}
/**
 * SANITIZE STYLESHEET OPTIONS
 * @param array $options
 * @return array
 */
function sanitize_cib_stylesheet_options( $options ) {
    
    //$options['style'] = wp_kses( $options['style']) ;
    $options['use_plugin_styles'] = intval( $options['use_plugin_styles'] ) ;
    
    return $options ;
    
}