<?php

$templateURI = get_template_directory_uri();

// Hook All The Things

add_filter( 'wp_list_categories', 'frank_remove_category_list_rel' );
add_filter( 'the_category', 'frank_remove_category_list_rel' );

add_filter( 'script_loader_src', 'frank_remove_version_url_parameter', 15, 1 );
add_filter( 'style_loader_src', 'frank_remove_version_url_parameter', 15, 1 );
add_filter( 'the_generator', 'frank_wp_generator' );	

add_action( 'widgets_init', 'frank_widgets' );
add_action( 'after_setup_theme', 'frank_register_menu' );
add_action( 'after_switch_theme', 'frank_set_missing_widget_options' );

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' ); 

// Add post types, metaboxes, & shortcodes
require_once('modules/post-types.php');
require_once('modules/post-types-mb.php');
require_once('modules/shortcodes.php');

// Thumbnail Image Sizes
add_image_size( 'sm-archive', 458, 258, true );
add_image_size( 'sm-review', 418, 620, true );
add_image_size( 'lg-slider', 1280, 550, true );
add_image_size( 'md-video', 953, 536, true );

// Used to create "review" movie poster thumbnail
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(
		array(
			'label' => 'Movie Poster (if applicable)',
			'id' => 'dt-review-poster',
			'post_type' => 'dt_shows'
		)
	);
}

// Custom Menus
function frank_register_menu() {

	register_nav_menu( 'frank_primary_navigation', 'Primary Navigation' );
	register_nav_menu( 'frank_mobile_navigation', 'Mobile Navigation' );
	register_nav_menu( 'frank_footer_navigation', 'Footer Navigation' );

}

// Clean Up Queries & Potential Performance Things
function frank_set_missing_widget_options( ){
	add_option( 'widget_pages', array( '_multiwidget' => 1 ) );
	add_option( 'widget_calendar', array( '_multiwidget' => 1 ) );
	add_option( 'widget_tag_cloud', array( '_multiwidget' => 1 ) );
	add_option( 'widget_nav_menu', array( '_multiwidget' => 1 ) );
}

function frank_remove_version_url_parameter( $src ) {
	$parts = explode( '?', $src );
	return $parts[0];
}

// Add Sidebar/Widgets
function frank_widgets() {
	
	register_sidebar(
		array(
			'name'      	=> 'Featured/Ad in Navigation',
			'id'     		=> 'dt-feature-top',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			)
	);
	
	register_sidebar(
		array(
			'name'      	=> 'Schedule on Home Page',
			'id'     	 	=> 'dt-schedule',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			)
	);
	
	register_sidebar(
		array(
			'name'      	=> 'Today in Footer',
			'id'     	 	=> 'dt-today-footer',
			'before_widget' => '<div id="footer-today">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
			)
	);
	
	register_sidebar(
		array(
			'name'      	=> 'Ad: Bottom of Home',
			'id'     	 	=> 'dt-home-feature-bottom',
			'before_widget' => '<div class="dt-feature-bottom">',
			'after_widget'  => '</div>',
			'before_title'  => '<p><a id="dt-bot-feat-close" class="icon-cancel-squared"></a>',
			'after_title'   => '</p>',
			)
	);
	
	register_sidebar(
		array(
			'name'      	=> 'Ad: All Single Page Footer',
			'id'     	 	=> 'dt-feature-single',
			'before_widget' => '<div class="dt-ad" style="clear:both;">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="content"><p>',
			'after_title'   => '</p></div>',
			)
	);

}

// Execute Shortcodes in our custom widgets
add_filter('dt-home-feature-bottom', 'do_shortcode');
add_filter('dt-feature-single', 'do_shortcode');
add_filter('dt-feature-top', 'do_shortcode');

function frank_wp_generator() {
		echo '<meta name="generator" content="WordPress ', bloginfo( 'version' ), '" />';
}

/* Remove rel attribute from the category list - thanks Joseph (http://josephleedy.me/blog/make-wordpress-category-list-valid-by-removing-rel-attribute/)! */
function frank_remove_category_list_rel( $output ) {
	$output = str_replace( ' rel="category tag"', '', $output );
	return $output;
}

