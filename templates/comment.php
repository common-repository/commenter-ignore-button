<?php
/**
 * @package: Commenter Ignore Button
 * @Since: 1.0
 * @Date: January 2017
 * @Author: CK MacLeod
 * @Author: URI: http://ckmacleod.com
 * @License: GPL3
 */

/*
 * ADDS CIB
 * ALSO: CREATES "SAYS" FILTER (REMOVES DEFAULT "SAYS"
 * ALSO: ADDS "INFINITE REPLIES" (limited by options settings)
 * @param object $comment
 * @param array $args
 * @param int $depth
 */
function ci_comment( $comment, $args, $depth ) {
    
    $says_default = '' ;
    $says = apply_filters( 'cib_says', $says_default ) ;
    
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    
    ?>

    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
    
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    
            <footer class="comment-meta">
            
                <div class="comment-author vcard">

                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

                    <?php
                        /* translators: %s: comment author link */
                        printf( __( '%s <span class="says">' .  $says . '</span>', 'cks_cib' ),
                                sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
                        );
                    ?>

                </div><!-- .comment-author -->

                <div class="comment-metadata">
                    
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>
                    </a>
                    
                    <?php if ( function_exists( 'cks_cib' ) ) { echo cks_cib( $comment->comment_ID ) ; } ?>

                    <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                    
                </div><!-- .comment-metadata -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                <?php endif; ?>
            </footer><!-- .comment-meta -->

            <div class="comment-content">
                <?php comment_text(); ?>
            </div><!-- .comment-content -->

            <?php
            comment_reply_link( array_merge( $args, array(
                'add_below' => 'div-comment',
                'depth'     => $depth,
                'max_depth' => $args['max_depth'] + 1, //Infinite Replies//
                'before'    => '<div class="reply">',
                'after'     => '</div>'
            ) ) );
            ?>

        </article><!-- .comment-body -->
        
<?php
	}
    