<section id="blog-archives">
<h1>Archives</h1>

    <div id="by-taxonomy">
        <h2>Categories</h2>
        <ul class="categories">
        <?php wp_list_categories('title_li='); ?>
        </ul>

        <h2>Tags</h2>
        <?php wp_tag_cloud(); ?>
    </div>

    <div id="by-date">
        <h2>Recent Posts</h2>
        <ul class="postbypost">
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
        </ul>

        <h2>Posts by Year</h2>
        <ul class="yearly">
        <?php wp_get_archives('type=yearly'); ?>
        </ul>
    </div>

</section>
