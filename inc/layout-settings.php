<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;

class Layouts {

	protected static $instance = null;

	public $prefix;
	public $type;
	public $meta_value;

	public function __construct() {
		$this->prefix = Constants::$theme_prefix;

		add_action( 'template_redirect', [ $this, 'layout_settings' ] );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function layout_settings() {
		$is_listing = $is_listing_archive = $is_listing_account = false;

		if ( class_exists( 'Rtcl' ) ) {
			$is_listing_archive = Functions::is_listings() || Functions::is_listing_taxonomy();
			$is_listing_account = Functions::is_account_page();
		}

		if ( $is_listing_archive || $is_listing_account ) {
			$is_listing = true;
		}

		// Single Pages
		if ( ( is_single() || is_page() ) && ! $is_listing ) {
			$post_type        = get_post_type();
			$post_id          = get_the_id();
			$this->meta_value = get_post_meta( $post_id, "{$this->prefix}_layout_settings", true );

			switch ( $post_type ) {
				case 'page':
					$this->type = 'page';
					break;
				case 'post':
					$this->type = 'single_post';
					break;
				case 'rtcl_listing':
					$this->type = 'listing_single';
					break;
				default:
					$this->type = 'page';
					break;
			}

			RDTheme::$layout                    = $this->meta_layout_option( 'layout' );
			RDTheme::$sidebar                   = $this->meta_layout_option( 'sidebar' );
			RDTheme::$has_top_bar               = $this->meta_layout_global_option( 'top_bar', true );
			RDTheme::$header_style              = $this->meta_layout_global_option( 'header_style' );
			RDTheme::$has_header_search         = $this->meta_layout_global_option( 'header_search', true );
			RDTheme::$classilist_has_breadcrumb = $this->meta_layout_global_option( 'breadcrumb', true );
		}

		// Blog and Archive.
		elseif ( is_home() || is_archive() || is_search() || is_404() || $is_listing ) {

			if ( is_search() ) {
				$this->type = 'search';
			} elseif ( is_404() ) {
				$this->type                                  = 'error';
				RDTheme::$options[ $this->type . '_layout' ] = 'full-width';
			} elseif ( $is_listing_archive ) {
				$this->type = 'listing_archive';
			} elseif ( $is_listing_account ) {
				$this->type = 'listing_account';
			} else {
				$this->type = 'blog';
			}

			RDTheme::$layout                    = $this->layout_option( 'layout' );
			RDTheme::$sidebar                   = $this->layout_option( 'sidebar' );
			RDTheme::$has_top_bar               = $this->layout_global_option( 'top_bar', true );
			RDTheme::$header_style              = $this->layout_global_option( 'header_style' );
			RDTheme::$has_header_search         = $this->layout_global_option( 'header_search', true );
			RDTheme::$classilist_has_breadcrumb = $this->layout_global_option( 'breadcrumb', true );
		}
	}

	// Single
	private function meta_layout_global_option( $key, $is_bool = false ) {
		$layout_key = $this->type . '_' . $key;

		$meta      = ! empty( $this->meta_value[ $key ] ) ? $this->meta_value[ $key ] : 'default';
		$op_layout = RDTheme::$options[ $layout_key ] ? RDTheme::$options[ $layout_key ] : 'default';
		$op_global = RDTheme::$options[ $key ];

		if ( 'default' != $meta ) {
			$result = $meta;
		} elseif ( 'default' != $op_layout ) {
			$result = $op_layout;
		} else {
			$result = $op_global;
		}

		if ( $is_bool ) {
			$result = ( 1 == $result || 'on' == $result ) ? true : false;
		}

		return $result;
	}

	// Single
	private function meta_layout_option( $key ) {
		$layout_key = $this->type . '_' . $key;

		$meta      = ! empty( $this->meta_value[ $key ] ) ? $this->meta_value[ $key ] : 'default';
		$op_layout = RDTheme::$options[ $layout_key ];

		if ( 'default' != $meta ) {
			$result = $meta;
		} else {
			$result = $op_layout;
		}

		return $result;
	}

	// Archive
	private function layout_global_option( $key, $is_bool = false ) {
		$layout_key = $this->type . '_' . $key;

		$op_layout = RDTheme::$options[ $layout_key ] ? RDTheme::$options[ $layout_key ] : 'default';
		$op_global = RDTheme::$options[ $key ];

		if ( 'default' != $op_layout ) {
			$result = $op_layout;
		} else {
			$result = $op_global;
		}

		if ( $is_bool ) {
			$result = ( 1 == $result || 'on' == $result ) ? true : false;
		}

		return $result;
	}

	// Archive
	private function layout_option( $key ) {
		$layout_key = $this->type . '_' . $key;
		$op_layout  = RDTheme::$options[ $layout_key ];

		return $op_layout;
	}
}

Layouts::instance();
