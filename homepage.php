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

<section id="events">
    <h1>Upcoming Events</h1>
    <?php echo do_shortcode( '[google-calendar-events id="1" type="list" max="3"]' ); ?>
    <p><strong><a href="<?php echo get_page_link(get_page_by_title("Events")->ID); ?>">See all our events</a>.</strong></p>
</section>

<section id="recent-posts">
    <h1>Recent Posts</h1>
    <ul class="recent-posts">
    <?php
    $args = array('numberposts' => 3);
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) :	setup_postdata($post); ?>
        <li>
            <em class="deck"><?php the_time('F j, Y'); ?></em>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <a class="byline" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="See all posts by <?php echo get_the_author_meta('user_firstname'); ?>">
                <?php echo get_avatar(get_the_author_meta('ID'),120); ?>
                <?php echo get_the_author_meta('user_firstname') . ' ' . get_the_author_meta('user_lastname'); ?>
            </a>
            <div class="excerpt"><?php the_excerpt(); ?></div>
        </li>
    <?php endforeach; ?>
    </ul>
    <p><strong><a href="<?php echo get_page_link(get_page_by_title("Archives")->ID); ?>">See all our posts</a>.</strong></p>
</section>

<?php get_footer(); ?>
