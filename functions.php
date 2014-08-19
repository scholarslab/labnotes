<?php

require_once('inc/helpers.php');
require_once('inc/comments.php');
require_once('inc/custom_background.php');
require_once('inc/custom_post_types.php');


// Post type support.
add_post_type_support('page', 'excerpt');


// Theme support.
add_theme_support( 'post-thumbnails' );


/**
 * Adds singular to body class.
 */
function labnotes_singular_class($classes) {
    global $post;
    if (is_singular()) {
        $classes[] = 'singular';
    }
	return $classes;
}

add_filter('body_class', 'labnotes_singular_class');


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
 * Template for search form.
 */
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
 * Register theme widgets.
 */
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


function get_person_image($postId = null, $options = array()) {
  global $post;

  $html = '';

  // Set the size option if it isn't set.
  $size = isset($options['size']) ? $options['size'] : '150';

  // Set the post ID
  $postId = $postId ? $postId : $post->ID;

  // Get the post custom fields.
  $customFields = get_post_custom($postId);

  $userEmail = $customFields['person_email'][0];
  $userId = $customFields['person_user_id'][0];

  // If the post has a custom field for person_user_id.
  if($userId > 0) {
      $user = get_userdata($userId);
      $userEmail = $user->user_email;
  }

  if (has_post_thumbnail($postId)) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), 'thumbnail' );
    $html = '<img src="'.$image[0].'" class="avatar">';
  } else {
    $html = get_avatar($userEmail, $size);
  }

  return '<span class="person_image">' . $html . '</span>';
}

/**
 * Adds the post slug to the body class.
 */
function labnotes_add_slug_to_body_class($classes) {

    if (!is_front_page()) {
        global $post;
        $classes[] = $post->post_name;
    }

    return $classes;

}

add_filter('body_class', 'labnotes_add_slug_to_body_class');


/**
 * If the content is empty for a Person post, see if there is an associated user
 * and set the content to the user's bio field.
 */
function labnotes_user_bio_for_content($content) {

    if (is_singular('people') && empty($content)) {
        if ($user = get_userdata(get_post_meta(get_the_ID(), 'person_user_id', true))) {
            $content = $user->user_description;
        }
    }

    return $content;

}

add_filter('the_content', 'labnotes_user_bio_for_content');


/**
 * Returns the link for a person post type. Used to filter the author_link output.
 */
function people_author_link($link, $author_id, $author_nicename) {

    if ($person = labnotes_get_person_by_user_id($author_id)) {
        $link = get_permalink($person->ID);
    }

    return $link;

}

add_filter( 'author_link', 'people_author_link', 10, 3);


function filter_get_avatar($avatar, $id, $size, $default, $alt) {

    if ($person = labnotes_get_person_by_user_id($id)) {
        if (has_post_thumbnail($person->ID)) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $person->ID ), 'thumbnail' );
            $avatar = '<img src="'.$image[0].'" class="avatar" alt="'.$alt.'">';
        }
    }

    return '<span class="author_image">' . $avatar . '</span>';

}

add_filter( 'get_avatar', 'filter_get_avatar', 10, 5);


/**
 * Safe Pasting for TinyMCE (automatically clean up MS Word HTML)
 * http://www.kevinleary.net/clean-up-microsoft-word-pasted-html-tinymce/
 */
function tinymce_paste_options($init) {
    $init['paste_auto_cleanup_on_paste'] = true;
    return $init;
}

if( is_admin() ) add_filter('tiny_mce_before_init', 'tinymce_paste_options');


/**
 * Creates link for people category terms.
 */
function labnotes_term_link($link, $term, $taxonomy) {

    if ($taxonomy == 'people-category') {
        $link = get_post_type_archive_link('people') . '?people-category='.$term->slug;
    }

    return $link;

}

add_filter('term_link', 'labnotes_term_link', 10, 3);
