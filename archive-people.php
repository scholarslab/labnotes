<?php

?>
<?php get_header(); ?>
<?php 
global $query_string;
query_posts( $query_string . '&posts_per_page=-1&meta_key=person_family_name&orderby=meta_value&order=asc' );
if (have_posts()) : ?>
<ul class="authors">
<?php while (have_posts()) : the_post(); ?>
<li>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php the_excerpt(); ?>
</li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
