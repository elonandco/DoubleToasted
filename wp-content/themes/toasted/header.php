<!DOCTYPE html>
<html lang="en-US">
<head>

	<title><?php wp_title( '&mdash;', true, 'right' ); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width" />
	<link rel="pingback" href="/xmlrpc.php" />

	<link rel="icon" type="image/png" href="/wp-content/themes/toasted/images/favicon.png">
	<link rel="stylesheet" href="/wp-content/themes/toasted/style.css?v=4.4.1" type="text/css" media="all">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Risque' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/wp-content/themes/toasted/font-awesome.min.css">

	<?php wp_head(); ?>

</head>

<?php

	// Checks if we have an "on-air" show
	global $onAirPostData;
	if ( $onAirPostData ) {$onAirClass = 'dt-onair';}
	else {$onAirClass = '';}

?>

<body <?php body_class(); ?>>

<?php add_thickbox(); ?>
<div id="dt-login" style="display:none;">
	<div class="content" id="dt-lightbox-login">

		<?php $isuser = is_user_logged_in(); ?>
		<?php if (!$isuser) { ?>

				<div class="post-content large-6 medium-6 columns" id="dt-box-login">
					<div class="large-10 large-centered columns">

						<h1>LOGIN</h1>

						<div id="error-fail">
							<span class="icon-alert"></span>
							<p> Sorry, that username or password is incorrect.</p>
						</div>

						<?php

							// Login form cache - added phase IV
							//$cached_login = wp_cache_get( 'cached_login' );
							// Removed cached login - how do we account for the request URI?
							//wp_cache_delete( 'cached_login');
							//if ( false === $cached_login ) {

								$args = array(
									'echo' => true,
									'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
									'form_id' => 'loginform',
									'label_username' => __( 'Username' ),
									'label_password' => __( 'Password' ),
									'label_remember' => __( 'Remember Me' ),
									'label_log_in' => __( 'Log In' ),
									'id_username' => 'user_login',
									'id_password' => 'user_pass',
									'id_remember' => 'rememberme',
									'id_submit' => 'wp-submit',
									'remember' => true,
									'value_username' => NULL,
									'value_remember' => false );

								$form = '

									<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php?wpe-login=kcoolman', 'login' ) ) . '" method="post">

										' . apply_filters( 'login_form_top', '', $args ) . '

										<p class="login-username">

											<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>

											<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '" size="20" tabindex="10" />

										</p>

										<p class="login-password">

											<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>

											<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value="" size="20" tabindex="20" />

										</p>

										' . apply_filters( 'login_form_middle', '', $args ) . '

										' . ( $args['remember'] ? '<p class="login-remember"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever" tabindex="90"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '

										<p class="login-submit">

											<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="button-primary" value="' . esc_attr( $args['label_log_in'] ) . '" tabindex="100" />

											<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />

										</p>

										' . apply_filters( 'login_form_bottom', '', $args ) . '

									</form>';

								echo $form;
								//wp_cache_set( 'cached_login', $form );

							//}

							//else { echo $cached_login; }

						?>

						<a class="dt-cancel" href="my-account/lost-password/">Forgot your login?</a>

						<div class="caricature caricature-6" id="login-caricature-left"></div>

					</div>
				</div>

				<div class="large-6 medium-6 columns" id="dt-login-register">
				<div class="large-12 large-centered columns">

					<p class="login-small">Join the conversation!</p>
					<h1>Register for a Free Trial Account<br> or<br> View Subscription Plans</h1>
					<a class="button register" href="/membership/">Register Now</a>
					<div id="login-print" style="margin-top:50px;width:100%;text-align:center;">
						<p class="login-small">By signing up for Double Toasted, you agree <br />to our <a href="#terms">Terms of Service</a> and <a href="#privacy">Privacy Policy</a></p>
					</div>

					<div class="caricature caricature-5" id="login-caricature-right"></div>

				</div>
				</div>



		<?php } else { ?>

			<h1>Log-in</h1>

		<?php } ?>
	</div>
</div>

