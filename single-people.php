<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>

  <h1><?php the_title(); ?></h1>
  <?php echo get_person_image(); ?>
  <div class="author-meta">
  <ul>
    <?php if ($email = antispambot($customFields['person_email'][0])): ?>
    <li class="email"><a href="<?php echo 'mailto:'.$email; ?>" class="email"><?php echo $email; ?></a></li>
    <?php endif; ?>
    <?php if ($phone = $customFields['person_phone'][0]): ?>
    <li class="tel"><?php echo labnotes_format_phone($phone); ?></li>
    <?php endif; ?>
    <?php if ($twitter = $customFields['person_twitter'][0]): ?>
    <li class="twitter"><a href="http://twitter.com/<?php echo str_replace('@', '', $twitter); ?>" class="url"><?php echo '@'.$twitter; ?></a></li>
    <?php endif; ?>
    <?php if ($url = $customFields['person_url'][0]): ?><li><a href="<?php echo $url; ?>">Personal Site</a></li><?php endif; ?>
  </ul>
  </div>

  <div class="entry-content">
  <?php the_content(); ?>

<?php

if ($customFields['person_user_id'][0] > 0) :

// Create a posts query for all the current author's posts.
$args = array(
'posts_per_page' => -1,
'author' => $customFields['person_user_id'][0]
);

query_posts($args);

if (have_posts()) : ?>
<div id="author-posts">
<h2>Posts by <?php echo $customFields['person_given_name'][0]; ?></h2>
<ul class="posts-list">

<?php while (have_posts()) : the_post(); ?>
<li><a href="<?php echo the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a> <span class="post-meta"><?php the_time('F j, Y'); ?></span></li>
<?php endwhile; ?>

</ul>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php endif; ?>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
