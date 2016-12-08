<?php

/**
 * Author: ritz <ritesh.patel@rtcamp.com>
 * Date: 10/4/14
 * Time: 1:59 PM
 */
class RTMediaProUploadUrl {

	function __construct() {
		//TODO add support for comma separated urls
		global $rtm_url_media_upload;
		$rtm_url_media_upload = false;

		if( $this->is_url_upload_enable() ) {
			add_filter( 'rtmedia_media_param_before_upload', array( $this, 'modify_upload_param_before_upload' ), 10, 1 ); // this is nothing but to set $_FILES['rtmedia_file']
			add_action( 'rtmedia_after_add_media', array( $this, 'set_media_meta_after_upload' ), 10, 3 );
			add_filter( 'rtmedia_uploader_tabs', array( $this, 'add_url_upload_tab' ), 49, 1 );
		}

		add_filter( 'rtmedia_general_content_groups', array( $this, 'admin_setting_add_url_upload_section' ), 10, 1 );
		add_filter( 'rtmedia_general_content_add_itmes', array( $this, 'admin_setting_add_url_upload_option' ), 10, 2 );
	}

	function add_url_upload_tab( $tabs ){
		$tabs['url_import'] = array(
			'title' => __( 'Url Import', 'rtmedia' ),
			'class' => array( 'rtm-url-import-tab' ),
			'content' => '<div class="rtm-upload-url" data-id="rtm-url-import-tab">'
						. apply_filters( 'rtm_before_url_upload_input', '' )
						.'<textarea name="rtmedia_url_upload_input" id="rtmedia_url_upload_input"></textarea><i class="rtm-url-upload-info rtmicon-info-circle rtmicon-fw" title="' . __( "Copy media URL to upload.", "rtmedia" ) . '"></i>'
						. apply_filters( 'rtm_after_url_upload_input', '' )
						.'</div>',
		);
		return $tabs;
	}

	function is_url_upload_enable() {
		global $rtmedia;
		$option = $rtmedia->options;
		if ( isset( $option[ 'general_enable_url_upload' ] ) && $option[ 'general_enable_url_upload' ] == '1' ){
			return true;
		}
		return false;
	}

	function admin_setting_add_url_upload_section( $general_group ) {
		$general_group[ 50 ] = "URL Upload";

		return $general_group;
	}

	function admin_setting_add_url_upload_option( $render_options, $options ) {
		$render_options[ 'general_enable_url_upload' ] = array(
			'title'    => __( 'Allow user to upload media via URL', 'rtmedia' ), 'callback' => array( 'RTMediaFormHandler', 'checkbox' ), 'args' => array(
				'key' => 'general_enable_url_upload', 'value' => $options[ 'general_enable_url_upload' ], 'desc' => __( 'User\'s don\'t have to download media first and then upload it. They can directly give URL to the media and rtMedia will handle it.', 'rtmedia' )
			), 'group' => 50
		);

		return $render_options;
	}

	function modify_upload_param_before_upload( $upload_params ) {
		if ( isset( $upload_params[ 'mode' ] ) && $upload_params[ 'mode' ] == 'url_upload' ){
			global $rtm_url_media_upload, $rtmedia;
			$options              = $rtmedia->options;
			$allowed_types        = $rtmedia->allowed_types;
			$rtm_url_media_upload = true;
			$image_src            = $upload_params[ 'url' ];
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			$file_temp_name           = download_url( $image_src );
			$file                     = array(
				'name' => basename( $image_src ), 'tmp_name' => $file_temp_name,
			);
			$upload_params[ 'mode' ]  = 'file_upload';
			$upload_params[ 'files' ] = $file;
			$file_size                = filesize( $file_temp_name ) / ( 1024 * 1024 );
			$file_type                = wp_check_filetype( basename( $image_src ) );
			if ( isset( $file_type[ 'ext' ] ) ){
				$media_type = rtmedia_get_media_type_from_extn( $file_type[ 'ext' ] );
				if ( isset( $options[ 'allowedTypes_' . $media_type . '_upload_limit' ] ) && $options[ 'allowedTypes_' . $media_type . '_upload_limit' ] != '0' && ( $options[ 'allowedTypes_' . $media_type . '_upload_limit' ] < $file_size ) ){
					unset( $upload_params[ 'files' ] );
				}
			}
		}

		return $upload_params;
	}

	function set_media_meta_after_upload( $media_ids, $file_object, $uploaded ) {
		global $rtm_url_media_upload;
		if ( isset( $rtm_url_media_upload ) && $rtm_url_media_upload ){
			if ( function_exists( 'parse_url' ) ){
				$url_info = parse_url( $uploaded[ 'url' ] );
				if ( isset( $url_info[ 'host' ] ) ){
					$rtmedia_model = new RTMediaModel();
					$rtmedia_model->update( array( 'source' => $url_info[ 'host' ] ), array( 'id' => $media_ids[ 0 ] ) );
				}
			}
			$rtmedia_meta_model = new RTMediaMeta();
			$rtmedia_meta_model->add_meta( $media_ids[ 0 ], 'url_uploaded_from', $uploaded[ 'url' ] );
		}
	}
} 