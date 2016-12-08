<?php

//$templateURI = get_template_directory_uri();

// Hook All The Things

add_filter('wp_list_categories', 'frank_remove_category_list_rel');
add_filter('the_category', 'frank_remove_category_list_rel');

add_filter('script_loader_src', 'frank_remove_version_url_parameter', 15, 1);
add_filter('style_loader_src', 'frank_remove_version_url_parameter', 15, 1);
add_filter('the_generator', 'frank_wp_generator');

add_action('widgets_init', 'frank_widgets');
add_action('after_setup_theme', 'frank_register_menu');
add_action('after_switch_theme', 'frank_set_missing_widget_options');

add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');

// Add post types, metaboxes, & shortcodes
require_once('modules/post-types.php');
require_once('modules/post-types-mb.php');
require_once('modules/shortcodes.php');

// Thumbnail Image Sizes
add_image_size('sm-archive', 458, 258, true);
add_image_size('sm-review', 418, 620, true);
add_image_size('lg-slider', 1280, 550, true);
add_image_size('md-video', 953, 536, true);

// Used to create "review" movie poster thumbnail
if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label'     => 'Movie Poster (if applicable)',
        'id'        => 'dt-review-poster',
        'post_type' => 'dt_shows',
    ));
}

// Custom Menus
function frank_register_menu() {

    register_nav_menu('frank_primary_navigation', 'Primary Navigation');
    register_nav_menu('frank_mobile_navigation', 'Mobile Navigation');
    register_nav_menu('frank_footer_navigation', 'Footer Navigation');

}

// Clean Up Queries & Potential Performance Things
function frank_set_missing_widget_options() {
    add_option('widget_pages', array('_multiwidget' => 1));
    add_option('widget_calendar', array('_multiwidget' => 1));
    add_option('widget_tag_cloud', array('_multiwidget' => 1));
    add_option('widget_nav_menu', array('_multiwidget' => 1));
}

function frank_remove_version_url_parameter($src) {
    $parts = explode('?', $src);

    return $parts[0];
}

