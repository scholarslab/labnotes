<?php

/**
 * Formats a phone number.
 *
 * @string $number The phone number to format.
 * @return string A formatted phone number.
 */
function labnotes_format_phone($number) {

    $string = "$number is not a valid number.";

    $number = preg_replace("/[^0-9]/", "", $number);

    if (strlen($number) == 10) {
        $string = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1.$2.$3", $number);
    }

    return $string;

}


/**
 * An array of meta fields for the theme post types.
 *
 * @return array.
 */
function labnotes_meta_fields($type = null) {

    $meta_fields = array(
        'research' => array(
            'research_url',
            'research_status'
        ),
        'people' => array(
            'person_title',
            'person_email',
            'person_phone',
            'person_twitter',
            'person_url',
            'person_user_id',
            'person_family_name',
            'person_given_name',
            'person_degree',
            'person_department',
            'person_status'
        )
    );

    if ( array_key_exists( $type, $meta_fields ) ) {
        return $meta_fields[$type];
    }

    return $meta_fields;

}

/**
 * Filters page content to display a list of page children.
 *
 * Checks to see if a custom post meta field called 'show children' is set to
 * true.
 */
function labnotes_display_page_children() {

    global $post;

    $html = '';

    $parent_id = 0;

    if(!$post->post_parent){
        // will display the subpages of this top level page
        $parent_id = $post->ID;
        $children = wp_list_pages("title_li=&child_of=".$parent_id."&echo=0");
    }
    else {

        if($post->ancestors) {
            // now you can get the the top ID of this page
            // wp is putting the ids DESC, thats why the top level ID is the last one
            $ancestors = get_post_ancestors($post->ID);
            $parent_id = end($ancestors);
            $children = wp_list_pages("title_li=&child_of=".$parent_id."&include=&echo=0");
        }
    }

    if ($children) {
        $parent = wp_list_pages("title_li=&include=".$parent_id."&echo=0");
        $html = '<nav class="local-navigation"><ul>'.$parent.$children.'</ul></nav>';
    }

    return $html;
}

/**
 * Returns a specific people post type by user ID.
 */
function labnotes_get_person_by_user_id($id) {

    $person = false;

    if (is_integer($id)) {

        $args = array(
            'post_type' => 'people',
            'meta_key' => 'person_user_id',
            'meta_value' => $id
        );

        $people = get_posts($args);
        $person = reset($people);

    }

    return $person;

}

/**
 * Converts a hexadecimal color to RGB value.
 *
 * @return array An array of RGB.
 */
function labnotes_hex2rgb($color) {
    list($r, $g, $b) = array($color[0].$color[1],
                             $color[2].$color[3],
                             $color[4].$color[5]);
    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
    return array($r, $g, $b);
}

/**
 * Returns path to background image for a given post.
 *
 * @uses wp_get_attachment_image_src()
 * @return string The URL for an image, or empty string.
 */
function labnotes_custom_background_image_src( $size = 'full' ) {

    global $post;

    $image_src = '';

    $attachment_id = get_post_meta( $post->ID, '_custom_background_image_id', true );

    if ( $attachment_id ) {
        $image_src = wp_get_attachment_image_src( $attachment_id, $size );
        $image_src = $image_src[0]; // URL is the first element in the returned array.
    }

    return $image_src;

}

/**
 * Returns graduate program categories adn year.
 *
 * @return string HTML.
 */
function labnotes_get_person_programs() {
    global $post;

    $category_type = 'people-category';

    $grad_programs = array('Graduate Fellow','Praxis Fellow');

    $html = '';

    foreach ($grad_programs as $program) {
        $term = get_term_by('name', $program, $category_type);

        if ( has_term($program, $category_type, $post->ID) ) {

            $years = get_terms($category_type, array('child_of' => $term->term_id));

            if ($years) {

                $year_array = array();

                foreach ($years as $year) {
                    if (has_term($year->term_id, $category_type, $post->ID)) {
                        $year_array[] = $year->name;
                    }
                }

                $year_string = implode($year_array, ', ');

                $program_string = $program . ', '.$year_string;
            }

            $html .= '<p class="title">'.$program_string.'</p>';
        }
    }

    return $html;
}

