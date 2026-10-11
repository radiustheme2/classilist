<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.7
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;
use Rtcl\Helpers\Link;

class Scripts {

	public $prefix;
	public $version;
	protected static $instance = null;

	/**
	 * Main construction function
	 */
	public function __construct() {
		$this->prefix  = Constants::$theme_prefix;
		$this->version = Constants::$theme_version;

		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 12 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 15 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_high_priority_scripts' ], 1500 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ], 15 );
	}

	/**
	 * @return self|null
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return void
	 */
	public function register_scripts() {
		/* Deregister */
		wp_deregister_style( 'font-awesome' );

		/*
		CSS*/
		// Google fonts.
		wp_register_style( $this->prefix . '-gfonts', $this->fonts_url(), [], $this->version );
		// Font-awesome.
		wp_register_style( 'font-awesome', URI_Helper::get_css( 'all.min' ), [], $this->version );
		// Bootstrap.
		wp_register_style( 'bootstrap', URI_Helper::get_maybe_rtl_css( 'bootstrap.min' ), [], $this->version );
		// Meanmenu.
		wp_register_style( $this->prefix . '-meanmenu', URI_Helper::get_maybe_rtl_css( 'meanmenu' ), [], $this->version );
		// Main Theme Style.
		wp_register_style( $this->prefix . '-style', URI_Helper::get_maybe_rtl_css( 'style' ), [], $this->version );
		// Listing.
		wp_register_style( $this->prefix . '-listing', URI_Helper::get_maybe_rtl_css( 'listing' ), [], $this->version );
		// Elementor.
		wp_register_style( $this->prefix . '-elementor', URI_Helper::get_maybe_rtl_css( 'elementor' ), [], $this->version );
		// RTL.
		wp_register_style( $this->prefix . '-rtl', URI_Helper::get_css( 'rtl' ), [], $this->version );

		/*
		JS*/
		// bootstrap js.
		wp_register_script( 'bootstrap', URI_Helper::get_js( 'bootstrap.bundle.min' ), [ 'jquery' ], $this->version, true );
		// Meanmenu js.
		wp_register_script( 'jquery-meanmenu', URI_Helper::get_js( 'jquery.meanmenu.min' ), [ 'jquery' ], $this->version, true );
		// Sticky Menu.
		wp_register_script( 'jquery-sticky', URI_Helper::get_js( 'jquery.sticky.min' ), [ 'jquery' ], $this->version, true );
		// Main js.
		wp_register_script( $this->prefix . '-main', URI_Helper::get_js( 'main' ), [ 'jquery' ], $this->version, true );
		// Sticky Sidebar.
		wp_register_script( 'sticky-sidebar', URI_Helper::get_js( 'sticky-sidebar.min' ), [ 'jquery' ], $this->version, true );
		// Counter.
		wp_register_script( 'waypoints', URI_Helper::get_js( 'waypoints.min' ), [ 'jquery' ], $this->version, true );
		wp_register_script( 'counterup', URI_Helper::get_js( 'jquery.counterup.min' ), [ 'jquery' ], $this->version, true );
		// Isotope.
		wp_register_script( 'images-loaded', URI_Helper::get_js( 'imagesloaded.pkgd.min' ), [ 'jquery' ], $this->version, true );
		wp_register_script( 'isotope', URI_Helper::get_js( 'isotope.pkgd.min' ), [ 'jquery' ], $this->version, true );
	}

	/**
	 * @return void
	 */
	public function enqueue_scripts() {
		/*CSS*/
		wp_enqueue_style( $this->prefix . '-gfonts' );
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( $this->prefix . '-meanmenu' );
		$this->elementor_scripts(); // Elementor Scripts in preview mode.
		$this->conditional_scripts(); // Conditional Scripts.
		wp_enqueue_style( $this->prefix . '-style' );
		wp_enqueue_style( $this->prefix . '-listing' );
		wp_enqueue_style( $this->prefix . '-elementor' );
		$this->dynamic_style();// Dynamic style.

		/*JS*/
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'jquery-meanmenu' );

