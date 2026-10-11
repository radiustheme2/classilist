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

class Helper {

	/**
	 * @return bool
	 */
	public static function has_sidebar() {
		return ( RDTheme::$layout == 'full-width' ) ? false : true;
	}

	/**
	 * @return void
	 */
	public static function the_layout_class() {
		$layout_class = self::has_sidebar() ? 'col-lg-9 col-md-8 col-sm-12 col-12' : 'col-sm-12 col-12';
		// Escape before output.
		echo esc_attr( apply_filters( 'classilist_layout_class', $layout_class ) );
	}

	/**
	 * @return void
	 */
	public static function the_sidebar_class() {
		echo esc_attr( apply_filters( 'classilist_sidebar_class', 'col-lg-3 col-md-4 ol-sm-12 col-12' ) );
	}

	/**
	 * @return void
	 */
	public static function the_title() {
		if ( is_404() ) {
			$title = esc_html__( 'Page not Found', 'classilist' );
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search Results for : ', 'classilist' ) . get_search_query();
		} elseif ( is_home() ) {
			if ( get_option( 'page_for_posts' ) ) {
				$title = get_the_title( get_option( 'page_for_posts' ) );
			} else {
				$title = apply_filters( 'classilist_blog_title', esc_html__( 'All Posts', 'classilist' ) );
			}
		} elseif ( is_archive() ) {
			$title = get_the_archive_title();
		} elseif ( is_page() ) {
			$title = get_the_title();
		} else {
			$title = get_the_title();
		}

		echo wp_kses_post( $title );
	}

	/**
	 * @return string|void
	 */
	public static function the_breadcrumb() {
		if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		} else {
			URI_Helper::requires( 'breadcrumbs.php' );
			$args       = [
				'show_browse'   => false,
				'post_taxonomy' => [ 'rtcl_listing' => 'rtcl_category' ],
			];
			$breadcrumb = new RDTheme_Breadcrumb( $args );
			return $breadcrumb->trail();
		}
	}

	/**
	 * @param $content
	 *
	 * @return string
	 */
	public static function filter_content( $content ) {
		// wp filters.
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );
		$content = wpautop( $content );
		$content = shortcode_unautop( $content );

		// remove shortcodes.
		$pattern = '/\[(.+?)\]/';
		$content = preg_replace( $pattern, '', $content );

		// remove tags.
		$content = wp_strip_all_tags( $content );

		return $content;
	}

	public static function get_current_post_content( $post = false ) {
		if ( ! $post ) {
			$post = get_post();
		}
		$content = has_excerpt( $post->ID ) ? $post->post_excerpt : $post->post_content;
		$content = self::filter_content( $content );
		return $content;
	}

	public static function comments_callback( $comment, $args, $depth ) {
		$args2 = get_defined_vars();
		URI_Helper::get_template_part( 'template-parts/comments-callback', $args2 );
	}

	public static function nav_menu_args() {
		$nav_menu_args = [
			'theme_location' => 'primary',
			'container'      => 'nav',
			'fallback_cb'    => false,
		];

		return $nav_menu_args;
	}
	public static function socials() {
		$rdtheme_socials = [
			'social_facebook'  => [
				'icon' => 'fa-brands fa-facebook-f',
				'url'  => RDTheme::$options['social_facebook'],
			],
			'social_twitter'   => [
				'icon' => 'fa-brands fa-x-twitter',
				'url'  => RDTheme::$options['social_twitter'],
			],
			'social_linkedin'  => [
				'icon' => 'fa-brands fa-linkedin-in',
				'url'  => RDTheme::$options['social_linkedin'],
			],
			'social_youtube'   => [
				'icon' => 'fab fa-youtube',
				'url'  => RDTheme::$options['social_youtube'],
			],
			'social_pinterest' => [
				'icon' => 'fab fa-pinterest',
				'url'  => RDTheme::$options['social_pinterest'],
			],
			'social_instagram' => [
				'icon' => 'fab fa-instagram',
				'url'  => RDTheme::$options['social_instagram'],
			],
			'social_rss'       => [
				'icon' => 'fas fa-rss-square',
				'url'  => RDTheme::$options['social_rss'],
			],
			'social_tiktok'    => [
				'icon' => 'fab fa-tiktok',
				'url'  => RDTheme::$options['social_tiktok'],
			],
		];
		return array_filter( $rdtheme_socials, [ __CLASS__ , 'filter_social' ] );
	}

	public static function filter_social( $args ) {
		return ( $args['url'] != '' );
	}

	public static function hex2rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = "$r, $g, $b";
		return $rgb;
	}

	public static function uniqueid() {
		$time = microtime();
		$time = str_replace( [ ' ','.' ], '-', $time );
		$id   = 'u-' . $time;
		return $id;
	}

	public static function custom_sidebar_fields() {
		$prefix         = Constants::$theme_prefix;
		$sidebar_fields = [];

		$sidebar_fields['sidebar'] = esc_html__( 'Sidebar', 'classilist' );

		$sidebars = get_option( "{$prefix}_custom_sidebars", [] );
		if ( $sidebars ) {
			foreach ( $sidebars as $sidebar ) {
				$sidebar_fields[ $sidebar['id'] ] = $sidebar['name'];
			}
		}

		return $sidebar_fields;
	}

	public static function get_file( $path ) {
		$file = get_stylesheet_directory_uri() . $path;
		if ( ! file_exists( $file ) ) {
			$file = get_template_directory_uri() . $path;
		}
		return $file;
	}

	public static function get_img( $filename ) {
		$path = '/assets/img/' . $filename;
		return self::get_file( $path );
	}

	public static function get_template_part( $template, $args = [] ) {
		extract( $args );

		$template = '/' . $template . '.php';

		if ( file_exists( get_stylesheet_directory() . $template ) ) {
			$file = get_stylesheet_directory() . $template;
		} else {
			$file = get_template_directory() . $template;
		}

		require $file;
	}

	public static function get_custom_listing_template( $template, $echo = true, $args = [] ) {
		$template = 'classified-listing/custom/' . $template;
		if ( $echo ) {
			self::get_template_part( $template, $args );
		} else {
			$template .= '.php';
			return $template;
		}
	}

	public static function wp_set_temp_query( $query ) {
		global $wp_query;
		$temp     = $wp_query;
		$wp_query = $query;
		return $temp;
	}

	public static function wp_reset_temp_query( $temp ) {
		global $wp_query;
		$wp_query = $temp;
		wp_reset_postdata();
	}
}
