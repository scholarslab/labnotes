<?php get_header(); ?>

<?php if (have_posts()) : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
<header>
    <h1><?php the_title(); ?></h1>
    <?php if ( $title = $customFields['person_title'][0] ) : ?>
    <p class="title"><?php echo $title; ?></p>
<?php endif; ?>
</header>
<div class="entry-content">
<?php the_content(); ?>

<?php

if ($customFields['person_user_id'][0] > 0) :

// Create a posts query for all the current author's posts.
$args = array(
'posts_per_page' => -1,
'author' => $customFields['person_user_id'][0]
);

query_posts($args);

if (have_posts()) : ?>
<div id="author-posts">
<h2>Posts by <?php echo $customFields['person_given_name'][0]; ?></h2>
<ul class="posts-list">

<?php while (have_posts()) : the_post(); ?>
<li><span class="post-meta"><?php the_time('F j, Y'); ?></span> <a href="<?php echo the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a></li>
<?php endwhile; ?>

</ul>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php endif; ?>
</div>

<?php endwhile; ?>
</article>
<?php endif; ?>

<?php get_footer(); ?>