// Add Sidebar/Widgets
function frank_widgets() {

    register_sidebar(array(
        'name'          => 'Nav:Featured Shows',
        'id'            => 'dt-feature-top',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ));
    register_sidebar(array(
        'name'          => 'Home: Schedule',
        'id'            => 'dt-schedule',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Footer: Today',
        'id'            => 'dt-today-footer',
        'before_widget' => '<div id="footer-today">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));
    register_sidebar(array(
        'name'          => 'Ad: Homepage Feature',
        'id'            => 'dt-home-feature-top',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ));
    register_sidebar(array(
        'name'          => 'Ad: Homepage Footer',
        'id'            => 'dt-home-feature-bottom',
        'before_widget' => '<div class="dt-feature-bottom">',
        'after_widget'  => '</div>',
        'before_title'  => '<p><a id="dt-bot-feat-close" class="icon-cancel-squared"></a>',
        'after_title'   => '</p>',
    ));
    register_sidebar(array(
        'name'          => 'Ad: Above Comments',
        'id'            => 'dt-above-comments',
        'before_widget' => '<div class="content ad-above-comments">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));
    register_sidebar(array(
        'name'          => 'Ad: Right of Comments',
        'id'            => 'dt-feature-single',
        'before_widget' => '<div class="dt-ad" style="clear:both;">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="content"><p>',
        'after_title'   => '</p></div>',
    ));
    register_sidebar(array(
        'name'          => 'Ad: Single Post Sidebar',
        'id'            => 'dt-ad-single-sidebar',
        'before_widget' => '<div class="dt-ad" style="clear:both;">',
        'after_widget'  => '</div>',
        'before_title'  => '<p>',
        'after_title'   => '</p>',
    ));

}

// Execute Shortcodes in our custom widgets
add_filter('dt-home-feature-bottom', 'do_shortcode');
add_filter('dt-feature-single', 'do_shortcode');
add_filter('dt-feature-top', 'do_shortcode');

function frank_wp_generator() {
    echo '<meta name="generator" content="WordPress ', bloginfo('version'), '" />';
}

/* Remove rel attribute from the category list - thanks Joseph (http://josephleedy.me/blog/make-wordpress-category-list-valid-by-removing-rel-attribute/)! */
function frank_remove_category_list_rel($output) {
    $output = str_replace(' rel="category tag"', '', $output);

    return $output;
}

// WP Admin: Remove Visual Editor on Pages (@wp-autop)
add_filter('user_can_richedit', 'wpse_58501_page_can_richedit');
function wpse_58501_page_can_richedit($can) {
    global $post;

    if ($post->post_type == 'page') {

        $shortcode = has_shortcode($post->post_content, 'section');

        if ($shortcode) {
            return false;
        }
    }

    return $can;
}

// WP Admin: Remove Dashboard Widgets that aren't useful
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

// WP Admin: Removes Widgets as they are not designed or integrated into the custom theme
// A developer might want to add these back in, but make sure to refine front-end integration!
// function unregister_default_widgets() {
// 	unregister_widget('WP_Widget_Pages');
// 	unregister_widget('WP_Widget_Calendar');
// 	unregister_widget('WP_Widget_Archives');
// 	unregister_widget('WP_Widget_Links');
// 	unregister_widget('WP_Widget_Meta');
// 	unregister_widget('WP_Widget_Search');
// 	//unregister_widget('WP_Widget_Text');
// 	unregister_widget('WP_Widget_Categories');
// 	unregister_widget('WP_Widget_Recent_Posts');
// 	unregister_widget('WP_Widget_Recent_Comments');
// 	unregister_widget('WP_Widget_RSS');
// 	unregister_widget('WP_Widget_Tag_Cloud');
// 	unregister_widget('WP_Nav_Menu_Widget');
// 	unregister_widget('Twenty_Eleven_Ephemera_Widget');
// 	unregister_widget( 'BP_Activity_Widget' );
// 	unregister_widget( 'BP_Blogs_Recent_Posts_Widget' );
// 	unregister_widget( 'BP_Groups_Widget' );
// 	unregister_widget( 'BP_Core_Welcome_Widget' );
// 	unregister_widget( 'BP_Core_Friends_Widget' );
// 	unregister_widget( 'BP_Core_Login_Widget' );
// 	unregister_widget( 'BP_Core_Members_Widget' );
// 	unregister_widget( 'BP_Core_Whos_Online_Widget' );
// 	unregister_widget( 'BP_Core_Recently_Active_Widget' );
// 	unregister_widget( 'WC_Widget_Recent_Products' );
// 	unregister_widget( 'WC_Widget_Products' );
// 	unregister_widget( 'WC_Widget_Featured_Products' );
// 	unregister_widget( 'WC_Widget_Product_Categories' );
// 	unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
// 	unregister_widget( 'WC_Widget_Cart' );
// 	unregister_widget( 'WC_Widget_Layered_Nav' );
// 	unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
// 	unregister_widget( 'WC_Widget_Price_Filter' );
// 	unregister_widget( 'WC_Widget_Product_Search' );
// 	unregister_widget( 'WC_Widget_Top_Rated_Products' );
// 	unregister_widget( 'WC_Widget_Recent_Reviews' );
// 	unregister_widget( 'WC_Widget_Recently_Viewed' );
// 	unregister_widget( 'WC_Widget_Best_Sellers' );
// 	unregister_widget( 'WC_Widget_Onsale' );
// 	unregister_widget( 'WC_Widget_Random_Products' );
// 	unregister_widget( 'BBP_Login_Widget' );
// 	unregister_widget( 'BBP_Views_Widget' );
// 	unregister_widget( 'BBP_Search_Widget' );
// 	unregister_widget( 'BBP_Forums_Widget' );
// 	unregister_widget( 'BBP_Topics_Widget' );
// 	unregister_widget( 'BBP_Stats_Widget' );
// 	unregister_widget( 'BBP_Replies_Widget' );
//  }
// add_action('widgets_init', 'unregister_default_widgets', 11);

// WP Admin: Change Custom Post Type Icons
// add_action( 'admin_head', 'dt_admin_css' );
// function dt_admin_css() {
// 	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/stylesheets/custom-admin.css">';
// }

// Buddypress: AJAX Function to Refresh Single Page Comments (not implemented)
add_action('wp_ajax_dt_side_refresh0602', 'dt_side_refresh0602');
function dt_side_refresh0602($activity_id) {
    $id = $_POST['activity_id'];
    if (bp_activity_blog_comments_has_activities('&include=' . $id)) {

        // Reverse Comment Order to show newest at top.
        global $activities_template;
        $activities_template->activities[0]->children = array_reverse($activities_template->activities[0]->children);

        while (bp_activities()) {

            bp_the_activity();
            echo '<div class="activity-comments" id="' . bp_activity_id() . '">';
            global $sideRefresh;
            $sideRefresh = true;
            bp_activity_comments();
            echo '</div>';

        }

    }
}

// Buddypress: Show Custom Post Type Activity
add_filter('bp_blogs_record_post_post_types', 'activity_publish_custom_post_types', 1, 1);
function activity_publish_custom_post_types($post_types) {
    $post_types[] = 'dt_shows';
    $post_types[] = 'dt-video';
    $post_types[] = 'dt-users-blog';
    $post_types[] = 'dt-comics';
    $post_types[] = 'dt-audio';

    return $post_types;
}

// Customize Soundcloud/Youtube Player Embeds
add_filter('oembed_result', 'lc_oembed_result', 10, 3);
function lc_oembed_result($html, $url) {

    // Soundcloud parameters
    if (strpos($url, 'soundcloud') !== false) {
        $html = str_replace('?visual=true', '?visual=false', $html);
        $html = str_replace('&show_artwork=true&maxwidth=500&maxheight=750', '&show_artwork=false&&color=ff7700&hide_related=true&maxwidth=200&maxheight=960', $html);
        $html = str_replace('width="500" height="400"', 'width="100%" height="180px"', $html);
    }

    // Youtube parameters
    if (strpos($url, 'youtube') !== false) {
        $html = str_replace('?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&color=white&rel=0', $html);
        $html = str_replace('width="500" height="281"', 'width="100%" height="500px"', $html);
    }

    return $html;

}

// Log-in Redirect, keeps users in the site experiences and away from /wp-admin
add_action('wp_login_failed', 'pu_login_failed'); // hook failed login
function pu_login_failed($user) {
    // check what page the login attempt is coming from
    $referrer = $_SERVER['HTTP_REFERER'];

    // check that were not on the default login page
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') && $user != null) {
        // make sure we don't already have a failed login attempt
        if (!strstr($referrer, '?login=failed')) {
            // Redirect to the login page and append a querystring of login failed
            wp_redirect($referrer . '?login=failed');
        } else {
            wp_redirect($referrer);
        }

        exit;
    }
}

// Log-in Redirect (blank fields), keeps users in the site experiences and away from /wp-admin
add_action('authenticate', 'pu_blank_login');
function pu_blank_login($user) {
    // check what page the login attempt is coming from
    $referrer = $_SERVER['HTTP_REFERER'];

    $error = false;

    if ($_POST['log'] == '' || $_POST['pwd'] == '') {
        $error = true;
    }

    // check that were not on the default login page
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') && $error) {

        // make sure we don't already have a failed login attempt
        if (!strstr($referrer, '?login=failed')) {
            // Redirect to the login page and append a querystring of login failed
            wp_redirect($referrer . '?login=failed');
        } else {
            wp_redirect($referrer);
        }

        exit;

    }
}

// Add OpenGraph to WP Languages
function add_opengraph_doctype($output) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter('language_attributes', 'add_opengraph_doctype');

// Add Facebook Properties for OpenGraph
function insert_fb_in_head_lb() {
    global $post, $bp;
    //var_dump($bp->current_component);
    if (!is_single() || $bp->current_component) {
        return;
    }

    echo '<meta property="fb:admins" content="korey.coleman.5"/>';
    echo '<meta property="og:title" content="' . get_the_title() . ' on DoubleToasted.com" />';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="DoubleToasted.com"/>';
    if (!has_post_thumbnail($post->ID)) {
        $default_image = "http://kcoolman.wpengine.com/wp-content/themes/toasted/screenshot-fb.jpg";
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
    }
    echo "
";
}

add_action('wp_head', 'insert_fb_in_head_lb', 5);

// WP Permalinks: Removes 'auto-correct'
// remove_filter('template_redirect', 'redirect_canonical');

// On-air: Check if we have a 'live' post and load post-data into global var if we do
function dt_set_onair_cookie() {

    $args = array(
        'numberposts' => 1,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
        'post_type'   => 'dt_shows',
        'post_status' => 'publish',
    );

    $cookiePost = wp_get_recent_posts($args, ARRAY_A);
    $onAirID    = $cookiePost[0]["ID"];
    $isOnAir    = get_post_meta($onAirID, '_lac0509_dt-is-live-stream', true);

    if ($isOnAir) {
        global $onAirPostData;
        $onAirPostData = $cookiePost;
    }

}

add_action('init', 'dt_set_onair_cookie');

// News: Adjust excerpt length
// add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
// function custom_excerpt_length( $length ) {
// 	return 20;
// }

// Add 'order' attribute to posts page - used for homepage slideshow
add_action('admin_init', 'posts_order_wpse_91866');
function posts_order_wpse_91866() {
    add_post_type_support('post', 'page-attributes');
}

// Removes '&nbsp|&nbsp' characters from BB-Press topic subscribe link
function ntwb_forum_subscription_link($args) {
    $args['before'] = '';
    $args['after']  = '';

    return $args;
}

add_filter('bbp_before_get_forum_subscribe_link_parse_args', 'ntwb_forum_subscription_link');

// Add specific CSS class by filter
// add_filter('body_class','my_class_names');
// function my_class_names($classes) {
//
// 	// add 'class-name' to the $classes array
// 	$classes[] = 'class-name';
// 	// return the $classes array
// 	return $classes;
//
// }

function remove_xprofile_links() {
    remove_filter('bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2);
}

add_action('bp_init', 'remove_xprofile_links');

// Add rtmedia activity type to bp-editable-activity
function add_edit_post_types($post_types) {
    $post_types[] = 'rtmedia_update'; // Hier die Slugs der Custom Post Types eintragen, bei denen Erwähnungen im Beitrag selbst berücksichtigt werden
    return $post_types;
}

add_filter('bp_editable_activity_allowed_type', 'add_edit_post_types');

// AJAX Function for Getting Posts - Used on "Show More" posts & Post Filters
add_action("wp_ajax_get_more_dt_posts", "get_more_dt_posts");
add_action("wp_ajax_nopriv_get_more_dt_posts", "get_more_dt_posts");

function get_more_dt_posts() {
    $nonceType = $_POST['sort'] && $_POST['page'] == 1 ? 'dt-ajax-sort-posts' : 'dt-ajax-load-more-reviews';

    if (!wp_verify_nonce($_POST['nonce'], $nonceType)) {
        die ('Couldn\'t load more posts.');
    }

    //removed && $_POST['type'] == 'dt_shows'
    if ($_POST['category'] !== 'false') {
        $cat = array(
            array(
                'taxonomy' => 'series',
                'field'    => 'slug',
                'terms'    => array(
                    $_POST['category'],
                ),
            ),
        );
    }

    // Search form
    if ($_POST['query']) {
        $query = sanitize_text_field($_POST['query']);
    }

    if ($_POST['type'] == 'dt-audio') {
        $post_type = array(
            'dt-audio',
            'dt_shows',
        );
        // For audio page - we're showing 2 post types here
    } else {
        $post_type = $_POST['type'];
    }

    if (!$_POST['sort']) {
        $args = array(
            'post_type'   => $post_type,
            'paged'       => $_POST['page'],
            'posts_per_page' => 20,
            'post_status' => array(
                'publish',
                'private',
            ),
            'tax_query'   => $cat,
            's'           => $query,
        );
        // Default view no sorting, also used for audio "series" select with no sorting
    } else {
        if (in_array($_POST['sort'], array('toasty', 'rating', 'rating_mart'))) {
            if ($_POST['sort'] == 'rating') {
                $key = '_lac0509_rev_rating';
            } elseif ($_POST['sort'] == 'rating_mart') {
                $key = '_lac0509_rev_mart_rating';
            } else {
                $key = 'dt_post_favorite_count';
            }

            $args = array(
                'post_type'   => $post_type,
                'orderby'     => 'meta_value_num',
                'paged'       => $_POST['page'],
                'post_status' => array(
                    'publish',
                    'private',
                ),
                'tax_query'   => $cat,
                'meta_key'    => $key,
                's'           => $query,
            );
        } else {
            if ($_POST['sort'] == 'oldest') {
                $order   = 'ASC';
                $orderby = '';
            } elseif ($_POST['sort'] == 'popular') {
                $order   = '';
                $orderby = 'comment_count';
            }

            if (isset($_POST['order'])) {
                $order = $_POST['order'];
            }

            if (isset($_POST['sort'])) {
                $orderby = $_POST['sort'];
            }

            $args = array(
                'post_type'   => $post_type,
                'order'       => $order,
                'orderby'     => $orderby,
                'paged'       => $_POST['page'],
                'post_status' => array(
                    'publish',
                    'private',
                ),
                'tax_query'   => $cat,
                's'           => $query,
            );
        }
    }

    $ajax_query = new WP_Query($args);

    if ($ajax_query->have_posts()) {
        while ($ajax_query->have_posts()) {
            $ajax_query->the_post();

            // Serve HTML for News Blog Posts
            if ($post_type == 'post') {
                $newsThumb = get_the_post_thumbnail($post->ID, 'sm-archive');

                if ($newsThumb) {
                    $newsPostClass = 'has-news-thumb';
                    $result .= '<div class="post columns end ' . $newsPostClass . ' animate-post">
                                    <p class="dt-news-date">' . get_the_date() . '</p>
                                            <a href="' . get_the_permalink() . '">
                                                <h2>' . get_the_title() . '</h2>
                                                <div class="dt-news-thumb">' . $newsThumb . '</div>
                                            </a>
                                            <div class="dt-news-info">
                                            <p>' . get_the_excerpt() . '</p>
											<a class="button" href="' . get_the_permalink() . '">Read More</a>
                                            </div>
									</div>
								</div>';
                }
            } else {
                // html reviews
                if ($_POST['category'] == 'reviews' && $post_type !== array('dt-audio', 'dt_shows')) {
                    $result .= '<div class="post large-3 medium-4 small-12 columns end animate-post">
                        <a class="dt-archive-thumb-small" href="' . get_the_permalink() . '">';

                    if (class_exists('MultiPostThumbnails')) {
                        $thumb = MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'dt-review-poster', null, 'sm-review');
                    }

                    $result .= $thumb;

                    $result .= '<div class="dt-archive-review-meta">';

                    // Get Favorite Count
                    if (bp_has_activities('&action=new_blog_post&secondary_id=' . get_the_ID())) {
                        while (bp_activities()) : bp_the_activity();
                            $my_fav_count = bp_activity_get_meta(bp_get_activity_id(), 'favorite_count');

                            if (!$my_fav_count >= 1) {
                                $my_fav_count = 0;
                            }

                            $result .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
                        endwhile;
                    }

                    // Get Comment Count
                    $result .= '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';

                    $rating = get_post_meta(get_the_ID(), '_lac0509_rev_rating', true);

                    if ($rating) {
                        $rating = $rating - 1;
                        $result .= '<span class="dt-archive-meta-rating"><span style="vertical-align:-2px;display:inline-block;margin-right:5px;font-weight:400;">K</span><img src="/wp-content/themes/toasted/images/reviews-meta-ratings-martini-' . $rating . '.png" width="130" alt="Our Rating" /></span>';
                    }

                    $rating_mart = get_post_meta(get_the_ID(), '_lac0509_rev_mart_rating', true);
                    if ($rating_mart) {
                        $rating_mart = $rating_mart - 1;
                        $result .= '<span class="dt-archive-meta-rating"><span style="vertical-align:-2px;display:inline-block;margin-right:5px;font-weight:400;">M</span><img src="/wp-content/themes/toasted/images/reviews-meta-ratings-martini-' . $rating_mart . '.png" width="130" alt="Our Rating" /></span>';
                    }

                    $result .= '</div>';

                    if ( function_exists( 'polldaddy_get_rating_html' ) ) {
                        $html = polldaddy_get_rating_html( 'check-options' );
                        $result .= '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">'.$html.'</div>';
                    }

                    $result .= '</a>';

                    // PollDaddy Rating Support
                    /*if (function_exists('polldaddy_get_rating_html')) {
                        $html = polldaddy_get_rating_html('check-options');
                        $result .= '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">' . $html . '</div>';
                    }*/

                    $result .= '</div>';

                } else {
                    if ($post_type == array('dt-audio', 'dt_shows')) {

                        $soundcloud_link = get_post_meta(get_the_ID(), '_lac0509_dt-audio-url', true);
                        if (!empty($soundcloud_link)) {

                            $title = '<span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_title() . '</span><br />';
                            $title .= '<p>' . get_the_excerpt(get_the_ID()) . '</p>';
                            $image = get_the_post_thumbnail(get_the_ID(), 'sm-archive');

                            $result .= '<div class="post columns animate-post"><a class="dt-archive-thumb-small">';
                            $result .= '<div class="dt-archive-audio-player">' . wp_oembed_get($soundcloud_link) . '</div>';
                            $result .= '<div class="dt-post-thumb">' . $image . '</div>';
                            $title .= '<div class="dt-post-meta">';

                            // Get Favorite Count
                            if (bp_has_activities('&action=new_blog_post&secondary_id=' . get_the_ID())) {

                                while (bp_activities()) : bp_the_activity();

                                    $my_fav_count = bp_activity_get_meta(bp_get_activity_id(), 'favorite_count');
                                    if (!$my_fav_count >= 1) {
                                        $my_fav_count = 0;
                                    }
                                    $title .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
                                endwhile;

                            }

                            // Get Comment Count
                            $title .= '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
                            $title .= '</div>';


                            $result .= '<div class="dt-post-info">' . $title . '</div></a></div>';
                            $result .= '<div class="divider"></div>';

                        }

                    } // Other Types
                    else {

                        // If User Blog add some extra meta
                        if ($_POST['type'] == 'dt-users-blog') {

                            $title = '<span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_title() . '</span><span style="font-weight:400;"> by ' . get_the_author() . '</span></a>';

                            // PollDaddy Rating Support
                            if (function_exists('polldaddy_get_rating_html')) {
                                $html = polldaddy_get_rating_html('check-options');
                                $title .= '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">' . $html . '</div>';
                            }
                            $title .= '<p style="clear:both;">' . get_the_excerpt(get_the_ID()) . '</p>';

                            $isthumb = get_the_post_thumbnail($post->ID, 'sm-archive');

                            if ($isthumb) {
                                $image = $isthumb;
                            } else {
                                $image = '<img src="/wp-content/themes/toasted/images/dt-users-blog-placeholder.png" />';
                            }

                        } else {
                            $title = '';
                            // PollDaddy Rating Support
                            if (function_exists('polldaddy_get_rating_html')) {
                                $html = polldaddy_get_rating_html('check-options');
                                $rating = '<div class="pds-rate-wrap" style="width:100%;clear:both;float:left;">' . $html . '</div>';
                            }
                            $title .= '<p style="clear:both;">' . get_the_excerpt(get_the_ID()) . '</p>';
                            $image = get_the_post_thumbnail(get_the_ID(), 'sm-archive');

                        }


                        $date = '<div class="dt-post-info"><span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_date('F j') . '</span></div>';

                        $result .= '<div class="post columns animate-post">'. $date .'<a class="dt-archive-thumb-small" href="' . get_the_permalink() . '">';

                        $result .= '<div class="dt-post-thumb">' . $image;
                        $result .= $rating . '<div class="dt-post-meta">';

                        // Get Favorite Count
                        if (bp_has_activities('&action=new_blog_post&secondary_id=' . get_the_ID())) {

                            while (bp_activities()) : bp_the_activity();

                                $my_fav_count = bp_activity_get_meta(bp_get_activity_id(), 'favorite_count');
                                if (!$my_fav_count >= 1) {
                                    $my_fav_count = 0;
                                }
                                $result .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
                            endwhile;

                        }

                        // Get Comment Count
                        $result .= '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
                        $result .= '</div></div></a>';


                        $result .= '<div class="dt-post-info">' . $title . '</div></div>';
                    }
                }
            }

        }

        echo $result;

    } else {
        if ($_POST['query']) {

            echo 'none';

        } else {
            echo '<h3 style="clear:both;width:100%;text-align:center;padding-top:40px;">Sorry, that\'s all we have.</h3>';
        }
    }

    die();

}

// Hide Panels for "Doubletoasted" main user
// Styling for Feature this functionality
add_action('admin_head', 'dt_hide_menus');
function dt_hide_menus() {
    global $current_user;
    get_currentuserinfo();

    if ($current_user->user_login == 'doubletoasted') { ?>
        <style>
            #menu-dashboard > ul, #menu-plugins, #toplevel_page_wpengine-common, #menu-comments, #toplevel_page_rtmedia-settings, #toplevel_page_bp-activity, #toplevel_page_bp-groups, #menu-appearance, #menu-settings, #toplevel_page_wpseo_dashboard, #toplevel_page_bp-general-settings, #toplevel_page_sweetcaptcha, #menu-tools {
                display: none;
            }

            .feature-this-table .post-thumb img {
                max-height: 70px;
                width: auto;
                border-radius: 10px;
            }

            .feature-this-table .post-thumb {
                text-align: center;
            }

            .ui-sortable-helper {
                background: #f9f9f9;
            }

            .spinner.inline-feature {
                float: none !important;
                margin: 0px 4px;
                height: 14px;
                position: relative;
                top: 2px;
                -webkit-background-size: 15px 15px;
            }

            .dt-feature-remove {
                color: #A00;
            }

            .dt-feature-remove:hover {
                color: #F00;
            }

            .menu-top.toplevel_page_feature_this .wp-menu-image:before {
                color: #999;
                padding: 7px 0;
                -webkit-transition: all .1s ease-in-out;
                transition: all .1s ease-in-out;
                content: "\f488";
            }

            #menu-posts-dt-users-blog.menu-top .wp-menu-image:before {
                content: "\f307";
            }

            #menu-posts-dt_shows.menu-top .wp-menu-image:before {
                content: "\f236";
            }
        </style>
    <?php }

    if (is_admin()) {
        ?>
        <style>
            .wp-admin #manage-polls #design, .wp-admin #manage-polls .answer-media-icons .media, .wp-admin #manage-polls .answer-media-icons .media-preview {
                display: none;
            }

            .wp-admin #manage-polls .answer-media-icons li .delete {
                display: block;
                padding-left: 10px;
            }

            .feature-this-table .post-thumb img {
                max-height: 70px;
                width: auto;
                border-radius: 10px;
            }

            .feature-this-table .post-thumb {
                text-align: center;
            }

            .ui-sortable-helper {
                background: #f9f9f9;
            }

            .spinner.inline-feature {
                float: none !important;
                margin: 0px 4px;
                height: 14px;
                position: relative;
                top: 2px;
                -webkit-background-size: 15px 15px;
            }

            .dt-feature-remove {
                color: #A00;
            }

            .dt-feature-remove:hover {
                color: #F00;
            }

            .menu-top.toplevel_page_feature_this .wp-menu-image:before {
                color: #999;
                padding: 7px 0;
                -webkit-transition: all .1s ease-in-out;
                transition: all .1s ease-in-out;
                content: "\f488";
            }

            #menu-posts-dt-users-blog.menu-top .wp-menu-image:before {
                content: "\f307";
            }

            #menu-posts-dt_shows.menu-top .wp-menu-image:before {
                content: "\f236";
            }
        </style>
        <?php
    }
}

