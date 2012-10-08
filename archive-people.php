<?php get_header(); ?>
<?php
$title = 'Staff';
if (@$_GET['category'] == 'graduate_fellow') {
  $title = 'Graduate Fellows';
}
?>

  <h1><?php echo $title; ?></h1>
<div style="overflow:hidden;">
<?php

// Get the current query.
global $wp_query;

if (@$_GET['category'] == 'graduate_fellow'):

$fellowArgs = array(
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

// Merge the wp_query and $staff args into our defaults.
$args = array_merge($wp_query->query, $fellowArgs);

query_posts($args);
if (have_posts()) : ?>

<ul class="people graduate_fellows">
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <li class="vcard">
    <?php echo get_avatar($customFields['person_email'][0],120); ?></a> 
    <h2 class="fn"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php if ($title = str_replace(' | ', '<br>',$customFields['person_title'][0])): ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>
  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>


<?php

else:

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
?>

<?php
/**
 * We want to separate the staff listing by department, so we need to narrow 
 * down our $defaultArgs for each department.
 */

// Get an array of our departments and loop through them.
$departments = array(array('administration' => 'Administration', 'its_research' => 'ITS Research Computing'), array('reseach_and_development' => 'Research & Development', 'gis_data' => 'Geospatial Information & Data Services'), array('public_service' => 'Outreach & Public Service'));
?>

<?php foreach ($departments as $departmentArray):?>
<div class="column">
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
<ul class="people staff">
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
  <li class="vcard">
    <?php echo get_avatar($customFields['person_email'][0],120); ?></a> 
    <h3 class="fn"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php if ($title = str_replace(' | ', '<br>',$customFields['person_title'][0])): ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>
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

    </ul>
  </li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>
