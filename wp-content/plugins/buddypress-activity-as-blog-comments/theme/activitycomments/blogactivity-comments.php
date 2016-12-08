
<?php do_action( 'bp_before_activity_blog_comments_loop' ) ?>

<?php if ( bp_activity_blog_comments_has_activities() ) : ?>

	<?php include( bp_activity_blog_comments_locate_template( array( 'activitycomments/blogactivity-loop.php' ), false ) ) ?>

<?php endif; ?>

<?php do_action( 'bp_after_activity_blog_comments_loop' ) ?>