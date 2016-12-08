<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) . '&per_page=24' ) ) : ?>

	<div class="pagination large-12 columns">

		<div class="pagination-links fl-right" id="dt-paging">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<div id="members-list">

	<?php 
	
		$i = 0;
		
		// Clear every fourth entry for grid
		while ( bp_members() ) : bp_the_member(); 
	
			$i++;
			if ($i%3 == 1) {  $class4 = 'clear'; }
			else { $class4 = ''; }
		
	?>

		<div class="large-4 medium-6 columns end <?php echo $class4; ?> animate-post">
			<div class="member-item">
			
				<div class="member-photo">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
				</div>
				
				<div class="member-info">
					<p class="username"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></p>
					<p class="activity"><?php bp_member_last_active(); ?></p>
				</div>
				
			</div>
		</div>
		
	<?php endwhile; ?>

	</div>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination clear large-12 columns">

		<div class="pag-count large-6 medium-6 columns" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links large-6 medium-6 columns" id="member-dir-pag-bottom">

			<div class="fl-right">
				<?php bp_members_pagination_links(); ?>
			</div>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>
