<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<title><?php bloginfo('site_title'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom" href="<?php bloginfo('atom_url'); ?>">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS" href="<?php bloginfo('rss2_url'); ?>">
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
<?php wp_head(); ?>

</head>

  <body <?php body_class(); ?>>

  <header role="banner">

      <div id="uvalib-header">
          <a href="http://lib.virginia.edu">
            <span id="rotunda"><img src="<?php echo get_template_directory_uri(); ?>/images/rotunda.gif" alt="The Rotunda"></span>
            <span id="uvalib-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/uvalib-logo-transparent.gif" alt="University of Virginia Library"></span>
          </a>
      </div>

      <h1>
        <a href="<?php bloginfo('url'); ?>" rel="home">

          <img src="http://static.scholarslab.org/images/logos/slab/slab-logo-rgb-350px.png" alt="<?php bloginfo('site_title'); ?>">
    
        </a>
      </h1>
<?php wp_nav_menu( 
        array(
          'theme_location' => 'header',
          'container' => 'nav',
          'container_class' => 'menu',
          'depth' => '1'
        ) 
      ); 
?>
<?php get_search_form(); ?>
  </header>

  <div role="main">

