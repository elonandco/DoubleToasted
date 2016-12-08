<?php do_action( 'bp_before_profile_loop_content' ); ?>

<div class="dt-user-standard-profile">

<?php

	// Gets Standard Profile Info
	
	$user_id = bp_displayed_user_id();
	
	// Name
	$profile[] = xprofile_get_field_data('Name', $user_id );
	
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-name">Name</h4><p>';
	
	if ($profile[0]) {
		echo $profile[0];
	}
	
	echo '</p></div></div>';
	
	
	// Birthday
	$profile[] = xprofile_get_field_data('Birthday', $user_id );
	
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-birth">Birthday</h4><p>';
	
	if ($profile[1]) {
		 echo date("F j, Y", strtotime($profile[1]));
	}
	
	else {
		echo 'Unknown';
	}
	
	echo  '</p></div></div>';
	
	// Hometown
	$profile[] = xprofile_get_field_data('Hometown', $user_id );
	
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-hometown">Hometown</h4><p>';
	
	if ($profile[2]) {
		echo $profile[2];
	}
	
	else {
		echo 'Mysterious';
	}
	
	echo '</p></div></div>';

	// About	
	$profile[] = xprofile_get_field_data('About', $user_id );
	echo '<div class="large-12 medium-12 columns end"><div class="user-info about"><h4 class="usr-about">About</h4><p>';
	if ($profile[3]) {
		 echo $profile[3];	
	}
	
	else {
		echo 'Unknown';
	}
	
	echo '</p></div></div>';
	
	// Best Movies
	$profile[] = xprofile_get_field_data('All Time Best Movies', $user_id );
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-movie10">All Time Best Movies</h4><p>';
	if ($profile[4]) {
		echo $profile[4];	
	}
	
	else {
		echo 'Unknown';
	}
	
	echo '</p></div></div>';
	
	// Best Music
	$profile[] = xprofile_get_field_data('All Time Best Music', $user_id );
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-music10">All Time Best Music</h4><p>';
	if ($profile[5]) {
		 echo $profile[5];
	}	
	
	else {
		echo 'Unknown';
	}
	
	echo '</p></div></div>';

	// Travel
	$profile[] = xprofile_get_field_data('Places Ive Traveled', $user_id );
	echo '<div class="large-4 medium-4 columns end"><div class="user-info"><h4 class="usr-travel">Place I\'ve Traveled</h4><p>';
	if ($profile[6]) {
		echo $profile[6];
	}
	
	else {
		echo 'Unknown';
	}
	
	echo '</p></div></div>';
	
?>

</div>

<?php if ( bp_has_profile('profile_group_id=3') ) : ?>

	<div class="dt-user-extended-profile">

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php do_action( 'bp_before_profile_field_content' ); ?>

			<div class="large-4 medium-6 columns">

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<?php if ( bp_field_has_data() ) : ?>
              
						  <?php 

								bp_the_profile_field_name(); 
								bp_the_profile_field_value(); 
								
						   ?>

						<?php endif; ?>

						<?php do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>
                        
			</div><!-- end bp-widget -->

			<?php do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

	</div>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
