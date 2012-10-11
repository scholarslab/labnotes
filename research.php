<?php
/*
 * Template Name: Research
 */
?>
<?php get_header(); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php 

$args = array(
  'post_type' => 'research',
  'posts_per_page' => '-1',
  'orderby' => 'title',
  'order' => 'asc'
);

query_posts($args);

if (have_posts()) : ?>
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
<?php wp_reset_query(); ?>

<?php get_footer(); ?>

