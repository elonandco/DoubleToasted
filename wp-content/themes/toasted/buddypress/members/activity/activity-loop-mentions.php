<div class="activity" role="main">

	<?php do_action( 'bp_before_activity_loop' ); ?>
	 
	<?php if ( bp_has_activities( '&scope=mentions&per_page=5' )  ) :  ?>
	
		<?php if ( empty( $_POST['page'] ) ) : ?>
	
			<!-- Changed id and class to "-mentions" -->
			<ul id="activity-stream" class="activity-list activity-profile-mentions item-list listless">
	
		<?php endif; ?>
		
		<?php while ( bp_activities() ) : bp_the_activity(); ?>
	
			<?php bp_get_template_part( 'activity/entry' ); ?>
	
		<?php endwhile; ?>
	
		<?php if ( empty( $_POST['page'] ) ) : ?>
	
			</ul>
	
		<?php endif; ?>

	<?php else : ?>
	
		<div id="message" class="info">
			<p><?php _e( 'Nobody has said anything yet.', 'buddypress' ); ?></p>
		</div>
		
	<?php endif; ?>
	
	<?php do_action( 'bp_after_activity_loop' ); ?>
	
	<form action="" name="activity-loop-form" id="activity-loop-form" method="post">
	
		<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>
	
	</form>
	
</div><!-- .activity -->