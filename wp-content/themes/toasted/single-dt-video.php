<?php
/**
 * @package Frank
 * This is the template for single show pages
 */
?>

<?php wp_enqueue_style( 'flow-css', get_template_directory_uri() . '/modules/scripts/skin/minimalist.css'  ); ?>

<?php get_header(); ?>

<div class="main single single-video show-simple-comments">

	<div class="content full-width dt-media">

		<div class="content">

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

					<div id="dt-media-header" class="clear">

						<div class="large-7 medium-6 columns">

							<?php echo '<h1>' . $post->post_title . '</h1>'; ?>

							<p class="dt-crumbs"><a href="/videos/">Videos</a> > <span><?php echo $post->post_title; ?></span></p>

						</div>

						<div class="post-paging large-5 medium-6 columns single-nav">

							<?php get_template_part( 'modules/post-nav-social' ); ?>

						</div>

					</div>

					<div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">

						<?php

							$videourl = get_post_meta( $post->ID, '_lac0509_dt-preview-video-url', true );

							if ($videourl) {

								$htmlvideopre = wp_oembed_get( $videourl );
								echo '<div id="dt-video-choice" style="display:block;">' . $htmlvideopre . '</div>';

							}

							else {

								$videoSD = get_post_meta( $post->ID, '_lac0509_dt-video-url', true );

								if ($videoSD) { ?>

									<div id="dt-flow-vid-wrap" style="position:relative;background:black;">
										<div class="flowplayer flow-sd" style="position:relative;">
										  <video src="http://doubletoasted.com/wp-content/uploads/ppv-video/<?php echo $videoSD; ?>"></video>
									   </div>
									</div>

								<?php


								} else {

									echo '<div id="dt-flow-vid-wrap" style="position:relative;background:black;">';
									echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is a problem with that video file.</h2>';
									echo '</div>';

								}

							}

						?>

						<div class="clear dt-media-postinfo">

							<h1 class="post-title"><?php the_title(); ?></h1>
							<?php the_content(); ?>

							<div class="dt-post-meta-single">

								<?php

									// Get Favorite Count
									if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . $post->ID ) ) {
										while ( bp_activities() ) : bp_the_activity();

										$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );
										if (!$my_fav_count >= 1)
											$my_fav_count = 0;
										echo '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
										endwhile;

									}

									// Get Comment Count
									echo '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';

								?>

							</div>

						</div>

					</div>

			<?php endwhile; ?>

		</div>
	</div>

	<?php

		// Show more videos carousel

		//$args = array(
		//	'numberposts' => 16,
		//	'orderby' => 'post_date',
		//	'exclude' => $post->ID,
		//	'order' => 'DESC',
		//	'post_type' => 'dt-video'
		//);

		//$homeQ = wp_get_recent_posts( $args, ARRAY_A );

		//if ($homeQ) {

			//echo '<div class="content more-shows"><div class="large-12 columns"><h2 id="dt-media-more">More Videos</h2><div id="dt-single-slider">';

			//foreach ($homeQ as $recentPost) {

			//	echo '<a href="' . get_the_permalink($recentPost["ID"]) . '">' . get_the_post_thumbnail($recentPost["ID"], 'sm-archive');
			//	echo '<span class="dt-ep">' . $recentPost["post_title"] . '</span>';
			//	echo '</a>';

			//}

			//echo '</div></div></div>';

		//}

	?>

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

<?php wp_enqueue_script( 'flowplayer', get_template_directory_uri() . '/modules/scripts/flowplayer.min.js', 'jquery' ); ?>

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

<script>

jQuery(document).ready(function() {
	jQuery('#dt-hd-toggle').fadeIn();
});


jQuery('#dt-flow-vid-wrap').hover(

	function() {
		jQuery('#dt-hd-toggle').fadeIn(100);
	},
	function() {
		jQuery('#dt-hd-toggle').delay(300).fadeOut(100);
	}

);

jQuery('#dt-premium-user-audio').click(function() {

	jQuery(this).fadeOut(300);
	jQuery('#dt-flow-vid-wrap').slideUp(300);
	jQuery('#dt-premium-audio').slideDown(400);

});

jQuery('#dt-hd-toggle').click(function() {

	var sdvid = jQuery('.flow-sd');
	var hdvid = jQuery('.flow-hd');
	var playing, switchto;

	if (hdvid.hasClass('active')) {
		playing = hdvid;
		switchto = sdvid;
		jQuery(this).text('SD');
	}

	else {
		playing = sdvid;
		switchto = hdvid;
		jQuery(this).text('HD');
	}

	if (hdvid.length > 0) {

		var setHt = jQuery('#dt-flow-vid-wrap').height();
		jQuery('#dt-flow-vid-wrap').height(setHt);

		// Make the switch
		var currentTime = playing.flowplayer().video.time;
		playing.flowplayer().stop();
		playing.fadeOut(500).toggleClass('active');
		switchto.fadeIn(500).toggleClass('active');
		switchto.flowplayer().seek(currentTime).play();

	}

});

</script>