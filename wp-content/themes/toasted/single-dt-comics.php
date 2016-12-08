<?php
/**
 * @package Frank
 * This is the template for single show pages
 */
?>

<?php get_header(); ?>

<div class="main single comic-single show-simple-comments">
	
	<div class="content full-width dt-media">
	
		<div class="content">

			<?php while ( have_posts() ) : ?>
			
				<?php the_post(); ?>
				
				<div id="dt-media-header" class="clear">
				
					<div class="large-7 medium-6 columns">

						<?php echo '<h1>' . $post->post_title . '</h1>'; ?>
						
						<p class="dt-crumbs">

							<a href="/comics/">Comics</a> >
							<span><?php echo $post->post_title; ?></span>
						
						</p>
						
					</div>
					
					<div class="post-paging large-5 medium-6 columns single-nav">
	
						<?php get_template_part( 'modules/post-nav-social' ); ?>
					
					</div>
					
				</div>
				
				<div class="post-content large-12 columns" id="dt-media-subscribe">

					
					
					<?php 
					
						$folderLocation = get_post_meta($post->ID, '_lac0509_dt-comic-folder', true); 
					
						if ($folderLocation) {
							$scriptLocation = '/wp-content/uploads/comics/' . $folderLocation . '/' . $folderLocation . '.html';
							echo '<iframe id="dt-comic-strip" src="' . $scriptLocation . '" width="100%" height="700"></iframe>';
						}
					
					?>

					<?php get_template_part( 'modules/post-metadata' ); ?>

				</div>

			<?php endwhile; ?>
		</div>
	</div>
	
	<div class="content">
	
		<div class="large-12 columns">
	
			<h2 id="dt-media-more">More Comics</h2>
		
			<div id="dt-single-slider">
				
				<?php
					 
					 $args = array(
						'numberposts' => 16,
						'orderby' => 'post_date',
						'order' => 'DESC',		
						'exclude' => $post->ID,			
						'post_type' => 'dt-comics'
					);
					
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
	
	<div class="content clear" id="dt-side-comments">
		 
		<div class="large-12 columns">
			<h2 id="dt-media-more">
			
				Comments
			
				<?php if (!is_user_logged_in()) { ?>
				
					<a class="button thickbox" href="#TB_inline?width=800&height=450&inlineId=dt-login" id="log-in-comment">Log-in to comment</a>
				
				<?php } ?>
			
			</h2>
		</div>
	
		<div class="activity large-9 medium-10 small-12  columns" role="main">		
			
			<?php 
			
				bp_get_template_part( 'activity/activity-loop-single' );
			
			?>

		</div><!-- .activity -->
 		
		<div class="large-3 columns medium-2 small-12" style="text-align:center;">
		
			<?php dynamic_sidebar( 'dt-feature-single' ); ?>
			
		</div>
	
	</div><!-- #dt-side-comments -->
	
</div><!-- .single.main -->

<?php get_footer(); ?>