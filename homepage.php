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
<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
</section>

<?php endwhile; endif; ?>

<div id="areas-of-focus">
<section id="research">
    <h1>Research</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Illud dico, ea, quae dicat, praeclare inter se cohaerere. Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae.</p>
</section>
<section id="fellowships">
    <h1>Fellowships</h1>
<p>Illud non continuo, ut aeque incontentae. Hoc loco tenere se Triarius non potuit. Paupertas si malum est, mendicus beatus esse nemo potest, quamvis sit sapiens.</p>
</section>
<section id="makerspace">
    <h1>Makerspace</h1>
<p>Recte, inquit, intellegis. Quo modo autem optimum, si bonum praeterea nullum est? Compensabatur, inquit, cum summis doloribus laetitia. Ita relinquet duas, de quibus etiam atque etiam consideret.</p>
</section>
<section id="events">
    <h1>Events</h1>
<p>Sic, et quidem diligentius saepiusque ista loquemur inter nos agemusque communiter. Nihil sane. Nihil enim hoc differt. Omnia contraria, quos etiam insanos esse vultis. Graccho, eius fere, aequalí?</p>
</section>
</div>

<?php get_footer(); ?>
