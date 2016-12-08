 <?php
 
/**
 * @package Frank
 */

echo '<h5 style="margin:0px;">Resources</h5>';

// Pulls related cateogry from post meta

$args = array( 'numberposts' => 6 );
$recent_posts = get_posts($args);	

echo '<dl>';

foreach( $recent_posts as $recent ){
	setup_postdata( $recent );
	$recentwidget = '<li><a href="' . get_permalink($recent->ID) . '" title="'. get_the_title($recent->ID) . '" >' . get_the_title($recent->ID) .'</a></li>';
	echo $recentwidget;

}

echo '</dl>';


?>

