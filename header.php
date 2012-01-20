<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<title><?php bloginfo('site_title'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom" href="<?php bloginfo('atom_url'); ?>">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS" href="<?php bloginfo('rss2_url'); ?>">

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

  </header>

  <div role="main">

