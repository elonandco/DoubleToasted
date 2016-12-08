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
	<img src="../wp-content/themes/toasted/images/reviews_top_image.gif" class="top-banner">

	<div class="content">

		<?php

			$args = array(
				'post_type' => 'dt_shows',
				'posts_per_page' => 20,
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

					<div class="overflow">

						<div class="large-5 medium-6 small-12 columns">

							<h2 class="page-title" style="margin-bottom:30px;">Reviews</h2>

						</div>
						<div class="large-7 medium-6 small-12 columns">
							<form method="get" id="dt-posts-custom-search" class="fl-right" action=""><input type="text" placeholder="Search" name="s" id="s" /></form>

                            <?php
                            $categorySortType = 'dt_shows';
                            $categorySortCategory = 'reviews';
                            include( locate_template( 'templates/partials/content-categorysort.php' ) );
                            ?>

							<!--<select id="dt-posts-order-by" type="dt_shows" category="reviews" meta="<?php /*echo wp_create_nonce( 'dt-ajax-sort-posts' ); */?>">
								<option value="newest">Newest</option>
								<option value="oldest">Oldest</option>
								<option value="rating">Koreys Rating</option>
								<option value="rating_mart">Martins Rating</option>
								<option value="popular">Most Popular</option>
								<option value="toasty">Most Toasted</option>
							</select>-->
							<a class="fl-right dt-rss-feed" href="/shows/reviews/" target="_blank">FEED</a>
						</div>

					</div>

					<div class="dt-scroll-wrap show-more-wrap">

					<?php while ( $review_query->have_posts() ): ?>

						<?php $review_query->the_post(); ?>

						<div class="post large-3 medium-4 small-12 columns end animate-post">

							<a class="dt-archive-thumb-small" href="<?php the_permalink(); ?>">

								<?php
									if (class_exists('MultiPostThumbnails')) :
										MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'dt-review-poster', NULL, 'sm-review');
									endif;
								 ?>

								 <div class="dt-archive-review-meta">

									<?php

										// Get Favorite Count
										if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . $post->ID ) ) {
											while ( bp_activities() ) : bp_the_activity();

											$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );
											if (!$my_fav_count >= 1)
												$my_fav_count = 0;
											echo '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
											endwhile;

										}

										// Get Comment Count
										echo '<span class="dt-archive-com-count">' . get_comments_number() . '</span><br />';

										$rating = get_post_meta( $post->ID, '_lac0509_rev_rating', true );
										$rating_mart = get_post_meta( $post->ID, '_lac0509_rev_mart_rating', true );
										if ($rating) {
											$rating = $rating - 1;
											echo '<span class="dt-archive-meta-rating"><span style="vertical-align:-2px;display:inline-block;margin-right:5px;font-weight:400;">K</span><img src="/wp-content/themes/toasted/images/reviews-meta-ratings-martini-' . $rating . '.png" width="130" alt="Our Rating" /></span>';
										}

										if ($rating_mart) {
											$rating_mart = $rating_mart - 1;
											echo '<br /><span class="dt-archive-meta-rating"><span style="vertical-align:-2px;display:inline-block;margin-right:5px;font-weight:400;">M</span><img src="/wp-content/themes/toasted/images/reviews-meta-ratings-martini-' . $rating_mart . '.png" width="130" alt="Our Rating" /></span>';
										}

									?>

								 </div>
								<?php
								// PollDaddy Rating Support
								if ( function_exists( 'polldaddy_get_rating_html' ) ) {
									$html = polldaddy_get_rating_html( 'check-options' );
									$elon = str_replace("!important", "", $html);
									echo '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">'.$html.'</div>';
								}
								?>
							</a>
						</div>

					<?php endwhile; ?>

					<?php get_template_part( 'templates/post-pagination' ); ?>

					</div>

					<div style="clear:both;" id="load-more-dt-posts" class="load-more"
						 data-currentpage="1"
						 data-lastpage="<?php echo $review_query->max_num_pages; ?>"
						 data-type="dt_shows"
						 data-category="reviews"
						 data-meta="<?php echo wp_create_nonce( 'dt-ajax-load-more-reviews' ); ?>">

						<img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
						<a href="#!">Show More</a>

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
                            <script>
                            var i = 0,
                            stars = document.getElementsByClassName('rating-star-icon');

                            console.log(stars.length)

                            for(i;i<stars.length;i++){
                                stars[i].style.backgroundSize = '100% auto';
                            }

                            </script>
<?php get_footer(); ?>