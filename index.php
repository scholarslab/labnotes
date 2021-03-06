<?php get_header(); ?>

<?php if (is_search()): ?>
    <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'labnotes' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
<?php endif; ?>

<?php if (is_category()): ?>
    <header class="archive-header">
    <h1 class="page-title"><?php echo single_cat_title( '', false); ?></h1>
    <?php if ( category_description() ) : // Show an optional category description ?>
	<div class="archive-meta"><?php echo wpautop(category_description()); ?></div>
	<?php endif; ?>
    </header>
<?php endif; ?>

    <?php if (have_posts()) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                <?php if (is_singular(array('post', 'page'))): ?>
                <div class="custom-background"></div>
                <?php endif; ?>
                    <h1><a href="<?php the_permalink(); ?>" rel="permalink" title="Permanent link for <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                <?php if (is_singular('post') || is_home() || is_archive()): ?>
                    <p class="post-meta">By <?php the_author(); ?> &middot; <?php the_time('F j, Y'); ?></p>
                <?php endif; ?>
                </header>
                <div class="entry-content">
                <?php
                    if (is_single() || is_page()):
                        the_content();
                    else:
                        the_excerpt();
                    endif;
                ?>
                </div>
                <?php if (is_singular('post')): ?>
                    <footer>
                        <a class="author_image_link" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="See all posts by <?php echo get_the_author_meta('user_firstname'); ?>"><?php echo get_avatar(get_the_author_meta('ID'),120); ?></a>

                        <p class="author-name"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="byline" title="See all posts by <?php echo get_the_author_meta('user_firstname'); ?>"><?php echo get_the_author_meta('display_name'); ?></a></p>

                        <?php if ($description = get_the_author_meta('user_description')): ?>
                        <div class="author-description"><?php echo wpautop($description); ?></div>
                        <?php endif; ?>
                    </footer>
                <?php endif; ?>
                <?php if (is_page()): echo labnotes_display_page_children(); endif; ?>
            </article>
            <?php if(is_singular('post')): comments_template(); endif; ?>
        <?php endwhile; ?>
        <?php if (is_archive()): ?>
        <nav class="pagination">
            <ul>
                <li class="older"><?php next_posts_link('&larr; Older Posts') ?></li>
                <?php if (is_paged()): ?>
                    <li class="newer"><?php previous_posts_link('Newer Posts &rarr;') ?></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>

    <?php else: ?>
        <p>We couldn't find the posts you were looking for.</p>
    <?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
