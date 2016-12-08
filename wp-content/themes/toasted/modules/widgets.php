<?php

// Latest News Widget

class My_Widget extends WP_Widget {

	public function __construct() {
		
	}

	public function widget( $args, $instance ) {
		$args = array( 'numberposts' => 1 );
			$recent_posts = get_posts($args);	
			foreach( $recent_posts as $recent ){
				setup_postdata( $recent );
				$recentwidget = get_the_post_thumbnail($recent->ID);
				$recentwidget .= '<h6><a href="' . get_permalink($recent->ID) . '" title="'. get_the_title($recent->ID) . '" >' . get_the_title($recent->ID) .'</a></h6>';
				$recentwidget .= get_the_excerpt($recent->ID);	
			}
		echo '<div class="large-4 columns recent-widget"><h5>Latest News</h5>' . $recentwidget . 'hey' . '</div>';
	}

 	public function form( $instance ) {
		// outputs the options form on admin
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
     register_widget( 'My_Widget' );
});

?>