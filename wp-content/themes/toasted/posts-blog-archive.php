<?php
/**
 * @package Frank
 */
/*
Template Name: Blog Archive
*/
?>

<?php get_header(); ?>

<div class="archive shows-archive main">

	<div class="dt-toggle-fixed" id="dt-toggle-fixed">
		<a class="icon-left-open-big"></a>
	</div>

	<div class="content">

			<?php if ( have_posts() ) : ?>
			
				<div class="archive-news large-12 medium-12 columns">
					<div class="large-12 medium-12 columns">
					
						<h2 class="page-title">News</h2>
						<p class="dt-crumbs"><a href="/shows/">News</a> > All Shows</p>
					
					</div>
				
					<?php while ( have_posts() ): ?>
					
						<?php the_post(); ?>
						
						<div class="post large-3 medium-4 small-2 columns">

							<?php the_post_thumbnail('sm-archive'); ?>
							
							<div class="dt-post-info">

								<?php $dtEpisode = get_post_meta( $post->ID, '_lac0509_dt_show_episode', true ); ?>
								<a href="<?php the_permalink(); ?>"><?php echo 'Episode '.$dtEpisode; ?></a>
								<a class="show-episode" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							</div>
						</div>
						
					<?php endwhile; ?>
						
					<?php get_template_part( 'modules/post-pagination' ); ?>
						
				</div>
				
				<?php else : ?>
				
				<div class="archive-none large-9 medium-9 columns">
				
					<h1><?php _e( 'No Results Were Found', 'frank_theme' ); ?></h1>
					<p><?php _e( 'There were no matches for your search. Please try a different search term.', 'frank_theme' ); ?></p>
					
					<div class="search-again">	
						<?php get_search_form(); ?>
					</div>
					
				</div>
				
			<?php endif; ?>

	</div>
</div><!-- .archive.main -->

<?php get_footer(); ?>