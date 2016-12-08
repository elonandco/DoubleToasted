<?php do_action( 'bp_before_directory_activity' ); ?>

<div id="buddypress">

	<div class="large-10 medium-6 columns">
	
		<h1 style="margin-bottom:20px;"><?php echo the_title(); ?></h1>
	
	</div>
	
<div class="large-2 medium-6 columns">

	<?php do_action( 'template_notices' ); ?>

	<div id="subnav" class="item-list-tabs activity-type-tabs" role="navigation">

			<?php do_action( 'bp_activity_type_tabs' ); ?>

			<div id="activity-filter-select" class="last">

				<select id="activity-filter-by">
				
					<option value="-1"><?php _e( 'Everything', 'buddypress' ); ?></option>
					<option value="activity_update"><?php _e( 'Updates', 'buddypress' ); ?></option>

					<?php if ( bp_is_active( 'forums' ) ) : ?>

						<option value="new_forum_topic"><?php _e( 'Forums', 'buddypress' ); ?></option>

					<?php endif; ?>

					<?php if ( bp_is_active( 'groups' ) ) : ?>

						<option value="joined_group"><?php _e( 'Groups', 'buddypress' ); ?></option>

					<?php endif; ?>

					<?php if ( bp_is_active( 'friends' ) ) : ?>

						<option value="friendship_accepted,friendship_created"><?php _e( 'Friends', 'buddypress' ); ?></option>

					<?php endif; ?>

						<option value="new_member"><?php _e( 'New Members', 'buddypress' ); ?></option>

						<?php do_action( 'bp_activity_filter_options' ); ?>

				</select>


			</div>

	</div>

</div>

<div class="clear large-12 columns">

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