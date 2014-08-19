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

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'labnotes' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'labnotes_comment' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav">
            <ul>
			<li class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'labnotes' ) ); ?></li>
			<li class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'labnotes' ) ); ?></li>
			</ul>
		</nav>
		<?php endif; // check for comment navigation ?>

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
