<?php get_header(); ?>

<?php

$defaultArgs = array('post_type' => 'research', 'posts_per_page' => -1);

$researchCategories = array(
    'scholars-lab',
    'collaboration'
);

?>

<header>
    <h1><?php _e( 'Research', 'labnotes' ); ?></h1>
</header>

<?php

foreach ($researchCategories as $category):

$categoryArgs = array(
    'research-category' => $category
);

$args = array_merge($defaultArgs, $categoryArgs);

query_posts($args);

if ( have_posts() ) : 

?>
<h2><?php single_cat_title(); ?></h2>
<div class="category-description"><?php echo category_description(); ?></div>
<ul class="research">
<?php while (have_posts()) : the_post(); ?>
<li>
    <a href="<?php the_permalink(); ?>" class="permalink">
    <?php the_post_thumbnail('full'); ?>
    <h2><?php the_title(); ?></h2>
    </a>
</li>
<?php endwhile; ?>
</ul>
<?php endif; wp_reset_query(); endforeach; ?>

<?php get_footer(); ?>
