<div id="dt-note-list">
<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
	<div class="notifications clear">
		<?php bp_the_notification_description();  ?>
		<span class="dt-n-date"><?php bp_the_notification_time_since();   ?></span>
	</div>	
<?php endwhile; ?>
</div>