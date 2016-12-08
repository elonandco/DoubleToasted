<?php

	echo '<div class="dt-paging-box">';

 	 	if (previous_post_link( '%link', '<span class="icon-left-open-mini"></span> PREVIOUS', FALSE, 'dt-users-blog' )) {
 			previous_post_link( '%link', '<span class="icon-left-open-mini"></span> PREVIOUS', FALSE, 'dt-users-blog' );
 		}

 		if ( next_post_link( '%link', 'NEXT <span class="icon-right-open-mini"></span>', FALSE, 'dt-users-blog' ) ) {
			next_post_link( '%link', 'NEXT <span class="icon-right-open-mini"></span>', FALSE, 'dt-users-blog' );
 		}

	echo '</div>';

?>

<div class="dt-icon-export">
	<div class="dt-hover-share">

		<a class="icon-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($post->ID); ?>"></a>
		<a class="icon-twitter" target="_blank" href="https://twitter.com/home?status=<?php echo get_the_permalink($post->ID); ?>"></a>

	</div>
</div>
