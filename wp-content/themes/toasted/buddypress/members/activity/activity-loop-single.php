<div class="activity" role="main" id="buddypress">

	<?php $action = '&action=new_blog_post';	 ?>
	<?php if ( bp_has_activities( $action . '&secondary_id=' . $post->ID ) ) { ?>
		
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
		
				<?php bp_get_template_part( 'activity/entry-single-2' ); ?>
		
			<?php endwhile; ?>
		
			<?php if ( bp_activity_has_more_items() && bp_activities() ) : ?>
		
				<li class="load-more large-12 columns" id="dt-load-userdash">
					<img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
					<a href="#more"><?php _e( 'Load More', 'buddypress' ); ?></a>
				</li>
		
			<?php endif; ?>
		
			<?php if ( empty( $_POST['page'] ) ) : ?>
		
				</ul>
		
			<?php endif; ?>
		
	<?php } else { ?>
	
		<div id="message" class="info">
			<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
		</div>
	
	<?php } ?>
	
	<?php do_action( 'bp_after_activity_loop' ); ?>
	
	<form action="" name="activity-loop-form" id="activity-loop-form" method="post">
	
		<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>
	
	</form>
	
</div><!-- .activity -->