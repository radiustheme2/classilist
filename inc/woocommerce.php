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

class RT_WooCommerce {

    protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme',   array( $this, 'woocommerce_support' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_wc_scripts' ), 12 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_wc_scripts' ), 12 );
        add_action( 'widgets_init',        array( $this, 'register_sidebars' ) );
        add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'wcc_change_breadcrumb_delimiter' ] );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function woocommerce_support() {
		// Theme supports
        add_theme_support('woocommerce');
        add_theme_support( 'wc-product-gallery-slider' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
	}

	public function register_wc_scripts() {
        wp_register_style('classilist-woocommerce',  URI_Helper::get_maybe_rtl_css( 'woocommerce' ) );
    }

    public function enqueue_wc_scripts() {
        wp_enqueue_style('classilist-woocommerce' );
    }

	public function register_sidebars() {
		
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar - WooCommerce', 'classilist' ),
			'id'            => 'sidebar-woocommerce',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

	}

    public function wcc_change_breadcrumb_delimiter( $defaults ) {
        $defaults['delimiter'] = '<span class="breadcrumb-seperator">-</span>';
        return $defaults;
    }

}

RT_WooCommerce::instance();