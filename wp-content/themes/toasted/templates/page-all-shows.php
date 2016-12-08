<?php
/**
 * @package Frank
 */
/*
Template Name: All Shows
*/
?>

<?php get_header(); ?>

<div class="archive shows-archive all-shows-archive main">

	<div class="content">

			<?php if ( have_posts() ) : ?>

				<div class="archive-posts large-12 medium-12 columns" style="margin:0px;">
					<div class="large-10 medium-10 small-12 columns">

						<h2 class="page-title">All Shows</h2>
						<p class="dt-crumbs"><a href="/all-shows/">Shows</a> > All Shows</p>

					</div>

					<div class="large-2 medium-2 small-12 columns">
						<a class="fl-right dt-rss-feed" href="/show/feed/" target="_blank">FEED</a>
					</div>

				</div>

				<?php the_post(); ?>
				<?php echo the_content(); ?>

				<?php else : ?>

				<div class="archive-none large-9 large-centered medium-9 columns">

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