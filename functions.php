<?php

/**
 * Adds theme support for page excerpts.
 */
add_post_type_support('page', 'excerpt');

/**
 * Filters page content to display a list of page children.
 *
 * Checks to see if a custom post meta field called 'show children' is set to
 * true.
 */
function labnotes_display_page_children($content)
{
    global $post;

    if (get_post_meta($post->ID, 'show_children', 'true') == true) {
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
            $html = '<ul class="page-children labnotes-page-children">';
            while (have_posts()) {
                the_post();
                $html .= '<li><a href="'.get_permalink(get_the_ID()).'" class="permalink">'.get_the_title().'</a> – '.get_the_excerpt().'</li>';
            }
            $html .= '</ul>';
        }
        $content = $content . $html;
        wp_reset_query();
    }
    return $content;
}

add_filter('the_content', 'labnotes_display_page_children');

/**
 * Filters the 'excerpt_more' to provide a 'Continue reading' link.
 */
function labnotes_excerpt_more($more) {
    global $post;
    $more = '&hellip;. <a href="'. get_permalink($post->ID) . '">More.</a>';
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
        <p><?php _e( 'Pingback:', 'labnotes' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'labnotes' ), '<span class="edit-link">', '</span>' ); ?></p>

    <?php
        break;
        default :
    ?>

        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <ul class="comment-meta">
                    <li class="image"><?php echo get_avatar( $comment, '60' ); ?></li>
                    <li class="fn"><?php comment_author_link(); ?></li>
                    <li class="comment-date">
                        <?php
                        printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                        esc_url( get_comment_link( $comment->comment_ID ) ),
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

add_action( 'show_user_profile', 'labnotes_edit_extra_profile_fields' );
add_action( 'edit_user_profile', 'labnotes_edit_extra_profile_fields' );

function labnotes_edit_extra_profile_fields( $user ) { ?>

    <h3>Extra User Information</h3>

    <table class="form-table">

        <tr>
            <th><label for="twitter">Twitter</label></th>

            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Twitter username.</span>
            </td>
        </tr>
        <tr>
            <th><label for="title">Title</label></th>

            <td>
                <input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your job title.</span>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'labnotes_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'labnotes_save_extra_profile_fields' );

function labnotes_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
    update_usermeta( $user_id, 'title', $_POST['title'] );

}

function labnotes_search_form($html) {
    $html = '<form role="search" method="get" id="search" action="' . home_url( '/' ) . '" >'
          . '<label for="s">' . __('Search for') . '</label>'
          . '<input type="search" value="' . get_search_query() . '" name="s" id="s" />'
          . '<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />'
          . '</form>';

    return $html;
}

add_filter( 'get_search_form', 'labnotes_search_form' );

/*
 * Adds scripts to WordPress's scripts queue.
 *
 */
if (!is_admin()) {
    wp_enqueue_script('slab-respond', get_bloginfo('template_url') . '/lib/respond/respond.min.js', null, null);
}

/**
 * HTML5 Shiv Markup 
 *
 * Adds markup for the HTM5 shiv, which helps versions of IE 8 and
 * order recognize and style HTML5 elements. By Remy Sharp.
 *
 **/
function labnotes_add_html5shiv_markup() {
?>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
}

add_action('wp_head', 'labnotes_add_html5shiv_markup');
