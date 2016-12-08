 <?php
/**
 * @package Frank
 */
?>
<!-- 
	<div class="row">	
		<?php get_search_form(); ?>
	</div>
 -->
		
<?php	

	echo '<div class="row"><h5>Archives</h5><ul class="archive-list">';
		wp_get_archives();
	echo '</ul></div>';

   ?>

