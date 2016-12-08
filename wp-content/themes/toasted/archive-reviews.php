<?php
/**
 * @package Frank
 */
/*
Template Name: Archive: Reviews
*/
?>

<?php get_header(); ?>

<div class="archive review-archive main">
	<div class="dt-toggle-fixed" id="dt-toggle-fixed">
		<a class="icon-left-open-big"></a>
	</div>
	<img src="../wp-content/themes/toasted/images/reviews_top_image.gif" class="top-banner">
	<div class="content">

		<?php
			$args = array(
				'post_type' => 'dt_shows',
				'tax_query' => array(
					array(
						'taxonomy' => 'series',
						'field' => 'slug',
						'terms' => array( 'reviews' )
					)
				)
			);

			$review_query = new WP_Query( $args ); ?>

			<?php if ( $review_query->have_posts() ) : ?>

				<div class="archive-posts large-12 medium-12 columns">
					<div class="large-12 medium-12 columns">

						<h2 class="page-title">Reviews</h2>
						<p class="dt-crumbs"><a href="/shows/">Reviews</a> > All Reviews</p>

					</div>

					<div class="dt-scroll-wrap check">

					<?php while ( $review_query->have_posts() ): ?>

						<?php $review_query->the_post(); ?>

						<div class="post large-3 medium-4 small-6 columns">

							<a class="dt-archive-thumb-small" href="<?php the_permalink(); ?>">

								<?php
									if (class_exists('MultiPostThumbnails')) :
										MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'dt-review-poster');
									endif;
								 ?>

							</a>

						</div>

					<?php endwhile; ?>

					<?php get_template_part( 'templates/post-pagination' ); ?>

					</div>

				</div>

				<?php else : ?>

				<div class="archive-none large-12 columns" style="overflow:hidden;margin-bottom:30px;">

					<h1><?php _e( 'No reviews added yet', 'frank_theme' ); ?></h1>
					<p><?php _e( 'Try searching the site above.', 'frank_theme' ); ?></p>

				</div>

			<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</div>
</div><!-- .archive.main -->
<?php get_footer(); ?>