// We're running another query on the audio archive - so we're just limiting here to save performance
function add_all_shows_to_audio_archive($query) {

    if (is_post_type_archive('dt-audio') && is_main_query()) {
        set_query_var('posts_per_page', 1);
    }
}

add_action("pre_get_posts", "add_all_shows_to_audio_archive");

// Feature This - Add "Feature This" checkbox to media popup
function add_feature_this_to_media($form_fields, $post) {

    $is_featured = (bool)get_post_meta($post->ID, 'dt-feature-this-header', true);
    $checked     = ($is_featured) ? 'checked' : '';

    $form_fields['feature_this'] = array(
        'value' => $is_featured,
        'input' => 'html',
        'html'  => '<input type="checkbox" ' . $checked . ' name="attachments[' . $post->ID . '][feature_this]" id="attachments[' . $post->ID . '][feature_this]" />',
        //Add to featured carousel
        'label' => __('Feature this?'),
    );

    return $form_fields;

}

add_filter('attachment_fields_to_edit', 'add_feature_this_to_media', 10, 2);

// Feature This - Save "Feature This" checkbox on media posts
function save_feature_this_to_media($post, $attachment) {

    $timestamp   = date('ymdHis', time());
    $is_featured = ($attachment['feature_this'] == 'on') ? intval($timestamp) : 0;

    if ($is_featured == 0) {
        delete_post_meta($post['ID'], 'dt-feature-this-header');
        wp_cache_delete('cached_feature_this'); // deletes front-end cached feature
    } else {
        update_post_meta($post['ID'], 'dt-feature-this-header', $is_featured);
        wp_cache_delete('cached_feature_this'); // deletes front-end cached feature
    }

    return $post;

}

