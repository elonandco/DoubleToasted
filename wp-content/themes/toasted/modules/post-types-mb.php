<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_shows_dtoptions_0509' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_shows_dtoptions_0509( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_lac0509_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes['shows_meta_0509'] = array(
		'id'         => 'dt_shows_options',
		'title'      => __( 'Media Info', 'cmb' ),
		'pages'      => array( 'dt_shows', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'On-Air?', 'cmb' ),
				'desc' => __( 'Yes', 'cmb' ),
				'id'   => $prefix . 'dt-is-live-stream',
				'type' => 'checkbox',
			),
			array(
				'name' => __( 'Time', 'cmb' ),
				'desc' => __( 'Used for homepage slider', 'cmb' ),
				'id'   => $prefix . 'dt-show-time',
				'type' => 'text_time',
			),
			array(
				'name' => __( 'Free Show?', 'cmb' ),
				'desc' => __( 'Yes', 'cmb' ),
				'id'   => $prefix . 'dt-free-show',
				'type' => 'checkbox',
			),
			array(
				'name' => __( 'Gigcasters ID:', 'cmb' ),
				'desc' => __( 'Used for live streams/Gigcasters On Demand (ex. 20140624)', 'cmb' ),
				'id'   => $prefix . 'dt-blastro-id',
				'type' => 'text_medium',
			),
// 			array(
// 				'name' => __( 'Episode:', 'cmb' ),
// 				'id'   => $prefix . 'dt_show_episode',
// 				'type' => 'text_small',
// 			),
			array(
				'name' => __( 'Product ID:', 'cmb' ),
				'desc' => __( 'Woocommerce ID (ex. 70)', 'cmb' ),
				'id'   => $prefix . 'dt-show-sku',
				'type' => 'text_small'
			),
			array(
				'name' => __( 'Paid Video Filename SD:', 'cmb' ),
				'desc' => __( 'exact filename from FTP (ex. 062514-website-launch-sd.mp4)', 'cmb' ),
				'id'   => $prefix . 'dt-video-url',
				'type' => 'text'
			),
			array(
				'name' => __( 'Paid Video Filename HD:', 'cmb' ),
				'desc' => __( 'exact filename from FTP (ex. 062514-website-launch-hd.mp4)', 'cmb' ),
				'id'   => $prefix . 'dt-video-url-hd',
				'type' => 'text'
			),
            array(
                'name' => __( 'Sample Start Time:', 'cmb' ),
                'desc' => __( 'The start time, in seconds, for the sample to begin', 'cmb' ),
                'id'   => $prefix . 'dt-video-sample_start',
                'type' => 'text'
            ),
            array(
                'name' => __( 'Sample End Time:', 'cmb' ),
                'desc' => __( 'The end time, in seconds, for the sample to stop', 'cmb' ),
                'id'   => $prefix . 'dt-video-sample_end',
                'type' => 'text'
            ),
			array(
				'name' => __( 'Free Video Link (if applicable):', 'cmb' ),
				'desc' => __( 'Youtube URL', 'cmb' ),
				'id'   => $prefix . 'dt-preview-video-url',
				'type' => 'oembed',
			),
			array(
				'name' => __( 'Free Audio Link:', 'cmb' ),
				'desc' => __( 'Soundcloud URL', 'cmb' ),
				'id'   => $prefix . 'dt-audio-url',
				'type' => 'oembed',
				// 'repeatable' => true,
			)
		),
	);
	
	$meta_boxes['dt_video_meta'] = array(
		'id'         => 'dt_video_options',
		'title'      => __( 'Media Info', 'cmb' ),
		'pages'      => array( 'dt-video' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Video Link:', 'cmb' ),
				'desc' => __( 'This will support many major sites text links. <a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">Full list here.</a>' ),
				'id'   => $prefix . 'dt-preview-video-url',
				'type' => 'oembed',
			),
			array(
				'name' => __( 'Uploaded Video:', 'cmb' ),
				'desc' => __( 'exact filename from FTP (ex. 062514-website-launch-sd.mp4). Also make sure to only choose either a file or a video link. The video link above will override this field.', 'cmb' ),
				'id'   => $prefix . 'dt-video-url',
				'type' => 'text'
			),
		),
	);

	$meta_boxes['shows_meta_0510'] = array(
		'id'         => 'dt_audio_shows',
		'title'      => __( 'Media Info', 'cmb' ),
		'pages'      => array( 'dt-audio', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Audio:', 'cmb' ),
				'desc' => __( 'Soundcloud URL', 'cmb' ),
				'id'   => $prefix . 'dt-audio-url',
				'type' => 'oembed',
				// 'repeatable' => true,
			)
		),
	);

	$meta_boxes['post_media_meta_0510'] = array(
		'id'         => 'dt_post_media',
		'title'      => __( 'Media Info', 'cmb' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Embed:', 'cmb' ),
				'desc' => __( 'Soundcloud/Youtube URL', 'cmb' ),
				'id'   => $prefix . 'dt-media-internal',
				'type' => 'oembed',
				// 'repeatable' => true,
			),
			array(
				'name' => __( 'Upload:', 'cmb' ),
				'desc' => __( 'Upload file to wordpress and select add "sv" shortcode', 'cmb' ),
				'id'   => $prefix . 'dt-media-external',
				'type' => 'wysiwyg',
				'options' => array(
					'wpautop' => false, // use wpautop?
					'media_buttons' => true, // show insert/upload button(s)
					'textarea_rows' => get_option('default_post_edit_rows', 3), // rows="..."
					'teeny' => true, // output the minimal editor config used in Press This
				)
			)
		)
	);
		
