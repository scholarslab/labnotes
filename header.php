<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.levelaccess.net/accessjs/YW1wX3V2YTExMDA/access.js" type="text/javascript"></script>

        <title><?php wp_title('·', true, 'right'); ?></title>

        <!-- Feeds -->
        <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom feed" href="<?php bloginfo('atom_url'); ?>">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS feed" href="<?php bloginfo('rss2_url'); ?>">

        <!-- Stylesheets -->
        <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,700|Source+Code+Pro:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

        <!-- Modernizr and Friends -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/responsive-nav.js/1.0.32/responsive-nav.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/headroom/0.6.0/headroom.min.js"></script>

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

    <a href="#main" class="skip">Skip to main content</a>

    <header role="banner" id="banner">

        <a id="homelink" href="<?php bloginfo('url'); ?>" rel="home">
        <span class="audible">Scholars&#8217; Lab Home Page</span>
        <?php include(get_stylesheet_directory() . '/images/slab-logo.svg'); ?>
        </a>
        <nav id="primary-navigation" role="navigation">
        <?php
        // Our main navigation.
        wp_nav_menu(
            array(
                'theme_location' => 'header',
                'container' => ''
            )
        );
        ?>
        </nav>
        <?php // get_search_form(); ?>
  </header>

  <main role="main" id="main">

