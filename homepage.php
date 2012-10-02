<?php
/*
 * Template Name: Home Page
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="homepage-blurb">
<div class="content">
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
</div>

</div>
<?php endwhile; endif; ?>
<div id="events">
<h2>Events</h2>
<?php echo do_shortcode( '[google-calendar-events id="1" type="list" max="3"]' ); ?>
</div>

<div id="recent-posts">
<h2>Posts</h2>
<ul class="recent-posts">
<?php
global $post;
$args = array('numberposts' => 3);
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
<li>
<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php the_excerpt(); ?>
</li>
<?php endforeach; ?>
</ul>
</div>
<br style="clear:both;">
<?php get_footer(); ?>
