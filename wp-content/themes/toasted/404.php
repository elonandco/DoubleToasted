<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

<?php

$post = $_GET['post_type'];

if ($post == 'dt-users-blog') { ?>

	<div class="main" role="main">
	
		<div class="content">
		
			<div class="large-12 medium-12 columns">
			
				<h2>You haven't published this article yet. </h2><p>Select "save and publish" while editing to publish.</p>
			
			</div>
		
		</div>
		
	</div>

<?php } else { ?>

<div class="main 404" role="main">

	<div class="content">

		<div class="large-8 large-centered columns" style="text-align:center;">
		
			<h1 class="404-title">404</h1>
			<h2><?php _e( 'What the #!@& did you do?!', 'frank_theme' ); ?></h2>
			
			<p><?php	echo sprintf( __( 'Just kidding. We couldn\'t find what you were looking for though, try searching the archives at the top of the page. ', 'frank_theme' ), $home_link ); ?></p>
		
		</div>
		
	</div>
	
</div>

<?php } ?>

<?php get_footer(); ?>