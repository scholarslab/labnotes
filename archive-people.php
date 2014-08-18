<?php get_header(); ?>

<?php

$defaultArgs = array('post_type' => 'people', 'posts_per_page' => -1, 'meta_key' => 'person_family_name', 'orderby' => 'meta_value', 'order' => 'asc');

// Merge the  and $staff args into our defaults.
$staffArgs = array_merge($defaultArgs, array('people-category' => 'staff'));

$studentAssistantArgs = array_merge($defaultArgs, array('people-category' => 'student-assistant'));

$currentFellowArgs = array_merge($defaultArgs, array('people-category' => '2014-2015-praxis-fellow, 2014-2015'));

?>

<header>
    <h1>People</h1>
</header>

<?php

$current = array(
    'meta_query' => array(
        array(
        'key'=>'person_status',
        'value'=> 'current',
        'compare' => '='
        )
    )
);

$currentStaffArgs = array_merge($staffArgs, $current);

query_posts($currentStaffArgs);
if (have_posts()) : ?>
<h2><?php echo single_cat_title(); ?></h2>
<ul class="people-list current">
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

<?php

$currentStudentArgs = array_merge($studentAssistantArgs, $current);
    
query_posts($currentStudentArgs);
if (have_posts()) : ?>
<h3>Student Assistants</h3>
<ul class="people-list current">
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

<?php

query_posts($currentFellowArgs);
if (have_posts()) : ?>
<h2>Current Fellows</h2>
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

<?php


$alumniArgs = array(
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => 'person_status',
            'value' => 'current',
            'compare' => '!='
        ),
        array(
            'key' => 'person_status',
            'compare' => 'NOT EXISTS'
        )
    ),
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'person_family_name',
            'compare' => 'EXISTS'
        )
    ),
    'post_type' => 'people',
    'posts_per_page' => -1,
    'meta_key' => 'person_family_name',
    'orderby' => 'meta_value',
    'order' => 'asc'
);

$foo = query_posts($alumniArgs);

if (have_posts()) : ?>
<h2>Alumni</h2>
<ul class="people-list">
<?php while( have_posts() ) : the_post(); ?>
<li>
<a href="<?php the_permalink(); ?>">
    <?php the_title(); ?>
</a>
</li>
<?php endwhile; ?>
</ul>
<?php endif; ?>
<?php wp_reset_query(); ?>


<?php get_footer(); ?>
