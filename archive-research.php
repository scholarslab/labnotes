<?php get_header(); ?>
<header>
    <h1><?php _e( 'Research', 'labnotes' ); ?></h1>
</header>
<?php if ( have_posts() ) : ?>
<ul class="research">
<?php while (have_posts()) : the_post(); ?>
<li>
    <a href="<?php the_permalink(); ?>" class="permalink">
    <h2><?php the_title(); ?></h2>
    <?php the_post_thumbnail('full'); ?>
    <div class="excerpt"><?php the_excerpt(); ?></div>
    </a>
</li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php get_footer(); ?>
