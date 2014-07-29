<section id="blog-archives">
<h1>Archives</h1>

    <div id="by-taxonomy">
        <div id="by-category">
        <h2>Categories</h2>
        <ul class="categories">
        <?php wp_list_categories('title_li='); ?>
        </ul>
        </div>

        <div id="by-tag">
        <h2>Tags</h2>
        <?php wp_tag_cloud(); ?>
        </div>
    </div>

    <div id="by-date">
        <div id="by-recent">
        <h2>Recent Posts</h2>
        <ul class="postbypost">
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
        </ul>
        </div>
        <div id="by-year">
        <h2>Posts by Year</h2>
        <ul class="yearly">
        <?php wp_get_archives('type=yearly'); ?>
        </ul>
        </div>
    </div>

</section>