		wp_enqueue_script( $this->prefix . '-main' );
		$this->localized_scripts(); // Localization.
	}

	/**
	 * @return void
	 */
	public function enqueue_high_priority_scripts() {
		if ( is_rtl() ) {
			wp_enqueue_style( $this->prefix . '-rtl' );
		}
	}

	/**
	 * @return void
	 */
	private function localized_scripts() {
		$logo = empty( RDTheme::$options['logo_dark']['url'] ) ? URI_Helper::get_img( 'logo-dark.png' ) : RDTheme::$options['logo_dark']['url'];

		$login_text = is_user_logged_in() ? RDTheme::$options['header_icon_text_logged'] : RDTheme::$options['header_icon_text_guest'];

		$appendHtml = '';
		$icon       = '';

		if ( RDTheme::$options['header_chat_icon'] && class_exists( 'Rtcl' ) ) {
			$icon .= RDTheme::$options['header_chat_icon'] ? '<a class="header-chat-icon rtcl-chat-unread-count" href="' . esc_url( Link::get_my_account_page_link( 'chat' ) ) . '"><i class="far fa-comments"></i></a>' : '';
		}

		if ( RDTheme::$options['header_icon'] && class_exists( 'Rtcl' ) ) {
			$icon .= RDTheme::$options['header_icon'] ? '<a class="header-login-icon" href="' . esc_url( Link::get_my_account_page_link() ) . '"><i class="fa-regular fa-user"></i></a>' : '';
		}

		$btn = ( RDTheme::$options['header_btn_txt'] && RDTheme::$options['header_btn_url'] ) ? '<a class="header-menu-btn" href="' . esc_url( RDTheme::$options['header_btn_url'] ) . '">' . esc_html( RDTheme::$options['header_btn_txt'] ) . '</a>' : '';

		if ( $icon || $btn ) {
			$appendHtml = '<div class="header-mobile-icons">' . $icon . $btn . '</div>';
		}

		$localize_data = [
			'hasAdminBar'   => is_admin_bar_showing() ? 1 : 0,
			'hasStickyMenu' => RDTheme::$options['sticky_menu'] ? 1 : 0,
			'headerStyle'   => RDTheme::$header_style,
			'meanWidth'     => RDTheme::$options['resmenu_width'],
			'primaryColor'  => RDTheme::$options['primary_color'],
			'siteLogo'      => '<a class="mean-logo-area" href="' . esc_url( home_url( '/' ) ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '"><img class="logo-small" src="' . esc_url( $logo ) . '" /></a>' . $appendHtml,
			'appendHtml'    => '',
			'rtl'           => is_rtl() ? 'yes' : 'no',
			'sold_out_text' => esc_html__( 'Sold Out', 'classilist' ),
		];

		$localize_data = apply_filters( 'classilist_localized_data', $localize_data );

		wp_localize_script( $this->prefix . '-main', 'ClassiListObj', $localize_data );
	}

	/**
	 * @return void
	 */
	private function conditional_scripts() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( RDTheme::$options['sticky_menu'] ) {
			wp_enqueue_script( 'jquery-sticky' );
		}

		if ( ( is_home() || is_archive() ) && 'style2' == RDTheme::$options['blog_style'] ) {
			wp_enqueue_script( 'images-loaded' );
			wp_enqueue_script( 'isotope' );
		}
	}

	/**
	 * @return void
	 */
	public function elementor_scripts() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		if ( Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_script( 'jquery-sticky' );
			wp_enqueue_script( 'waypoints' );
			wp_enqueue_script( 'counterup' );
			wp_enqueue_script( 'images-loaded' );
			wp_enqueue_script( 'isotope' );
		}
	}

	/**
	 * @return string
	 */
	public function fonts_url() {
		$fonts_url = '';
		if ( 'off' !== _x( 'on', 'Google fonts - Open Sans and Poppins : on or off', 'classilist' ) ) {
			$fonts_url = add_query_arg( 'family', rawurlencode( 'Roboto:400,500,700|Poppins:300,400,500,600&subset=latin,latin-ext' ), '//fonts.googleapis.com/css' );
		}
		return $fonts_url;
	}

	/**
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_style( $this->prefix . '-admin', URI_Helper::get_css( 'admin' ), [], $this->version );
	}

	/**
	 * @return void
	 */
	private function dynamic_style() {
		$dynamic_css = '';
		ob_start();
		URI_Helper::requires( 'dynamic-style.php' );
		URI_Helper::requires( 'dynamic-style-listing.php' );
		URI_Helper::requires( 'dynamic-style-elementor.php' );
		$dynamic_css .= ob_get_clean();
		$dynamic_css  = $this->minified_css( $dynamic_css );
		wp_register_style( $this->prefix . '-dynamic', false, [], $this->version );
		wp_enqueue_style( $this->prefix . '-dynamic' );
		wp_add_inline_style( $this->prefix . '-dynamic', $dynamic_css );
	}

	/**
	 * @param $css
	 *
	 * @return array|string|string[]
	 */
	private function minified_css( $css ) {
		/* remove comments */
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		/* remove tabs, spaces, newlines, etc. */
		$css = str_replace( [ "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ], ' ', $css );
		return $css;
	}
}

Scripts::instance();
