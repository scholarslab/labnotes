<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>

  <h1><?php the_title(); ?></h1>
  <div class="author-meta">
  <?php // echo get_avatar($currentAuthor->ID, 150); ?>

  <ul>
        <?php if ($twitter = $customFields['person_twitter'][0]): ?><li>Twitter: <a href="http://twitter.com/<?php echo $twitter; ?>">@<?php echo $twitter; ?></a></li><?php endif; ?>
        <?php if ($url = $customFields['person_url'][0]): ?><li>Site: <a href="<?php echo $url; ?>">User&#8217;s Site</a></li><?php endif; ?>
  </ul>
  </div>
  <div class="entry-content">

  <?php the_content(); ?>
  
<?php if ($userId = $customFields['person_user_id'][0]) : ?>

<?php
// Create a posts query for all the current author's posts.
$args = array(
'posts_per_page' => -1,
'author' => $userId
);

query_posts($args);

if (have_posts()) : ?>

<h2>Posts by <?php echo $customFields['person_given_name'][0]; ?></h2>
<ul class="posts-list">

<?php while (have_posts()) : the_post(); ?>
<li><a href="<?php echo the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a> <span class="post-meta"><?php the_time('F j, Y'); ?></span></li>
<?php endwhile; ?>

</ul>

<?php endif; ?>
</div>
<?php wp_reset_query(); ?>
<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
