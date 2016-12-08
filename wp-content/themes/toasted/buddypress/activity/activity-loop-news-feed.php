<div class="activity" role="main">

	<!-- //bp_extend_get_news_feed_ids( bp_loggedin_user_id(), 10, 1) )-->

	<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) . '&per_page=10' ) ) :  ?>
	
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
	
			<li class="load-more large-12 columns">
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