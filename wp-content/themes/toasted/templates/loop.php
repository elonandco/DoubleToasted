<?php
?>
<div class="large-12 columns">

	<?php
	
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			get_template_part( 'modules/post' );
		
		endwhile;
		endif; 
	?>

</div>