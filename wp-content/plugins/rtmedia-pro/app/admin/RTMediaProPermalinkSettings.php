<?php
/**
 * Adds settings to the permalinks admin settings page.
 *
 * @author Kishore Sahoo <kishore.sahoo@rtcamp.com>
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'RTMediaProPermalinkSettings' ) ){

	/**
	 * RTMediaProPermalinkSettings Class
	 */
	class RTMediaProPermalinkSettings {

		/**
		 * Hook in tabs.
		 *
		 * @access public
		 * @param void
		 * @return void
		 */
		public function __construct() {
			global $rtmedia;
			$options = $rtmedia->options;
			if ( isset( $options[ 'rtmedia_enable_wp_album' ] ) && $options[ 'rtmedia_enable_wp_album' ] != "0" ) {
				add_action( 'admin_init', array( $this, 'settings_init' ) );
				add_action( 'admin_init', array( $this, 'settings_save' ) );
			}
		}

		/**
		 * Init our settings.
		 *
		 * @access public
		 * @param void
		 * @return void
		 */
		public function settings_init() {
			// Add a section to the permalinks page
			add_settings_section( 'sitewide-gallery-section-permalink', __( 'rtMedia: Slug for sitewide gallery section', 'rtmedia' ), array( $this, 'settings' ), 'permalink' );
		}

		/**
		 * Show the settings.
		 *
		 * @access public
		 * @param void
		 * @return void
		 */
		public function settings() {
			?>
				<p>These settings control the permalinks used for sitewide gallery section in rtMedia. These settings only apply when <strong>not using "default" permalinks above.</strong></p>
				<p>You are seeing this settings because you have enabled <strong>Sitewide Gallery Section</strong> in <a href="<?php echo admin_url ( "admin.php?page=rtmedia-settings#rtmedia-wordpress" ) ?>" target="_blank">rtMedia admin settings</a>.</p>
			<?php

			global $rtmedia;
			$options = $rtmedia->options;
			$album_permalink = $options['rtmedia_wp_album_slug'];

			// Set Base slug
			$album_base 	= _x( 'album', 'default-slug', 'rtmedia' );
			$gallery_base 	= _x( 'gallery', 'default-slug', 'rtmedia' );
			$media_base 	= _x( 'media', 'default-slug', 'rtmedia' );

			$base_slug_array = array(
				array(
					'title' => __( 'Album', 'rtmedia' ),
					'slug' =>  $album_base,
					'value' => '/' . trailingslashit( $album_base ),
				),
				array(
					'title' => __( 'Gallery', 'rtmedia' ),
					'slug' => $gallery_base,
					'value' => '/' . trailingslashit( $gallery_base ),
				),
				array(
					'title' => __( 'Media', 'rtmedia' ),
					'slug' => $media_base,
					'value' => '/' . trailingslashit( $media_base ),
				),
			);
			$match = false;
			?>
			<table class="form-table">
				<tbody>
				<?php
					foreach( $base_slug_array as $slug_option ){
						if( $slug_option['slug'] == $album_permalink ){
							$match = true;
						}
				?>
						<tr>
							<th><label><input name="rtmedia_wp_album_permalink" type="radio" value="<?php echo $slug_option['value']; ?>" class="rtm-permalink-radio" <?php checked( $slug_option['slug'], $album_permalink ) ?> /> <?php echo $slug_option['title']; ?></label></th>
							<td><code><?php echo home_url() . $slug_option['value']; ?>sample-album/</code></td>
						</tr>
				<?php
					}
				?>
					<tr>
						<th><label><input name="rtmedia_wp_album_permalink" id="rtmedia_custom_selection" type="radio" value="<?php echo '/' . $album_permalink . '/' ?>" class="rtm-permalink-radio" <?php checked( $match, false ) ?> />
							<?php _e( 'Custom', 'rtmedia' ); ?></label></th>
						<td>
							<input name="rtmedia_wp_album_slug" id="rtmedia_wp_album_slug" type="text" value="<?php echo '/' . trailingslashit( esc_attr( $album_permalink ) ); ?>" class="regular-text code">
							<span class="description"><?php _e( 'Enter a custom base to use. A base <strong>must</strong> be set or WordPress will use default instead.', 'rtmedia' ); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
			<script type="text/javascript">
				jQuery(function(){
					jQuery('input.rtm-permalink-radio').change(function() {
						jQuery('#rtmedia_wp_album_slug').val( jQuery(this).val() );
					});

					jQuery('#rtmedia_wp_album_slug').focus(function(){
						jQuery('#rtmedia_custom_selection').click();
					});
				});
			</script>
			<?php
		}

		/**
		 * Save the settings.
		 *
		 * @access public
		 * @param void
		 * @return void
		 */
		public function settings_save() {
			if ( ! is_admin() ){
				return;
			}

			// We need to save the options ourselves; settings api does not trigger save for the permalinks page
			if ( isset( $_POST['permalink_structure'] )  && isset( $_POST['rtmedia_wp_album_permalink'] ) ){

				global $rtmedia;
				$options = $rtmedia->options;

				// sanitize slug
				$album_permalink = str_replace( '/', '', sanitize_text_field( $_POST['rtmedia_wp_album_slug'] ) );

				if( empty( $album_permalink ) ){
					$album_permalink = 'rtmedia-album';
				}

				$options['rtmedia_wp_album_slug'] = $album_permalink;

				rtmedia_update_site_option( 'rtmedia-options', $options );
			}
		}
	}

}