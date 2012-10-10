<?php
/*
 * Template Name: Graduate Fellows
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php endwhile; endif; ?>

<div style="overflow:hidden;">
<?php

// Get the current query.
global $wp_query;

$args = array(
  'post_type' => 'people',
  'posts_per_page' => '-1',
  'meta_query' => array(
    array(
      'key' => 'person_category',
      'value' => 'graduate_fellow'
    )
  ),
  'meta_key' => 'person_family_name',
  'orderby' => 'meta_value',
  'order' => 'asc'
);

query_posts($args);
if (have_posts()) : ?>

<ul class="people graduate_fellows">
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <li class="vcard">
    <h2 class="fn"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php echo get_avatar($customFields['person_email'][0],120); ?></a>
    <?php if ($title = str_replace(' | ', '<br>',$customFields['person_title'][0])): ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>

  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
</div>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>
