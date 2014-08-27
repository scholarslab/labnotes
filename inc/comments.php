<?php

/**
 * Comments template.
 */
function labnotes_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        case 'social-twitter':
    ?>

        <span <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?></span>

    <?php
        break;
        default :
?>

        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <ul class="comment-meta">
                    <li class="image"><?php echo get_avatar($comment, '60'); ?></li>
                    <li class="fn"><?php comment_author_link(); ?></li>
                    <li class="comment-date">
                        <?php
                        printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                        esc_url( get_comment_link( get_comment_ID() )),
                        get_comment_time( 'c' ),
                        get_comment_date()
                        );
                        ?>
                    </li>
                    <?php edit_comment_link( __( 'Edit this Comment' ), '<li class="edit-link">', '</li>' ); ?>
                    <li class="reply-link">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'labnotes' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </li>
                </ul>
                <div class="comment-content">
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
        </article>

        <?php
        break;
    endswitch;
}

