<!DOCTYPE html>
<html class="no-js" lang="en_US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php bloginfo('site_title'); ?></title>

        <!-- Stylesheets -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,700|Source+Code+Pro:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

        <!-- Feeds -->
        <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom feed" href="<?php bloginfo('atom_url'); ?>">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS feed" href="<?php bloginfo('rss2_url'); ?>">

        <!-- Modernizr and Friends -->
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/modernizr.min.js"></script>
        <script>
          Modernizr.load([
            {
              test: Modernizr.mq(),
              nope: ['<?php echo get_stylesheet_directory_uri(); ?>/javascripts/respond.min.js',
              '<?php echo get_stylesheet_directory_uri(); ?>/javascripts/selectivizr.min.js']
            }
          ]);
        </script>

        <script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/responsive-nav.min.js"></script>

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

    <a href="#main" class="skip">Skip to main content</a>

    <header role="banner">

        <a id="homelink" href="<?php bloginfo('url'); ?>" rel="home">
        <?php include(get_stylesheet_directory() . '/images/slab-logo.svg'); ?>
        </a>
        <nav>
        <?php
        // Our main navigation.
        wp_nav_menu(
            array(
                'theme_location' => 'header',
                'container' => 'div',
                'container_class' => 'menu main-nav',
            )
        );
        ?>
</nav>
        <?php // get_search_form(); ?>
  </header>

  <main role="main" id="main">

