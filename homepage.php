<?php
/*
 * Template Name: Home Page
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section id="homepage-blurb">
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
</section>

<?php endwhile; endif; ?>

<div id="areas-of-focus">
<section id="research">
    <h1>Research</h1>
    <p>Lorem ipsum dolor sit amet.</p>
</section>
<section id="fellowships">
    <h1>Fellowships</h1>
    <p>Lorem ipsum dolor sit amet.</p>
</section>
<section id="makerspace">
    <h1>Makerspace</h1>
    <p>Lorem ipsum dolor sit amet.</p>
</section>
<section id="events">
    <h1>Events</h1>
    <p>Lorem ipsum dolor sit amet.</p>
</section>
</div>

<?php get_footer(); ?>
