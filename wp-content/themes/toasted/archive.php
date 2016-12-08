<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>

    <div class="archive shows-archive main">
        <div class="content">

            <?php if (have_posts()) : ?>
                <div class="archive-posts large-12 medium-12 columns">
                    <div class="overflow">
                        <div class="show-title columns">
                            <?php $post = $posts[0]; ?> <!-- Hack so the_date() works -->
                            <?php if (is_tax()): ?>
                                <?php
                                // Handles Review/Freview Category Hierarchy
                                $terms        = wp_get_post_terms($post->ID, 'series');
                                $howManyTerms = count($terms);
                                $i            = 0;
                                if ($howManyTerms >= 2) {
                                    $i = $howManyTerms - 1;
                                }
                                ?>
                                <h2 class="page-title"><?php echo $terms[$i]->name; ?></h2>
                                <p class="dt-crumbs"><a href="/all-shows/">Shows</a> > <?php echo $terms[$i]->name; ?>
                                </p>
                            <?php elseif (is_category()) : //category archive ?>
                                <h2 class="page-title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217;
                                    Category</h2>
                            <?php elseif (is_tag()) : // tag archive ?>
                                <h2 class="page-title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
                            <?php elseif (is_day()) : // daily archive ?>
                                <h2 class="page-title">Archive for <?php the_time('F jS, Y'); ?></h2>
                            <?php elseif (is_month()) : // monthly archive ?>
                                <h2 class="page-title">Archive for <?php the_time('F, Y'); ?></h2>
                            <?php elseif (is_year()) : // yearly archive ?>
                                <h2 class="page-title">Archive for <?php the_time('Y'); ?></h2>
                            <?php elseif (is_author()) : // author archive ?>
                                <h2 class="page-title">Author Archive</h2>
                            <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : // paged archive ?>
                                <h2 class="page-title">Blog Archives</h2>
                            <?php else : // paged archive ?>
                                <h2 class="page-title">Shows</h2>
                                <p class="dt-crumbs"><a href="/all-shows/">Shows</a> > All Shows</p>
                            <?php endif; ?>
                        </div> <!-- /.large-6 -->

                        <div class="show-filters columns" id="dt-filter-search">
                            <form method="get" id="dt-posts-custom-search" class="fl-right" action="">
                                <input type="text" placeholder="Search" name="s" id="s"/>
                            </form>

                            <?php
                            $categorySortType = 'dt_shows';
                            $categorySortCategory = $terms[$i]->slug;
                            include( locate_template( 'templates/partials/content-categorysort.php' ) );
                            ?>

                            <a class="fl-right dt-rss-feed" href="feed/" target="_blank">FEED</a>
                        </div> <!-- /#dt-filter-search -->
                    </div> <!-- /.overflow -->

                    <div class="show-more-wrap dt-make-grid" data-columns>
                        <?php while (have_posts()): ?>
                            <?php the_post(); ?>
                            <div class="post columns animate-post">
                                <?php
                                global $onAirPostData;
                                // This will mark an on-air post as special
                                if ($post->ID == $onAirPostData[0]['ID']) {
                                    $onAirListClass = true;
                                } else {
                                    $onAirListClass = false;
                                }
                                ?>

                                <a class="dt-archive-thumb-small" href="<?php the_permalink(); ?>">
                                    <div class="dt-post-info">
                                        <span style="font-weight:600;font-size:14px;line-height:20px;">
                                            <?php echo get_the_date('F j'); ?>
                                        </span>
                                    </div> <!-- /.dt-post-info -->

                                    <div class="dt-post-thumb">
                                        <?php
                                        the_post_thumbnail('sm-archive');

                                        // If the show is live add special sauce
                                        // removed on air paragraph tag
                                        /*if ($onAirListClass) {
                                            echo '<p style="margin: 0px;background-color:#FDE562;border-top-left-radius:7px;padding: 10px;width: auto;display: inline;position: absolute;top: 0px;color:#0C1E41;">ON-AIR NOW!</p>';
                                        }*/
                                        ?>

                                        <div class="dt-post-meta dt-show-meta">
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

                                            // get reviews count
                                            $wooCommerceSku = get_post_meta($post->ID, '_lac0509_dt-show-sku', true);
                                            $wooCommerceProduct = new WC_Product($wooCommerceSku);
                                            echo '<span class="dt-archive-review-count">' . $wooCommerceProduct->get_review_count() . '</span>';
                                            ?>
                                        </div> <!-- /.dt-post-meta -->

                                        <?php
                                        if (function_exists('polldaddy_get_rating_html')) {
                                            $html = polldaddy_get_rating_html('check-options');
                                            $title .= '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">' . $html . '</div>';
                                        }
                                        echo $title;
                                        ?>
                                    </div> <!-- /.dt-post-thumb -->
                                </a>

                                <div class="dt-post-info">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div> <!-- /.post -->
                        <?php endwhile; ?>
                    </div> <!-- /.show-more-wrap -->

                    <?php if ($wp_query->max_num_pages > 1) : ?>
                        <div style="clear:both;" id="load-more-dt-posts" class="load-more"
                             data-currentpage="1"
                             data-lastpage="<?php echo $wp_query->max_num_pages; ?>" type="dt_shows"
                             data-category="<?php echo $terms[$i]->slug; ?>"
                             data-meta="<?php echo wp_create_nonce('dt-ajax-load-more-reviews'); ?>">
                            <img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
                            <a href="#!">Show More</a>
                        </div>
                    <?php endif; ?>
                </div> <!-- /.archive-posts -->
            <?php else : ?>
                <div class="archive-none large-9 medium-9 columns" style="margin-bottom:30px;overflow:hidden;">
                    <h1><?php _e('Nothing yet. Stay tuned.', 'frank_theme'); ?></h1>
                    <p><?php _e('You might want to try using the search bar above.', 'frank_theme'); ?></p>
                </div>
            <?php endif; ?>
        </div> <!-- /.content -->

    </div><!-- /.archive.main -->

<?php get_footer(); ?>