<?php
/**
 * The template for displaying Buddypress pages
 *
 *
 * @package Wordpress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php

if ( have_posts() ) :

	// Start the Loop.
	while ( have_posts() ) : the_post(); 
	
	?>
			
		<?php the_content(); ?>


	<?php
	endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>