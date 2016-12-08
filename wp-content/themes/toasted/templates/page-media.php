<?php
/**
 * @package Frank
 */
/*
Template Name: Media Page
*/
?>

<?php get_header(); ?>

<div class="main single">
	
	<div class="content full-width dt-media">
		<div class="content">

			<?php while ( have_posts() ) : ?>
			
				<?php the_post(); ?>
				<div id="dt-media-header">
					<div class="large-7 medium-6 columns">
						
						<h1><?php the_title(); ?></h1>
						
						<?php get_template_part( 'modules/breadcrumbs' ); ?>
						
					</div>
					
					<div class="post-paging large-5 medium-6 columns single-nav">
	
						<?php get_template_part( 'modules/post-nav-social' ); ?>
					
					</div>
				</div>
				
				<div class="post-content large-12 medium-12 columns">
					
					<?php the_content(); ?>
					<?php get_template_part( 'modules/post-metadata' ); ?>	
	
				</div>

			<?php endwhile; ?>
		</div>
	</div>
	
	<div class="content">
	
		<div class="large-12 columns">
	
			<h2 id="dt-media-more">Recent Shows</h2>
		
			<div id="dt-single-slider">
				
				<?php
				
					$args = array(
						'numberposts' => 16,
						'orderby' => 'post_date',
						'order' => 'DESC',
						'post_type' => 'dt_shows',
						'post_status' => 'publish' );
					
					$homeQ = wp_get_recent_posts( $args, ARRAY_A );
				
					foreach ($homeQ as $recentPost) {
	
						echo '<a href="' . get_the_permalink($recentPost["ID"]) . '">' . get_the_post_thumbnail($recentPost["ID"], 'sm-archive');
						echo '<span class="dt-ep">' . $recentPost["post_title"] . '</span>';
						echo '</a>';	
					
					}
					
				?>
				
			</ul>
		
		</div>
		
		</div>
		
	</div>
	
</div><!-- .single.main -->

<?php get_footer(); ?>