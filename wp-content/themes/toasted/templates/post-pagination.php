<?php
$next = get_next_posts_link();
$prev = get_previous_posts_link();
?>
<?php if ( $next || $prev ): ?>

	<div id="dt-page-nav">

	<?php if ( $next ): ?>
		<a id="dt-nav-next" href='<?php echo next_posts( false, 0 ); ?>'> <?php _e( 'Older Entries', 'frank_theme' ) ?> </a>
	<?php endif; ?>
	<?php if ( $prev ): ?>
		<a id="dt-nav-prev" href='<?php echo previous_posts( false, 0 ); ?>'> <?php _e( 'Newer Entries', 'frank_theme' ) ?> </a>
	<?php endif; ?>
	
	</div>
	
<?php endif; ?>