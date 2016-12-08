<?php
/**
 * @package Frank
 */
/*
Template Name: Cleanup Functions
*/
?>

<!-- Used for doing back-end clean up stuff -->
<?php get_header(); ?>

<div class="main single on-air show-simple-comments">

<?php

$args = array('post_type' => 'dt-audio');

// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	echo '<h2>Updating posts</h2>';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$check = set_post_type( get_the_ID(), 'dt_shows' );
		echo '<h4 style="color:black;padding-top:20px;">'.get_the_title().'</h4>';
	}
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();




?>
</div><!-- .single.main -->

<?php get_footer(); ?>