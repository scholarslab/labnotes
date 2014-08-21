<!DOCTYPE html>
<html class="no-js" lang="en_US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php bloginfo('site_title'); ?></title>

        <!-- Feeds -->
        <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom feed" href="<?php bloginfo('atom_url'); ?>">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS feed" href="<?php bloginfo('rss2_url'); ?>">

        <!-- Stylesheets -->
        <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,700|Source+Code+Pro:400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

        <!-- Modernizr and Friends -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js"></script>
        <script>
        Modernizr.load([
        {
            test: Modernizr.mq(),
            nope: [
                '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js',
                '//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js'
            ]
        }
        ]);
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/responsive-nav.js/1.0.32/responsive-nav.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/headroom/0.6.0/headroom.min.js"></script>

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

    <a href="#main" class="skip">Skip to main content</a>

    <header role="banner" id="banner">

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

