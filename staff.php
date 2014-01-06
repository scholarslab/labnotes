<?php
/*
 * Template Name: Staff
 */
?>
<?php get_header(); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<div style="overflow:hidden;">
<?php

/**
 * An array of additional arguments we want to pass to the query.
 *
 * These include:
 * - Get all the posts
 * - Get only posts where the 'person_category' is set to 'staff'
 * - Order by the menu_order field
 * - Order them ascending.
 */
$defaultArgs = array(
  'post_type' => 'people',
  'posts_per_page' => '-1',
  'orderby' => 'meta_value',
  'order' => 'asc',
  'meta_key'=>'person_family_name'
);
 
$staffArgs = array_merge($defaultArgs, array('people-category' => 'staff'));
query_posts($staffArgs);
if (have_posts()) : ?>
<h2>Staff</h2>
<ul class="staff">
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <li class="vcard">
    <a href="<?php the_permalink(); ?>"><?php echo get_person_image(); ?></a>
    <h3 class="fn"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php if ($title = str_replace(' | ', '<br>',$customFields['person_title'][0])): ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>
  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php
$staffArgs = array_merge($defaultArgs, array('people-category' => 'student-assistant'));
query_posts($staffArgs);
if (have_posts()) : ?>
<h2>Students</h2>
<ul class="staff">
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <li class="vcard">
    <a href="<?php the_permalink(); ?>"><?php echo get_person_image(); ?></a>
    <h3 class="fn"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php if ($title = str_replace(' | ', '<br>',$customFields['person_title'][0])): ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>
  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>

</div>
<?php get_footer(); ?>