add_action('attachment_fields_to_save', 'save_feature_this_to_media', null, 2);

// Feature This - Adds admin panel so we can rearrange posts
function dt_feature_this_manager() {
    add_menu_page('Featured', 'Featured', 'manage_options', 'feature_this', 'show_feature_this', 'div', 3);
}

function show_feature_this() {

    global $wpdb;
    $featured_posts = $wpdb->get_results('SELECT post_id, meta_value FROM wp_postmeta WHERE meta_key = "dt-feature-this-header" ORDER BY meta_value DESC LIMIT 16', OBJECT);
    $timestamp      = intval(date('ymdHis', time()));

    if ($featured_posts) {

        ?>

        <h2>Manage Featured Posts</h2>
        <span class="spinner dt-manage-featured" style="position:fixed;top:50px;right:10px;"></span>
        <p>The items below are all from your "feature this" button. Drag and drop a project to change the order.</p>
        <table class="feature-this-table wp-list-table widefat fixed">
            <thead>
            <tr>
                <th scope="col" style="width:10%;" id="title" class="manage-column column-title sortable desc" style="">
                    <span>Image</span></th>
                <th scope="col" id="title" class="manage-column column-title sortable desc" style=""><span>Title</span>
                </th>
                <th scope="col" id="author" style="width:20%;" class="manage-column column-author" style="">Author</th>
                <th scope="col" id="date" style="width:20%;" class="manage-column column-date sortable asc" style="">
                    <span>Date</span><span class="sorting-indicator"></span></th>

            </tr>
            </thead>
            <tfoot>
            <tr>
                <th scope="col" class="manage-column column-title sortable desc" style=""><span>Thumbnail</span><span
                        class="sorting-indicator"></span></th>
                <th scope="col" class="manage-column column-title sortable desc" style=""><span>Title</span><span
                        class="sorting-indicator"></span></th>
                <th scope="col" id="author" class="manage-column column-author" style="">Author</th>
                <th scope="col" class="manage-column column-date sortable asc" style=""><span>Date</span><span
                        class="sorting-indicator"></span></th>
            </tr>
            </tfoot>
            <tbody id="feature-this-list" timestamp="<?php echo $timestamp; ?>">

            <?php foreach ($featured_posts as $post) { ?>

                <?php $post_info = get_post_type($post->post_id); ?>
                <?php $class = ($i > 0) ? 'alternate' : ''; ?>

                <?php if ($post_info == 'attachment') { ?>

                    <tr id="post-<?php echo $post->post_id ?>" postid="<?php echo $post->post_id ?>"
                        order="<?php echo $post->meta_value ?>"
                        class="post-<?php echo $post->post_id . ' ' . $class; ?> type-post format-standard hentry">
                        <td class="post-thumb page-thumb column-thumb">
                            <strong><?php echo wp_get_attachment_image($post->post_id); ?></strong></td>
                        <td class="post-title page-title column-title">
                            <strong><?php echo get_the_title($post->post_id); ?></strong><a class="dt-feature-remove"
                                                                                            href="">Remove Feature</a>
                        </td>
                        <?php $author_id = get_post_field('post_author', $post->post_id); ?>
                        <td class="author column-author"><?php echo get_the_author_meta('display_name', $author_id); ?></td>
                        <td class="date column-date"><?php echo get_the_date('F j, Y', $post->post_id); ?></td>
                    </tr>

                <?php } else { ?> <!-- All Other Post Types -->

                    <tr id="post-<?php echo $post->post_id ?>" postid="<?php echo $post->post_id ?>"
                        order="<?php echo $post->meta_value ?>"
                        class="post-<?php echo $post->post_id . ' ' . $class; ?> type-post format-standard hentry">
                        <td class="post-thumb page-thumb column-thumb">
                            <strong><?php echo get_the_post_thumbnail($post->post_id, 'thumbnail'); ?></strong></td>
                        <td class="post-title page-title column-title">
                            <strong><?php echo get_the_title($post->post_id); ?></strong><a class="dt-feature-remove"
                                                                                            href="">Remove Feature</a>
                        </td>
                        <?php $author_id = get_post_field('post_author', $post->post_id); ?>
                        <td class="author column-author"><?php echo get_the_author_meta('display_name', $author_id); ?></td>
                        <td class="date column-date"><?php echo get_the_date('F j, Y', $post->post_id); ?></td>
                    </tr>

                <?php } ?>

                <?php $i = ($i > 0) ? 0 : 1; ?>

            <?php } ?> <!-- End foreach loop -->

            </tbody>
        </table>

        <?php

    } else {
        echo '<h3>Sorry, looks like you haven\'nt added any featured items.</h3>';
    }

}

