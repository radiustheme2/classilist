<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_editor_style( 'style-editor.css' );

if ( ! isset( $content_width ) ) {
	$content_width = 1240;
}

/**
 * Classilist Core plugin main class
 */
class ClassiList_Main {

	/**
	 * @var string
	 */
	public $theme = 'classilist';

	/**
	 * @var string
	 */
	public $action = 'classilist_theme_init';

	/**
	 * Construction Function
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'load_textdomain' ], 20 );
		add_action( 'after_setup_theme', [ $this, 'includes' ], 5 );
		add_action( 'admin_notices', [ $this, 'plugin_update_notices' ] );
	}

	/**
	 * @return void
	 */
	public function load_textdomain() {
		load_theme_textdomain( $this->theme, get_template_directory() . '/languages' );
	}

	/**
	 * @return void
	 */
	public function includes() {
		do_action( $this->action );
		require_once get_template_directory() . '/inc/constants.php';
		require_once get_template_directory() . '/inc/uri-helper.php';
		require_once get_template_directory() . '/inc/includes.php';
	}

	/**
	 * @return void
	 */
	public function plugin_update_notices() {
		$plugins = [];

		if ( defined( 'CLASSILIST_CORE' ) ) {
			if ( version_compare( CLASSILIST_CORE, '2.0.0', '<' ) ) {
				$plugins[] = 'ClassiList Core';
			}
		}

		if ( defined( 'RTCL_VERSION' ) ) {
			if ( version_compare( RTCL_VERSION, '4.2.2', '<' ) ) {
				$plugins[] = 'Classified Listing Pro';
			}
		}

		if ( defined( 'RTCL_STORE_VERSION' ) ) {
			if ( version_compare( RTCL_STORE_VERSION, '3.2.0', '<' ) ) {
				$plugins[] = 'Classified Listing Store';
			}
		}

		foreach ( $plugins as $plugin ) {
			$notice = '<div class="error"><p>' . sprintf( __( "Please update plugin <b><i>%1\$s</b></i> to the latest version otherwise some functionalities will not work properly. You can update it from <a href='%2\$s'>here</a>", 'classilist' ), $plugin, menu_page_url( 'classilist-install-plugins', false ) ) . '</p></div>';
			echo wp_kses_post( $notice );
		}
	}
}

new ClassiList_Main();
