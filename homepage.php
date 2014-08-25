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

<?php endwhile; endif; ?>
</section>

<div class="widgets">
<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
</div>

<div id="recent-activity">
<section id="latest-posts">
    <h1>Latest Posts</h1>
<?php
global $post;
$args = array( 'posts_per_page' => 3);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) :
  setup_postdata( $post ); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <p class="post-meta">By <?php the_author(); ?> &middot; <?php the_time('F j, Y'); ?></p>
        <div class="excerpt">
        <?php the_excerpt(); ?>
        </div>
    </article>
<?php endforeach;
wp_reset_postdata(); ?>
</section>
<section id="upcoming-events">
<h1>Upcoming Events</h1>
<?php if(is_plugin_active('events-manager')): ?>
<?php echo do_shortcode('[events_list limit="5"]'); ?>
<?php endif; ?>
</section>
</div>
<?php get_footer(); ?>