add_action('admin_menu', 'dt_feature_this_manager');

// Adds sort javascript to feature this admin page
add_action('admin_enqueue_scripts', 'my_enqueue');

function my_enqueue($hook) {

    if ('toplevel_page_feature_this' == $hook || 'edit.php' == $hook) {  // only show on "feature this" admin page
        // Admin sortable scripts
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jq-feature-sort-init', '/wp-content/themes/toasted/modules/scripts/admin-feature-sort-init.js', 'jquery-ui-sortable', '1.0.0', true);
    } else {
        return;
    }

}

add_filter('json_api_encode', 'dt_clean_favorites_and_rating');

function dt_clean_favorites_and_rating($response) {
    if (isset($response['posts'])) {
        foreach ($response['posts'] as $post) {
            dt_add_favorites_and_rating($post);
        }
    } elseif (isset($response['post'])) {
        dt_add_favorites_and_rating($response['post']);
    }

    return $response;
}

function dt_add_favorites_and_rating(&$post) {
    $favorites = 0;
    $rating    = 0;

    if (isset($post->custom_fields)) {
        if (isset($post->custom_fields->dt_post_favorite_count)) {
            $favorites = $post->custom_fields->dt_post_favorite_count[0];
        }

        if (isset($post->custom_fields->pd_rating)) {
            $ratingData = unserialize($post->custom_fields->pd_rating[0]);
            $rating     = round($ratingData['average'], 2);
        }
    }

    $post->favorites  = $favorites;
    $post->rating     = $rating;
    $post->popularity = $favorites + $rating;
}

