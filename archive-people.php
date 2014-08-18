<?php get_header(); ?>

<?php

$defaultArgs = array('post_type' => 'people', 'posts_per_page' => -1, 'meta_key' => 'person_family_name', 'orderby' => 'meta_value', 'order' => 'asc');

// Merge the  and $staff args into our defaults.
$staffArgs = array_merge($defaultArgs, array('people-category' => 'staff'));

?>
<header>
    <h1>People</h1>
</header>

<?php
query_posts($staffArgs);
if (have_posts()) : ?>
<h2><?php echo single_cat_title(); ?></h2>
<ul class="people-list">
<?php while( have_posts() ) : the_post(); ?>
<li>
<a href="<?php the_permalink(); ?>">
    <img src="<?php echo labnotes_people_image(); ?>" alt="" />
    <?php the_title(); ?>
</a>
</li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>


<?php get_footer(); ?>