// WP Admin: Remove Visual Editor on Pages (@wp-autop)
add_filter( 'user_can_richedit', 'wpse_58501_page_can_richedit' );
function wpse_58501_page_can_richedit( $can ) 
{
    global $post;

    if ( $post->post_type == 'page' ) {
    
    	$shortcode = has_shortcode( $post->post_content, 'section' );
    	
    	if ($shortcode) {
	        return false;
	    }
	}

    return $can;
}

// WP Admin: Remove Dashboard Widgets that aren't useful
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// WP Admin: Removes Widgets as they are not designed or integrated into the custom theme
// A developer might want to add these back in, but make sure to refine front-end integration!
function unregister_default_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');	
	//unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
	unregister_widget('Twenty_Eleven_Ephemera_Widget');
	unregister_widget( 'BP_Activity_Widget' );
	unregister_widget( 'BP_Blogs_Recent_Posts_Widget' );
	unregister_widget( 'BP_Groups_Widget' );
	unregister_widget( 'BP_Core_Welcome_Widget' );
	unregister_widget( 'BP_Core_Friends_Widget' );
	unregister_widget( 'BP_Core_Login_Widget' );
	unregister_widget( 'BP_Core_Members_Widget' );
	unregister_widget( 'BP_Core_Whos_Online_Widget' );
	unregister_widget( 'BP_Core_Recently_Active_Widget' );
	unregister_widget( 'WC_Widget_Recent_Products' );
	unregister_widget( 'WC_Widget_Products' );
	unregister_widget( 'WC_Widget_Featured_Products' );
	unregister_widget( 'WC_Widget_Product_Categories' );
	unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
	unregister_widget( 'WC_Widget_Cart' );
	unregister_widget( 'WC_Widget_Layered_Nav' );
	unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
	unregister_widget( 'WC_Widget_Price_Filter' );
	unregister_widget( 'WC_Widget_Product_Search' );
	unregister_widget( 'WC_Widget_Top_Rated_Products' );
	unregister_widget( 'WC_Widget_Recent_Reviews' );
	unregister_widget( 'WC_Widget_Recently_Viewed' );
	unregister_widget( 'WC_Widget_Best_Sellers' );
	unregister_widget( 'WC_Widget_Onsale' );
	unregister_widget( 'WC_Widget_Random_Products' );
	unregister_widget( 'BBP_Login_Widget' );
	unregister_widget( 'BBP_Views_Widget' );
	unregister_widget( 'BBP_Search_Widget' );
	unregister_widget( 'BBP_Forums_Widget' );
	unregister_widget( 'BBP_Topics_Widget' );
	unregister_widget( 'BBP_Stats_Widget' );
	unregister_widget( 'BBP_Replies_Widget' );
 }
add_action('widgets_init', 'unregister_default_widgets', 11);

// Include Custom Post Type content in search
// function dt_filter_search($query) {
//     if ($query->is_search) {
// 		//$query->set('post_type', array('dt_shows', 'post', 'page', 'dt-comic', 'dt-audio'));
//     };
//     return $query;
// };
// add_filter('pre_get_posts', 'dt_filter_search');

// WP Admin: Change Custom Post Type Icons
add_action( 'admin_head', 'dt_admin_css' );
function dt_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/stylesheets/custom-admin.css">';
}

// WooCommerce: Redirects from Cart to Checkout
// add_filter('add_to_cart_redirect', 'custom_add_to_cart_redirect');
// function custom_add_to_cart_redirect() {
// 	$showid = $_GET['showid'];
// 	return get_permalink(get_option('woocommerce_checkout_page_id')) . '?showid=' . $showid ; // Replace with the url of your choosing
// }

// WooCommerce: Empty Cart on Page Load
// add_action( 'init', 'woocommerce_clear_cart_url' );
// function woocommerce_clear_cart_url() {
//   global $woocommerce;
//     if ( isset( $_GET['empty-cart'] ) ) { 
//         $woocommerce->cart->empty_cart(); 
//     }
// }

// Buddypress: AJAX Function to Refresh Single Page Comments (not implemented)
add_action( 'wp_ajax_dt_side_refresh0602', 'dt_side_refresh0602' );
function dt_side_refresh0602($activity_id) {
	$id = $_POST['activity_id'];
	if ( bp_activity_blog_comments_has_activities( '&include=' . $id ) ) {

		// Reverse Comment Order to show newest at top.
		global $activities_template;
		$activities_template->activities[0]->children = array_reverse($activities_template->activities[0]->children);

		while ( bp_activities() ) {
		
			bp_the_activity();			
			echo '<div class="activity-comments" id="' . bp_activity_id() . '">';
				global $sideRefresh; $sideRefresh = true;
				bp_activity_comments();
			echo '</div>';
				
		 }

	}
}

