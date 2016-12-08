 <?php
/**
 * @package Frank
 */
?>
	<div class="row">	
		<?php get_search_form(); ?>
	</div>
		
<?php	
	$args = array( 'numberposts' => 1, 'category' => -4, );
	$recent_posts = get_posts($args);	
	foreach( $recent_posts as $recent ){
		setup_postdata( $recent );
		$recentwidget = '<h5>Recent News</h5>';
		$recentwidget .= '<a href="' . get_permalink($recent->ID) . '">' . get_the_post_thumbnail($recent->ID, 'thumb-post') . '</a>';
		$recentwidget .= '<h6><a href="' . get_permalink($recent->ID) . '" title="'. get_the_title($recent->ID) . '" >' . get_the_title($recent->ID) .'</a></h6>';
		$recentwidget .= '<p>' . get_the_excerpt($recent->ID) . '</p><a class="button" href="' . get_permalink($recent->ID) . '">Read More</a>';	
	}
	echo '<div class="row">' . $recentwidget . '</div>';

	echo '<div class="row"><h5>Archives</h5><ul class="archive-list">';
	wp_get_archives();
	echo '</ul></div>';
	
	echo '<div class="row">';
		echo do_shortcode('[twitter-widget]');
	echo '</div>';

   ?>

