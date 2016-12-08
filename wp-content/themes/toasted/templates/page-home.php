<?php
/**
 * @package Frank
 */
/*
Template Name: Home Page
*/
?>

<?php wp_enqueue_style('dt-owl-carousel', get_template_directory_uri() . '/modules/scripts/carousel/owl.carousel.css'); ?>
<?php wp_enqueue_style('dt-owl-carousel-theme', get_template_directory_uri() . '/modules/scripts/carousel/owl.theme.css'); ?>

<?php if ($_SERVER['REMOTE_ADDR'] == '104.182.29.177s'): ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Page Center -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:970px;height:90px"
         data-ad-client="ca-pub-4758578222251672"
         data-ad-slot="3881575948"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <?php
    die('stopping');
    endif;
    ?>

<?php get_header(); ?>
    <div class="index main dt-home">

        <div class="content full-width">

            <div class="relative">
                <div id="dt-home-slider" class="slider">

                    <?php

                    // Removed caching from slider (temp)
                    // $cached_home_slider = wp_cache_get( 'cached_home_slider' );
                    // if ( false === $cached_home_slider ) {

                    $args = array(
                        'numberposts' => 5,
                        'orderby'     => 'menu_order',
                        'order'       => 'DESC',
                        'post_type'   => array('post', 'dt_shows', 'dt-comics', 'dt-audio', 'dt-video'),
                        'post_status' => 'publish',
                        'tax_query'   => array(
                            array(
                                'taxonomy' => 'featured',
                                'field'    => 'slug',
                                'terms'    => 'homepage-slideshow',
                            ),
                        ),
                    );

                    $homeQuery = wp_get_recent_posts($args, ARRAY_A);

                    // Used to create a secondary slider for nav
                    //$recentNav = array();
                    $itemInfo = array();

                    // loop through all the posts
                    foreach ($homeQuery as $recentPost) {
                        $date = false;

                        // Does this show belong to a series?
                        $dtSeries = wp_get_post_terms($recentPost['ID'], 'series');

                        // Default to Category Parent (if it exists)
                        if ($dtSeries && !is_wp_error($dtSeries)) {
                            $howManyTerms = count($dtSeries);
                            $i            = 0;

                            if ($howManyTerms >= 2) {
                                $i                    = $howManyTerms - 1;
                                $dtSeries[0]->term_id = $dtSeries[$i]->term_id;
                            }

                            // if there is a post made today, lets update the $date to reflect today
                            if (strtotime($recentPost['post_date']) > strtotime('today')) {
                                $date = '<h3 class="home-date"><span style="color:#f70;">Today!</span>';

                                // add the time, if we can
                                if ($time = get_post_meta($recentPost['ID'], '_lac0509_dt-show-time', true)) {
                                    $date .= ' at ' . $time;
                                }

                                $date .= '</h3>';
                            }

                            // Lets use default title for movie reviews
                            if ($dtSeries[$i]->name == 'Reviews') {
                                $dtTitle = '<h1>' . $recentPost['post_title'] . '</h1>';
                            } else {
                                $dtTitle = '<h1 class="show-title">' . $dtSeries[$i]->name . '</h1>';
                            }
                        } else {
                            $dtTitle = '<h1>' . get_the_title($recentPost['ID']) . '</h1>';
                        }

                        if (!$date) {
                            $date = '<h3 class="home-date">' . date('F j', strtotime($recentPost['post_date'])) . '</h3>';
                        }

                        if ($recentPost['post_excerpt']) {
                            $excerpt = $recentPost['post_excerpt'];
                        } else {
                            $excerpt = strlen($recentPost['post_content']) > 250 ? substr($recentPost['post_content'], 0, 250) . '...' : $recentPost['post_content'];
                        }

                        // Added for Phase IV - Responsive image serving thru "do-resize" class - jquery component at top of load.js
                        $full_size   = wp_get_attachment_image_src(get_post_thumbnail_id($recentPost['ID']), 'lg-slider');
                        $medium_size = wp_get_attachment_image_src(get_post_thumbnail_id($recentPost['ID']), 'md-video');
                        $small_size  = wp_get_attachment_image_src(get_post_thumbnail_id($recentPost['ID']), 'sm-archive');

                        $main_slides .= '<div><div><img large="' . $full_size[0] . '" medium="' . $medium_size[0] . '" small="' . $small_size[0] . '" src="wp-content/themes/toasted/images/placeholder-black.png" class="do-resize attachment-lg-slider wp-post-image" alt="Double Toasted Shows"></div>';
                        $main_slides .= '<a href="' . get_the_permalink($recentPost["ID"]) . '"><div class="dt-slide-info large-8 medium-8 columns">' . $date . $dtTitle . '<p>' . $excerpt . '</p></div></a></div>';

                        $itemInfo[] = $recentPost['post_title'];

                        //$recentNav[] = "echo get_the_post_thumbnail(" . $recentPost["ID"] . ", 'sm-archive');";

                    }

                    echo $main_slides;

                    // 	wp_cache_set( 'cached_home_slider', $main_slides );
                    // 	wp_cache_set( 'cached_home_slider_info', $itemInfo );
                    // 	wp_cache_set( 'cached_home_slider_nav', $recentNav );

                    // }

                    // else { echo $cached_home_slider; $itemInfo = wp_cache_get('cached_home_slider_info'); $recentNav = wp_cache_get('cached_home_slider_nav'); }

                    ?>
                </div> <!-- /.dt-home-slider -->
                <div class="pagination">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                 </div>
                 <div class="prev arrow"></div>
                 <div class="next arrow"></div>
            </div>

            <?php dynamic_sidebar('dt-schedule'); ?>

            <?php
            $showsToDisplay = array();
            $seriesData     = get_terms('series', array(
                'hide_empty' => false,
            ));

            $defaultOrdinal = 500;
            foreach ($seriesData as $series) {
                $termMeta = get_option('taxonomy_' . $series->term_id);
                $ordinal  = $termMeta['ordinal'];

                if (!$ordinal) {
                    $ordinal = $defaultOrdinal;
                    $defaultOrdinal += 10;
                }

                if (isset($termMeta['hide_from_feed']) && $termMeta['hide_from_feed'] == 'true') {
                    continue;
                }

                $showsToDisplay[$ordinal] = array(
                    'title'       => $series->name,
                    'description' => $series->description,
                    'slug'        => $series->slug,
                );
            }

            array_push($showsToDisplay, array(
                'title'       => 'Miscellaneous',
                'description' => 'Miscellaneous Shows',
                'slug'        => 'misc',
            ));
            ksort($showsToDisplay, SORT_NUMERIC);
            ?>

            <div class="all-shows">
                <?php foreach ($showsToDisplay as $show): ?>
                    <div class="show show-<?php echo $show['slug']; ?>">
                        <div class="title">
                            <h2><?php echo $show['title']; ?></h2>
                            <span><?php echo $show['description']; ?></span>

                            <?php if (!in_array($show['slug'], array('fan-art', 'news'))): ?>
                                <div class="categories">
                                    <div class="drop">Categories<span>v</span></div>
                                    <div class="dropdown">
                                        <div class="tooltip"></div>
                                        <ul>
                                            <li data-order="recent">Most Recent</li>
                                            <li data-order="popular">Most Popular</li>
                                            <li data-order="AtoZ">Sort A to Z</li>
                                            <li data-order="ZtoA">Sort Z to A</li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <ul class="slider">
                            <li class="loading">Loading...</li>
                        </ul>
                        <ul class="pagination"></ul>
                        <div class="prev arrow"></div>
                        <div class="next arrow"></div>
                    </div>
                    <div class="divider"></div>
                <?php endforeach; ?>
            </div>

            <?php dynamic_sidebar('dt-home-feature-bottom'); ?>

        </div>

    </div><!-- .index.main -->

<?php get_footer(); ?>