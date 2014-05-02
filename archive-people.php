<?php get_header(); ?>

<header>
<?php
if ($category = get_query_var('people-category')) {

    $heading = ucwords(str_replace('-', ' ', $category));

} else {
   $heading = 'People';
}

?>    
    <h1><?php echo $heading; ?></h1>
</header>
<?php if (have_posts()) : ?>
<ul class="people-list">
<?php while( have_posts() ) : the_post(); ?>
<li>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php get_footer(); ?>
