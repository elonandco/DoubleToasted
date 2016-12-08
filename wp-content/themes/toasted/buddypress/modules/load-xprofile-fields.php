<?php
/*

	This template is used to load custom buddypress fields into WooCommerce Registration
	- Template is taken from Buddypress members/register.php template
	- Only modification is removal of visibility code block
	- The template is called from the WooCommerce registration hooks


*/
?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<div class="register-section clear" id="profile-details-section">
					<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
					
						<div class="editfield">

							<?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>

								<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
								<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
								<input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" />

							<?php endif; ?>

							<?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>

								<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
								<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
								<textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_edit_value(); ?></textarea>

							<?php endif; ?>

							<?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>

								<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
								<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
								<select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>">
									<?php bp_the_profile_field_options(); ?>
								</select>

							<?php endif; ?>

							<?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>

								<label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
								<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
								<select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" multiple="multiple">
									<?php bp_the_profile_field_options(); ?>
								</select>

							<?php endif; ?>

							<?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

								<div class="radio">
									<span class="label"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></span>

									<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
									<?php bp_the_profile_field_options(); ?>

									<?php if ( !bp_get_the_profile_field_is_required() ) : ?>
										<a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name(); ?>' );"><?php _e( 'Clear', 'buddypress' ); ?></a>
									<?php endif; ?>
								</div>

							<?php endif; ?>

							<?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

								<div class="checkbox">
									<span class="label"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></span>

									<?php do_action( bp_get_the_profile_field_errors_action() ); ?>
									<?php bp_the_profile_field_options(); ?>
								</div>

							<?php endif; ?>

							<?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>

								<div class="datebox">
									<label for="<?php bp_the_profile_field_input_name(); ?>_day"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
									<?php do_action( bp_get_the_profile_field_errors_action() ); ?>

									<select name="<?php bp_the_profile_field_input_name(); ?>_day" id="<?php bp_the_profile_field_input_name(); ?>_day">
										<?php bp_the_profile_field_options( 'type=day' ); ?>
									</select>

									<select name="<?php bp_the_profile_field_input_name(); ?>_month" id="<?php bp_the_profile_field_input_name(); ?>_month">
										<?php bp_the_profile_field_options( 'type=month' ); ?>
									</select>

									<select name="<?php bp_the_profile_field_input_name(); ?>_year" id="<?php bp_the_profile_field_input_name(); ?>_year">
										<?php bp_the_profile_field_options( 'type=year' ); ?>
									</select>
								</div>

							<?php endif; ?>

							<?php do_action( 'bp_custom_profile_edit_fields_pre_visibility' ); ?>

							<?php do_action( 'bp_custom_profile_edit_fields' ); ?>

							<p class="description"><?php bp_the_profile_field_description(); ?></p>

						</div>

					<?php endwhile; ?>

					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_group_field_ids(); ?>" />

					<?php endwhile; endif; endif; ?>

				</div><!-- #profile-details-section -->

			<?php endif; ?>