<?php	

	echo '<div class="dt-paging-box">';

	if ( is_singular( 'post' ) ) {

 		if (previous_post_link( '%link', '<span class="icon-left-open-big"></span> PREVIOUS' )) { 
 			previous_post_link( '%link', '<span class="icon-left-open-big"></span> PREVIOUS' );
 		}
 		
 		if ( next_post_link( '%link', 'NEXT <span class="icon-right-open-big"></span>' ) ) {
			next_post_link( '%link', 'NEXT <span class="icon-right-open-big"></span>' );
 		}
 		
 	}
 	
 	else {
 	
 	 	if (previous_post_link( '%link', '<span class="icon-left-open-big"></span> PREVIOUS', TRUE, 22, 'series' )) { 
 			previous_post_link( '%link', '<span class="icon-left-open-big"></span> PREVIOUS', TRUE, 22, 'series' );
 		}
 		
 		if ( next_post_link( '%link', 'NEXT <span class="icon-right-open-big"></span>', TRUE, 22, 'series' ) ) {
			next_post_link( '%link', 'NEXT <span class="icon-right-open-big"></span>', TRUE, 22, 'series' );
 		}


		//	get_adjacent_post( true, '22', false, 'series' );
 		
 	}
	
	echo '</div>';

?>

<div class="dt-icon-export">
	<div class="dt-hover-share">
	
		<?php $thumb_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>


		<!--<a class="comments"><i class="fa fa-comment-o" aria-hidden="true"></i></a>-->
	
		<a class="icon-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?s=100&p[title]=<?php the_title(); ?>&p[url]=<?php echo get_the_permalink($post->ID); ?>&p[summary]=<?php echo $show_content; ?>&p[images][0]=<?php echo $thumb_url; ?>"></a>
		<a class="icon-twitter" target="_blank" href="https://twitter.com/home?status=<?php echo get_the_permalink($post->ID); ?>"></a>

		<?php

		if (is_user_logged_in()) {
		
			// Custom function to get BP activity ID from Post ID
			$activity_id = bp_activity_get_activity_id( array(
				'secondary_item_id' => $post->ID
			) );
			
			bp_has_activities();
	
//			if ($onAirPostData || !is_page(3670)) {	
					
				if ( my_bp_activity_is_favorite($activity_id) ) : ?>
				
					<a id="dt-likeit" class="icon-heart-empty faved dt-like-single" postid="<?php echo $post->ID; ?>"href="<?php my_bp_activity_favorite_link($activity_id) ?>" activity="<?php echo $activity_id; ?>"></a>
				
				<?php else : ?>
				
					<a id="dt-likeit" class="icon-heart-empty dt-like-single" postid="<?php echo $post->ID; ?>" href="<?php my_bp_activity_unfavorite_link($activity_id) ?>" activity="<?php echo $activity_id; ?>"></a>
				
				<?php endif; ?>
				
			<?php // } 
			
		} ?>
		
	</div>
</div>
