<?php
/**
  * @package: Commenter Ignore Button
 * @Since: 1.0
 * @Date: January 2017
 * @Author: CK MacLeod
 * @Author: URI: http://ckmacleod.com
 * @License: GPL3
 * Substitute template for displaying comments, minimally adapted from 2017
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */


if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area comments">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'cks_cib' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s Reply to &ldquo;%2$s&rdquo;',
							'%1$s Replies to &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'cks_cib'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>
    
                <?php if (function_exists( 'cks_cib_list_ignorables' ) ) { cks_cib_list_ignorables() ; } ?>
    
		<ol class="comment-list commentlist">
                    
			<?php
                            $reply_before = '<div class="reply-before"></div>' ;
                            //removing 2017 specific formatting - conform themes by filtering wp_list_comments_args
				wp_list_comments( array(
					#'avatar_size' => 100,
					'style'       => 'ol',
					'short_ping'  => true,
					'reply_text'  => $reply_before . __( 'Reply', 'cks_cib' ),
				) );
			?>
		</ol>

		<?php 
                
                //removed 2017 specific formatting - conform themes by filtering $prev_html, $next_html
                
                $prev_html = '<span class="screen-reader-text">' . __( 'Previous', 'cks_cib' ) . '</span>' ;
                
                $prev = apply_filters( 'cib_pagination_prev', $prev_html ) ;
                
                $next_html = '<span class="screen-reader-text">' . __( 'Next', 'cks_cib' ) . '</span>' ;
                
                $next = apply_filters( 'cib_pagination_next', $next_html ) ;
                
                //'the_comments_pagination' has existed only since WP 4.4
                if ( function_exists( 'the_comments_pagination' ) ) { 
                    
                    the_comments_pagination( array(
                         
			'prev_text' => $prev,
			'next_text' => $next
                        
                    ));
                    
                }

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'cks_cib' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
