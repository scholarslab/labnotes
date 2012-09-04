<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <em class="deck">Research</em>
  <h1><?php the_title(); ?></h1>
  <div class="entry-content">

  <?php the_content(); ?>
  </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>

