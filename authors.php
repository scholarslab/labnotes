<?php
/*
 * Template Name: Authors
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<ul class="authors">
<?php
$authors = labnotes_get_users_order_by_usermeta();
foreach ($authors as $author):
  $authorId = $author->ID;
  $authorInfo = get_userdata($authorId);
?>
<li>
    <h2><?php echo $authorInfo->user_firstname; ?> <?php echo $authorInfo->user_lastname; ?></h2>
    <?php echo get_avatar($authorId, 125); ?>
    <div class="author-meta">
        <?php echo wpautop($authorInfo->description); ?>
        <p>
        <?php if ($twitter = get_the_author_meta('twitter', $authorId)): ?><span>Twitter: <a href="http://twitter.com/<?php echo $twitter; ?>">@<?php echo $twitter; ?></a></span><?php endif; ?>
        <?php if ($twitter = get_the_author_meta('twitter', $authorId) && $url = get_the_author_meta('user_url', $authorId)): ?><span>&nbsp;|&nbsp;</span><?php endif; ?>
        <?php if ($url = get_the_author_meta('user_url', $authorId)): ?><span>Site: <a href="<?php echo $url; ?>"><?php echo $authorInfo->user_firstname; ?>&#8217;s Site</a></span><?php endif; ?>
        </p>
    </div>
</li>
<?php endforeach; ?>
</ul>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
