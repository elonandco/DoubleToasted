<?php

/*
  Plugin Name: rtMedia Pro
  Plugin URI: https://rtcamp.com/rtmedia/addons/pro/
  Description: This plugin adds new features in rtMedia
  Version: 2.5.21
  Author: rtCamp
  Text Domain: rtmedia
  Author URI: http://rtcamp.com/?utm_source=dashboard&utm_medium=plugin&utm_campaign=buddypress-media
 */

if ( ! defined( 'RTMEDIA_PRO_PATH' ) ){

	/**
	 *  The server file system path to the plugin directory
	 *
	 */
	define ( 'RTMEDIA_PRO_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'RTMEDIA_PRO_URL' ) ){

	/**
	 * The url to the plugin directory
	 *
	 */
	define ( 'RTMEDIA_PRO_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'RTMEDIA_PRO_BASE_NAME' ) ){

	/**
	 * The url to the plugin directory
	 *
	 */
	define ( 'RTMEDIA_PRO_BASE_NAME', plugin_basename( __FILE__ ) );
}
if ( ! defined ( 'RTMEDIA_PRO_VERSION' ) ) {
	define ( 'RTMEDIA_PRO_VERSION', '2.5.21' );
}

if ( ! defined ( 'EDD_RTMEDIA_PRO_STORE_URL' ) ) {
	// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
	define( 'EDD_RTMEDIA_PRO_STORE_URL', 'https://rtcamp.com/' );
}

if ( ! defined ( 'EDD_RTMEDIA_PRO_ITEM_NAME' ) ) {
	// the name of your product. This should match the download name in EDD exactly
	define( 'EDD_RTMEDIA_PRO_ITEM_NAME', 'rtMedia PRO' );
}

// define RTMEDIA_DEBUG to true in wp-config.php to debug updates
if( defined( 'RTMEDIA_DEBUG' ) && RTMEDIA_DEBUG === true ){
    set_site_transient( 'update_plugins', null );
}


/**
 * Auto Loader Function
 *
 * Autoloads classes on instantiation. Used by spl_autoload_register.
 *
 * @param string $class_name The name of the class to autoload
 */
function rtmedia_pro_autoloader( $class_name ) {
	$rtlibpath = array(
		'app/admin/' . $class_name . '.php',
		'app/main/controllers/shortcodes/' . $class_name . '.php',
		'app/main/controllers/media/' . $class_name . '.php',
		'app/main/widgets/' . $class_name . '.php',
		'app/importers/' . $class_name . '.php',
		'app/helper/' . $class_name . '.php',
	);
	foreach ( $rtlibpath as $path ) {
		$path = RTMEDIA_PRO_PATH . $path;
		if ( file_exists( $path ) ){
			include $path;
			break;
		}
	}
}

/**
 * rtmedia_pro_loader Function.
 *
 * @param  array $class_construct
 * @return array $class_construct
 */
function rtmedia_pro_loader( $class_construct ) {
	require_once RTMEDIA_PRO_PATH . 'app/RTMediaPro.php';
	$class_construct[ 'pro' ]                    = false;
	$class_construct[ 'ProRate' ]                = false;
	$class_construct[ 'ProGlobalAlbums' ]        = false;
	$class_construct[ 'ProCoverArt' ]            = false;
	$class_construct[ 'ProProfilePicture' ]      = false;
	$class_construct[ 'ProModeration' ]          = false;
	$class_construct[ 'ProBlockUsers' ]          = false;
	$class_construct[ 'ProDownload' ]            = false;
	$class_construct[ 'ProPlaylist' ]            = false;
	$class_construct[ 'ProPlaylistInteraction' ] = false;
	$class_construct[ 'ProPoints' ]              = false;
	$class_construct[ 'ProDocSupport' ]          = false;
	$class_construct[ 'ProOtherTypeSupport' ]    = false;
	$class_construct[ 'ProBBPress' ]             = false;
	$class_construct[ 'ProbbPressImporter' ]     = false;
	$class_construct[ 'ProCommentForm' ]         = false;
	$class_construct[ 'ProFeed' ]                = false;
	$class_construct[ 'AlbumList' ]              = false;
	$class_construct[ 'ProUserLikes' ]           = false;
	$class_construct[ 'ProUploadLimit' ]         = false;
	$class_construct[ 'AttributesModel' ]        = false;
	$class_construct[ 'ProAttributes' ]          = false;
	$class_construct[ 'ProSort' ]                = false;
	$class_construct[ 'ProShortcodeSorting' ]    = false;
	$class_construct[ 'ProUploadTerms' ]         = false;
	$class_construct[ 'ProUploadUrl' ]           = false;
	$class_construct[ 'ProMediaShare' ]          = false;
	$class_construct[ 'ProFavList' ]             = false;
	$class_construct[ 'ProFavListInteraction' ]  = false;
	$class_construct[ 'ProPermalinkSettings' ]   = false;
	return $class_construct;
}

/**
 * Register the autoloader function into spl_autoload
 */
spl_autoload_register( 'rtmedia_pro_autoloader' );
add_filter( 'rtmedia_class_construct', 'rtmedia_pro_loader' );


include_once( RTMEDIA_PRO_PATH . 'lib/edd-license/RTMediaProEDDLicense.php' );
new RTMediaProEDDLicense();
/**
 * Install/activate rtMedia plugins *
 */

if( !defined( 'RTMEDIA_PATH' ) ) {
	function rtmedia_plugins_enque_js() {
		wp_enqueue_script( 'rtmedia-plugins', RTMEDIA_PRO_URL . "app/assets/js/rtMedia_plugin_check.js", '', false, true );
		wp_localize_script( 'rtmedia-plugins', 'rtmedia_ajax_url', admin_url( 'admin-ajax.php' ) );
        wp_localize_script( 'rtmedia-plugins', 'rtmedia_pro_ajax_loader', admin_url( '/images/spinner.gif' ) );
	}

	add_action( 'admin_enqueue_scripts', 'rtmedia_plugins_enque_js' );
	add_action( 'admin_notices', 'admin_notice_rtmedia_not_installed' );
    add_action( 'admin_init', 'rtmedia_pro_set_rtmedia_activation_variables' );
	add_action( 'wp_ajax_rtmedia_pro_install_plugin', 'rtmedia_pro_install_plugin_ajax', 10 );
	add_action( 'wp_ajax_rtmedia_pro_activate_plugin', 'rtmedia_pro_activate_plugin_ajax', 10 );
	rtmedia_pro_plugin_upgrader_class();
}

function rtmedia_pro_set_rtmedia_activation_variables() {
	/**
	 * Automatic install/activate rtMedia
	 */
	global $rtmedia_plugins;
	$rtmedia_plugins = array(
		'buddypress-media' => array(
			'project_type' => 'all', 'name' => esc_html__( 'rtMedia for WordPress, BuddyPress and bbPress', 'rtmedia' ), 'active' => is_plugin_active( 'rtMedia/index.php' ), 'filename' => 'index.php',
		), 'rtMedia'       => array(
			'project_type' => 'all', 'name' => esc_html__( 'rtMedia for WordPress, BuddyPress and bbPress', 'rtmedia' ), 'active' => is_plugin_active( 'rtMedia/index.php' ), 'filename' => 'index.php',
		)
	);
}

function rtmedia_pro_plugin_upgrader_class() {

	require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );

	if ( ! class_exists( 'RTMedia_Plugin_Upgrader_Skin' ) ){
		class RTMedia_Plugin_Upgrader_Skin extends WP_Upgrader_Skin {
			function __construct( $args = array() ) {
				$defaults = array( 'type' => 'web', 'url' => '', 'plugin' => '', 'nonce' => '', 'title' => '' );
				$args     = wp_parse_args( $args, $defaults );

				$this->type = $args[ 'type' ];
				$this->api  = isset( $args[ 'api' ] ) ? $args[ 'api' ] : array();

				parent::__construct( $args );
			}

			public function request_filesystem_credentials( $error = false, $context = false, $allow_relaxed_file_ownership = false ) {
				return true;
			}

			public function error( $errors ) {
				die( '-1' );
			}

			public function header() { }

			public function footer() { }

			public function feedback( $string ) { }
		}
	}
}

function admin_notice_rtmedia_not_installed() {
    if( current_user_can( "list_users" ) ) {
        global $rtmedia_not_installed_or_activated_admin_notice;
        
        $rtmedia_pro_not_installed_msg_set = false;
        
        // Admin notice if rtMedia is not installed / activated
        if( !isset( $rtmedia_not_installed_or_activated_admin_notice ) && is_null( $rtmedia_not_installed_or_activated_admin_notice ) ) {
            $rtmedia_not_installed_or_activated_admin_notice = "<b>" . __( "rtMedia Add-on(s)", "rtmedia" ) . "</b> " . __( "will not work if you will not", "rtmedia" ) . " ";
            $rtmedia_pro_not_installed_msg_set = true;
        }
        
        if( !is_rtmedia_plugin_installed( 'buddypress-media' ) && !is_rtmedia_plugin_installed( 'rtMedia' ) ) {
            $nonce = wp_create_nonce( 'rtmedia_pro_install_plugin_buddypress-media' );
            
            if( $rtmedia_pro_not_installed_msg_set ) {
                $rtmedia_not_installed_or_activated_admin_notice .= __( "install rtMedia. Click", "rtmedia" ) . " ";
                $rtmedia_not_installed_or_activated_admin_notice .= '<a href="#" onclick="install_rtmedia_plugins( \'buddypress-media\', \'rtmedia_pro_install_plugin\', \'' . $nonce . '\' );">' . __( "here", "rtmedia" ) . '</a> ';
                $rtmedia_not_installed_or_activated_admin_notice .= __( 'to install rtMedia.', 'rtmedia' );
            }
        } else {
            if( is_rtmedia_plugin_installed( 'buddypress-media' ) && !is_rtmedia_plugin_active( 'buddypress-media' ) ) {
                $path = get_path_for_rtmedia_plugins( 'buddypress-media' );
                $nonce = wp_create_nonce( 'rtmedia_pro_activate_plugin_' . $path );
                
                if( $rtmedia_pro_not_installed_msg_set ) {
                    $rtmedia_not_installed_or_activated_admin_notice .= __( "activate buddypress-media. Click", "rtmedia" ) . " ";
                    $rtmedia_not_installed_or_activated_admin_notice .= '<a href="#" onclick="activate_rtmedia_plugins( \'' . $path . '\', \'rtmedia_pro_activate_plugin\', \'' . $nonce . '\' );">' . __( "here", "rtmedia" ) . '</a> ';
                    $rtmedia_not_installed_or_activated_admin_notice .= __( 'to activate rtMedia.', 'rtmedia' );
                }
            }
            
            if( is_rtmedia_plugin_installed( 'rtMedia' ) && !is_rtmedia_plugin_active( 'rtMedia' ) ) {
                $path = get_path_for_rtmedia_plugins( 'rtMedia' );
                $nonce = wp_create_nonce( 'rtmedia_pro_activate_plugin_' . $path );
                
                if( $rtmedia_pro_not_installed_msg_set ) {
                    $rtmedia_not_installed_or_activated_admin_notice .= __( "activate rtMedia. Click", "rtmedia" ) . " ";
                    $rtmedia_not_installed_or_activated_admin_notice .= '<a href="#" onclick="activate_rtmedia_plugins( \'' . $path . '\', \'rtmedia_pro_activate_plugin\', \'' . $nonce . '\' );">' . __( "here", "rtmedia" ) . '</a> ';
                    $rtmedia_not_installed_or_activated_admin_notice .= __( 'to activate rtMedia.', 'rtmedia' );
                }
            }
        }
        
        if( $rtmedia_pro_not_installed_msg_set ) {
            ?>
            <div class="error rtmedia-not-installed-error">
                <p>
                    <?php echo $rtmedia_not_installed_or_activated_admin_notice; ?>
                </p>
            </div>
            <?php
        }
    }
}

function get_path_for_rtmedia_plugins( $slug ) {
	global $rtmedia_plugins;
	$filename = ( ! empty( $rtmedia_plugins[ $slug ][ 'filename' ] ) ) ? $rtmedia_plugins[ $slug ][ 'filename' ] : $slug . '.php';

	return $slug . '/' . $filename;
}

function is_rtmedia_plugin_active( $slug ) {
	global $rtmedia_plugins;
	if ( empty( $rtmedia_plugins[ $slug ] ) ){
		return false;
	}

	return $rtmedia_plugins[ $slug ][ 'active' ];
}

function is_rtmedia_plugin_installed( $slug ) {
	global $rtmedia_plugins;
	if ( empty( $rtmedia_plugins[ $slug ] ) ){
		return false;
	}

	if ( is_rtmedia_plugin_active( $slug ) || file_exists( WP_PLUGIN_DIR . '/' . get_path_for_rtmedia_plugins( $slug ) ) ){
		return true;
	}

	return false;
}

function rtmedia_pro_install_plugin_ajax() {
	if ( empty( $_POST[ 'plugin_slug' ] ) ){
		die( __( 'ERROR: No slug was passed to the AJAX callback.', 'rtmedia' ) );
	}

	check_ajax_referer( 'rtmedia_pro_install_plugin_' . $_POST[ 'plugin_slug' ] );

	if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ){
		die( __( 'ERROR: You lack permissions to install and/or activate plugins.', 'rtmedia' ) );
	}

	rtmedia_pro_install_plugin(  $_POST[ 'plugin_slug' ]);

	echo "true";
	die();
}

