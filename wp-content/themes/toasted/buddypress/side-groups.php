    <div class="pagination">
 
		<div id="dt-side-header">
	
			<p id="dt-side-subhead" class="large-12 medium-12 columns"><strong>Your Groups</strong>
			<!-- <p id="dt-side-count" class="large-6 medium-6 columns">254 Comments</p> -->
	
		</div>
 
 
    </div>
 
 <?php 

	if ( bp_has_groups('type=active&slug=false&user_id=' . bp_loggedin_user_id() ) ) : 
	
?>
 
    <ul id="groups-list" class="item-list listless">
    <?php while ( bp_groups() ) : bp_the_group(); ?>
 
        <li>
            <div class="item-avatar">
                <a href="<?php bp_group_permalink() ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ) ?></a>
            </div>
 
            <div class="item">
                <div class="item-title"><a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a></div>
                <div class="item-meta"><span class="activity"><?php printf( __( 'active %s ago', 'buddypress' ), bp_get_group_last_active() ) ?></span></div>
 
                <div class="item-desc"><?php bp_group_description_excerpt() ?></div>
 
                <?php do_action( 'bp_directory_groups_item' ) ?>
            </div>
 
            <div class="action">
                <?php bp_group_join_button() ?>
 
                <div class="meta">
                    <?php bp_group_type() ?> / <?php bp_group_member_count() ?>
                </div>
 
                <?php do_action( 'bp_directory_groups_actions' ) ?>
            </div>
 
            <div class="clear"></div>
        </li>
 
    <?php endwhile; ?>
    </ul>
 
    <?php do_action( 'bp_after_groups_loop' ) ?>
 
<?php else: ?>
 
    <div id="message" class="info">
        <p><?php _e( 'You haven\'nt joined any groups yet.', 'buddypress' ) ?></p>
    </div>
 
<?php endif; ?>