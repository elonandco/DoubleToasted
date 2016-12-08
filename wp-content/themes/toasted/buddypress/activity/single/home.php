<!-- 
<form action="" name="activity-loop-form" id="activity-loop-form" method="post">

	<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

</form>
 -->

<div id="buddypress">

	<?php do_action( 'template_notices' ); ?>

	<div class="activity" role="main">

		<?php if ( bp_has_activities( 'include=' . bp_current_action() ) ) : ?>

			<ul id="activity-stream" class="activity-list item-list listless activity">

			<?php while ( bp_activities() ) : bp_the_activity(); ?>

				<?php bp_get_template_part( 'activity/entry' ); ?>

			<?php endwhile; ?>

			</ul>

		<?php endif; ?>
	</div>
</div>