// Buddypress: Show Custom Post Type Activity
add_filter ( 'bp_blogs_record_post_post_types', 'activity_publish_custom_post_types',1,1 );
function activity_publish_custom_post_types( $post_types ) {
		$post_types[] = 'dt_shows';
		$post_types[] = 'dt-video';
		$post_types[] = 'dt-users-blog';
		$post_types[] = 'dt-comics';
		$post_types[] = 'dt-audio';
		return $post_types;
}

// Customize Soundcloud/Youtube Player Embeds
add_filter('oembed_result','lc_oembed_result', 10, 3);
function lc_oembed_result($html, $url) {
 
 // Soundcloud parameters
 if (strpos($url,'soundcloud') !== false) { 
	$html = str_replace( '?visual=true', '?visual=false', $html );
	$html = str_replace( '&show_artwork=true&maxwidth=500&maxheight=750', '&show_artwork=false&&color=ff7700&hide_related=true&maxwidth=200&maxheight=960', $html);
 	$html = str_replace( 'width="500" height="400"', 'width="100%" height="180px"', $html);
 }

 // Youtube parameters
 if (strpos($url,'youtube') !== false) { 
	$html = str_replace( '?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&color=white&rel=0', $html );
 	$html = str_replace( 'width="500" height="281"', 'width="100%" height="500px"', $html);
 }

 return $html;

}

// Log-in Redirect, keeps users in the site experiences and away from /wp-admin
add_action( 'wp_login_failed', 'pu_login_failed' ); // hook failed login
function pu_login_failed( $user ) {
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }

	    exit;
	}
}

// Log-in Redirect (blank fields), keeps users in the site experiences and away from /wp-admin
add_action( 'authenticate', 'pu_blank_login');
function pu_blank_login( $user ){
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	$error = false;
	
  	if($_POST['log'] == '' || $_POST['pwd'] == '')
  	{
  		$error = true;
  	}

  	// check that were not on the default login page
  	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {

  		// make sure we don't already have a failed login attempt
    	if ( !strstr($referrer, '?login=failed') ) {
    		// Redirect to the login page and append a querystring of login failed
        	wp_redirect( $referrer . '?login=failed' );
      	} else {
        	wp_redirect( $referrer );
      	}

    exit;

  	}
}

// Add OpenGraph to WP Languages
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

// Add Facebook Properties for OpenGraph
function insert_fb_in_head_lb() {
	global $post, $bp;
	//var_dump($bp->current_component);
	if ( !is_single() || $bp->current_component )
		return;
		
        echo '<meta property="fb:admins" content="korey.coleman.5"/>';
        echo '<meta property="og:title" content="' . get_the_title() . ' on DoubleToasted.com" />';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="DoubleToasted.com"/>';
	if(!has_post_thumbnail( $post->ID )) { 
		$default_image="http://kcoolman.wpengine.com/wp-content/themes/toasted/screenshot-fb.jpg";
		echo '<meta property="og:image" content="' . $default_image . '"/>';
	}
	else{
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}
	echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head_lb', 5 );

// WP Permalinks: Removes 'auto-correct'
// remove_filter('template_redirect', 'redirect_canonical');

// On-air: Check if we have a 'live' post and load post-data into global var if we do
function dt_set_onair_cookie() {

	$args = array(
		'numberposts' => 1,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'dt_shows',
		'post_status' => 'publish',
     );

	$cookiePost = wp_get_recent_posts( $args, ARRAY_A );
	$onAirID = $cookiePost[0]["ID"];
	$isOnAir = get_post_meta( $onAirID, '_lac0509_dt-is-live-stream', true );
	
    if ( $isOnAir ) {
    	global $onAirPostData;
    	$onAirPostData = $cookiePost;  
    }

}
add_action( 'init', 'dt_set_onair_cookie');

// News: Adjust excerpt length
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 20;
}

// Add 'order' attribute to posts page
add_action( 'admin_init', 'posts_order_wpse_91866' );

function posts_order_wpse_91866() 
{
    add_post_type_support( 'post', 'page-attributes' );
}
 