<div class="dt-window-wrap <?php echo $onAirClass; ?> dt-side-start-on" id="dt-window-wrap">

	<div class="header">

		<div class="content full-width main-sub-nav">

		</div>

		<div class="content full-width main-nav-strip">

			<div class="logo left">
				<a href="/" target="_self" class="main-logo-link"><img src="/wp-content/themes/toasted/images/double-toasted-logo@2x.png" width="185" rel="DoubleToasted.com" /></a>
			</div>

			<a id="dt-open-mob-menu">MENU <span class="icon-down-open-big dt-feat-arrow"></span></a>


			<p class="deformat dt-account-links">

				<?php if ( $isuser ) : ?>

					<a class="dt-donate-header" target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3UJNTB2CUA3MC">DONATE</a>

					<?php

						$userid = bp_loggedin_user_id();
						$bpusername = bp_members_get_user_nicename( $userid );

						global $bp;

						echo '<a id="dt-usr-mail" class="dt-header-user with-icon" href="/members/' . $bpusername . '/messages/" title="Messages"> <span class="show-for-large-up">';
						bp_total_unread_messages_count();
						echo '</span></a>';

						// Pulls notification number from Buddypress
						$count    = bp_notifications_get_unread_notification_count( $userid );
						$class    = ( 0 === $count ) ? 'inactive' : 'active';
						echo '<a id="dt-usr-ntfctn" class="dt-header-user with-icon ' . $class . '" href="/members/' . $bpusername . '/notifications/" title="Notifications"> <span class="show-for-large-up">' . number_format_i18n( $count ) . '</span></a>';

					?>

					</a>


					<a id="dt-usr-settings" class="dt-header-user with-icon" href="/activity" title="Settings"> <span class="show-for-large-up">Home</span></a>
					<a id="dt-usr-profile" class="dt-header-user with-icon" href="/members/<?php echo $bpusername; ?>/" title="Activity"> <span class="show-for-large-up"><?php echo $bpusername; ?></span></a>
					<a id="dt-usr-logout" class="dt-header-user show-for-large-up" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">Logout</a>


				<?php else : ?>



				<?php endif; ?>

			<?php
					// Removed search form after integrating show specific searches
					// $cached_search_form = wp_cache_get( 'cached_search_form' );

					// if ( false === $cached_search_form ) {
					// 	$search_form = get_search_form();
					// 	wp_cache_set( 'cached_search_form', $search_form );
					// 	echo $search_form;
					// }
					// else { echo $cached_search_form; }
			 ?>
		 </p>


			<a class="dt-open-feature">FEATURED <span class="icon-down-open-big dt-feat-arrow"></span></a>

			<div class="nav right">
				<a class="open-mobile" style="display:none;" href="#mobile-menu"></a>

				<?php

					//$cached_desktop_nav = wp_cache_get( 'cached_desktop_nav' );
					// Removed cached nav here - there were some issues getting the on-air nav up

					//if ( false === $cached_desktop_nav ) {
						$nav_menu = wp_nav_menu( array( 'echo' => false, 'items_wrap' => '%3$s', 'theme_location' => 'frank_primary_navigation', 'container' => false ) );
						$nav_menu .= '<li id="menu-item-60" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-60"><a class="dt-donate-header" target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3UJNTB2CUA3MC">DONATE</a></li>';
						$nav_menu .= '<li id="menu-item-60" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-60"><a class="dt-toggle thickbox" href="/#TB_inline?width=800&height=500&inlineId=dt-login" id="dt-toggle-login">LOG-IN / JOIN</a></li>';
						//wp_cache_set( 'cached_desktop_nav', $nav_menu );
						echo '<ul class="main-nav-menu" id="menu-main-menu">' . $nav_menu . '</ul>';
					//}
					//else { echo '<ul class="main-nav-menu" id="menu-main-menu">' . $cached_desktop_nav . '</ul>'; $nav_menu = $cached_desktop_nav; }

				?>

			</div>

		</div>

		<div class="large-12 columns" id="dt-mobile-nav-menu">
			<?php echo '<div class="menu-main-menu-container" id="mobile-menu"><ul class="main-mobile-menu">' . $nav_menu . '</ul></div>'; ?>
		</div>

	</div><!-- .header -->