add_action('wp_enqueue_scripts', 'wp_public_scripts');
function wp_public_scripts() {
    wp_enqueue_script('home-feeds', get_template_directory_uri() . '/js/home-feeds.js', 'jquery');
    wp_enqueue_script('newsletter-subscribe', get_template_directory_uri() . '/js/newsletter-subscribe.js', 'jquery');
    wp_enqueue_script('popcorn', get_template_directory_uri() . '/modules/scripts/popcorn.min.js', 'popcorn');
    wp_enqueue_script('popcorn.capture', get_template_directory_uri() . '/modules/scripts/popcorn.capture.js', 'popcorn.capture');
}

// Used to update post meta via AJAX for feature this admin page on re-sort
add_action('wp_ajax_dt_set_feature_this', 'dt_set_feature_this');
function dt_set_feature_this() {

    if ($_POST['order'] == 'newest') {
        $_POST['order'] = date('ymdHis', time());
    }

    if ($_POST['order'] == 0) {
        delete_post_meta($_POST['post_id'], 'dt-feature-this-header');
        wp_cache_delete('cached_feature_this'); // deletes front-end cached feature
    } else {
        if ($_POST['post_id'] && $_POST['order']) {
            update_post_meta($_POST['post_id'], 'dt-feature-this-header', $_POST['order']);
            wp_cache_delete('cached_feature_this'); // deletes front-end cached feature
        }
    }

    return;

}

// Add "Feature This" button to community post actions on manage posts page
function dt_feature_community_posts($actions, $post) {
    if ($post->post_type == 'dt-users-blog' && $post->post_status == 'publish') {

        $is_featured = get_post_meta($post->ID, 'dt-feature-this-header', true);

        if (empty($is_featured)) {
            $actions['feature_this'] = '<a href="" class="feature-this-post" title="" rel="permalink">Feature This</a><span class="spinner inline-feature"></span>';
            //$actions['spinner2'] = '<a><span class="spinner" style="height:16px;positon:relative;top:4px;display:block;-webkit-background-size:15px 15px;float:left;"></span></a>';
        } else {
            $actions['feature_this'] = '<a href="" class="feature-this-post featured" title="" rel="permalink">Featured</a><span class="spinner inline-feature"></span>';
            //$actions['spinner2'] = '<a><span class="spinner" style="height:16px;positon:relative;top:4px;display:block;-webkit-background-size:15px 15px;float:left;"></span></a>';
        }
    }

    return $actions;
}

add_filter('post_row_actions', 'dt_feature_community_posts', 10, 2);

// Resets Homepage Carousel Cache upon new posts
add_action('save_post', 'dt_clear_homepage_cache');
add_action('delete_post', 'dt_clear_homepage_cache', 10);
function dt_clear_homepage_cache($id) {

    // Dump Home Slider Cache so we can get the latest show slides
    wp_cache_delete('cached_home_slider'); // used to reset cache sometimes

    // If this is a live stream - update nav
    $is_live = get_post_meta($id, '_lac0509_dt-is-live-stream', true);
    if ($is_live) {
        wp_cache_delete('cached_desktop_nav');
    }

}

// Resets cached navigation menus when menus are updated
add_action('wp_update_nav_menu', 'dt_clear_nav_menu');
function dt_clear_nav_menu($nav_menu_selected_id) {
    wp_cache_delete('cached_desktop_nav');
    wp_cache_delete('cached_footer_nav');
}

// This cron function updates the toasted and reply count for activities
// if ( ! wp_next_scheduled( 'update_activity_meta_hook' ) ) {
//   wp_schedule_event( time(), 'daily', 'update_activity_meta_hook' );
// }

// add_action( 'update_activity_meta_hook', 'dt_update_activity_meta' );

// function dt_update_activity_meta() {

// 	$message = "Hey Mike,\r\n\r\nWe just updated the database with updates reply and favorite counts:\r\n\r\n";

// 	// Get all activities in the last month (includes bumped activities)
// 	global $wpdb;
// 	$last_month = date( 'Y-m-d', strtotime("last month") );

// 	$sql = 'SELECT id
// 			FROM wp_bp_activity
// 			WHERE type <> "last_activity"
// 			AND date_recorded > "'.$last_month.'"';

// 	$activities = $wpdb->get_results( $sql, ARRAY_N );

// 	foreach ($activities as $activity) {

// 		// Get favorite count thru BP Meta
// 		$fav_count = bp_activity_get_meta( $activity[0], 'favorite_count' );

// 		// Important to reset to 0 in case users have "un-favorited"
// 		if (!$fav_count >= 1)
// 			$fav_count = 0;

// 		// Store the new count in WP Post Meta
// 		$update_fav_count = update_post_meta($activity[0], 'dt_post_favorite_count', $fav_count);

// 		// Find activity comments and count them
// 		$activity_comments = $wpdb->get_results( 'SELECT id FROM wp_bp_activity WHERE secondary_item_id = '.$activity[0], ARRAY_N ); // parent id is stored in secondary_item_id
// 		$comment_count = count($activity_comments);

// 		// Update WP Post Meta w/ the new reply count
// 		update_post_meta( $activity[0], 'dt_reply_count', $comment_count );

// 		// Add ID to our email
// 		$message .= $activity[0].', ';

// 	}

// 	// Send myself an email to confirm cron is running
// 	wp_mail( 'mikelacourse@gmail.com', 'Updated Toasted Activity Meta', 'Automatic scheduled email from WordPress. Updated: '.$message);

// }

