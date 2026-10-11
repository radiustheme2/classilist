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

/**
 * Main Class
 */
class General_Setup {

	/**
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Constructor Class
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'theme_setup' ] );
		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		add_filter( 'body_class', [ $this, 'body_classes' ] );
		add_action( 'wp_head', [ $this, 'noscript_hide_preloader' ], 1 );
		add_action( 'wp_head', [ $this, 'pingback' ] );
		add_action( 'wp_body_open', [ $this, 'preloader' ] );
		add_action( 'wp_footer', [ $this, 'scroll_to_top_html' ], 1 );
		add_filter( 'comment_form_fields', [ $this, 'move_textarea_to_bottom' ] );
		add_filter( 'post_class', [ $this, 'hentry_config' ] );
		add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] );
		add_filter( 'excerpt_length', [ $this, 'excerpt_length' ] );

		// Elementor supports.
		add_filter( 'elementor/widgets/wordpress/widget_args', [ $this, 'elementor_widget_args' ] );
		add_action( 'elementor/theme/register_locations', [ $this, 'elementor_register_locations' ] );

		// Restrict Admin Area.
		add_action( 'after_setup_theme', [ $this, 'restrict_admin_area' ] );
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
	public function theme_setup() {

		// Theme supports.
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );
		add_editor_style();

		// Image sizes.
		$sizes = [
			'rdtheme-size1' => [ 1180, 590, true ], // When Full width
			'rdtheme-size2' => [ 390, 260, true ], // Blog style 2
			'rdtheme-size3' => [ 860, 430, true ], // When sidebar present
		];

		$sizes = apply_filters( 'classilist_image_size', $sizes );

		foreach ( $sizes as $size => $value ) {
			add_image_size( $size, $value[0], $value[1], $value[2] );
		}

		// Register menus.
		register_nav_menus(
			[
				'primary' => esc_html__( 'Primary', 'classilist' ),
			]
		);
	}

	/**
	 * @return void
	 */
	public function register_sidebars() {

		register_sidebar(
			[
				'name'          => esc_html__( 'Sidebar', 'classilist' ),
				'id'            => 'sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			]
		);

		$footer_widget_titles = [
			'1' => esc_html__( 'Footer 1', 'classilist' ),
			'2' => esc_html__( 'Footer 2', 'classilist' ),
			'3' => esc_html__( 'Footer 3', 'classilist' ),
			'4' => esc_html__( 'Footer 4', 'classilist' ),
		];

		foreach ( $footer_widget_titles as $id => $name ) {
			register_sidebar(
				[
					'name'          => $name,
					'id'            => 'footer-' . $id,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle">',
					'after_title'   => '</h3>',
				]
			);
		}
		register_sidebar(
			[
				'name'          => esc_html__( 'Sidebar - My Account', 'classilist' ),
				'id'            => 'sidebar-myaccount',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			]
		);
	}

	/**
	 * @param array $classes .
	 *
	 * @return mixed
	 */
	public function body_classes( $classes ) {
		// Header.
		$classes[] = 'non-stick';
		$classes[] = 'header-style-' . RDTheme::$header_style;

		if ( RDTheme::$has_top_bar ) {
			$classes[] = 'has-topbar';
		}

		if ( RDTheme::$has_header_search ) {
			$classes[] = 'header-search-enabled';
		}

		// Sidebar.
		if ( 'left-sidebar' == RDTheme::$layout ) {
			$classes[] = 'has-sidebar left-sidebar';
		} elseif ( 'right-sidebar' == RDTheme::$layout ) {
			$classes[] = 'has-sidebar right-sidebar';
		} else {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}

	public function preloader() {
		// Preloader.
		if ( RDTheme::$options['preloader'] ) {
			if ( ! empty( RDTheme::$options['preloader_image']['url'] ) ) {
				$preloader_img = RDTheme::$options['preloader_image']['url'];
			} else {
				$preloader_img = URI_Helper::get_img( 'preloader.gif' );
			}
			echo '<div id="preloader" style="background-image:url(' . esc_url( $preloader_img ) . ');"></div>';
		}
	}

	public function noscript_hide_preloader() {
		// Hide preloader if js is disabled.
		echo '<noscript><style>#preloader{display:none;}</style></noscript>';
	}

	public function pingback() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	public function scroll_to_top_html() {
		// Back-to-top link
		if ( RDTheme::$options['back_to_top'] ) {
			echo '<a href="#" class="scrollToTop"><i class="fa fa-angle-double-up"></i></a>';
		}
	}


	/**
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function move_textarea_to_bottom( $fields ) {
		$temp = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $temp;
		return $fields;
	}

	/**
	 * @param $classes
	 *
	 * @return array|mixed
	 */
	public function hentry_config( $classes ) {
		if ( is_search() || is_page() ) {
			$classes = array_diff( $classes, [ 'hentry' ] );
		}
		return $classes;
	}

	/**
	 * @return string
	 */
	public function excerpt_more() {
		if ( is_search() ) {
			$readmore = '<a href="' . get_the_permalink() . '"> [' . esc_html__( 'read more ...', 'classilist' ) . ']</a>';
			return $readmore;
		}
		return ' ...';
	}

	/**
	 * @param $length
	 *
	 * @return int|mixed
	 */
	public function excerpt_length( $length ) {
		if ( ( is_home() || is_archive() ) && 'style2' == RDTheme::$options['blog_style'] ) {
			return 25;
		}

		return $length;
	}

	/**
	 * @return void
	 */
	public function restrict_admin_area() {
		if ( RDTheme::$options['restrict_admin_area'] && ! current_user_can( 'administrator' ) ) {
			show_admin_bar( false );
		}
	}

	/**
	 * @param $args
	 *
	 * @return mixed
	 */
	public function elementor_widget_args( $args ) {
		$args['before_widget'] = '<div class="widget %2$s">';
		$args['after_widget']  = '</div>';
		$args['before_title']  = '<h3>';
		$args['after_title']   = '</h3>';
		return $args;
	}

	/**
	 * Register Elementor theme locations.
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager The theme manager instance.
	 *
	 * @return void
	 */
	function elementor_register_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_location( 'header' );
		$elementor_theme_manager->register_location( 'footer' );
	}
}

General_Setup::instance();
