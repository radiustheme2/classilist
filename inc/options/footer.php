<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.6
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \Redux;

$classilist_opt_name = Constants::$theme_options;

Redux::setSection(
	$classilist_opt_name,
	[
		'title'   => esc_html__( 'Footer', 'classilist' ),
		'id'      => 'footer_section',
		'heading' => '',
		'icon'    => 'el el-caret-down',
		'fields'  => [
			[
				'id'     => 'section-copyright-area',
				'type'   => 'section',
				'title'  => esc_html__( 'Copyright Area', 'classilist' ),
				'indent' => true,
			],
			[
				'id'      => 'copyright_area',
				'type'    => 'switch',
				'title'   => esc_html__( 'Display Copyright Area', 'classilist' ),
				'on'      => esc_html__( 'Enabled', 'classilist' ),
				'off'     => esc_html__( 'Disabled', 'classilist' ),
				'default' => true,
			],
			[
				'id'       => 'copyright_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Copyright Text', 'classilist' ),
				'default'  => '&copy; Copyright ClassiList 2026. Designed and Developed by <a target="_blank" href="' . esc_url( Constants::$theme_author_uri ) . '">RadiusTheme</a>',
				'required' => [ 'copyright_area', 'equals', true ],
			],
			[
				'id'       => 'payment_icons',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display Payment Icons', 'classilist' ),
				'on'       => esc_html__( 'Enabled', 'classilist' ),
				'off'      => esc_html__( 'Disabled', 'classilist' ),
				'default'  => false,
				'required' => [ 'copyright_area', 'equals', true ],
			],
			[
				'id'       => 'payment_img',
				'type'     => 'gallery',
				'title'    => esc_html__( 'Payment Images Gallery', 'classilist' ),
				'subtitle' => esc_html__( 'This payment image sise should be 34×21px', 'classilist' ),
				'required' => [ 'payment_icons', 'equals', true ],
			],
		],
	]
);
