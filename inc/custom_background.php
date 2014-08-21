<?php

$custom_background_args = array(
	'default-color' => 'ffffff',
    'default-image' => get_template_directory_uri() . '/images/background.jpg',
    'wp-head-callback'       => 'labnotes_custom_background_cb'
);



add_theme_support( 'custom-background', $custom_background_args );

function labnotes_custom_background_cb() {

    // $background is the saved custom image, or the default image.
    $background = set_url_scheme( get_background_image() );

    // $color is the saved custom color.
    // A default has to be specified in style.css. It will not be printed here.
    $color = get_background_color();

    if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
        $color = false;
    }

    if ( ! $background && ! $color )
        return;

    $background_color = null;

    $overlay_color = '#292929';

    if ($color) {
        $rgb = labnotes_hex2rgb($color);
        $rgb_string = implode($rgb, ',');
        $background_color = "background-color: #$color;"
                          . "background-color: rgba($rgb_string, 0.75);";
        $overlay_color = $rgb_string;
    }

    $style = $background_color ? $background_color : '';

    if ( $background ) {
        $image = " background-image: url('$background'); "
               . " background-image: -moz-linear-gradient(left, rgba($overlay_color, 0.95), rgba($overlay_color, 0.95)), url('$background'); "
               . "background-image: -webkit-linear-gradient(left, rgba($overlay_color, 0.95), rgba($overlay_color, 0.95)), url('$background');"
               . "background-image: linear-gradient(left, rgba($overlay_color, 0.95), rgba($overlay_color, 0.95)), url('$background');";

        $repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

        if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
            $repeat = 'no-repeat';

        $size = '';
        if ($repeat == 'no-repeat')
            $size = " -moz-background-size: cover;"
                  . " -webkit-background-size:cover;"
                  . " background-size: cover;";

        $repeat = " background-repeat: $repeat;";

        $position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );

        if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
            $position = '50%';

        $position = " background-position: top $position;";

        $attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
        if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
            $attachment = 'scroll';

        $attachment = " background-attachment: $attachment;";

        $style .= $image . $repeat . $position . $attachment . $size;

        $default_selector = 'html, .singular main header';
        $selector = apply_filters('labnotes_custom_background_image', $default_selector);

        $html = '<style type="text/css" id="custom-background-css">'
              . $selector
              . '{'
              . trim($style)
              . '}'
               . '</style>';

        echo $html;

    }

}

