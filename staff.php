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
  'people-category' => 'staff',
  'orderby' => 'menu_order',
  'order' => 'asc'
);

/**
 * We want to separate the staff listing by department, so we need to narrow 
 * down our $defaultArgs for each department.
 */

// Get an array of our departments and loop through them.
$departments = array(array('administration' => 'Administration', 'its_research' => 'ITS Research Computing'), array('reseach_and_development' => 'Research & Development', 'gis_data' => 'Geospatial Information & Data Services'), array('public_service' => 'Outreach & Public Service'));
?>

<?php foreach ($departments as $departmentArray):?>
<div class="department">
<?php foreach ($departmentArray as $field => $title):
  
  // Add additional argument so that 'person_department' equals our current 
  // departent label.
  $deptArgs = array(
    'meta_query' => array(
      array(
        'key' => 'person_department',
        'value' => $field
      )
    )
  );

// Now, merge our additional department args into the defaultArgs set earlier, 
// and query posts with them. This *should* get only people who are staff and 
// who are in this particular departent in our foreach loop, ordered by menu 
// order.
$args = array_merge($defaultArgs, $deptArgs);
query_posts($args);
if (have_posts()) : ?>
<h2><?php echo $title; ?></h2>
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
<?php endforeach; ?>
</div>
<?php endforeach; ?>
</div>
<?php get_footer(); ?>
