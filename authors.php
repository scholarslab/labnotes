<?php
/*
 * Template Name: Authors
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>

<ul class="authors">
<?php
$authors = slab_get_users_order_by_usermeta();
foreach ($authors as $author):
  $authorId = $author->ID;
  $authorInfo = get_userdata($authorId);
?>

  <li>
  <?php echo get_avatar($authorId, 200); ?>
<a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo $authorInfo->user_firstname; ?> <?php echo $authorInfo->user_lastname; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