function rtmedia_pro_install_plugin( $plugin_slug ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	$api = plugins_api( 'plugin_information', array( 'slug' => $plugin_slug, 'fields' => array( 'sections' => false ) ) );

	if ( is_wp_error( $api ) ){
		die( sprintf( __( 'ERROR: Error fetching plugin information: %s', 'rtmedia' ), $api->get_error_message() ) );
	}

	$upgrader = new Plugin_Upgrader( new RTMedia_Plugin_Upgrader_Skin( array(
		'nonce' => 'install-plugin_' . $plugin_slug, 'plugin' => $plugin_slug, 'api' => $api,
	) ) );

	$install_result = $upgrader->install( $api->download_link );

	if ( ! $install_result || is_wp_error( $install_result ) ){
		// $install_result can be false if the file system isn't writeable.
		$error_message = __( 'Please ensure the file system is writeable', 'rtmedia' );

		if ( is_wp_error( $install_result ) ){
			$error_message = $install_result->get_error_message();
		}

		die( sprintf( __( 'ERROR: Failed to install plugin: %s', 'rtmedia' ), $error_message ) );
	}

	$activate_result = activate_plugin( get_path_for_rtmedia_plugins( $plugin_slug ) );

	if ( is_wp_error( $activate_result ) ){
		die( sprintf( __( 'ERROR: Failed to activate plugin: %s', 'a8c-developer' ), $activate_result->get_error_message() ) );
	}
}

function rtmedia_pro_activate_plugin_ajax() {
	if ( empty( $_POST[ 'path' ] ) ){
		die( __( 'ERROR: No slug was passed to the AJAX callback.', 'rtmedia' ) );
	}
	check_ajax_referer( 'rtmedia_pro_activate_plugin_' . $_POST[ 'path' ] );

	if ( ! current_user_can( 'activate_plugins' ) ){
		die( __( 'ERROR: You lack permissions to activate plugins.', 'rtmedia' ) );
	}

	rtmedia_pro_activate_plugin( $_POST[ 'path' ] );

	echo "true";
	die();
}

function rtmedia_pro_activate_plugin( $plugin_path ) {

	$activate_result = activate_plugin( $plugin_path );

	if ( is_wp_error( $activate_result ) ){
		die( sprintf( __( 'ERROR: Failed to activate plugin: %s', 'rtmedia' ), $activate_result->get_error_message() ) );
	}
}
