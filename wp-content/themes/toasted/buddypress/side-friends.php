<?php if ( bp_has_members( 'user_id=' . bp_loggedin_user_id() ) ) : ?>
 
  <div id="pag-top" class="pagination">
 
    <div class="pag-count" id="member-dir-count-top">
 
		<div id="dt-side-header">
	
			<p id="dt-side-subhead" class="large-12 medium-12 columns"><strong><?php bp_members_pagination_count(); ?></strong>
			<!-- <p id="dt-side-count" class="large-6 medium-6 columns">254 Comments</p> -->
	
		</div>
 
   </div>
 
   <div class="pagination-links" id="member-dir-pag-top">
 
      <?php bp_members_pagination_links(); ?>
 
   </div>
 
  </div>
 
  <?php do_action( 'bp_before_directory_members_list' ); ?>
 
  <ul id="members-list" class="listless item-list" role="main">
 
  <?php while ( bp_members() ) : bp_the_member(); ?>
 
    <li>
      <div class="item-avatar">
         <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
      </div>
 
      <div class="item">
        <div class="item-title">
           <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
 
       </div>
 
       <div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
 
       <?php do_action( 'bp_directory_members_item' ); ?>
 
      <?php
       /***
        * If you want to show specific profile fields here you can,
        * but it'll add an extra query for each member in the loop
        * (only one regardless of the number of fields you show):
        *
        * bp_member_profile_data( 'field=the field name' );
       */
       ?>
       </div>
 
       <div class="action">
 
           <?php do_action( 'bp_directory_members_actions' ); ?>
 
      </div>
 
      <div class="clear"></div>
   </li>
 
 <?php endwhile; ?>
 
 </ul>
 
 <?php do_action( 'bp_after_directory_members_list' ); ?>
 
 <?php bp_member_hidden_fields(); ?>
 
 <div id="pag-bottom" class="pagination">
 
    <div class="pagination-links" id="member-dir-pag-bottom">
 
      <?php bp_members_pagination_links(); ?>
 
    </div>
 
  </div>
 
<?php else: ?>
 
   <div id="message" class="info">
      <p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
   </div>
 
<?php endif; ?>