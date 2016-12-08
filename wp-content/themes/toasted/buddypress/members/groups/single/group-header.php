<?php

do_action( 'bp_before_group_header' );

?>

<div id="item-header-avatar" class="large-2 medium-2 columns rounded">
	<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

		<?php bp_group_avatar(); ?>

	</a>
	
	<h4 class="highlight dt-usr-btn dt-btn-offline"><?php bp_group_type(); ?></h4>
	
	<div id="item-meta" class="clear">
	
		<div id="item-buttons">
	
			<?php do_action( 'bp_group_header_actions' ); ?>
	
		</div><!-- #item-buttons -->
	
		<?php do_action( 'bp_group_header_meta' ); ?>

	</div>
	
	<div id="group-script-side">
		<?php bp_group_description(); ?>
	</div>

	  <div id="item-actions">
		<?php if ( bp_group_is_visible() ) : ?>
			<div class="clear group-admins <?php if ( bp_group_has_moderators() ) { echo 'col-sm-6'; } else { echo 'col-sm-12'; } ?>">
			<h5><?php _e( 'Admins', 'buddypress' ); ?></h5>
	
			<?php bp_group_list_admins();
	
			do_action( 'bp_after_group_menu_admins' );
			?>
			</div>
			<?php
			if ( bp_group_has_moderators() ) : ?>
				<div class="group-mods col-xs-6 col-sm-6">
				
				<?php do_action( 'bp_before_group_menu_mods' ); ?>
				<h3><?php _e( 'Group Mods' , 'buddypress' ); ?></h3>
	
				<?php bp_group_list_mods();
	
				do_action( 'bp_after_group_menu_mods' );
				?>
				</div>
				<?php
			endif;
	
		endif; ?>
		</div>
	
</div><!-- #item-header-avatar -->

<div class="large-10 medium-12 columns">

<div id="item-header-content" <?php if (isset($_COOKIE['bp-profile-header']) && $_COOKIE['bp-profile-header'] == 'small') {echo 'style="display:none;"';} ?>>
	
	<h1><?php bp_group_name(); ?></h1>

	<?php do_action( 'bp_before_group_header_meta' ); ?>
	
	    <div id="item-nav" class="bp-main-subnav">
        	<div class="item-list-tabs no-ajax group-sub-nav" id="object-nav" role="navigation">
          	<ul class="responsive-tabs listless fl-left" id="user-nav">
    
            <?php bp_get_options_nav(); ?>
    
            <?php /* do_action( 'bp_group_options_nav' ); */ ?>
    
         	 </ul>
         	 
         	 <div id="dt-object-two" class="fl-right">
        
				 <span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
				<a href="<?php bp_group_activity_feed_link(); ?>" title="<?php _e( 'RSS Feed', 'buddypress' ); ?>"><?php _e( 'RSS', 'buddypress' ); ?></a>
        
        	</div>
        
        </div>
      
      </div><!-- #item-nav -->
	
</div><!-- #item-header-content -->

<?php

do_action( 'bp_after_group_header' );

?>