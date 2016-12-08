<?php 

	global $bp; 
	$bpComponent = $bp->current_component; 
	$bpComponentPiece = $bp->current_action; 

	if ($bpComponent == 'groups' && $bpComponentPiece !== '') {
		$isGroupSingle = true;
	}

?>

<div id="dt-side-header">

	<p id="dt-side-subhead" class="large-12 medium-12 columns"><strong><?php if ($isGroupSingle) { echo 'Group Favorites'; } else { echo 'Recent Favorites'; } ?></strong>
	<!-- <p id="dt-side-count" class="large-6 medium-6 columns">254 Comments</p> -->

</div>

<?php if ( bp_has_activities( '&scope=favorites' ) ) : ?>

    <?php while ( bp_activities() ) : bp_the_activity(); ?>
    
				<div class="activity-header">
				
					<div class="large-9 medium-8 columns">				
						<?php bp_activity_action(); ?>
					</div>
					
					<a href="<?php bp_activity_thread_permalink(); ?>" class="button view bp-secondary-action large-3 medium-4 columns" title="<?php _e( 'View Conversation', 'buddypress' ); ?>"><?php _e( 'View', 'buddypress' ); ?></a>
		
				</div>
				
				

    <?php endwhile; ?>

<?php else: ?>
 
    <div id="message" class="info">
        <p><?php _e( 'You don\'t have any favorites. </3', 'buddypress' ) ?></p>
    </div>
 
<?php endif; ?>