<?php
/**
 * @package Frank
 */
/*
Template Name: Account Log-in
*/
?>

<?php get_header(); ?>

<div class="main single">
	
	<div class="content">
	
		<?php if (!is_user_logged_in()) { ?>
		
			<?php while ( have_posts() ) : ?>
			
				<?php the_post(); ?>
				
				<div class="post-content large-4 medium-6 large-centered medium-centered columns">
							
					<h1><?php the_title(); ?></h1>
							
					<?php 
					
					$args = array(
						'echo' => true,
						'redirect' => 'http://kcoolman.wpengine.com/activity/', 
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
						'value_remember' => false ); ?>
					
					<?php
					
					$args = array('redirect' => get_permalink( get_page( $page_id_of_member_area ) ) );
					
					if ($GLOBALS[ 'isLoginFail' ]) {
						?>
							<div id="login-error">
								<p>Username/password incorrect.</p>
							</div>
						<?php
					}
				
					wp_login_form( $args );
					
					?>
				
				</div>
	
			<?php endwhile; ?>
		<?php } else { ?>
			<h1>Log-in</h1>
			<p>
		<?php } ?>
	</div>
	
</div><!-- .single.main -->

<?php get_footer(); ?>