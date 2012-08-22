<?php get_header(); ?>
<h1>Staff</h1>
<?php

// Get the current query.
global $wp_query;

/**
 * An array of additional arguments we want to pass to the query.
 *
 * These include:
 * - Get all the posts
 * - Get only posts where the 'person_category' is set to 'staff'
 * - Order by the menu_order field
 * - Order them ascending.
 */
$staffArgs = array(
  'posts_per_page' => '-1',
  'meta_query' => array(
    array(
      'key' => 'person_category',
      'value' => 'staff'
    )
  ),
  'orderby' => 'menu_order',
  'order' => 'asc'
);

// Merge the wp_query and $staff args into our defaults.
$defaultArgs = array_merge($wp_query->query, $staffArgs);

/**
 * We want to separate the staff listing by department, so we need to narrow 
 * down our $defaultArgs for each department.
 */

// Get an array of our departments and loop through them.
$departments = labnotes_people_departments();
foreach ($departments as $field => $title):
  
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
<ul class="authors">
<?php while (have_posts()) : the_post(); ?>
  <li>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php the_excerpt(); ?>
  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php endforeach; ?>
<?php get_footer(); ?>
