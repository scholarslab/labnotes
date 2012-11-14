<?php

/**
 * Adds theme support for page excerpts.
 */
add_post_type_support('page', 'excerpt');

/**
 * Add theme support for post thumbnails.
 */
add_theme_support( 'post-thumbnails' );

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

// add_filter('the_content', 'labnotes_display_page_children');

/**
 * Filters the 'excerpt_more' to provide a 'Continue reading' link. Currently
 * only updates the link for 'post' post types.
 */
function labnotes_excerpt_more($more) {
  global $post;
  if ($post->post_type == 'post') {
    $more = '&hellip;. <a href="'. get_permalink($post->ID) . '">More.</a>';
  }
  return $more;
}

add_filter('excerpt_more', 'labnotes_excerpt_more');

/**
 * Register our navigation menus
 */
if ( function_exists('register_nav_menus') ) {

register_nav_menus( array(
    'header' => __( 'Header Navigation', 'labnotes' ),
    'courtesy' => __( 'Courtesy Navigation', 'labnotes' ),
    'footer' => __( 'Footer Navigation', 'labnotes' )
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

/**
 * Custom Post Type for People
 */
function labnotes_register_post_types() {
    register_post_type( 'people',
        array(
            'labels' => array(
                'name' => __( 'People' ),
                'singular_name' => __( 'Person' )
              ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 20,
            'hierarchical' => false,
            'has_archive' => false,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'people')
        )
      );
    register_post_type( 'research',
        array(
            'labels' => array(
                'name' => __( 'Research' ),
                'singular_name' => __( 'Research Project' )
              ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt'),
            'menu_position' => 20,
            'hierarchical' => false,
            'has_archive' => false,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'research')
        )
    );
}

add_action( 'init', 'labnotes_register_post_types' );

/**
 * Adds our post meta boxes for the 'sp_workshop' post type.
 */
function labnotes_add_meta_boxes() {
  add_meta_box("wp-user-information", __('Personal Info'), "labnotes_people_meta_box", "people", "side", "high");
  add_meta_box("wp-user-information", __('Project Info'), "labnotes_research_meta_box", "research", "side", "high");
  
}

add_action( 'admin_init', 'labnotes_add_meta_boxes');

function labnotes_people_meta_fields() {
  return array(
    'person_title',
    'person_email',
    'person_phone',
    'person_twitter',
    'person_url',
    'person_user_id',
    'person_family_name',
    'person_given_name',
    'person_degree',
    'person_category',
    'person_department'
  );
}

function labnotes_people_departments() {
  return array(
      'administration' => 'Administration',
      'reseach_and_development' => 'Research & Development',
      'public_service' => 'Outreach & Public Service',
      'gis_data' => 'Geospatial Information and Data Services',
      'its_research' => 'ITS Research Computing'
  );
}

/**
 * Meta box for personal information.
 */
function labnotes_people_meta_box(){
    global $post;
    $custom = get_post_custom($post->ID);

    $fields = labnotes_people_meta_fields();

    $categoryOptions = array('staff' => 'Staff', 'graduate_fellow' => 'Graduate Fellow');

    $departmentOptions = labnotes_people_departments(); 

?>

<?php foreach ($fields as $field): if ($field == 'person_user_id' || $field == 'person_category' || $field == 'person_department') continue; ?>
    <p><label for="<?php echo $field; ?>"><?php echo ucwords(str_replace('_', ' ', str_replace('person_', ' ', $field))); ?></label></p>
    <p><input type="text" value="<?php echo @$custom[$field][0]; ?>" name="<?php echo $field; ?>" /></p>
<?php endforeach; ?>

    <p><label for="person_user_id">User</label></p>
    <p><?php wp_dropdown_users(array('show_option_none' => 'No User', 'name' => 'person_user_id', 'selected' => @$custom['person_user_id'][0])); ?></p>

    <p><label for="person_category">Category</label></p>
    <p>
      <select name="person_category">
      <option>Choose a Category</option>
      <?php foreach ($categoryOptions as $name => $label): ?>
      <option value="<?php echo $name; ?>"<?php if (@$custom['person_category'][0] == $name) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
      <?php endforeach; ?>
      </select>
    </p>

    <p><label for="person_department">Department</label></p>
    <p>
      <select name="person_department">
      <option>Choose a Department</option>
      <?php foreach ($departmentOptions as $name => $label): ?>
      <option value="<?php echo $name; ?>"<?php if (@$custom['person_department'][0] == $name) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
      <?php endforeach; ?>
      </select>
    </p>

<?php
}

function labnotes_research_meta_fields() {
  return array(
    'research_url',
    'research_status'
  );
}

/**
 * Meta box for personal information.
 */
function labnotes_research_meta_box(){
    global $post;
    $custom = get_post_custom($post->ID);

    $fields = labnotes_people_meta_fields();

    $statusOptions = array('current' => 'Current Research', 'archived' => 'Past Research');

?>

    <p><label for="research_url">Project URL</label></p>
    <p><input type="text" value="<?php echo @$custom['research_url'][0]; ?>" name="research_url" /></p>

    <p><label for="research_status">Status</label></p>
    <p>
      <select name="research_status">
      <option>Choose a Status</option>
      <?php foreach ($statusOptions as $name => $label): ?>
      <option value="<?php echo $name; ?>"<?php if (@$custom['research_status'][0] == $name) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
      <?php endforeach; ?>
      </select>
    </p>

<?php
}

/**
* Saves our custom post metadata. Used on the 'save_post' hook.
*/
function labnotes_save_post(){
  global $post;

  if ( 'people' == @$_POST['post_type'] ) {
    $fields = labnotes_people_meta_fields();
    foreach ($fields as $field) {
      if ( array_key_exists($field, $_POST)) {
          update_post_meta($post->ID, $field, $_POST[$field]);
      }
    }
  }

  if ( 'research' == @$_POST['post_type'] ) {
    $fields = labnotes_research_meta_fields();
    foreach ($fields as $field) {
      if ( array_key_exists($field, $_POST)) {
          update_post_meta($post->ID, $field, $_POST[$field]);
      }
    }
  }

}

add_action( 'save_post','labnotes_save_post');

/**
 * Formats a phone number.
 */
function labnotes_format_phone($number) {

  $string = "$number is not a valid number.";

  $number = preg_replace("/[^0-9]/", "", $number);

  if (strlen($number) == 10) {
      $string = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1.$2.$3", $number);
  }

  return $string;
}

// Register widgets.
function labnotes_widgets_init() {
    $beforeTitle = '<h2>';
    $afterTitle = '</h2>';

    register_sidebar( array(
        'name' => __( 'Home Page Widget Area', 'labnotes' ),
        'id' => 'homepage-widget-area',
        'description' => __( 'The home page widget area', 'labnotes' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => $beforeTitle,
        'after_title' => $afterTitle
      ) );
}

add_action('widgets_init', 'labnotes_widgets_init');

function get_person_image($size = '150') {
  global $post;

  $postId = $post->ID;

  $customFields = get_post_custom($postId);

  $html = '';

  if (has_post_thumbnail($postId)) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), 'thumbnail' );
    $html = '<img src="'.$image[0].'" class="avatar">';
  } else {
    $html = get_avatar($customFields['person_email'][0],$size);
  }

  return $html;
}

add_shortcode('labnotes_people', 'labnotes_people_query');

function labnotes_people_query($attrs) {
  extract(
    shortcode_atts(
      array(
        'category' => 'staff',
      ),
      $attrs
    )
  );


  $params = array(
    'post_type' => 'people',
    'posts_per_page' => '-1',
    'meta_key' => 'person_family_name',
    'orderby' => 'meta_value',
    'order' => 'asc'
  );

  $category = $attrs['category'];
  $params['meta_query'] = array(
        array(
          'key' => 'person_category',
          'value' => $category
        )
      );


  query_posts($params);
  $html = '';
  if (have_posts()) {
        $html = '<ul class="people graduate_fellows">';
        while (have_posts()) {
          the_post();
          $id = get_the_ID();
            $html .= '<li class="vcard">'
                   . '<a href="'. get_permalink($id) .'">'
                   . get_person_image($id)
                   . get_the_title($id)
                   .'</a>'
                   . '</li>';
        }
        $html = $html . '</ul>';
    }

  wp_reset_query();
  return html_entity_decode($html);
}