// The following 2 functions are aimed to kill spam-bots	
// http://www.pixeljar.net/2012/09/19/eliminate-buddypress-spam-registrations/
add_action( 'bp_after_signup_profile_fields', 'dt_add_honeypot' );
 
/**
 * Add a hidden text input that users won't see
 * so it should always be empty. If it's filled out
 * we know it's a spambot or some other hooligan
 */
function dt_add_honeypot() {
	echo '<div style="display: none;">';
	echo '<input type="text" name="oh_no_you_dint" id="sucka" />';
	echo '</div>';
}
 
// Validate the kill-spam input
add_filter( 'bp_core_validate_user_signup', 'dt_check_honeypot' );
 
/**
 * Check to see if the honeypot field has a value.
 * If it does, return an error
 */
function dt_check_honeypot( $result = array() ) {
	global $bp;
 
	if( isset( $_POST['oh_no_you_dint'] ) && !empty( $_POST['oh_no_you_dint'] ) )
        //$errors->add( 'user_email', __( 'Sorry, that email address is already used!', 'buddypress' ) );
		//var_dump($result['errors']);
		$result['errors']->add( 'user_name', __( "<h2 style='padding:30px 0px;line-height:30px;'>Wow. Really? You're totally a spammer. Go somewhere else with your spammy ways.</h2>" ) );
				
	return $result;

}

// Removes '&nbsp|&nbsp' characters from BB-Press topic subscribe link
function ntwb_forum_subscription_link( $args ) {
    $args['before'] = '';
    $args['after']  = '';
    return $args;
}
 
add_filter( 'bbp_before_get_forum_subscribe_link_parse_args', 'ntwb_forum_subscription_link' );

// Add specific CSS class by filter
add_filter('body_class','my_class_names');

function my_class_names($classes) {

	// add 'class-name' to the $classes array
	$classes[] = 'class-name';
	// return the $classes array
	return $classes;
	
}

function remove_xprofile_links() {
    remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}
add_action( 'bp_init', 'remove_xprofile_links' );

// Add rtmedia activity type to bp-editable-activity
function add_edit_post_types( $post_types ) {
      $post_types[] = 'rtmedia_update'; // Hier die Slugs der Custom Post Types eintragen, bei denen Erwähnungen im Beitrag selbst berücksichtigt werden
      return $post_types;
  }
add_filter( 'bp_editable_activity_allowed_type', 'add_edit_post_types' );

// AJAX Function for Getting Posts - Used on "Show More" posts & Post Filters
add_action("wp_ajax_get_more_dt_posts", "get_more_dt_posts");
add_action("wp_ajax_nopriv_get_more_dt_posts", "get_more_dt_posts");