// 	$meta_boxes['comics_meta_0510'] = array(
// 		'id'         => 'dt_comic_issue',
// 		'title'      => __( 'Meta Info', 'cmb' ),
// 		'pages'      => array( 'dt-comics', ), // Post type
// 		'context'    => 'normal',
// 		'priority'   => 'high',
// 		'show_names' => true, // Show field names on the left
// 		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
// 		'fields'     => array(
// 			array(
// 				'name' => __( 'Issue:', 'cmb' ),
// 				'id'   => $prefix . 'dt-comic-issue',
// 				'type' => 'text_medium',
// 				// 'repeatable' => true,
// 			),
// 			array(
// 				'name' => __( 'Location:', 'cmb' ),
// 				'desc' => __( 'The folder name where the comic was uploaded.', 'cmb' ),
// 				'id'   => $prefix . 'dt-comic-folder',
// 				'type' => 'text_medium',
// 				// 'repeatable' => true,
// 			)
// 		),
// 	);
	
	$meta_boxes['products_meta_0510'] = array(
		'id'         => 'dt-products-meta',
		'title'      => __( 'Redirect URL', 'cmb' ),
		'pages'      => array( 'product', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Show URL:', 'cmb' ),
				'desc' => __( 'Redirects user to show once purchased.', 'cmb' ),
				'id'   => $prefix . 'dt-product-url',
				'type' => 'text_medium',
				// 'repeatable' => true,
			)
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}

/* Added Review Extra Info Metaboxes */
add_filter( 'cmb_meta_boxes', 'cmb_shows_dtoptions_0912' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_shows_dtoptions_0912( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_lac0509_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes['shows_meta_0912'] = array(
		'id'         => 'dt-reviews-meta',
		'title'      => __( 'Single Review Meta (if applicable)', 'cmb' ),
		'pages'      => array( 'dt_shows', ), // Post type
		'show_on' 	 => array( 'key' => 'taxonomy', 'value' => array( 'series' => 'reviews' ) ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name'    => 'Koreys Rating',
				'desc'    => 'This is shown directly below media and is also used for sorting.',
				'id'      => $prefix . 'rev_rating',
				'type'    => 'select',
				'options' => array(
					'0' => __( 'Unrated', 'cmb' ),
					'1' => __( 'FUCK YOU!!!', 'cmb' ),
					'2' => __( 'Some Ol’ Bullshit', 'cmb' ),
					'3' => __( 'Rental', 'cmb' ),
					'4' => __( 'Matinee', 'cmb' ),
					'5' => __( 'Full Price!', 'cmb' ),
					'6' => __( 'Better Than Sex!!!', 'cmb' ),
				),
				'default' => 'custom',
			),
			array(
				'name'    => 'Martins Rating',
				'desc'    => 'This is shown directly below media and is also used for sorting.',
				'id'      => $prefix . 'rev_mart_rating',
				'type'    => 'select',
				'options' => array(
					'0' => __( 'Unrated', 'cmb' ),
					'1' => __( 'FUCK YOU!!!', 'cmb' ),
					'2' => __( 'Some Ol’ Bullshit', 'cmb' ),
					'3' => __( 'Rental', 'cmb' ),
					'4' => __( 'Matinee', 'cmb' ),
					'5' => __( 'Full Price!', 'cmb' ),
					'6' => __( 'Better Than Sex!!!', 'cmb' ),
				),
				'default' => 'custom',
			),
			array(
				'name' => 'Director',
				'id' => $prefix . 'review_director',
				'type' => 'text_medium'
			),
			array(
				'name' => 'Release Date',
				'id' => $prefix . 'review_release',
				'type' => 'text_date'
			)
			
		)
	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'metaboxes/init.php';

}

/**
 * Taxonomy show_on filter 
 * @author Bill Erickson
 * @link https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $metabox
 * @return bool display metabox
 */
function be_taxonomy_show_on_filter( $display, $meta_box ) {

    if ( 'taxonomy' !== $meta_box['show_on']['key'] )
        return $display;

    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
    elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
    if( !isset( $post_id ) )
        return $display;

    foreach( $meta_box['show_on']['value'] as $taxonomy => $slugs ) {
        if( !is_array( $slugs ) )
            $slugs = array( $slugs );

        $display = false;           
        $terms = wp_get_object_terms( $post_id, $taxonomy );
        foreach( $terms as $term )
            if( in_array( $term->slug, $slugs ) )
                $display = true;
    }

    return $display;

}
add_filter( 'cmb_show_on', 'be_taxonomy_show_on_filter', 10, 2 );

?>