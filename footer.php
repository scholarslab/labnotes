  </div>

  <footer role="contentinfo">

    <div class="vcard" id="slab-vcard">
        <div><a href="http://scholarslab.org" class="fn org url">Scholars' Lab</a></div>
        <div><a href="http://www.library.virginia.edu" class="url">University of Virginia Library</a></div>
        <div class="street-address">P.O. Box 400129</div>
        <div>
            <span class="locality">Charlottesville</span>,
            <abbr class="region" title="Virginia">VA</abbr>
            <span class="postal-code">22904-4129</span>
        </div>
        <div class="tel"><abbr class="type" title="work">T:</abbr> <span class="value">434.243.8800</span></div>
        <div class="tel"><abbr class="type" title="fax">F:</abbr> <span class="value">434.924.1431</span></div>
    </div>

    <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => 'nav', 'container_class' => 'menu', 'depth' => '1' ) ); ?>

  <div id="social-media">
<?php
$socialMedia = array(
  'twitter' => 'http://twitter.com/scholarslab',
  'facebook' => 'https://www.facebook.com/scholarslab',
  'googleplus' => 'https://plus.google.com/114472010795641313811',
  'vimeo' => 'https://vimeo.com/scholarslab',
  'github' => 'http://github.com/scholarslab/'
);

foreach ($socialMedia as $n => $v): ?>
    <a href="<?php echo $v; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/<?php echo $n; ?>.png"></a>
<?php endforeach; ?>
  </div>
    <?php wp_footer(); ?>
  </footer>
</body>
</html>
