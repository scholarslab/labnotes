<?php

$currentAuthor = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

get_header();

?>

  <h1><?php echo $currentAuthor->first_name; ?> <?php echo $currentAuthor->last_name; ?></h1>

  <?php echo get_avatar($currentAuthor->ID, 200); ?>

  <?php echo wpautop($currentAuthor->description); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <?php endwhile; ?>

  <?php endif; ?>

<?php get_footer(); ?>
