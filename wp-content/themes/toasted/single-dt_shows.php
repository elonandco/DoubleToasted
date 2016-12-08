<?php
/**
 * @package Frank
 * This is the template for single show pages
 */
?>

<?php wp_enqueue_style('flow-css', get_template_directory_uri() . '/modules/scripts/skin/minimalist.css'); ?>

<?php get_header(); ?>

<div class="main single dt-single-show-type show-simple-comments">

    <div class="content full-width dt-media">

        <div class="contents">

            <?php while (have_posts()) : ?>

                <?php the_post(); ?>

                <div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">

                    <?php

                    $liveShow = false;

                    // Is this show Live!?
                    global $onAirPostData;
                    if ($onAirPostData[0]["ID"] == $post->ID) {
                        $liveShow = true;
                    }

                    // Check if user has purchased this particular episode
                    $productID   = get_post_meta($post->ID, '_lac0509_dt-show-sku', true);
                    $currentUser = wp_get_current_user();

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

                    $freeShow       = get_post_meta($post->ID, '_lac0509_dt-free-show', true);
                    $audiourl       = get_post_meta($post->ID, '_lac0509_dt-audio-url', true);
                    //echo 'post id ' . $post->ID;

                    if ($freeShow) {
                        $hasAccess = true;
                    }

                    // User has purchased, show the thing
                    if ($hasAccess) {

                        // If it's a VOD video
                        if (!$liveShow) {

                            $videoSD    = get_post_meta($post->ID, '_lac0509_dt-video-url', true);
                            $videoHD    = get_post_meta($post->ID, '_lac0509_dt-video-url-hd', true);
                            $imageThumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'md-video');

                            echo '<div id="dt-flow-vid-wrap" style="position:relative;background:black;">';

                            if ($videoGigcaster) { ?>
                                <div class="" style="position:relative; text-align: center;">
                                    <iframe src="http://ppv.gigcasters.com/embed/<?php echo $blastroID; ?>.html"
                                            width="1066" height="650" scrolling="no" frameborder="0">[Your browser does
                                        not support frames or is currently
                                        configured not to display frames. Please use an up-to-date browser that is
                                        capable of displaying frames.]
                                    </iframe>
                                </div>
                            <?php } elseif ($videoSD) { ?>

                                <div class="flowplayer flow-sd" style="position:relative;">
                                    <video
                                        src="http://doubletoasted.com/wp-content/uploads/ppv-video/<?php echo $videoSD; ?>"></video>
                                </div>

                                <?php if ($videoHD): ?>
                                    <div class="flowplayer flow-hd" style="position:absolute;display:none;top:0px;">
                                        <video
                                            src="http://doubletoasted.com/wp-content/uploads/ppv-video/<?php echo $videoHD; ?>"></video>
                                    </div>

                                    <a id="dt-hd-toggle"
                                       style="display:none;position:absolute;top:20px;left:20px;text-decoration:none;background:black;padding: 10px 20px 10px 15px;border-radius:10px;color: white;z-index:200;font-size: 40px;font-weight:700;font-style: italic;">SD</a>
                                <?php endif;

                                echo '</div>';

                            } else {
                                if (!$videoSD && !$videoHD) {
                                    echo '<h2 style="color:white;padding:120px 70px;background:black;">This show is still toasting but we\'ll have it ready for you soon.</h2></div>';
                                } else {
                                    echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is a problem with that video file.</h2></div>';
                                }
                            }

                        } // If it's a live stream
                        else {

                            $blastroID = get_post_meta($post->ID, '_lac0509_dt-blastro-id', true);

                            if ($blastroID) {

                                require_once('templates/blastro/BlCrypto.php');

                                echo '<div style="text-align: center; background-color: black;">
                                        <iframe src="https://ppv.gigcasters.com/embed/' . $blastroID . '.html"
                                                    width="1066" height="650" scrolling="no" frameborder="0">[Your browser does
                                                not support frames or is currently
                                                configured not to display frames. Please use an up-to-date browser that is
                                                capable of displaying frames.]
                                            </iframe>
                                      </div>';
                            } else {

                                echo '<h2 style="color:white;padding:20px;">We\'re sorry, there is an issue with the livestream ID.</h2>';

                            }

                        }

                    } // Not purchased, show options
                    else {

                        $videourl   = get_post_meta($post->ID, '_lac0509_dt-preview-video-url', true);
                        $imageThumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'md-video');

                        // Just have audio and free, show the audio player
                        if ($audiourl && !$videourl && !$productID) {
                            $htmlaudio = wp_oembed_get($audiourl);
                            echo '<div id="dt-audio-only-choice">' . $htmlaudio . '</div>';
                            $audio_already_set = true;
                            //echo '<h3>test</h3>';
                            //echo '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/164974625&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
                        } // We have options and/or this is a VOD product
                        else {

                            ?>

                            <div id="dt-video-option" style="position:relative;">

                                <div id="dt-option-content" style="position:relative;z-index:1;">


                                    <div id="dt-review-content" class="single-show" style="width:100%;">

                                        <?php $time = get_post_meta($post->ID, '_lac0509_dt-show-time', true); ?>
                                        <?php $date = date('F j', strtotime(get_the_date())); ?>
                                        <?php if ($time) {
                                            $date .= ' at ' . date('g:ia', strtotime($time));
                                        } ?>

                                        <?php $director = get_post_meta($post->ID, '_lac0509_review_director', true); ?>
                                        <?php $release = get_post_meta($post->ID, '_lac0509_review_release', true); ?>

                                        <?php if ($director || $release) : ?>

                                            <h3><?php echo $date;
                                                if ($director) {
                                                    echo '- Directed by ' . $director;
                                                }
                                                if ($release) {
                                                    echo ' - Released ' . $release;
                                                } ?></h3>
                                            <?php $review = true; ?>

                                        <?php endif; ?>

                                        <?php if (!$review) {
                                            echo '<h3>' . $date . '</h3>';
                                        } ?>
                                        <h1 class="post-title"><?php the_title(); ?></h1>
                                        <?php
                                        // Does this show have a Poll attached to it?
                                        if (function_exists('polldaddy_get_rating_html')) {
                                            $html = polldaddy_get_rating_html('check-options');
                                            echo '<div class="pds-rate-wrap">' . $html . '</div>';
                                        }
                                        ?>

                                        <div class="dt-post-meta-single">

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
                                    </div>


                                    <?php


                                    // If there is an associated product ID, give user the option to purchase
                                    if ($productID && !$liveShow && ($audiourl || $videourl)) {

                                        echo '<h2>Full length video episodes are available on demand or by subscription</h2>';
                                        echo '<div class="bottom-buttons"><a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy Video</a><a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a></div>';

                                        // If there is an associated audio URL, give user the option to listen for free
                                        // 														if ($audiourl) {
                                        // 															echo '<a id="dt-audio-click">Listen to the full audio-only version.</a>';
                                        // 														}

                                        // If there is an associated video preview URL, give user the option to view for free
                                        if ($videourl) {
                                            echo '<a style="display:block;clear:both;padding-top:20px;" id="dt-video-click">Watch the free short video version.</a>';
                                        }

                                    } // If this is a liveshow
                                    else {
                                        if ($liveShow) {

                                            echo '<h2>We are live! You have 2 options to access the live show:</h2>';
                                            echo '<div class"bottom-buttons"><a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy This Stream</a><a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a></div>';
                                        } // If this is a show in between being live and having available content, or if there is only paid video, no previews
                                        else {
                                            if (!$audiourl && !$videourl) {

                                                // Check if there is paid content
                                                $videoSD = get_post_meta($post->ID, '_lac0509_dt-video-url', true);

                                                // If no, this is a live-stream processing
                                                if (!$videoSD) {
                                                    echo '<h2>This show is still toasting but we\'ll have it ready for you soon.</h2>';
                                                } // Paid Video Only
                                                else {

                                                    echo '<h2>Full length video episodes are available on demand or by subscription</h2>';
                                                    echo '<a class="dt-click button" href="http://www.doubletoasted.com/cart/?add-to-cart=' . $productID . '&showid=' . $post->ID . '">Buy Video</a>';
                                                    echo '<a class="dt-click button" href="http://www.doubletoasted.com/membership/">View Plans</a>';

                                                }
                                            } // Otherwise we have just a free show
                                            else {

                                                echo '<h2>Watch the short video version or click the link above to listen to the full audio version.</h2>';

                                                // If there is an associated audio URL, give user the option to listen for free
                                                //if ($audiourl) {
                                                //	echo '<a id="dt-audio-click">Listen to the audio only version.</a>';
                                                //}

                                                // If there is an associated video preview URL, give user the option to view for free
                                                if ($videourl) {
                                                    echo '<a id="dt-video-click" style="padding-top:20px;display:inline-block;">Watch the video version.</a>';
                                                }

                                            }
                                        }
                                    }

                                    ?>

                                </div>

                                <div
                                    style="opacity:.4;width:100%;height:100%;background-size:cover;z-index:0;position:absolute;top:0px;left:0px;background-image:url('<?php echo $imageThumb[0]; ?>');"></div>

                            </div>


                            <?php

                            // Does this show have a soundcloud link attached to it?
                            $audiourl = get_post_meta($post->ID, '_lac0509_dt-audio-url', true);
                            //var_dump($audiourl);
                            if ($audiourl && !$audio_already_set) {
                                $htmlaudio = wp_oembed_get($audiourl);
                                echo '<div id="dt-audio-sc" style="padding:0;overflow:hidden;clear:both;">' . $htmlaudio . '</div>';
                            }

                            ?>


                            <?php

                            // Render the audio html
                            if ($audiourl) {
                                $htmlaudio = wp_oembed_get($audiourl);
                                echo '<div id="dt-audio-choice">' . $htmlaudio . '</div>';
                                //echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/164974625&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>';

                            }

                            // Render the video html
                            if ($videourl) {
                                $htmlvideopre = wp_oembed_get($videourl);
                                echo '<div id="dt-video-choice">' . $htmlvideopre . '</div>';
                            }

                        }

                    }

                    ?>

                    <div id="dt-media-header" class="clear">

                        <div class="content">

                            <div class="large-7 medium-6 columns">

                                <?php

                                $hideCrumbs = false;

                                // Does this show belong to a series?
                                $dtSeries = wp_get_post_terms($post->ID, 'series');
                                if ($dtSeries && !is_wp_error($dtSeries)) {

                                    // Default to Category Parent (if it exists)
                                    $howManyTerms = count($dtSeries);
                                    $i            = 0;

                                    if ($howManyTerms >= 2) {
                                        $i                    = $howManyTerms - 1;
                                        $dtSeries[0]->term_id = $dtSeries[$i]->term_id;

                                    }

                                    $dtTitle = $dtSeries[$i]->name;
                                    $dtLink  = $dtSeries[$i]->slug;

                                    echo '<h1 class="dt-crumbs">' . $dtTitle . '</h1>';

                                } else {

                                    // If no series title set to show title
                                    echo '<h1 class="dt-crumbs">' . $post->post_title . '</h1>';
                                    $dtTitle = 'Misc';
                                    $dtLink  = '';

                                }

                                if ($dtLink == 'reviews') {
                                    $hideCrumbs = true;
                                }

                                ?>
                                <?php $time = get_post_meta($recentPost["ID"], '_lac0509_dt-show-time', true); ?>
                                <?php $date = date('F j', strtotime(get_the_date())) . ' '; ?>
                                <?php if ($time) {
                                    $date .= ' at ' . date('g:ia', strtotime($time));
                                } ?>
                                <?php $director = get_post_meta($post->ID, '_lac0509_review_director', true); ?>
                                <?php $release = get_post_meta($post->ID, '_lac0509_review_release', true); ?>
                                <?php if ($director || $release) : ?>
                                    <h3><?php echo $date;
                                        if ($director) {
                                            echo '- Directed by ' . $director;
                                        }
                                        if ($release) {
                                            echo ' - Released ' . $release;
                                        } ?></h3>
                                    <?php $review = true; ?>
                                <?php endif; ?>
                                <?php if (!$review) {
                                    echo '<h3>' . $date . '</h3>';
                                } ?>

                                <p class="dt-crumbs">

                                    <?php if ($hideCrumbs) { ?>

                                        <a href="/reviews/">Reviews</a> >
                                        <span><?php echo $post->post_title; ?></span>

                                    <?php } else { ?>

                                        <a href="/all-shows/">Shows</a> >
                                        <a href="/shows/<?php echo $dtLink ?>/"><?php echo $dtTitle; ?></a> >
                                        <span><?php echo $post->post_title; ?></span>

                                    <?php } ?>

                                </p>

                            </div>
                        </div>

                    </div>
                    <div class="second-toolbar">
                        <?php get_template_part('modules/post-nav-social'); ?>
                        <ul class="video-link">
                            <?php
                            $linksToAdd        = array();
                            $audioUrl          = get_post_meta($post->ID, '_lac0509_dt-audio-url', true);
                            $videoUrl          = get_post_meta($post->ID, '_lac0509_dt-video-url', true);
                            $videoGigcasterUrl = get_post_meta($post->ID, '_lac0509_dt-video-url-gigcaster', true);

                            //die($post->ID . ' - ' . $videoUrl . ' is the video url');
                            $videoHtml = '<li class="video"><i class="fa fa-television" aria-hidden="true"></i></li>';
                            $audioHtml = '<li class="audio"><i class="fa fa-volume-up" aria-hidden="true"></i></li>';

                            if (!class_exists('Mobile_Detect')) {
                                require_once('Mobile_Detect.php');
                                $detect = new Mobile_Detect();
                            }

                            if ($detect && $detect->isMobile()) {
                                if ($audioUrl) {
                                    $linksToAdd[] = $audioUrlHtml;
                                }

                                if ($videoUrl || $videoGigcasterUrl) {
                                    $linksToAdd[] = $videoHtml;
                                }
                            } else {
                                if ($videoUrl || $videoGigcasterUrl) {
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

                    <div class="clear dt-media-postinfo">

                        <?php $rating = get_post_meta($post->ID, '_lac0509_rev_rating', true); ?>
                        <?php $rating_mart = get_post_meta($post->ID, '_lac0509_rev_mart_rating', true); ?>

                        <?php if ($dtLink == 'reviews' && ($rating || $rating_mart)) : ?>

                            <div id="dt-review-content" class="single-review">
                                <div class="dt-second-row">


                                    <div class="your-rating">
                                        <h3>Your Rating</h3>
                                        <img src="/wp-content/themes/toasted/images/reviews-ratings-martini-5.png"
                                             width="165" alt="Our Rating"/>
                                        <p class="rating-term">Click to write review</p>

                                    </div>

                                    <div class="user-rating">
                                        <h3>User's Rating</h3>
                                        <?php $html = polldaddy_get_rating_html('check-options'); ?>
                                        <?php echo '<div class="pds-rate-wrap" style="float:left;padding-top:3px;">' . $html . '</div>'; ?>
                                    </div>

                                    <div class="koreys-rating">
                                        <?php if ($rating) : ?>

                                            <h3>Korey's Rating</h3>
                                            <img
                                                src="/wp-content/themes/toasted/images/reviews-ratings-martini-<?php echo $rating; ?>.png"
                                                width="165" alt="Our Rating"/>
                                            <?php $ratingterms = array(
                                                'Unrated',
                                                'FUCK YOU!!!',
                                                'Some Ol’ Bullshit',
                                                'Rental',
                                                'Matinee',
                                                'Full Price!',
                                                'Better Than Sex!!!',
                                            ); ?>
                                            <p class="rating-term"><?php echo $ratingterms[$rating]; ?></p>

                                        <?php endif; ?>
                                    </div>
                                    <div class="martins-rating">

                                        <?php if ($rating_mart) : ?>

                                            <h3>Martin's Rating</h3>
                                            <img
                                                src="/wp-content/themes/toasted/images/reviews-ratings-martini-<?php echo $rating_mart; ?>.png"
                                                width="165" alt="Our Rating"/>
                                            <?php $ratingterms = array(
                                                'Unrated',
                                                'FUCK YOU!!!',
                                                'Some Ol’ Bullshit',
                                                'Rental',
                                                'Matinee',
                                                'Full Price!',
                                                'Better Than Sex!!!',
                                            ); ?>
                                            <p class="rating-term"><?php echo $ratingterms[$rating_mart]; ?></p>

                                        <?php endif; ?>
                                    </div>

                                    <div id="TB_overlay" class="TB_overlayBG review-overlay">
                                        <div class="write-a-review">
                                            <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                                            <h2>HOW TOASTED DID THIS MOVIE HAVE YOU?</h2>
                                            <img
                                                src="/wp-content/themes/toasted/images/reviews-ratings-martini-rate.png"
                                                width="210" alt="Our Rating"/>
                                            <span class="short-review">Better Than Sex!!!</span>
                                            <textarea rows="4" cols="50"
                                                      placeholder="Tell us how you really feel"></textarea>
                                            <div class="bottom-bottoms">
                                                <button class="cencel" type="button">Cancel</button>
                                                <button class="submit" type="button">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        <?php else : ?>


                            <div class="dt-single-show-desc">
                                <?php remove_filter('the_content', 'polldaddy_show_rating', 5); ?>
                                <?php the_content(); ?>
                            </div>

                        <?php endif; ?>


                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

    <?php dynamic_sidebar('dt-above-comments'); ?>

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

    <div class="more-shows">
        <div class="divider"></div>
        <?php $taxes = wp_get_post_terms($post->ID, 'series'); ?>
        <?php $taxInfo = $taxes[0]; ?>
        <div class="show show-<?php echo $taxInfo->slug; ?>">
            <div class="title">
                <h2><?php echo $taxInfo->name; ?></h2>
                <span><?php echo $taxInfo->description; ?></span>

                <?php if (!in_array($taxInfo->slug, array('fan-art', 'news'))): ?>
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
    </div>


</div><!-- .single.main -->

<?php wp_enqueue_script('flowplayer', get_template_directory_uri() . '/modules/scripts/flowplayer.min.js', 'jquery'); ?>

<!-- Plugin: BP EDITABLE ACTIVITY
	Had to manually que scripts for single show page comments -->

<?php wp_enqueue_script('jquery-ui-tooltip'); ?>
<?php wp_enqueue_script('jquery-ui-button'); ?>
<?php wp_enqueue_script('editable-activity', '/wp-content/plugins/bp-editable-activity/assets/editable-activity.js', array(
    'jquery',
    'jquery-editable',
)); ?>
<?php wp_enqueue_script('jquery-editable', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/js/jqueryui-editable.min.js', array(
    'jquery',
    'jquery-ui-tooltip',
    'jquery-ui-button',
)); ?>

<?php wp_enqueue_style('jq-edit-ui-css', '/wp-content/plugins/bp-editable-activity/assets/jqui/jquery-ui-1.10.4.custom.css'); ?>
<?php wp_enqueue_style('jqui-edit-css', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/css/jqueryui-editable.css'); ?>

<?php
$data = array(
    'edit_activity_title' => __('Edit Activity', 'bp-editable-activity'),
    'edit_comment_title'  => __('Edit Comment', 'bp-editable-activity'),
);

wp_localize_script('editable-activity', 'BPEditableActivity', $data);
?>

<!-- end BP EDITABLE ACTIVITY -->

<?php get_footer(); ?>

<script>

    jQuery(document).ready(function () {
        jQuery('#dt-hd-toggle').fadeIn();
    });


    jQuery('#dt-flow-vid-wrap').hover(
        function () {
            jQuery('#dt-hd-toggle').fadeIn(100);
        },
        function () {
            jQuery('#dt-hd-toggle').delay(300).fadeOut(100);
        }
    );

    jQuery('#dt-premium-user-audio').click(function () {

        if (jQuery(this).hasClass('dt-non-subscriber')) {
            jQuery(this).fadeOut(300);
            jQuery('#dt-video-option').slideUp(200);
            jQuery('#dt-premium-audio').slideDown(400);
        }

        else {
            jQuery(this).fadeOut(300);
            jQuery('#dt-flow-vid-wrap').slideUp(300);
            jQuery('#dt-premium-audio').slideDown(400);
        }

    });

    jQuery('#dt-hd-toggle').click(function () {

        var sdvid = jQuery('.flow-sd');
        var hdvid = jQuery('.flow-hd');
        var playing, switchto;

        if (hdvid.hasClass('active')) {
            playing  = hdvid;
            switchto = sdvid;
            jQuery(this).text('SD');
        }

        else {
            playing  = sdvid;
            switchto = hdvid;
            jQuery(this).text('HD');
        }

        if (hdvid.length > 0) {

            var setHt = jQuery('#dt-flow-vid-wrap').height();
            jQuery('#dt-flow-vid-wrap').height(setHt);

            // Make the switch
            var currentTime = playing.flowplayer().video.time;
            playing.flowplayer().stop();
            playing.fadeOut(500).toggleClass('active');
            switchto.fadeIn(500).toggleClass('active');
            switchto.flowplayer().seek(currentTime).play();

        }

    });

</script>