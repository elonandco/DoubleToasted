<?php do_action( 'bp_before_directory_activity' ); ?>

<div id="buddypress">

<?php do_action( 'template_notices' ); ?>
<div style="margin-bottom:20px;overflow:hidden;">
<div class="large-9 medium-8 columns news-feed-pg"><h1>Home</h1></div>
	
<div class="large-3 medium-4 columns news-feed-pg">

	<div id="subnav" class="item-list-tabs activity-type-tabs" role="navigation">

			<?php do_action( 'bp_activity_type_tabs' ); ?>

			<div id="activity-filter-select" class="last">

				<select id="activity-filter-by" class="dt-news-feed">

					<option value="-1"><?php _e( 'Sitewide Activity', 'buddypress' ); ?></option>
					<option value="activity_update"><?php _e( '-- Updates', 'buddypress' ); ?></option>
					<option value="joined_group"><?php _e( '-- Groups', 'buddypress' ); ?></option>
					<option value="friendship_accepted,friendship_created"><?php _e( '-- Friendships', 'buddypress' ); ?></option>
					<option value="updated_profile"><?php _e( '-- Profile Updates', 'buddypress' ); ?></option>
					<option value="bbp_topic_create"><?php _e( '-- Forum Topics', 'buddypress' ); ?></option>
					<option value="bbp_reply_create"><?php _e( '-- Forum Replies', 'buddypress' ); ?></option>
					<option value="new_member"><?php _e( '-- New Members', 'buddypress' ); ?></option>

				<?php						

					$user = bp_loggedin_user_id();

					if ($user) { ?>
			
						<option value="news_feed"><?php _e( 'News Feed', 'buddypress' ); ?></option>
						<option value="friend_updates"><?php _e( '-- Your Friends', 'buddypress' ); ?></option>
						<option value="group_updates"><?php _e( '-- Your Groups', 'buddypress' ); ?></option>
						<option value="user_mentions"><?php _e( '-- Your Mentions', 'buddypress' ); ?></option>
						<option value="user_favorites"><?php _e( '-- Your Favorites', 'buddypress' ); ?></option>

					<?php } ?>

					<!-- 	Created a custom select list here, so i've removed the drop-down
							Removed //do_action( 'bp_activity_filter_options' ); 					-->

				</select>


			</div>

	</div>
	
</div>
</div>

<div class="large-3 medium-4 small-2 columns news-feed-sidebar clear">

	<?php

		if ($user) {
			$user_title = 'Active Friends';
			$user_query = '&user_id='.$user;
			$username = get_userdata( $user );
			echo '<div class="news-feed-user">';
			echo 	'<a class="news-usr-img" href="'.bp_loggedin_user_domain().'">'.bp_core_fetch_avatar ( array( 'item_id' => $user, 'type' => 'full' ) ).'</a>';
			echo 	'<p class="news-feed-uname"><a href="'.bp_loggedin_user_domain() . '" title="Your Profile">'.$username->display_name.'</a>';
			echo 		'<a href="'.bp_loggedin_user_domain() . 'profile/edit/" class="edit-usr" title="Edit Profile">Edit Your Profile</a></p>';
			echo '</div>';
		} else {
		 	$user_title = 'Active Users';
			$user_query = '&user_id=';
		}

	?>

	<div class="active-members">

		<h3 class="first-title"><?php echo $user_title ?></h3>
		
		<?php if ( bp_has_members( bp_ajax_querystring( 'members' ).$user_query.'&per_page=10&type=active&max=10' ) ) : ?>
		
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
		<h3>Active Groups</h3>

			<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ). '&max=10&type=active&user_id='.$user ) ) : ?>
					
					<div id="groups-dir-list" class="groups dir-list">
				
						<div id="groups-list" class="item-list clear">
					
						<?php while ( bp_groups() ) : bp_the_group(); ?>
						
							<div class="group-dir-entry animate-post">
								<div class="member-item group-inner-list bottom-to-top">
						  
									 <div class="member-photo relative">
										<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=80&height=80' ); ?></a>
									</div>
						
									<div class="item">
									
										<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
						
										<div class="item-desc" style="display:none;">
											<?php bp_group_description_excerpt(); ?>
										</div>
						
										<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>
						
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

</div>

<div class="large-9 medium-8 small-10 columns">

	<?php do_action( 'bp_before_directory_activity_content' ); ?>

	<?php if ( is_user_logged_in() ) : ?>

		<?php bp_get_template_part( 'activity/post-form-home' ); ?>

	<?php endif; ?>

	<?php do_action( 'bp_before_directory_activity_list' ); ?>

	<div class="activity" role="main">

		<?php bp_get_template_part( 'activity/activity-loop' ); ?>

	</div><!-- .activity -->

	<?php do_action( 'bp_after_directory_activity_list' ); ?>

	<?php do_action( 'bp_directory_activity_content' ); ?>

	<?php do_action( 'bp_after_directory_activity_content' ); ?>

	<?php do_action( 'bp_after_directory_activity' ); ?>

</div>