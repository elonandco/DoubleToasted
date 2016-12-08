<?php

/**
 * BuddyPress - Users Forums
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="activity large-4 medium-4 columns" role="main">

	<?php bp_get_template_part( 'members/single/member-sidebar' ); ?>

</div>

<div class="item-list-tabs no-ajax profile-subn large-8 medium-8 columns" id="subnav" role="navigation">
	<ul class="listless fl-right">
		<?php bp_get_options_nav(); ?>

		<li id="forums-order-select" class="last filter">

			<select id="forums-order-by">
				<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
				<option value="popular"><?php _e( 'Most Posts', 'buddypress' ); ?></option>
				<option value="unreplied"><?php _e( 'Unreplied', 'buddypress' ); ?></option>

				<?php do_action( 'bp_forums_directory_order_options' ); ?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php

if ( bp_is_current_action( 'favorites' ) ) :
	bp_get_template_part( 'members/single/forums/topics' );

else :
	do_action( 'bp_before_member_forums_content' ); ?>

	<div class="forums myforums large-12 columns">

		<?php bp_get_template_part( 'forums/forums-loop' ) ?>

	</div>

	<?php do_action( 'bp_after_member_forums_content' ); ?>

<?php endif; ?>
