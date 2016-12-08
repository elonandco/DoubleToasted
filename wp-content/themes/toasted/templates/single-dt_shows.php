<?php
/**
 * @package Frank
 * This is the template for single show pages
 */
?>

<?php wp_enqueue_style( 'flow-css', get_template_directory_uri() . '/modules/scripts/skin/minimalist.css'  ); ?>

<?php get_header(); ?>

<div class="main single dt-single-show-type show-simple-comments">

	<div class="content full-width dt-media">

		<div class="content">

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

					<div id="dt-media-header" class="clear">

						<div class="large-7 medium-6 columns">

							<?php

								$hideCrumbs = false;

								// Does this show belong to a series?
								$dtSeries = wp_get_post_terms( $post->ID, 'series' );
								if ($dtSeries && !is_wp_error( $dtSeries )) {

									// Default to Category Parent (if it exists)
									$howManyTerms = count($dtSeries);
									$i = 0;

									if ($howManyTerms >= 2) {
										$i = $howManyTerms - 1;
										$dtSeries[0]->term_id = $dtSeries[$i]->term_id;

									}

									$dtTitle = $dtSeries[$i]->name;
									$dtLink = $dtSeries[$i]->slug;

									echo '<h1>' . $dtTitle . '</h1>';

								 }

								else {

									// If no series title set to show title
									echo '<h1>' . $post->post_title . '</h1>';
									$dtTitle = 'Misc';
									$dtLink = '';

								 }

								 if ($dtLink == 'reviews') {
										$hideCrumbs = true;
								}

							?>



							<p class="dt-crumbs">

								<?php if ($hideCrumbs) { ?>

									<a href="/reviews/">Reviews</a> >
									<span><?php echo $post->post_title; ?></span>

								<?php } else { ?>

									<a href="/all-shows/">Shows</a> >
									<a href="/shows/<?php echo $dtLink ?>/"><?php echo $dtTitle; ?></a> >
									<span><?php echo $post->post_title; ?></span>

								<?php } ?>

							</p>

						</div>

						<div class="post-paging large-5 medium-6 columns single-nav">

							<?php get_template_part( 'modules/post-nav-social' ); ?>

						</div>

					</div>

					<div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">

						<?php

							$liveShow = false;

							// Is this show Live!?
							global $onAirPostData;
							if ($onAirPostData[0]["ID"] == $post->ID) {
								$liveShow = true;
							}

							// Check if user has purchased this particular episode
							$productID = get_post_meta( $post->ID, '_lac0509_dt-show-sku', true );
							$currentUser = wp_get_current_user();

							if ($productID) {

								$subStatus = WC_Subscriptions_Manager::user_has_subscription( $user_id = $currentUser->ID, $product_id = '', $status = 'active' );

								if ($subStatus) {
									$hasAccess = true;
								}

								else if ( woocommerce_customer_bought_product( $currentUser->user_email, $currentUser->ID, $productID)) {
									$hasAccess = true;
								}

							}

							$freeShow 		= get_post_meta( $post->ID, '_lac0509_dt-free-show', true );
							$audiourl 		= get_post_meta( $post->ID, '_lac0509_dt-audio-url', true );

							if ($freeShow || $videoGigcaster) {
								$hasAccess = true;
							}

							// User has purchased, show the thing
							if ($hasAccess) {

								// If it's a VOD video
								if (!$liveShow) {

									$videoSD = get_post_meta( $post->ID, '_lac0509_dt-video-url', true );
									$videoHD = get_post_meta( $post->ID, '_lac0509_dt-video-url-hd', true );
									$imageThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'md-video');

									echo '<div id="dt-flow-vid-wrap" style="position:relative;background:black;">';

									if ($videoGigcaster) { ?>
										<div class="" style="position:relative; text-align: center;">
											<iframe src="http://ppv.gigcasters.com/embed/<?php echo $blastroID; ?>.html"
													width="1024" height="768" scrolling="no" frameborder="0">[Your browser does
												not support frames or is currently
												configured not to display frames. Please use an up-to-date browser that is
												capable of displaying frames.]
											</iframe>
										</div>
									<?php } elseif ($videoSD) { ?>

										<div class="flowplayer flow-sd" style="position:relative;">
										  <video src="http://doubletoasted.com/wp-content/uploads/ppv-video/<?php echo $videoSD; ?>"></video>
									   </div>

										<?php if ($videoHD) { ?>

										   <div class="flowplayer flow-hd" style="position:absolute;display:none;top:0px;">
											  <video src="http://doubletoasted.com/wp-content/uploads/ppv-video/<?php echo $videoHD; ?>"></video>
										   </div>

										   <a id="dt-hd-toggle" style="display:none;position:absolute;top:20px;left:20px;text-decoration:none;background:black;padding: 10px 20px 10px 15px;border-radius:10px;color: white;z-index:200;font-size: 40px;font-weight:700;font-style: italic;">SD</a>

										<?php }

										echo '</div>';

										echo '<a class="fl-right" id="dt-premium-user-audio">Click here for the audio only version</a>';
										echo '<div style="display:none;" id="dt-premium-audio">' . wp_oembed_get( $audiourl ) . '</div>';

									}

									else if (!$videoSD && !$videoHD) {
										echo '<h2 style="color:white;padding:70px 30px;background:black;">This show is still toasting, it should be up within 24 hours.</h2></div>';
									}

									else {
										echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is a problem with that video file.</h2></div>';
									}

								}

								// If it's a live stream
								else {

									$blastroID = get_post_meta( $post->ID, '_lac0509_dt-blastro-id', true );

									if ($blastroID) {

										require_once('templates/blastro/BlCrypto.php');

                                		echo '<div style="text-align: center; background-color: black;">
		                                        <iframe src="https://ppv.gigcasters.com/embed/' . $blastroID . '.html"
		                                                    width="1066" height="650" scrolling="no" frameborder="0">[Your browser does
		                                                not support frames or is currently
		                                                configured not to display frames. Please use an up-to-date browser that is
		                                                capable of displaying frames.]
		                                            </iframe>
		                                      </div>';
									}

									else {

										echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is an issue with the livestream ID.</h2>';

									}

								}

							}

							// Not purchased, show options
							else {

								$videourl = get_post_meta( $post->ID, '_lac0509_dt-preview-video-url', true );
								$imageThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'md-video');

								// Just have audio and free, show the audio player
								if ($audiourl && !$videourl && !$productID) {
									$htmlaudio = wp_oembed_get( $audiourl );
									echo '<div id="dt-audio-only-choice">' . $htmlaudio . '</div>';
									//echo '<h3>test</h3>';
									//echo '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/164974625&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
								}

								// We have options and/or this is a VOD product
								else {

							?>

									<div id="dt-video-option" style="position:relative;">

										<div id="dt-option-content" style="position:relative;z-index:1;">

												<?php

													// If there is an associated product ID, give user the option to purchase
													if ($productID && !$liveShow && ( $audiourl || $videourl ) ) {

														echo '<h2>Full length video episodes are available on demand or by subscription</h2>';
														echo '<a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy Video</a>';
														echo '<a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a>';

														// If there is an associated audio URL, give user the option to listen for free
														if ($audiourl) {
															echo '<a id="dt-audio-click">Listen to the full audio-only version.</a>';
														}

														// If there is an associated video preview URL, give user the option to view for free
														if ($videourl) {
															echo '<a id="dt-video-click">Watch the free short video version.</a>';
														}

													}

													// If this is a liveshow
													else if ($liveShow) {

														echo '<h2>We are live! You have 2 options to access the live show:</h2>';
														echo '<a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy This Stream</a>';
														echo '<a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a>';

													}

													// If this is a show in between being live and having available content, or if there is only paid video, no previews
													else if (!$audiourl && !$videourl) {

														// Check if there is paid content
														$videoSD = get_post_meta( $post->ID, '_lac0509_dt-video-url', true );

														// If no, this is a live-stream processing
														if (!$videoSD) {
															echo '<h2>This show is still toasting but we\'ll have it ready for you soon.</h2>';
														}

														// Paid Video Only
														else {

															echo '<h2>Full length video episodes are available on demand or by subscription</h2>';
															echo '<a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy Video</a>';
															echo '<a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a>';

														}
													}

													// Otherwise we have just a free show
													else {

														echo '<h2>Choose a format:</h2>';

														// If there is an associated audio URL, give user the option to listen for free
														if ($audiourl) {
															echo '<a id="dt-audio-click">Listen to the audio only version.</a>';
														}

														// If there is an associated video preview URL, give user the option to view for free
														if ($videourl) {
															echo '<a id="dt-video-click">Watch the video version.</a>';
														}

													}

												?>

										</div>

										<div style="opacity:.4;width:100%;height:100%;background-size:cover;z-index:0;position:absolute;top:0px;left:0px;background-image:url('<?php echo $imageThumb[0]; ?>');"></div>

									</div>

							<?php

									// Render the audio html
									if ($audiourl) {
										$htmlaudio = wp_oembed_get( $audiourl );
										echo '<div id="dt-audio-choice">' . $htmlaudio . '</div>';
										//echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/164974625&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>';

									}

									// Render the video html
									if ($videourl) {
										$htmlvideopre = wp_oembed_get( $videourl );
										echo '<div id="dt-video-choice">' . $htmlvideopre . '</div>';
									}

								}

							}

							?>

						<div class="clear dt-media-postinfo">

							<?php $rating = get_post_meta( $post->ID, '_lac0509_rev_rating', true ); ?>
							<?php $rating_mart = get_post_meta( $post->ID, '_lac0509_rev_mart_rating', true ); ?>

							<?php if ( $dtLink == 'reviews' && ( $rating || $rating_mart ) ) : ?>

								<div id="dt-review-content">

									<h1 class="post-title"><?php the_title(); ?></h1>

									<?php $time = get_post_meta( $recentPost["ID"], '_lac0509_dt-show-time', true ); ?>
									<?php $date = date( 'F j' , strtotime(get_the_date()) ) . ' '; ?>
									<?php if ($time) { $date .= ' at ' . date('g:ia',strtotime($time)); } ?>

									<?php $director = get_post_meta( $post->ID, '_lac0509_review_director', true ); ?>
									<?php $release = get_post_meta( $post->ID, '_lac0509_review_release', true ); ?>

									<?php if ($director || $release ) : ?>

										<h3><?php echo $date; if ($director) { echo '- Directed by ' . $director; } if ($release) echo ' - Released ' . $release; ?></h3>
										<?php $review = true; ?>

									<?php endif; ?>

									<?php if (!$review) { echo '<h3>' . $date . '</h3>'; } ?>

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

								<div id="dt-review-meta">

									<?php if ($rating) : ?>

										<h3>Korey's Rating</h3>
										<img src="/wp-content/themes/toasted/images/reviews-ratings-martini-<?php echo $rating; ?>.png" width="130" alt="Our Rating" />
										<?php $ratingterms = array( 'Unrated', 'FUCK YOU!!!', 'Some Ol’ Bullshit', 'Rental', 'Matinee', 'Full Price!', 'Better Than Sex!!!' ); ?>
										<p class="rating-term"><?php echo $ratingterms[$rating]; ?></p>

									<?php endif; ?>

									<?php if ($rating_mart) : ?>

										<h3 style="margin-top:20px;">Martin's Rating</h3>
										<img src="/wp-content/themes/toasted/images/reviews-ratings-martini-<?php echo $rating_mart; ?>.png" width="130" alt="Our Rating" />
										<?php $ratingterms = array( 'Unrated', 'FUCK YOU!!!', 'Some Ol’ Bullshit', 'Rental', 'Matinee', 'Full Price!', 'Better Than Sex!!!' ); ?>
										<p class="rating-term"><?php echo $ratingterms[$rating_mart]; ?></p>

									<?php endif; ?>

								</div>

							<?php else : ?>

								<div id="dt-review-content" style="width:100%;">

									<h1 class="post-title"><?php the_title(); ?></h1>

									<?php $time = get_post_meta( $post->ID, '_lac0509_dt-show-time', true ); ?>
									<?php $date = date( 'F j' , strtotime( get_the_date() ) ); ?>
									<?php if ($time) { $date .= ' at ' . date('g:ia',strtotime($time)); } ?>

									<?php $director = get_post_meta( $post->ID, '_lac0509_review_director', true ); ?>
									<?php $release = get_post_meta( $post->ID, '_lac0509_review_release', true ); ?>

									<?php if ($director || $release ) : ?>

										<h3><?php echo $date; if ($director) { echo '- Directed by ' . $director; } if ($release) echo ' - Released ' . $release; ?></h3>
										<?php $review = true; ?>

									<?php endif; ?>

									<?php if (!$review) { echo '<h3>' . $date . '</h3>'; } ?>
									<?php the_content(); ?>

								</div>

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

							<?php endif; ?>


						</div>

					</div>

			<?php endwhile; ?>

		</div>

	</div>

	</div>

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