// Removes Admin Bar for Subscribers
// function my_function_admin_bar($content) {
// 	return ( current_user_can( 'administrator' ) ) ? $content : false;
// }
// add_filter( 'show_admin_bar' , 'my_function_admin_bar');

////////////////////////////////////////////////////////////////////////////////////////////////

// Adds BuddyPress profile fields to WooCommerce Registration

add_action('woocommerce_after_order_notes', 'dt_add_bp_profile_to_wc', 9, 0);
add_action('woocommerce_created_customer', 'dt_add_bp_profile_to_wc_new_customer');

/* Add field elements into the page after customer details
	- load-xprofile-fields.php template is taken from profile-loop.php */
function dt_add_bp_profile_to_wc() {

    // Only show these fields for new users
    if (!is_user_logged_in()) {

        echo '<div class="bp-profile-fields" style="max-width:100%;">';
        echo '<h3 style="margin-bottom:3px;">Your Profile</h3>';

        // Load BP Fields
        include 'buddypress/modules/load-xprofile-fields.php';

        echo '</div>';

    }

}

/* Stores BP field data once new user is created in the system
	- User has already been validated & created
	- Function below taken from BP_Signup Class in "class-bp-signup.php"
	- Removed visibily functions at end  */
function dt_add_bp_profile_to_wc_new_customer($customer_id) {

    if (bp_is_active('xprofile')) {

        if (!empty($_POST['signup_profile_field_ids'])) {

            $profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);

            foreach ((array)$profile_field_ids as $field_id) {
                if (empty($_POST["field_{$field_id}"])) {
                    continue;
                }

                $current_field = $_POST["field_{$field_id}"];
                xprofile_set_field_data($field_id, $customer_id, $current_field);

            }

        }
    }

}

////////////////////////////////////////////////////////////////////////////////////////////////

// Adds Phone Authentication to Registration & Checkout (thru Twilio)

// These filters/actions add the actual fields into the registration form

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields'); // remove original phone field
add_action('woocommerce_checkout_after_customer_details', 'dt_add_phone_auth_fields', 9, 0);
add_action('register_form', 'dt_add_phone_auth_fields');

// These are validation hooks to make sure our phone number is authenticated before moving forward

add_action('woocommerce_checkout_process', 'dt_wc_check_if_phone_is_authorized');
add_filter('bp_signup_validate', 'dt_bp_check_if_phone_is_authorized');

// Once the user registers this hook adds a second verification code to the DB so we know the verified number is tied to an account

add_action('user_register', 'dt_store_user_id_for_phone_auth');

// This action re-orders WC scripts and allows us to bind a click handlder to our phone auth w/ the correct priority

add_action('init', 'dt_reorder_woocommerce_main_script');

// Remove phone field from WooCommerce - we'll get this from the phone auth script

function custom_override_checkout_fields($fields) {
    unset($fields['billing']['billing_phone']);

    return $fields;
}

// Add field elements to the registration & checkout pages

function dt_add_phone_auth_fields() {

    // Only show these fields for new users
    if (!is_user_logged_in()) {

        ?>

        <div class="dt-phone-auth"
             style="border:1px solid #ccc;max-width:100%;padding:50px;background-color: white;border-radius: 5px;margin-top: 15px;">

            <h3 style="" id="auth_header">Account Authentication</h3>
            <p id="auth_header_sub" style="margin-top:0px;">In order to ensure you are an actual human being, enter your
                phone number below with area code. You will then receive a verification code and a phone call. Enter the
                verification code when prompted by the voice message. (Note: your phone number will ONLY be used for
                authentication.)</p>

            <div id="auth_enter_number">
                <input style="max-width:250px;height:40px !important;font-size:16px;" id="auth_phone_number"
                       name="auth_phone_number" type="text" placeholder="Enter your phone number">
                <input style="margin:0px;line-height:9px !important" class="button" name="auth_submit" id="auth_submit"
                       type="submit" value="Verify">
            </div>

            <div id="auth_verify_code" style="display: none;font-weight:400;">
                <!-- <p >Calling you in just a moment.</p> -->
                <p style="margin-top:0px;">When prompted, enter the verification code:</p>
                <h1 id="auth_verification_code"></h1>
                <p><strong id="status">Calling you in just a moment…</strong></p>
            </div>

            <div id="auth_verify_again" style="display:none;">
                <p id="auth_verify_error" style="display:none;color:#F76;font-weight:400;margin-top:0px;"></p>
                <p><a href="#!" id="dt_try_call_again" class="button"
                      style="font-size:13px;border-radius:5px;margin-left:0px;">Try Again</a></p>
            </div>

        </div>

        <?php

    }

}

// Make sure phone has been authenticated and related user has not already been created for WooCommerce Checkout

function dt_wc_check_if_phone_is_authorized() {

    // Only validate these fields for new users
    if (!is_user_logged_in()) {

        if (!empty($_POST["auth_phone_number"])) {
            global $wpdb;
            $number = preg_replace('/[^0-9]/', '', mysql_real_escape_string($_POST["auth_phone_number"]));

            // If this is a 10 digit American number, lets add international prefix of 1 to be consistent with Twilios Auth System
            if (strlen($number) == 10) {
                $number = '1' . $number;
            } // if the user has entered 01 for the country code, lets remove the 0
            else {
                if ($number[0] == 0) {
                    $number = ltrim($number, '0');
                }
            }

            // Get our phone info from the DB
            $sql = 'SELECT *
					FROM wp_phone_auth
					WHERE phone_number = "' . $number . '"';

            $phone_info = $wpdb->get_row($sql, OBJECT);

            // If phone is verified & user does not exist yet
            if ($phone_info->verified == 1) {
                if ($phone_info->user_id == 0) {
                    return;
                } else {
                    wc_add_notice(__('Error: That phone number is connected to an existing account.'), 'error');
                }
            } else {
                wc_add_notice(__('Error: Your phone number could not been verified, please try again.'), 'error');
            }
        } else {
            wc_add_notice(__('Error: Please enter a phone number for account authentication.'), 'error');
        }

    }

}

// Make sure phone has been authenticated and related user has not already been created for registration

function dt_bp_check_if_phone_is_authorized() {

    if (!empty($_POST["auth_phone_number"])) {

        // Strip any non numeric characters from our phone number
        $number = preg_replace('/[^0-9]/', '', mysql_real_escape_string($_POST["auth_phone_number"]));

        // If this is a 10 digit American number, lets add international prefix of 1 to be consistent with Twilios Auth System
        if (strlen($number) == 10) {
            $number = '1' . $number;
        } // if the user has entered 01 for the country code, lets remove the 0
        else {
            if ($number[0] == 0) {
                $number = ltrim($number, '0');
            }
        }

        // Get our phone info from the DB
        global $wpdb;
        $sql = 'SELECT *
				FROM wp_phone_auth
				WHERE phone_number = "' . $number . '"';

        $phone_info = $wpdb->get_row($sql, OBJECT);

        // If phone is verified & user does not exist yet
        if ($phone_info->verified == 1 && $phone_info->user_id == 0) {
            return;
        } else {
            global $bp;
            $bp->signup->errors['signup_username'] = __('Error: that phone number is connected to an existing account.', 'buddypress');
        }

    } else {
        global $bp;
        $bp->signup->errors['signup_username'] = __('Error: please authenticate your phone number to continue with registration.', 'buddypress');
    }

}

