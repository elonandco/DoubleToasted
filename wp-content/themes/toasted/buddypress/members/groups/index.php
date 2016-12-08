<?php do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress" class="dt-new-group-list-switch">

	<?php do_action( 'bp_before_directory_groups' ); ?>

	<?php do_action( 'bp_before_directory_groups_content' ); ?>
	
	<div class="group-list-top large-12 columns">
	
			<h1 class="fl-left"><?php echo the_title(); ?></h1>
			
			<?php if ( is_user_logged_in() ) : ?>
			
			<div class="fl-right group-index-actions">
			
				<?php $bpusername = bp_members_get_user_nicename(bp_loggedin_user_id()); ?>
			
				<a href="/groups/create/" title="Create a Group" class="dt-usr-btn dt-btn-orange">Create a Group</a>
				<a href="/members/<?php echo $bpusername; ?>/groups/my-groups/" class="dt-usr-btn" >My Groups</a>
				<a href="/members/<?php echo $bpusername; ?>/activity/groups/" class="dt-usr-btn dt-btn-dkblue" >My Group Feed</a>
				
			</div>
				
			<?php endif; ?>
			
	</div>

		<?php bp_get_template_part( 'groups/groups-loop' ); ?>

	<?php do_action( 'bp_directory_groups_content' ); ?>

	<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>
`
	<?php do_action( 'bp_after_directory_groups_content' ); ?>

	<?php do_action( 'bp_after_directory_groups' ); ?>
	
	<?php wp_enqueue_script( 'jquery-masonry' ); ?>	

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_groups_page' ); ?>