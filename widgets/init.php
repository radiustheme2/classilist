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

class Custom_Widgets_Init {

	public $widgets;
	protected static $instance = null;

	public function __construct() {

		// Widgets -- filename=>classname /@dev
		$this->widgets =  array(
			'about'       => 'About_Widget',
			'information' => 'Information_Widget',
		);

		add_action( 'widgets_init', array( $this, 'custom_widgets' ) );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function custom_widgets() {
		if ( !class_exists( 'RT_Widget_Fields' ) ) return;

		foreach ( $this->widgets as $filename => $classname ) {
			$file  = $filename . '.php';
			$class = __NAMESPACE__ . '\\' . $classname;

			URI_Helper::requires( $file, 'widgets' );
			register_widget( $class );
		}
	}
}

Custom_Widgets_Init::instance();