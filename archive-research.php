<?php get_header(); ?>
<h1>Research</h1>
<?php 
global $query_string;

$query_string = $query_string . '&posts_per_page=-1&meta_key=research_status&orderby=title&order=asc';

query_posts( $query_string . '&meta_value=current' );
if (have_posts()) : ?>
<div id="current-research">
<ul class="projects labnotes-page-children">
<?php while (have_posts()) : the_post(); ?>
<li>
  <p><a href="<?php the_permalink(); ?>" class="permalink"><?php the_title(); ?></a> &ndash; 
  <?php echo get_the_excerpt(); ?>
  </p>
</li>
<?php endwhile; ?>
</ul>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php 
query_posts( $query_string . '&meta_value=archived' );
if (have_posts()) : ?>
<div id="archived-research">
<h2>Previous Research</h2>
<ul class="projects labnotes-page-children">
<?php while (have_posts()) : the_post(); ?>
<li>
  <p><a href="<?php the_permalink(); ?>" class="permalink"><?php the_title(); ?></a> &ndash; 
  <?php echo get_the_excerpt(); ?>
  </p>
</li>
<?php endwhile; ?>
</ul>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>

