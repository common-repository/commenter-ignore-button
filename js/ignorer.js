/**
 * @package: Commenter Ignore Button
 * @Since: 1.0
 * @Date: January 2017
 * @Author: CK MacLeod
 * @Author: URI: http://ckmacleod.com
 * @License: GPL3
 */

jQuery(document).ready(function($){

    $('.comment').on('click','a.cks-cib-ignore-button', (function(e) {

        e.preventDefault();

        //easier to deal with literals for simple cookie
        $.cookie.raw = true;

        var ignore = $(this).attr('data-do') ;
        var ignore_name = $(this).attr('data-name');
        var data_id = $(this).attr('data-id');
        var class_ignore = "." + ignore ;
        var ignorable = $.cookie( 'ignorable' ) ;
        var ignorable_names = $.cookie( 'ignorable_names' ) ;
        var ignore_button = class_ignore + '-button' ;
        var untitle = cib_titles.unignore_title ;
        var add_message = '<span class="adding-to-ignore">adding ' + ignore_name + ' to Ignore List</span>';
        var add_on = '<span class="adding-to-list"> (adding ' + ignore_name + ')</span>';
        var window_height = $(window).height();
        
        $(ignore_button).prop('title', untitle + ' ' + ignore_name);
        $('#ignorables-list p').append(add_on);
        
        if (ignorable) {
            ignored = ignorable + ',' + ignore ;
        } else {
            ignored = ignore ;
        }       
    
        if (ignorable_names) {
            ignored_names = ignorable_names + ',' + ignore_name ;
        } else {
            ignored_names = ignore_name ;
        }
        
        $(class_ignore).addClass('ignore-this-comment');
        $(ignore_button).removeClass('cks-cib-ignore-button').addClass('cks-cib-unignore-button');
        $(ignore_button + ' .cib-button-text').text(cib_titles.unignore_label);
        
        var sillval = cib_options.sill ;
        var fadeinval = cib_options.fadein ;
        var delayval = cib_options.delay ;
        var fadeoutval = cib_options.fadeout ;
        var isill = parseInt(sillval);
        var ifadein = parseInt(fadeinval);
        var idelay = parseInt(delayval);
        var ifadeout = parseInt(fadeoutval);
       
        var offset = $('#comment-' + data_id).offset();
        var window_adjust = (.5 * window_height) + isill ;
        
        $.cookie( 'ignorable', ignored, { expires: 365, path: '/' } );
        $.cookie( 'ignorable_names', ignored_names, {expires: 365, path: '/' } );
        $.cookie( 'comment_author_proxyhash', 'proxy_author', {expires: 365, path: '/' } );
        
        $(add_message).insertAfter(class_ignore + '.ignore-this-comment > article .cib-container').fadeIn(ifadein).delay(idelay).fadeOut(ifadeout);

        $('html, body').animate({
            scrollTop: offset.top - window_adjust
            }, 0, 'linear');

        return false;

    }));

    $('.comment').on('click','a.cks-cib-unignore-button', (function(e) {

        e.preventDefault();

        $.cookie.raw = true;

        var ignore = $(this).attr('data-do') ;
        var ignore_name = $(this).attr('data-name');
        var data_id = $(this).attr('data-id');
        var class_ignore = "." + ignore ;
        var ignorable = $.cookie( 'ignorable' ) ;
        var ignorable_names = $.cookie( 'ignorable_names' ) ;
        var ignore_button = class_ignore + '-button' ;
        var title = cib_titles.ignore_title ;
	var remove_message = '<span class="removing-from-ignore">' + cib_titles.removing + ' ' + ignore_name + ' ' + cib_titles.from_list + '</span>';
        var remove_add_on = '<span class="removing-from-list"> (' + cib_titles.removing + ' ' + ignore_name + ')</span>';
        var window_height = $(window).height();
        
        $(ignore_button).prop('title', title + ' ' + ignore_name);
        
        if ( $('#ignorables-list').length ) {
        var replaceable_text = $('#ignorables-list p').html(); 
        } else {
        var replaceable_text = '' ;
        }
        
        replaceable_text.replace(ignore_name + ', ', '');
        replaceable_text = replaceable_text.replace(', ' + ignore_name, '');
        replaceable_text = replaceable_text.replace(ignore_name, '');
        replaceable_text = replaceable_text.replace('(' + cib_titles.removing + ' )', '');
        replaceable_text = replaceable_text.replace('(' + cib_titles.adding + ' )', '');
        if (replaceable_text) { $('#ignorables-list p').html(replaceable_text); }
	if (replaceable_text) { $('#ignorables-list p').append(remove_add_on); }

        ignored = ignorable.replace( ',' + ignore, '' ) ;
        ignored = ignored.replace( ignore + ',', '') ;
        ignored = ignored.replace( ignore, '' ) ;
        ignored_names = ignorable_names.replace( ',' + ignore_name, '' ) ;
        ignored_names = ignored_names.replace( ignore_name + ',', '') ;
        ignored_names = ignored_names.replace(ignore_name, '' ) ;

        $(class_ignore).removeClass('ignore-this-comment');
        $(ignore_button).addClass('cks-cib-ignore-button').removeClass('cks-cib-unignore-button');
        $(ignore_button + ' .cib-button-text').text(cib_titles.ignore_label);

        $.cookie( 'ignorable', ignored, { expires: 365, path: '/' } );
        $.cookie( 'ignorable_names', ignored_names, {expires: 365, path: '/' } );
        $.cookie( 'comment_author_proxyhash', 'proxy_author', { path: '/' } );
		
        var fadeinval = cib_options.fadein ;
        var delayval = cib_options.delay ;
        var fadeoutval = cib_options.fadeout ;
        var ifadein = parseInt(fadeinval);
        var idelay = parseInt(delayval);
        var ifadeout = parseInt(fadeoutval);
        $(remove_message).insertAfter(class_ignore + ' > article .cib-container').fadeIn(ifadein).delay(idelay).fadeOut(ifadeout);
        
        var offset = $('#comment-' + data_id).offset();
        var window_adjust = (.5 * window_height)   ;

        $('html, body').animate({
            scrollTop: offset.top - window_adjust
            }, 0, 'linear');
            
        if ( !ignored_names.trim() ) {
            $('#ignorables-list').hide();
        }

        return false;

    }));
    
    $('#cib-guidelines-head').click(function(e) {
        
        e.preventDefault();
        
        $('#cib-guidelines-body').slideToggle();
        
    });

});