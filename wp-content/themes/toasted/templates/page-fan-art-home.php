<?php
/**
 * @package Frank
 */
/*
Template Name: Fan Art
*/
?>

<?php get_header(); ?>

<?php do_action( 'bp_before_activity_loop' ); ?>

<div id="buddypress">

<div class="activity" role="main">

<div class="main community-home top-posts">
<div class="top-banner"></div>
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

			<div class="fan-art-list">
				<div class="fan-art row top" style="clear: both;">
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
				</div>
				<div class="fan-art row" style="margin-top: 100px; clear: both;">
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
				</div>
				<div class="fan-art row" style="margin-top: 100px; clear: both;">
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
					<div class="large-6 columns fan-art container">
						<a href="#">
							<h4 class="fan-art-label"></h4>
							<div class="fan-art image-container"></div>
						</a>
						<div class="fan-art-description"></div>
					</div>
				</div>
			</div>
			<div class="pagination" style="width: 87%">
				<div class="large-6 columns"><a href="#" style="float: left;">Previous</a></div>
				<div class="large-5 columns"><a href="#" style="float: right;">Next</a></div>
			</div>

		</div>

		<div class="dividers small both">
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

    <div class="more-shows" style="clear: both">
        <div class="divider bottom"></div>
        <div class="show show-all-series">
            <div class="title">
                <h2>RECENT SHOWS</h2>
                <div class="categories fan-dropdown">
                    <div class="drop">Categories<span>v</span></div>
                    <div class="dropdown">
                        <div class="tooltip"></div>
                        <ul>
                            <li value="recent">Most Recent</li>
                            <li value="popular">Most Popular</li>
                            <li value="AtoZ">Sort A to Z</li>
                            <li value="ZtoA">Sort Z to A</li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="slider">

            </ul>
            <ul class="pagination"></ul>
            <div class="prev arrow"></div>
            <div class="next arrow"></div>
        </div>
    </div>

</div><!-- .community-home.main -->

</div>

</div>

<script type="text/javascript">
	var $ = jQuery;

	$.ajax({
           url: '/api/dtshows/get_fan_art_media/',
           cache: false,
           success: function (data) {
               $.each(data.posts, function (index, fanArt) {
               		var container = $(".fan-art.container").not(".filled").first();
               		var label = container.find(".fan-art-label");
               		var imageContainer = container.find(".fan-art.image-container");
               		var imageDescription = container.find(".fan-art-description");

               		label.html("Added by @" + fanArt.activity.display_name);
               		imageContainer.css("background-image", "url(" + fanArt.media.url + ")");
               		imageDescription.append("A small description would go here. <p class='like'>(" + fanArt.media.likes + ") Like </p>")

               		container.addClass("filled");                   
               });
           }
       });
</script>

<?php get_footer(); ?>