// Store the user id in the authentication table so we know the user was actually created

function dt_store_user_id_for_phone_auth($user_id) {

    // Only authenticate for new users (not logged in) - phone auth is hidden therefore empty for new users
    if (!empty($_POST["auth_phone_number"])) {

        global $wpdb;
        $number = preg_replace('/[^0-9]/', '', mysql_real_escape_string($_POST["auth_phone_number"]));

        // If this is a 10 digit American number, lets add international prefix of 1 to be consistent with Twilios Auth System
        if (strlen($number) == 10) {
            $number = '1' . $number;
        } // if the user has entered 01 for the country code, lets remove the 0
        else {
            if ($number[0] == 0) {
                $number = ltrim($number, '0');
            }
        }

        // Get our phone info from the DB
        $sql = 'SELECT *
				FROM wp_phone_auth
				WHERE phone_number = "' . $number . '"';

        $phone_info = $wpdb->get_row($sql, OBJECT);

        // Update the DB with the User ID - this serves as a way to validate existing users against new phone authentications
        $wpdb->replace('wp_phone_auth', array(
            'ID'                => $phone_info->ID,
            'phone_number'      => $phone_info->phone_number,
            'verification_code' => $phone_info->verification_code,
            'verified'          => $phone_info->verified,
            'user_id'           => $user_id,
        ), array('%d', '%d', '%d', '%d', '%d'));

    }

}

// Load WooCommerce javascript after our core javascript so our submit button handler propagates in the correct order

function dt_reorder_woocommerce_main_script() {
    wp_deregister_script('wc-checkout');
    wp_register_script('wc-checkout', '/wp-content/plugins/woocommerce/assets/js/frontend/checkout.min.js', array(
        'jquery',
        'dt-core',
        'woocommerce',
        'wc-country-select',
        'wc-address-i18n',
    ));
    wp_enqueue_script('wc-checkout');
}

////////////////////////////////////////////////////////////////////////////////////////////////

// Adds RSS template for iTunes, TuneIn, & Stitcher compatible feed

remove_all_actions('do_feed_rss2');
add_action('do_feed_rss2', 'dt_custom_feed_rss2', 10, 1);

function dt_custom_feed_rss2($for_comments) {
    $rss_template = get_template_directory() . '/dt-feed-rss2.php';
    if (file_exists($rss_template)) {
        load_template($rss_template);
    }
}

add_action('series_add_form_fields', 'dt_series_add_visible_field', 10, 2);
add_action('series_edit_form_fields', 'dt_series_add_visible_field', 10, 2);
function dt_series_add_visible_field($term) {
    // get the term id
    $termId = $term->term_id;

    $termMeta     = get_option('taxonomy_' . $termId);
    $hideFromFeed = false;

    if ($termMeta['hide_from_feed'] == 'true') {
        $hideFromFeed = true;
    }
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_meta[hide_from_feed]"><?php _e('Hide From Feed', 'dt'); ?></label>
        </th>
        <td>
            <select name="term_meta[hide_from_feed]" id="term_meta[hide_from_feed]">
                <option value="true" <?php echo($hideFromFeed ? 'selected' : ''); ?>>Yes</option>
                <option value="false" <?php echo(!$hideFromFeed == 'false' ? 'selected' : ''); ?>>No</option>
            </select>
            <p class="description"><?php _e('Should the Series hide from the homepage?', 'dt'); ?></p>
        </td>
    </tr>
    <?php
}

add_action('series_add_form_fields', 'dt_series_add_ordinal_field', 10, 2);
add_action('series_edit_form_fields', 'dt_series_add_ordinal_field', 10, 2);
function dt_series_add_ordinal_field($term) {
    // get the term id
    $termId = $term->term_id;

    $termMeta = get_option('taxonomy_' . $termId);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_meta[ordinal]"><?php _e('Ordinal', 'dt'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[ordinal]" id="term_meta[ordinal]"
                   value="<?php echo $termMeta['ordinal']; ?>"/>
            <p class="description"><?php _e('What order should we display?  <i>Ex: 10</i>', 'dt'); ?></p>
        </td>
    </tr>
    <?php
}

add_action('series_add_form_fields', 'dt_series_add_ad_placement_field', 10, 2);
add_action('series_edit_form_fields', 'dt_series_add_ad_placement_field', 10, 2);
function dt_series_add_ad_placement_field($term) {
    // get the term id
    $termId = $term->term_id;

    $termMeta = get_option('taxonomy_' . $termId);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_meta[ad_placement]"><?php _e('Ad Placement', 'dt'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[ad_placement]" id="term_meta[ad_placement]"
                   value="<?php echo $termMeta['ad_placement']; ?>"/>
            <p class="description"><?php _e('What positions should the ads be in? <i>Ex: 2, 5</i>', 'dt'); ?></p>
        </td>
    </tr>
    <?php
}

add_action('edited_series', 'save_series_custom_fields');
add_action('edited_series', 'save_series_custom_fields');
function save_series_custom_fields($termId) {
    if (isset($_POST['term_meta'])) {
        $termMeta     = get_option('taxonomy_' . $termId);
        $categoryKeys = array_keys($_POST['term_meta']);

        foreach ($categoryKeys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                if ($key == 'ad_placement') {
                    $_POST['term_meta'][$key] = str_replace(' ', '', $_POST['term_meta'][$key]);
                }

                $termMeta[$key] = $_POST['term_meta'][$key];
            }
        }

        update_option('taxonomy_' . $termId, $termMeta);
    }
}

add_filter('manage_series_custom_column', 'add_series_column_content', 10, 3);
function add_series_column_content($content, $column_name, $term_id) {
    $term     = get_term($term_id, 'series');
    $termMeta = get_option('taxonomy_' . $term->term_id);
    switch ($column_name) {
        case 'ordinal':
            $content = $termMeta['ordinal'];
            break;
        default:
            break;
    }

    return $content;
}

add_filter('manage_edit-series_columns', 'manage_series_columns');
function manage_series_columns($columns) {
    // add 'My Column'
    $columns['ordinal'] = 'Ordinal';

    return $columns;
}

// Adds new filters for the "If Menu" to conditionally show or hide menu items
add_filter( 'if_menu_conditions', 'wpb_new_menu_conditions' );

function wpb_new_menu_conditions( $conditions ) {
  $conditions[] = array(
    'name'    =>  'there is a live stream', // name of the condition
    'condition' =>  function($item) {          // callback - must return TRUE or FALSE
    global $onAirPostData;
    return $onAirPostData;
    }
  );

  return $conditions;
}

function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');