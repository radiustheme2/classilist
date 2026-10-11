<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.5
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class URI_Helper {
	
	public static function requires( $filename, $dir = false ){
		if ( $dir) {
			$child_file = get_stylesheet_directory() . '/' . $dir . '/' . $filename;

			if ( file_exists( $child_file ) ) {
				$file = $child_file;
			}
			else {
				$file = get_template_directory() . '/' . $dir . '/' . $filename;
			}
		}
		else {
			$child_file = get_stylesheet_directory() . '/inc/' . $filename;

			if ( file_exists( $child_file ) ) {
				$file = $child_file;
			}
			else {
				$file = Constants::$theme_inc_dir . $filename;
			}
		}

		if (file_exists( $file )) {
            require_once $file;
        }
	}

	public static function get_file( $path ){
		$filepath = get_stylesheet_directory() . $path;
		$file     = get_stylesheet_directory_uri() . $path;
		if ( !file_exists( $filepath ) ) {
			$file = get_template_directory_uri() . $path;
		}
		return $file;
	}

	public static function get_img( $filename ){
		$path = '/assets/img/' . $filename;
		return self::get_file( $path );
	}

	public static function get_css( $filename ){
		$path = '/assets/css/' . $filename . '.css';
		return self::get_file( $path );
	}

	public static function get_maybe_rtl_css( $filename ){
		if ( is_rtl() ) {
			$path = '/assets/css-auto-rtl/' . $filename . '.css';
			return self::get_file( $path );
		}
		else {
			return self::get_css( $filename );
		}
	}

	public static function get_js( $filename ){
		$path = '/assets/js/' . $filename . '.js';
		return self::get_file( $path );
	}

	public static function get_template_part( $template, $args = array() ){
		extract( $args );

		$template = '/' . $template . '.php';

		if ( file_exists( get_stylesheet_directory() . $template ) ) {
			$file = get_stylesheet_directory() . $template;
		}
		else {
			$file = get_template_directory() . $template;
		}

		if (file_exists($file)) {
            require $file;
        }
	}

	public static function get_custom_listing_template( $template, $echo = true, $args = array() ){
		$template = 'classified-listing/custom/' . $template;
		if ( $echo ) {
			self::get_template_part( $template, $args );
		}
		else {
			$template .= '.php'; 
			return $template;
		}
	}

	public static function get_custom_store_template( $template, $echo = true, $args = array() ){
		$template = 'classified-listing/store/custom/' . $template;
		if ( $echo ) {
			self::get_template_part( $template, $args );
		}
		else {
			$template .= '.php'; 
			return $template;
		}
	}
}