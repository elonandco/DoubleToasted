<?php
/**
 * @package Frank
 */
/*
Template Name: Archive: Comics
*/
?>

<?php get_header(); ?>

<div class="archive comic-archive main">

	<div class="dt-toggle-fixed" id="dt-toggle-fixed">
		<a class="icon-left-open-big"></a>
	</div>

	<div class="content">

			<?php if ( have_posts() ) : ?>
						
				<div class="archive-posts large-12 medium-12 columns">
					<div class="large-12 medium-12 columns">

						<h2 class="page-title">Comics</h2>
						<p class="dt-crumbs"><a href="/comics/">Comics</a> > All Comics</p>					
					
					</div>
					
					<div class="dt-scroll-wrap">
				
					<?php while ( have_posts() ): ?>
					
						<?php the_post(); ?>
						
						<div class="post large-4 medium-6 small-12 columns end">

							<a class="dt-archive-thumb-small" href="<?php the_permalink(); ?>">
							
							<?php echo the_post_thumbnail('sm-archive'); ?>
							
								<div class="dt-post-info">
								
								<?php
									
// 									$dtIssue = get_post_meta( $post->ID, '_lac0509_dt-comic-issue', true ); 
// 									if ($dtIssue) {
// 										echo '<span class="dt-ep">Issue '.$dtIssue . '</span>';
// 										the_title('<span class="dt-sh-title">', '</span>', true); 
// 									}
								
									$newPostDate = human_time_diff( get_the_date('U'), current_time('timestamp') );
									echo '<span style="font-weight:100;font-size:13px;">' . $newPostDate . ' ago</span><br />';
									the_title('<span class="dt-sh-title">', '</span>', true); 
										
								?>
	
								</div>
							
							</a>
							
						</div>
						
					<?php endwhile; ?>
						
					<?php get_template_part( 'templates/post-pagination' ); ?>
					</div>
						
				</div>
				
				<?php else : ?>
				
				<div class="archive-none large-12 columns">
				
					<h1><?php _e( 'No comics added yet.', 'frank_theme' ); ?></h1>
					<p><?php _e( 'Try searching the site above.', 'frank_theme' ); ?></p>
					
				</div>
				
			<?php endif; ?>

	</div>
</div><!-- .archive.main -->

<?php get_footer(); ?>