function get_more_dt_posts(  ) {

	$noncetype = $_POST['sort'] && $_POST['page'] == 1 ? 'dt-ajax-sort-posts' : 'dt-ajax-load-more-reviews';
	
	if ( ! wp_verify_nonce( $_POST['nonce'], $noncetype ) )
		die ('Couldn\'t load more posts.');
        
	if ( $_POST['category'] !== 'false' && $_POST['type'] == 'dt_shows' )
		$cat = array( array( 'taxonomy' => 'series', 'field' => 'slug', 'terms' => array( $_POST['category'] ) ) );

	if (!$_POST['sort']) {
		$args = array(
			'post_type' 	=> $_POST['type'],
			'paged' 		=> $_POST['page'],
			'post_status' 	=> array( 'publish', 'private' ),
			'tax_query' 	=> $cat
		);
	}
	
	else if ($_POST['sort'] == 'toasty' || $_POST['sort'] == 'rating') {
	
		if ($_POST['sort'] == 'rating') {
			$key = '_lac0509_rev_rating';
		}	
		
		else {
			$key = 'dt_post_favorite_count';	
		}
		
		$args = array(
			'post_type' 	=> $_POST['type'],
			'orderby'		=> 'meta_value_num',
			'paged' 		=> $_POST['page'],
			'post_status' 	=> array( 'publish', 'private' ),
			'tax_query' 	=> $cat,
			'meta_key' 		=> $key
		);	
	}
		
	else {
	
		if ($_POST['sort'] == 'oldest') {
			$order = 'ASC';
			$orderby = '';
		}	
		
		else if ($_POST['sort'] == 'popular') {
			$order = '';
			$orderby = 'comment_count';
		}
		
		$args = array(
			'post_type' 	=> $_POST['type'],
			'order'			=> $order,
			'orderby'		=> $orderby,
			'paged' 		=> $_POST['page'],
			'post_status' 	=> array( 'publish', 'private' ),
			'tax_query' 	=> $cat
		);	
	}
	
	$ajax_query = new WP_Query( $args );
	
	if ( $ajax_query->have_posts() ) {
		while ( $ajax_query->have_posts() ) {	
				
			$ajax_query->the_post();
			
			// Serve HTML for News Blog Posts
			if ($_POST['type'] == 'post' ) {
				$newsthumb = get_the_post_thumbnail($post->ID, 'sm-archive');
				if ($newsthumb) {
					$newspostclass = 'has-news-thumb';
					$result .= '<div class="post columns end ' . $newspostclass . ' animate-post">
									<div class="dt-news-thumb-img">' . $newsthumb . '</div>
										<div class="dt-news-info">
											<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
											<p class="dt-news-date">' . get_the_date() . '</p><p>' . get_the_excerpt() . '</p>
											<a class="button" href="' . get_the_permalink() . '">Read More</a>							
										</div>							
									</div>
								</div>';
				}
			}
			
			// Serve HTML for Reviews Posts
			else if ($_POST['category'] == 'reviews') {
				$result .= '<div class="post large-3 medium-4 small-6 columns end animate-post posts-page-' . $_POST['page'] . '"><a class="dt-archive-thumb-small" href="' . get_the_permalink() . '">';
				if (class_exists('MultiPostThumbnails')) 
					$thumb = MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'dt-review-poster', NULL, 'sm-review');
				$result .= $thumb;
				
				$result .= '<div class="dt-archive-review-meta">';
										
						// Get Favorite Count
						if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . get_the_ID() ) ) { 
							while ( bp_activities() ) : bp_the_activity();

							$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );						
							if (!$my_fav_count >= 1)
								$my_fav_count = 0;
							$result .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span><br />';
							endwhile;
					
						}

						// Get Comment Count
						$result .= '<span class="dt-archive-com-count">' . get_comments_number() . '</span><br />';
						
						$rating = get_post_meta( get_the_ID(), '_lac0509_rev_rating', true );
						if ($rating) {
							$rating = $rating - 1;
							$result .= '<span class="dt-archive-meta-rating"><img src="/wp-content/themes/toasted/images/reviews-meta-ratings-martini-' . $rating . '.png" width="130" alt="Our Rating" />';
						}
								 
				$result .= '</div></a></div>';

			}
			
			// Other Types
			else {
			
				// If User Blog add some extra meta
				if ($_POST['type'] == 'dt-users-blog') {
				
					$title = '<span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_date('F j') . '</span><br />';
					$title .= '<span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_title() . '</span><span style="font-weight:400;"> by ' . get_the_author() . '</span><br />';
					
					$isthumb = get_the_post_thumbnail($post->ID, 'sm-archive');
				
					if ($isthumb) {
						$image = $isthumb;
					}
					
					else {
						$image = '<img src="/wp-content/themes/toasted/images/dt-users-blog-placeholder.png" />';
					}
				
				}
				
				else {
				
					$title = '<span style="font-weight:600;font-size:14px;line-height:20px;">' . get_the_date('F j') . '</span><br />';
					$title .= '<p>' . get_the_excerpt( get_the_ID() ) . '</p>';
					$image = get_the_post_thumbnail(get_the_ID(), 'sm-archive');
				
				}
	
				$result .= '<div class="post columns animate-post">
								<a class="dt-archive-thumb-small" href="' . get_the_permalink() . '">';
								
				$result .= 			'<div class="dt-post-thumb">' . $image;
				$result .= 				'<div class="dt-post-meta">';

										// Get Favorite Count
										if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . get_the_ID() ) ) {
										 
											while ( bp_activities() ) : bp_the_activity();
						
											$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );						
											if (!$my_fav_count >= 1)
												$my_fav_count = 0;
											$result .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
											endwhile;
									
										}			
				
										// Get Comment Count
				$result .= 					'<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
				$result .= 				'</div>
									</div>';
								
								
				$result .=			'<div class="dt-post-info">' . $title . '</div>
								</a>							
							</div>';
			}
				
		}
		
		echo $result;
		
	} else {
		echo '<h3 style="clear:both;width:100%;text-align:center;padding-top:40px;">No more posts found.</h2>';
	}
	
die();

}

?>