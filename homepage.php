<?php
/*
 * Template Name: Home Page
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section id="homepage-blurb">
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>

<?php endwhile; endif; ?>
</section>

<div class="widgets">
<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
</div>

<div id="recent-activity">
<section id="latest-posts">
    <h1>Latest Posts</h1>
<?php
global $post;
$args = array( 'posts_per_page' => 3);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : 
  setup_postdata( $post ); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <p class="post-meta">By <?php the_author(); ?> &middot; <?php the_time('F j, Y'); ?> &middot; <?php the_category(', '); ?></p>

        <div class="excerpt">
        <?php the_excerpt(); ?>
        </div>
    </article>
<?php endforeach;
wp_reset_postdata(); ?>
</section>
<section id="upcoming-events">
<h1>Upcoming Events</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliter enim nosmet ipsos nosse non possumus. Duo Reges: constructio interrete. Deinde dolorem quem maximum? Conferam tecum, quam cuique verso rem subicias; Portenta haec esse dicit, neque ea ratione ullo modo posse vivi; Tum Lucius: Mihi vero ista valde probata sunt, quod item fratri puto. Ita fit beatae vitae domina fortuna, quam Epicurus ait exiguam intervenire sapienti. Cur tantas regiones barbarorum pedibus obiit, tot maria transmisit? </p>
<p>Sine ea igitur iucunde negat posse se vivere? Omnia contraria, quos etiam insanos esse vultis. </p>
<p>Utilitatis causa amicitia est quaesita. Ut in geometria, prima si dederis, danda sunt omnia. Negat esse eam, inquit, propter se expetendam. Quae cum dixisset, finem ille. Quamquam haec quidem praeposita recte et reiecta dicere licebit. Sic enim censent, oportunitatis esse beate vivere. Ita ceterorum sententiis semotis relinquitur non mihi cum Torquato, sed virtuti cum voluptate certatio. Quia dolori non voluptas contraria est, sed doloris privatio. </p>
</section>
</div>
<?php get_footer(); ?>
