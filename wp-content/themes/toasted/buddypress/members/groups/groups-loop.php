<?php

/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_groups_loop' ); ?>

	<?php do_action( 'template_notices' ); ?>

	<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ). '&per_page=24' ) ) : ?>
	
		<?php if (empty($_POST)) : ?>
	
			<div class="group-list-subnav large-12 columns">
		
				<div id="subnav" class="item-list-tabs fl-left" role="navigation">
				
					<?php if (bp_is_my_profile()) : ?>
						<div class="fl-right user-grp-invite">
							<?php $bpusername = bp_members_get_user_nicename(bp_displayed_user_id()); ?>
							<a href="/members/<?php echo $bpusername; ?>/groups/invites/">Invitations</a>
						</div>
					<? endif; ?>
				
					<div id="group-dir-search" class="dir-search fl-right" role="search">
						<?php bp_directory_groups_search_form(); ?>
					</div><!-- #group-dir-search -->
			
					<form action="" method="post" id="groups-directory-form" class="dir-form fl-right">
			
						<ul class="listless">
			
							<?php do_action( 'bp_groups_directory_group_filter' ); ?>
			
							<?php do_action( 'bp_groups_directory_group_types' ); ?>
			
							<li id="groups-order-select" class="last filter">
			
								<select id="groups-order-by">
									<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
									<option value="popular"><?php _e( 'Most Members', 'buddypress' ); ?></option>
									<option value="newest"><?php _e( 'Newly Created', 'buddypress' ); ?></option>
									<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
			
									<?php do_action( 'bp_groups_directory_order_options' ); ?>
									
								</select>
								
							</li>
								
						</ul>
						
				</form><!-- #groups-directory-form -->
			
			</div>
	
				<div class="fl-right group-list-right-nav">
				
					<div id="pag-top" class="pagination fl-right first-group-pagination">
				
						<div class="pagination-links fl-right" id="group-dir-pag-top">
				
							<?php bp_groups_pagination_links(); ?>
				
						</div>
				
					</div>
					
					<div class="dt-group-list-view fl-right">
						
						<a href="#" class="dt-group-switch list-view">List View</a> | <a href="#" class="dt-group-switch grid-view active">Grid View</a>
						
					</div>
					
					
				
				</div>
			
			</div>
	
		<?php else : ?>
		
			<div id="pag-top" class="pagination fl-right new-pagination-groups group-list-right-nav" style="display:none;">
		
				<div class="pagination-links fl-right" id="group-dir-pag-top">
		
					<?php bp_groups_pagination_links(); ?>
		
				</div>
		
			</div>
				
		<?php endif; ?>
		
		<div id="groups-dir-list" class="groups dir-list">
	
		<div id="groups-list" class="item-list clear" data-columns>
	
		<?php while ( bp_groups() ) : bp_the_group(); ?>
		
			<div class="columns group-dir-entry end animate-post">
				<div class="member-item group-inner-list animated animate-when-almost-visible bottom-to-top">
		  
					 <div class="member-photo relative">
						<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=80&height=80' ); ?></a>
						<span class="member-count"><?php echo preg_replace('/\D/', '', bp_get_group_member_count());  ?></span>
					</div>
		
					<div class="item">
					
						<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
		
						<div class="item-desc" style="display:none;">
							<?php bp_group_description_excerpt(); ?>
						</div>
		
						<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>
		
						<?php do_action( 'bp_directory_groups_item' ); ?>
						
						<div class="action">
		
							<div class="meta">
			
								<?php bp_group_type(); ?>
			
							</div>
					
							<?php do_action( 'bp_directory_groups_actions' ); ?>
			
						</div>
		
					</div>
		

					
				</div><!--end group-inner-lis-->
			</div>
		<?php endwhile; ?>
	
		</div>
	
		<?php do_action( 'bp_after_directory_groups_list' ); ?>
	
		<div id="pag-bottom" class="pagination large-12 columns">
	
			<div class="pag-count" id="group-dir-count-bottom fl-left">
	
				<?php bp_groups_pagination_count(); ?>
	
			</div>
	
			<div class="pagination-links" id="group-dir-pag-bottom fl-right">
	
				<?php bp_groups_pagination_links(); ?>
	
			</div>
	
		</div>
		
		</div><!-- #groups-dir-list -->

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>