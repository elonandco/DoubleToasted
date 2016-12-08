<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>

<div class="main single-news show-simple-comments">

	<div class="content full-width">

			<div class="">

				<div class="post-content clear">

					<div class="large-7 medium-6 columns">

						<h1 class="post-title"><?php the_title(); ?></h1>
						<h4>
							<?php

								$user = get_current_user_id();
								if ( get_the_author_meta('ID') == $user ) {

									$bpusername = bp_members_get_user_nicename($user);
									echo '<a href="/members/' . $bpusername . '/articles/new/?article=' . get_the_ID() . '">Edit Post</a>';

								}

							?>

						</h4>

					</div>

				</div>

			</div>

			<?php endwhile; ?>
			<div class="second-toolbar">
				<?php get_template_part( 'modules/post-nav-users-blog' ); ?>
			</div>
	</div>


	<?php dynamic_sidebar( 'dt-above-comments' ); ?>

	<div class="content clear" id="dt-side-comments">

		<div class="large-12 columns">
			<h2 id="dt-media-more">

				Comments

				<?php if (!is_user_logged_in()) { ?>

					<a class="button thickbox" href="#TB_inline?width=800&height=450&inlineId=dt-login" id="log-in-comment">Log-in to comment</a>

				<?php } ?>

			</h2>
		</div>

		<div class="activity large-9 medium-10 small-12 columns" role="main">

			<?php

				bp_get_template_part( 'activity/activity-loop-single' );

			?>

		</div><!-- .activity -->

		<div class="large-3 columns medium-2 small-12" style="text-align:center;">

			<?php

				dynamic_sidebar( 'dt-feature-single' );

			?>

		</div>

	</div>

</div><!-- .single.main -->

<!-- Plugin: BP EDITABLE ACTIVITY
	Had to manually que scripts for single show page comments -->

<?php wp_enqueue_script( 'jquery-ui-tooltip' ); ?>
<?php wp_enqueue_script( 'jquery-ui-button' ); ?>
<?php wp_enqueue_script( 'editable-activity', '/wp-content/plugins/bp-editable-activity/assets/editable-activity.js', array('jquery','jquery-editable') ); ?>
<?php wp_enqueue_script( 'jquery-editable', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/js/jqueryui-editable.min.js', array('jquery','jquery-ui-tooltip','jquery-ui-button') ); ?>

<?php wp_enqueue_style( 'jq-edit-ui-css', '/wp-content/plugins/bp-editable-activity/assets/jqui/jquery-ui-1.10.4.custom.css' ); ?>
<?php wp_enqueue_style( 'jqui-edit-css', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/css/jqueryui-editable.css' ); ?>

<?php
	$data = array(
		'edit_activity_title' => __( 'Edit Activity', 'bp-editable-activity' ),
		'edit_comment_title' => __( 'Edit Comment', 'bp-editable-activity')
	);

	wp_localize_script('editable-activity', 'BPEditableActivity', $data );
?>

<!-- end BP EDITABLE ACTIVITY -->

<?php get_footer(); ?>