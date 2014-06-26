<?php

$currentAuthor = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

get_header();

?>

  <h1><?php echo $currentAuthor->first_name; ?> <?php echo $currentAuthor->last_name; ?></h1>
  <div class="author-meta">
  <?php echo get_avatar($currentAuthor->ID, 150); ?>
  <ul>
        <?php if ($twitter = get_the_author_meta('twitter', $currentAuthor->ID)): ?><li>Twitter: <a href="http://twitter.com/<?php echo $twitter; ?>">@<?php echo $twitter; ?></a></li><?php endif; ?>
        <?php if ($url = get_the_author_meta('user_url', $currentAuthor->ID)): ?><li>Site: <a href="<?php echo $url; ?>"><?php echo $authorInfo->user_firstname; ?>&#8217;s Site</a></li><?php endif; ?>
  </ul>
  </div>
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
    <li><span class="post-meta"><?php the_time('F j, Y'); ?></span> <a href="<?php echo the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a> </li>
  <?php endwhile; ?>

  </ul>

  <?php endif; ?>
  </div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
