<?php

/**
 * Adds theme support for page excerpts.
 */
add_post_type_support('page', 'excerpt');

/**
 * Filters page content to display a list of page children.
 */
function labnotes_display_page_children($content)
{
    global $post;

    if (is_page()) {
        $html = '';

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_parent' => $post->ID,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'nopaging' => true,
        );

        query_posts($args);
        if (have_posts()) {
            $html = '<ul>';
            while (have_posts()) {
                the_post();
                $url = get_permalink(get_the_ID());

                $html .= '<li><a href="'.$url.'">'.get_the_title().'</a> – '.get_the_excerpt().'</li>';
            }
            $html .= '</ul>';
            wp_reset_query();
        }
        $content = $content . $html;
    }
    return $content;
}

add_filter('the_content', 'labnotes_display_page_children');

/**
 * Filters the 'excerpt_more' to provide a 'Continue reading' link.
 */
function labnotes_excerpt_more($more) {
    global $post;
    $more = '&hellip;. <a href="'. get_permalink($post->ID) . '">Continue reading...</a>';
    return $more;
}

add_filter('excerpt_more', 'labnotes_excerpt_more');

/**
 * Register our navigation menus
 */
if ( function_exists('register_nav_menus') ) {

register_nav_menus( array(
	'header' => __( 'Header Navigation', 'labnotes' ),
	'footer' => __( 'Footer Navigation', 'labnotes' ),
) );

}

/**
 * Register our sidebar.
 */
if ( function_exists('register_sidebar') ) {
    register_sidebar(array( 'name' => 'FooterSidebar',
                            'id' => 'footer-sidebar',
                            'description' => 'Widgets in this area will be shown in the footer.',
                            'before_title' => '',
                            'after_title' => ''));
}

/**
 * Returns users ordered by a given key.
 *
 * @param string The meta_key to order by. Default is 'last_name'.
 * @param string The sort direction. Default is ASC.
 * @todo Add parameter to skip users with specific IDs
 * @todo Add parameter to skip users with an empty last name.
 */
function labnotes_get_users_order_by_usermeta($metaKey = 'last_name', $sortDir = 'ASC')
{
  global $wpdb;

  $select = "SELECT * FROM $wpdb->users
             INNER JOIN $wpdb->usermeta ON ($wpdb->users.ID = $wpdb->usermeta.user_id)
             WHERE $wpdb->usermeta.meta_key = '$metaKey'
             ORDER BY $wpdb->usermeta.meta_value $sortDir";

  $users = $wpdb->get_results($select);

  return $users;
}

function labnotes_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</header>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
