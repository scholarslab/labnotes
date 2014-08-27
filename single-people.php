<?php get_header(); ?>

<?php if (have_posts()) : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php while (have_posts()) : the_post(); ?>
<?php $customFields = get_post_custom(); ?>
<header>
    <?php if ($image = labnotes_custom_background_image_src()) : ?>
    <div class="person-image">
    <img src="<?php echo $image; ?>" alt="" />
</div>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php if ( $title = $customFields['person_title'][0] ) : ?>
    <p class="title"><?php echo $title; ?></p>
    <?php endif; ?>

    <p class="contacts">
    <?php if ($email = $customFields['person_email'][0]): ?>
    <a class="email" href="mailto://<?php echo antispambot($email); ?>">
        <i class="fa fa-envelope"></i>
        <?php echo antispambot($email); ?>
    </a>
    <?php endif; ?>

    <?php if ($phone = $customFields['person_phone'][0]): ?>
    <span class="phone">
        <i class="fa fa-phone"></i>
        <?php echo $phone; ?>
    </span>
    <?php endif; ?>

    <?php if ($url = $customFields['person_url'][0]): ?>
    <a class="url" href="<?php echo $url; ?>">
        <i class="fa fa-external-link"></i>
        Website
    </a>
    <?php endif; ?>

    <?php if ($twitter = $customFields['person_twitter'][0]): ?>
    <a class="twitter" href="http://twitter.com/<?php echo $twitter; ?>">
        <i class="fa fa-twitter"></i>
        Twitter
    </a>
    <?php endif; ?>

    </p>
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
