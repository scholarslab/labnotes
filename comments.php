<?php
/**
 * Comments
 */
?>
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'labnotes' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>


    <?php

    $defaultArgs = array('post_id' => $post->ID, 'count' => true);

    $realComments = get_comments(array_merge($defaultArgs, array('type' => 'comment')));
    $tweets = get_comments(array_merge($defaultArgs, array('type' => 'social-twitter')));
    $pings = get_comments(array_merge($defaultArgs, array('type' => 'pings')));


    ?>

	<?php if ( have_comments() ) : ?>

        <?php if ($realComments): ?>
        <section id="default">
        <h2 class="comments-title"><?php echo count($realComments); ?> Comments</h2>
            <ol class="commentlist">
            <?php wp_list_comments('callback=labnotes_comment&type=comment'); ?>
            </ol>
        </section>
        <?php endif; ?>

        <?php if ($tweets): ?>
        <section id="tweetbacks">
        <h2 class="comments-title"><?php echo count($tweets); ?> Tweets</h2>
            <p class="commentlist">
            <?php wp_list_comments(array(

                'callback' => 'labnotes_comment',
                'type' => 'social-twitter'
            )); ?>
            </p>
        </section>
        <?php endif; ?>

        <?php if ($pings): ?>
        <section id="pingbacks">
            <h2 class="comments-title">Pingbacks</h2>
            <p class="commentlist">
            <?php wp_list_comments('callback=labnotes_comment&type=pings'); ?>
            </p>
        </section>
        <?php endif; ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'labnotes' ); ?></p>
	<?php endif; ?>

<?php

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$comment_notes_before = '<div class="comment-notes"><p>'
                      . __( 'Your email address will not be published.' )
                      . ( $req ? $required_text : '' )
                      . '</p><p>'
                      . sprintf(
                        __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
                            ' <code>' . allowed_tags() . '</code>'
                        )
                      . '</p></div>';

$args = array(
    'comment_notes_before' => $comment_notes_before,
    'comment_notes_after' => ''
);

comment_form($args);

?>

</div><!-- #comments -->
