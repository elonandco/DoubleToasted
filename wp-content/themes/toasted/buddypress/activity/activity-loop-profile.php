<div class="activity" role="main">
		
	<?php do_action( 'bp_before_activity_loop' ); ?>
	 
	<!-- This function gets our profile updates -->
	<?php $args = bp_extend_get_profile_activity_ids(10,1); ?>
	<?php //$actions = '&action=new_forum_post,new_blog_comment,new_forum_topic,activity_update,bbp_reply_create,bbp_topic_create,created_group,activity_comment'; ?>

	<?php 

		var_dump($args);
		$test = $args . $actions . '&per_page=10';
		var_dump($test);

	 ?>

	<?php if ( bp_has_activities( $args . $actions . '&per_page=10' )  ) :  ?>
		
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