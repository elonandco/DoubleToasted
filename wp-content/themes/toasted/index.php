<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

    <div class="archive news-archive main page">
        <img src="../wp-content/themes/toasted/images/news_top_image.gif" class="top-banner">
        <div class="content">
            <?php if (have_posts()) : ?>
                <div class="archive-news large-12 columns">

                    <div class="dt-news-header overflow">
                        <div class="large-8 medium-6 small-12 columns">
                            <h2 class="page-title">News</h2>
                            <p class="dt-crumbs"><a href="/news/">News</a> > All News</p>
                        </div> <!-- /.dt-news-header -->

                        <div class="large-4 medium-6 small-12 columns">

                            <?php
                            $categorySortType = 'post';
                            include(locate_template('templates/partials/content-categorysort.php'));
                            ?>

                            <!--<select id="dt-posts-order-by" type="post" category="false" meta="<?php /*echo wp_create_nonce( 'dt-ajax-sort-posts' ); */ ?>">
							<option value="newest">Newest</option>
							<option value="oldest">Oldest</option>
							<option value="popular">Most Popular</option>
							<option value="toasty">Most Toasted2</option>
						</select>-->
                            <a class="fl-right dt-rss-feed" href="/news/feed/" target="_blank">FEED</a>
                        </div> <!-- /.columns -->
                    </div> <!-- /.dt-news-header -->

                    <div class="news-posts show-more-wrap dt-make-grid" id="news-posts-archive" data-columns>
                        <?php while (have_posts()): ?>
                            <?php the_post(); ?>
                            <?php $newsthumb = get_the_post_thumbnail($post->ID, 'sm-archive'); ?>

                            <div class="post columns end<?php echo $newsthumb ? ' has-news-thumb' : ''; ?> animate-post">
                                <p class="dt-news-date"><?php echo get_the_date(); ?></p>
                                <a href="<?php the_permalink(); ?>">
                                    <h2>
                                        <?php the_title(); ?>
                                    </h2>
                                    <div class="dt-news-thumb">
                                        <?php echo $newsthumb; ?>

                                        <div class="dt-post-meta-single meta-news">
                                            <div class="dt-post-meta-center">
                                                <?php
                                                // Get Favorite Count
                                                if (bp_has_activities('&action=new_blog_post&secondary_id=' . $post->ID)) {
                                                    while (bp_activities()) : bp_the_activity();

                                                        $my_fav_count = bp_activity_get_meta(bp_get_activity_id(), 'favorite_count');

                                                        if (!$my_fav_count >= 1) {
                                                            $my_fav_count = 0;
                                                        }

                                                        echo '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
                                                    endwhile;
                                                }

                                                // Get Comment Count
                                                echo '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
                                                ?>
                                            </div>
                                        </div> <!-- /.dt-post-meta-single -->

                                        <?php
                                        if (function_exists('polldaddy_get_rating_html')) {
                                            $html = polldaddy_get_rating_html('check-options');
                                            echo '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">' . $html . '</div>';
                                        }
                                        ?>

                                    </div> <!-- /.dt-news-thumb -->
                                </a>

                                <div class="dt-news-info">
                                    <?php the_excerpt(); ?>
                                    <a class="button" href="<?php the_permalink(); ?>">Read More</a>
                                </div> <!-- /.dt-news-info -->
                            </div> <!-- /.post -->
                        <?php endwhile; ?>
                    </div> <!-- /.news-posts -->

                    <?php if ($wp_query->max_num_pages > 1) : ?>
                        <div style="clear:both;" id="load-more-dt-posts" class="load-more"
                             data-currentpage="1"
                             data-lastpage="<?php echo $wp_query->max_num_pages; ?>"
                             data-type="post"
                             data-category="false"
                             data-meta="<?php echo wp_create_nonce('dt-ajax-load-more-reviews'); ?>">

                            <img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
                            <a href="#!">Show More</a>
                        </div> <!-- /.load-more-dt-posts -->
                    <?php endif; ?>
                </div> <!-- /.archive-news -->
            <?php else : ?>
                <div class="archive-none large-12 medium-12 columns">
                    <h1><?php _e('No Results Were Found', 'frank_theme'); ?></h1>
                    <p><?php _e('There were no matches for your search. Please try a different search term.', 'frank_theme'); ?></p>

                    <div class="search-again">
                        <?php get_search_form(); ?>
                    </div> <!-- /.search-again -->
                </div> <!-- /.archive-none -->
            <?php endif; ?>
        </div> <!-- /.content -->
    </div><!-- /.archive.main -->
<?php get_footer(); ?>