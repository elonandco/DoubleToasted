<div id="buddypress">

	<div class="large-6 medium-6 columns">
	
		<h1><?php echo the_title(); ?></h1>
	
	</div>

	<div class="large-6 medium-6 columns">

		<div id="subnav" class="item-list-tabs" role="navigation">
			
				<div id="members-dir-search" class="dir-search fl-right" role="search">
					<?php bp_directory_members_search_form(); ?>
				</div><!-- #members-dir-search -->
				
				<form action="" method="post" id="members-directory-form" class="dir-form fl-right">
				
					<ul class="listless">
						<li id="members-order-select" class="last filter">
							<select id="members-order-by">
								<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
								<option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>
		
								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
								<?php endif; ?>
		
								<?php do_action( 'bp_members_directory_order_options' ); ?>
							</select>
						</li>	
					</ul>
										
				</form><!-- #members-directory-form -->
			
				<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
					<div id="members-personal" class="fl-right"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/'; ?>"><?php printf( __( 'My Friends <span>%s</span>', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></div>
				<?php endif; ?>
			
		</div><!-- .item-list-tabs -->

	</div>

	<div id="members-dir-list" class="members dir-list">
		<?php bp_get_template_part( 'members/members-loop' ); ?>
	</div><!-- #members-dir-list -->

	<?php do_action( 'bp_directory_members_content' ); ?>

	<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

	<?php do_action( 'bp_after_directory_members_content' ); ?>

	<?php do_action( 'bp_after_directory_members' ); ?>

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_members_page' ); ?>