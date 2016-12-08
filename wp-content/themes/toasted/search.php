<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

<div class="search-archive archive main" role="main">

	<div class="dt-toggle-fixed" id="dt-toggle-fixed">
		<a class="icon-left-open-big"></a>
	</div>

	<div class="content">

		<?php if ( have_posts() ) : ?>
		
			<div class="large-12 columns results">
			
				<div>
					<?php
						echo '<h1>';
						_e( 'Looking for ', 'frank_theme' );
						
						echo '&#8216';  // left single quotation mark
						echo the_search_query();
						echo '&#8217';  // right single quotation mark
						echo '</h1>';
					?>
				</div>
				
				<div class="post-search-results dt-scroll-wrap">
				
					<?php while ( have_posts() ): ?>
					
							<?php the_post(); ?>
							<?php remove_filter( 'the_excerpt', 'polldaddy_show_rating' ); ?>
							<?php get_template_part( 'templates/post' ); ?>
							
					<?php endwhile; ?>
						
					<?php get_template_part( 'templates/post-pagination' ); ?>
						
				</div>
						
			</div>
			
			<?php else : ?>
			
			<div class="large-12 columns">
				<h1>
					<?php _e( 'No Results Were Found', 'frank_theme' ); ?>
				</h1>
				<p style="color:gray;">
					<?php _e( 'There were no matches for your search. Please try a different search term.', 'frank_theme' ); ?>
				</p>
			</div>
			
		<?php endif; ?>
		
	</div>
	
</div>

<?php wp_enqueue_script( 'dt-jq-infscroll', get_template_directory_uri() . '/modules/scripts/jquery.infscroll.min.js', 'pound-basic-scripts-0507', '1.0.0', true ); ?>

<?php get_footer(); ?>