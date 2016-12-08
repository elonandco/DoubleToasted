<?php
/**
 * @package Frank
 */
/*
Template Name: On-air Page
*/
?>

<?php
// If there is an on-air show, load that post data into the page.
if ($onAirPostData) {
    $posts = query_posts('post_type=dt_shows&p=' . $onAirPostData[0]['ID']);
}
?>

<?php get_header(); ?>

    <div class="main single on-air show-simple-comments">

        <div class="content full-width dt-media">

            <?php while (have_posts()) : ?>

                <?php the_post(); ?>

                <div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">

                    <?php if (!$onAirPostData) { ?>

                        <div id="dt-video-option" class="dt-dead-feed">

                            <div id="dt-option-content">
                                <h2>CURRENTLY OFFLINE</h2>
                                <a class="dt-click button" href="http://www.doubletoasted.com/membership/">View
                                    Plans</a>
                            </div>

                        </div>

                    <?php } else {

                        $currentUser = wp_get_current_user();

                        // Check if the user has purchased
                        if ($currentUser) {

                            $productID = get_post_meta($post->ID, '_lac0509_dt-show-sku', true);

                            if ($productID) {

                                $subStatus = WC_Subscriptions_Manager::user_has_subscription($user_id = $currentUser->ID, $product_id = '', $status = 'active');

                                if ($subStatus) {
                                    $hasAccess = true;
                                } else {
                                    if (woocommerce_customer_bought_product($currentUser->user_email, $currentUser->ID, $productID)) {

                                        $hasAccess = true;

                                    }
                                }

                            }

                            $freeShow = get_post_meta($post->ID, '_lac0509_dt-free-show', true);

                            if ($freeShow) {
                                $hasAccess = true;
                            }
                        }

                        // User has purchased, serve the toasty streampie
                        if ($hasAccess) {

                            $blastroID = get_post_meta($post->ID, '_lac0509_dt-blastro-id', true);

                            if ($blastroID) {

                                require_once('blastro/BlCrypto.php');

                                echo '<div style="text-align: center; background-color: black;">
                                        <iframe src="https://ppv.gigcasters.com/embed/' . $blastroID . '.html"
                                                    width="1066" height="650" scrolling="no" frameborder="0">[Your browser does
                                                not support frames or is currently
                                                configured not to display frames. Please use an up-to-date browser that is
                                                capable of displaying frames.]
                                            </iframe>
                                      </div>';

                            } else {

                                echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is an issue with our livestream server. Please check back soon.</h2>';

                            }

                        } else {

                            ?>

                            <div id="dt-video-option">

                                <div id="dt-option-content" class="on-air">

                                    <h2>We are live! You have 2 options to access the live show:</h2>

                                    <?php

                                    if ($productID) {

                                        echo '<a class="dt-click button" href="http://doubletoasted.com/cart/?add-to-cart=' . $productID . '">Buy Stream</a>';

                                    }
                                    ?>
                                    <a class="dt-click button" href="http://kcoolman.wpengine.com/membership/">View
                                        Plans</a>

                                </div>

                            </div>

                        <?php }

                    } ?>

                </div>

            <?php endwhile; ?>

            <div id="dt-media-header">
                <div class="content">
                    <div class="large-7 medium-6 columns">

                        <h1><?php the_title(); ?></h1>

                    </div>

                    <?php if ($onAirPostData) { ?>

                        <div class="post-paging large-5 medium-6 columns single-nav">


                        </div>

                    <?php } ?>
                </div>
            </div>

            <div class="second-toolbar">
                <div class="dt-icon-export">

                    <div class="dt-hover-share">

                        <?php $show_content = get_the_content(); ?>
                        <?php $thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                        <a class="icon-facebook" target="_blank"
                           href="https://www.facebook.com/sharer.php?s=100&p[title]=<?php the_title(); ?>&p[url]=<?php echo get_the_permalink($post->ID); ?>&p[summary]=<?php echo $show_content; ?>&p[images][0]=<?php echo $thumb_url; ?>"></a>
                        <a class="icon-twitter" target="_blank"
                           href="https://twitter.com/home?status=<?php echo get_the_permalink($post->ID); ?>"></a>

                        <?php

                        if (is_user_logged_in()) {

                            // Custom function to get BP activity ID from Post ID
                            $activity_id = bp_activity_get_activity_id(array(
                                'secondary_item_id' => $onAirPostData[0]['ID'],
                            ));

                            bp_has_activities();

                            if ($onAirPostData) {

                                if (my_bp_activity_is_favorite($activity_id)) : ?>

                                    <a id="dt-likeit" class="icon-heart-empty faved dt-like-single"
                                       href="<?php my_bp_activity_favorite_link($activity_id) ?>"
                                       activity="<?php echo $activity_id; ?>"></a>

                                <?php else : ?>

                                    <a id="dt-likeit" class="icon-heart-empty dt-like-single"
                                       href="<?php my_bp_activity_unfavorite_link($activity_id) ?>"
                                       activity="<?php echo $activity_id; ?>"></a>

                                <?php endif; ?>

                            <?php }

                        } ?>

                    </div>
                </div>
                <ul class="video-link">
                    <?php
                    $linksToAdd = array();
                    $audioUrl   = get_post_meta($post->ID, '_lac0509_dt-audio-url', true);
                    $videoUrl   = get_post_meta($post->ID, '_lac0509_dt-video-url', true);
                    $videoHtml  = '<li class="video"><i class="fa fa-television" aria-hidden="true"></i></li>';
                    $audioHtml  = '<li class="audio"><i class="fa fa-volume-up" aria-hidden="true"></i></li>';

                    if (!class_exists('Mobile_Detect')) {
                        require_once(dirname(dirname(__FILE__ )). '/Mobile_Detect.php');
                        $detect = new Mobile_Detect();
                    }

                    if ($detect && $detect->isMobile()) {
                        if ($audioUrl) {
                            $linksToAdd[] = $audioUrlHtml;
                        }

                        if ($videoUrl) {
                            $linksToAdd[] = $videoHtml;
                        }
                    } else {
                        if ($videoUrl) {
                            $linksToAdd[] = $videoHtml;
                        }

                        if ($audioUrl) {
                            $linksToAdd[] = $audioHtml;
                        }
                    }

                    $linksToAdd[] = '<li class="comments"><i class="fa fa-comment-o" aria-hidden="true"></i></li>';

                    $i = 0;
                    foreach ($linksToAdd as $link) {
                        if ($i == 0) {
                            $link = str_replace('class="', 'class="active ', $link);
                        }

                        echo $link;
                        $i++;
                    }
                    ?>
                </ul>
            </div>


            <div class="content"></div>
        </div>

        <?php if ($onAirPostData) { ?>

            <div class="content clear" id="dt-side-comments">

                <div class="large-12 columns">
                    <h2 id="dt-media-more">

                        Comments

                        <?php if (!is_user_logged_in()) { ?>

                            <a class="button thickbox" href="#TB_inline?width=800&height=450&inlineId=dt-login"
                               id="log-in-comment">Log-in to comment</a>

                        <?php } ?>

                    </h2>
                </div>

                <div class="activity large-9 medium-10 small-12 columns" role="main">

                    <?php

                    bp_get_template_part('activity/activity-loop-single');

                    ?>

                </div><!-- .activity -->

                <div class="large-3 columns medium-2 small-12" style="text-align:center;">

                    <?php

                    dynamic_sidebar('dt-feature-single');

                    ?>

                </div>

            </div>

        <?php } else { ?>

            <div class="content"></div>

        <?php } ?>

    </div><!-- .single.main -->

    <div class="more-shows">
        <div class="divider"></div>
        <div class="show show-all-series">
            <div class="title">
                <h2>RECENT SHOWS</h2>
                <div class="categories fan-dropdown">
                    <div class="drop">Categories<span>v</span></div>
                    <div class="dropdown">
                        <div class="tooltip"></div>
                        <ul>
                            <li value="recent">Most Recent</li>
                            <li value="popular">Most Popular</li>
                            <li value="AtoZ">Sort A to Z</li>
                            <li value="ZtoA">Sort Z to A</li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="slider">

            </ul>
            <ul class="pagination"></ul>
            <div class="prev arrow"></div>
            <div class="next arrow"></div>
        </div>
    </div>

<?php wp_enqueue_script('dt-owl-script', get_template_directory_uri() . '/modules/scripts/carousel/owl.carousel.min.js', 'pound-basic-scripts-0507', '1.0.0', true); ?>

<?php get_footer(); ?>