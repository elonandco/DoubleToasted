<?php

/**
 * BuddyPress - Users Blogs
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="activity large-4 medium-4 columns" role="main">

	<?php bp_get_template_part( 'members/single/member-sidebar' ); ?>

</div>

<div class="item-list-tabs large-8 medium-8 columns profile-subn" id="subnav" role="navigation">
	<ul class="listless fl-right">

		<?php bp_get_options_nav(); ?>

		<li id="blogs-order-select" class="last filter">

			<select id="blogs-all">
				<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
				<option value="newest"><?php _e( 'Newest', 'buddypress' ); ?></option>
				<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

				<?php do_action( 'bp_member_blog_order_options' ); ?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php
switch ( bp_current_action() ) :

	// Home/My Blogs
	case 'my-sites' :
		do_action( 'bp_before_member_blogs_content' ); ?>

		<div class="blogs myblogs" role="main">

			<?php bp_get_template_part( 'blogs/blogs-loop' ) ?>

		</div><!-- .blogs.myblogs -->

		<?php do_action( 'bp_after_member_blogs_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;