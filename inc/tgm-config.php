<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.3.0
 * @package ClassiList
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * TGM Configuration file
 */
class TGM_Config {

	/**
	 * @var string
	 */
	public $prefix;

	/**
	 * @var string
	 */
	public $path;

	/**
	 * Construction Function
	 */
	public function __construct() {
		$this->prefix = Constants::$theme_prefix;
		$this->path   = Constants::$theme_plugins_dir;

		add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );
	}

	/**
	 * @return void
	 */
	public function register_required_plugins() {
		$plugins = [
			// Repository.
			[
				'name'     => 'Classified Listing',
				'slug'     => 'classified-listing',
				'required' => true,
			],
			[
				'name'     => 'Classified Listing Toolkits',
				'slug'     => 'classified-listing-toolkits',
				'required' => true,
			],
			[
				'name'     => 'Redux Framework',
				'slug'     => 'redux-framework',
				'required' => true,
			],
			[
				'name'     => 'Review Schema',
				'slug'     => 'review-schema',
				'required' => false,
			],
			[
				'name'     => 'Elementor Page Builder',
				'slug'     => 'elementor',
				'required' => true,
			],
			[
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
			],
			[
				'name'     => 'Radius Booking',
				'slug'     => 'radius-booking',
				'required' => false,
			],
			[
				'name'     => 'Easy Demo Importer',
				'slug'     => 'easy-demo-importer',
				'required' => false,
			],

			// Bundled.
			[
				'name'     => 'ClassiList Core',
				'slug'     => 'classilist-core',
				'source'   => 'classilist-core.zip',
				'required' => true,
				'version'  => '2.0.2',
			],
			[
				'name'     => 'RT Framework',
				'slug'     => 'rt-framework',
				'source'   => 'rt-framework.zip',
				'required' => true,
				'version'  => '2.9.1',
			],
			[
				'name'     => 'Classified Listing Pro',
				'slug'     => 'classified-listing-pro',
				'source'   => 'classified-listing-pro.zip',
				'required' => true,
				'version'  => '4.3.0',
			],
			[
				'name'     => 'Classified Listing Store',
				'slug'     => 'classified-listing-store',
				'source'   => 'classified-listing-store.zip',
				'required' => false,
				'version'  => '3.2.3',
			],
			[
				'name'     => 'Review Schema Pro',
				'slug'     => 'review-schema-pro',
				'source'   => 'review-schema-pro.zip',
				'required' => false,
				'version'  => '2.1.2',
			],
		];

		$config = [
			'id'           => $this->prefix,            // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => $this->path,              // Default absolute path to bundled plugins.
			'menu'         => $this->prefix . '-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                    // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		];

		tgmpa( $plugins, $config );
	}
}

new TGM_Config();
