<?php

$currentAuthor = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

get_header();

?>

  <h1><?php echo $currentAuthor->first_name; ?> <?php echo $currentAuthor->last_name; ?></h1>

  <?php echo get_avatar($currentAuthor->ID, 150); ?>

  <div class="entry-content">

  <?php echo wpautop($currentAuthor->description); ?>
  <?php

  // Create a posts query for all the current author's posts.
  $args = array(
    'posts_per_page' => -1,
    'author' => $currentAuthor->ID
  );

  query_posts($args);

  if (have_posts()) : ?>

  <h2>Posts by <?php echo $currentAuthor->first_name; ?></h2>
  <ul class="posts-list">

  <?php while (have_posts()) : the_post(); ?>
    <li><a href="<?php echo the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a> <span class="post-meta"><?php the_time('F j, Y'); ?></span></li>
  <?php endwhile; ?>

  </ul>

  <?php endif; ?>
  </div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
