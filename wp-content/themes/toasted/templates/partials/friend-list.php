<?php if ( bp_has_members(  'user_id=' . bp_loggedin_user_id() . '&per_page=24&type=active&max=5' ) ) : ?>
	<div class="active-members">
		<h3 class="first-title">Active Friends<div class="down-arrow">V</div></h3>

			<div id="friends-list">

			<?php while ( bp_members() ) : bp_the_member(); ?>

				<div class="member-item animate-post">

					<div class="member-photo">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
					</div>

					<div class="member-info">
						<p class="username"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></p>
						<p class="activity"><?php bp_member_last_active(); ?></p>
					</div>

				</div>

			<?php endwhile; ?>

			</div>

	</div>
<?php endif; ?>