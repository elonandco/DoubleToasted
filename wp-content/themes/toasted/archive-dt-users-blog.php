<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

<div class="archive shows-archive community-blog main">

	<div class="content">

			<?php if ( have_posts() ) : ?>

				<div class="archive-posts large-12 medium-12 columns">
					<div class="overflow">
						<div class="large-5 medium-6 small-12 columns">

							<h1 style="margin-bottom:30px;">Community Blog</h1>

						</div>
						<div class="large-7 medium-6 small-12 columns">
							<form method="get" id="dt-posts-custom-search" class="fl-right" action=""><input type="text" placeholder="Search" name="s" id="s" /></form>

							<?php
							$categorySortType = 'dt-users-blog';
							include( locate_template( 'templates/partials/content-categorysort.php' ) );
							?>

							<!--<select id="dt-posts-order-by" type="dt-users-blog" category="false" meta="<?php /*echo wp_create_nonce( 'dt-ajax-sort-posts' ); */?>">
								<option value="newest">Newest</option>
								<option value="oldest">Oldest</option>
								<option value="popular">Most Popular</option>
								<option value="toasty">Most Toasted</option>
							</select>-->
							<a class="fl-right dt-rss-feed" href="/dt-users-blog/feed/" target="_blank">FEED</a>
						</div>
					</div>
					<div class="show-more-wrap dt-make-grid" data-columns>
						<?php while ( have_posts() ): ?>

							<?php the_post(); ?>

							<div class="post columns animate-post">

								<a class="dt-archive-thumb-small" href="<?php the_permalink(); ?>">
											<?php

											echo '<a href="' . get_the_permalink() . '"><span style="font-weight:600;font-size:14px;line-height:20px;color:#f70;display:block;">' . get_the_date('F j') . '</span>';
											echo '<span class="blog-title">' . get_the_title() . '</span>';

											?>
									<div class="dt-post-thumb">

										<?php

											$isthumb = get_the_post_thumbnail($post->ID, 'sm-archive');

											if ($isthumb) {
												echo $isthumb;
											}

											else {
												echo '<img src="/wp-content/themes/toasted/images/dt-users-blog-placeholder.png" />';
											}

										?>

										<div class="dt-post-meta">

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
												echo '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';

											?>

										</div>

									</div>
									<?php

									echo '<span class="blog-author"> by ' . get_the_author() . '</span></a>';

									?>
								</a>

									<div class="dt-post-info">
										<?php
											echo the_excerpt();

										?>

									</div>

							</div>

						<?php endwhile; ?>

					</div>

					<?php if ($wp_query->max_num_pages > 1) : ?>

						<div style="clear:both;" id="load-more-dt-posts" class="load-more"
							 data-currentpage="1"
							 data-lastpage="<?php echo $wp_query->max_num_pages; ?>"
							 data-type="dt-users-blog"
							 data-category="false"
							 data-meta="<?php echo wp_create_nonce( 'dt-ajax-load-more-reviews' ); ?>">

							<img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
							<a href="#!">Show More</a>

						</div>

					<?php endif; ?>

				</div>

				<?php else : ?>

				<div class="archive-none large-9 medium-9 columns" style="margin-bottom:30px;overflow:hidden;">

					<h1><?php _e( 'Nothing yet. Stay tuned.', 'frank_theme' ); ?></h1>
					<p><?php _e( 'You might want to try using the search bar above.', 'frank_theme' ); ?></p>

				</div>

			<?php endif; ?>

	</div>

</div><!-- .archive.main -->

<?php get_footer(); ?>