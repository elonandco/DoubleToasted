<div class="activity" role="main">

	<?php 
	
		global $bp;
		$scope = $bp->current_action;
		$page = ($_POST['page']) ? '&page=' . $_POST['page'] : '&page=1';
	
		// Shows friends and user activity on home screen of profile
		if (bp_is_home() && $scope == 'just-me') {

			$user = bp_loggedin_user_id();
			$friends = friends_get_friend_user_ids( $user );
			$friends[] = $user;
			$friends_and_me = implode( ',', (array) $friends );
			$user_id =  '&user_id=' . $friends_and_me;
			
			$action = '&action=activity_update,rtmedia_update,created_group,new_blog_post,bbp_reply_create,bbp_topic_create';			
			$scope = '&scope=false';
			
			$args = $scope . $user_id . $action . $page;

		}
		
		// Show mentions only from friends on other peoples profiles like a wall
		else if (bp_is_user() && $scope == 'just-me') {

			$user = bp_displayed_user_id();
			$friends = friends_get_friend_user_ids( $user );
			$friends[] = $user;
			$friends_and_me = implode( ',', (array) $friends );
			
			$user_id =  '&user_id=' . $friends_and_me;						
			$action = '&action=activity_update,rtmedia_update,created_group,new_blog_post,bbp_reply_create,bbp_topic_create';
			$search_terms = '&search_terms=@' . bp_activity_get_user_mentionname( $user ) . '<';
			
			$args = $search_terms . $user_id . $action . $page;
			
		}
		
		// Inherit regular scope
		else {
		
			$action = '&action=activity_update,rtmedia_update,created_group,new_blog_post,bbp_reply_create,bbp_topic_create';
			$args = $action . '&scope=' . $scope . $page;
		
		}
		
		do_action( 'bp_before_activity_loop' );
	
	?>
	 
	<?php if ( bp_has_activities( $args )  ) :  ?>
	
		<!-- bp_ajax_querystring( 'activity' ) . $queryargs ) -->
	
		<!-- 	Compiled list of filter actions (for reference):
				new_forum_post,new_blog_comment,new_forum_topic,activity_update,
				bbp_reply_create,bbp_topic_create,created_group,activity_comment -->
	
		<!-- Show pagination if JS is not enabled, since the "Load More" link will do nothing -->
		<noscript>
			<div class="pagination">
				<div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
				<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
			</div>
		</noscript>
	
		<?php if ( empty( $_POST['page'] ) ) : ?>
	
			<ul id="activity-stream" class="activity-list item-list listless">
	
		<?php endif; ?>
		
		<?php while ( bp_activities() ) : bp_the_activity(); ?>
	
			<?php $bphasactcheck = true; ?>
			<?php bp_get_template_part( 'activity/entry' ); ?>
	
		<?php endwhile; ?>
		
		<?php if ( bp_activity_has_more_items() && $bphasactcheck ) : ?>
	
			<li class="load-more large-12 columns" id="dt-load-userdash">
				<img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
				<a href="#more"><?php _e( 'Load More', 'buddypress' ); ?></a>
			</li>
	
		<?php endif; ?>
	
		<?php if ( empty( $_POST['page'] ) ) : ?>
	
			</ul>
	
		<?php endif; ?>
	
		<?php else : ?>
		
			<div id="message" class="info">
				<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
			</div>
		
		<?php endif; ?>
	
	<?php do_action( 'bp_after_activity_loop' ); ?>
	
	<form action="" name="activity-loop-form" id="activity-loop-form" method="post">
	
		<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>
	
	</form>
	
</div><!-- .activity -->