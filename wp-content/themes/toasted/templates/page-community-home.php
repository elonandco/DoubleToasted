<?php
/**
 * @package Frank
 */
/*
Template Name: Community/Top Posts
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_activity_loop' ); ?>

<div id="buddypress">

<div class="activity" role="main">

<div class="main community-home top-posts">
<img src="../wp-content/themes/toasted/images/DT_banner-Community-v2.gif" class="top-banner">
	<div class="content full-width">
		<div class="content">

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

				<div class="large-7 medium-4 small-12 columns">

					<h1><?php the_title(); ?></h1>

				</div>

				<div class="large-5 medium-8 small-12 columns community-user-action">

					<div style="float:right;">
					<?php if (is_user_logged_in()) { ?>
						<?php $bpusername = bp_members_get_user_nicename( get_current_user_id() ); ?>
						<a class="dt-usr-btn dt-btn-orange" href="/members/<?php echo $bpusername; ?>/">My Friend Feed</a>
						<a class="dt-usr-btn dt-btn-dkblue" href="/members/<?php echo $bpusername; ?>/activity/groups/">My Group Feed</a>
						<a class="dt-usr-btn dt-btn-blue" href="/members/<?php echo $bpusername; ?>/activity/mentions/">My Wall</a>
					<?php } ?>
					</div>

				</div>

				<div class="post-content large-12 medium-12 columns">

					<?php

						if ( ! is_user_logged_in() ) {

							the_content();

						}

					?>

				</div>

			<?php endwhile; ?>
		</div>
	</div>
	<div class="divider top"></div>

	<div class="content top">

		<div class="large-8 columns">

			<div class="most-popular">
				<h3 class="first-title">Most Popular</h3>

				<ul id="activity-stream" class="activity-list item-list listless">
					<?php

						global $wpdb;
						global $bp;
						global $activities_template;

						$last_month = date( 'Y-m-d', strtotime("3 months ago") );

						// Get our most popular/commented activity ID's direct from the Database
						$results = $wpdb->get_results( 'SELECT id
															FROM wp_bp_activity, wp_postmeta
															WHERE (wp_postmeta.meta_key = "dt_reply_count"
																AND wp_bp_activity.id = wp_postmeta.post_id
																AND wp_bp_activity.date_recorded > "'.$last_month.'"
																AND wp_bp_activity.type <> "new_blog_post"
																AND wp_bp_activity.type <> "activity_comment" )
															ORDER BY meta_value DESC LIMIT 5', ARRAY_N );

						// Convert the array to a string value
						foreach ($results as $result) {
							$most_popular .= $result[0] . ',';
						}

						// Remove the trailing slash
						$most_popular = rtrim($most_popular, ",");

						// Run the BuddyPress Loop w/ our activity id's
						$args = '&scope=false&include='.$most_popular.'&display_comments=threaded';
						if ( bp_has_activities( $args ) ) {
							while ( bp_activities() ) : bp_the_activity();
								bp_get_template_part( 'activity/entry' );
							endwhile;
						}

					?>
				</ul><!-- Most Popular Activities -->

			</div>

			<div class="most-toasted">
				<h3>Most Toasted</h3>
				<ul id="activity-stream" class="activity-list item-list listless">
					<?php

						$most_popular = str_replace(',', '","', $most_popular);
						$most_popular = '"'.$most_popular.'"';

						// Get our most toasted activity ID's direct from the Database
						$results = $wpdb->get_results( 'SELECT activity_id
															FROM wp_bp_activity, wp_bp_activity_meta
															WHERE (wp_bp_activity_meta.meta_key = "favorite_count"
																AND wp_bp_activity.id = wp_bp_activity_meta.activity_id
																AND wp_bp_activity.date_recorded > "'.$last_month.'"
																AND wp_bp_activity.id NOT IN ('.$most_popular.')
																AND wp_bp_activity.type <> "new_blog_post"
																AND wp_bp_activity.type <> "activity_comment" )
															ORDER BY meta_value DESC LIMIT 10', ARRAY_N );

						// Convert the array to a string value
						foreach ($results as $result) {
							$most_toasted .= $result[0] . ',';
						}

						// Remove the trailing slash
						$most_toasted = rtrim($most_toasted, ",");

						// Run the BuddyPress Loop w/ our activity id's
						$args = '&scope=false&include='.$most_toasted.'&display_comments=threaded';
						if ( bp_has_activities( $args ) ) {
							while ( bp_activities() ) : bp_the_activity();
								bp_get_template_part( 'activity/entry' );
							endwhile;
						}

					?>
				</ul><!-- Most Toasted Activities -->

			</div>

		</div>

		<div class="dividers both">
			<div class="divider divider-1"></div>
			<div class="divider divider-2"></div>
		</div>

		<div class="large-3 columns">

			<div class="active-members">
				<h3 class="first-title">Active Members<div class="down-arrow">V</div></h3>

				<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) . '&per_page=24&type=active&max=5' ) ) : ?>

					<div id="members-list">

					<?php while ( bp_members() ) : bp_the_member(); ?>

						<div class="member-item animate-post">

							<div class="member-photo">
								<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
							</div>

							<div class="member-info">
								<p class="username"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></p>
								<p class="activity"><?php bp_member_last_active(); ?></p>
							</div>

						</div>

					<?php endwhile; ?>

					</div>

				<?php else: ?>

					<div id="message" class="info">
						<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
					</div>

				<?php endif; ?>

			</div>

			<div class="active-groups">
				<h3>Active Groups <div class="down-arrow">V</div></h3>
					<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ). '&max=5&type=active' ) ) : ?>

							<div id="groups-dir-list" class="groups dir-list">

								<div id="groups-list" class="item-list clear">

								<?php while ( bp_groups() ) : bp_the_group(); ?>

									<div class="group-dir-entry animate-post">
										<div class="member-item group-inner-list bottom-to-top">

											 <div class="member-photo relative">
												<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=80&height=80' ); ?></a>
											</div>

											<div class="member-info">

												<p class="username"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></p>

												<div class="item-desc" style="display:none;">
													<?php bp_group_description_excerpt(); ?>
												</div>

												<p class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></p>

												<?php do_action( 'bp_directory_groups_item' ); ?>

											</div>

										</div><!--end group-inner-lis-->
									</div>
								<?php endwhile; ?>

								</div>

							</div>

					<?php else: ?>

						<div id="message" class="info">
							<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
						</div>

					<?php endif; ?>

			</div>

			<?php get_template_part( 'templates/partials/friend', 'list' ); ?>

		</div>

	</div>

</div><!-- .community-home.main -->

</div>

</div>

<?php get_footer(); ?>