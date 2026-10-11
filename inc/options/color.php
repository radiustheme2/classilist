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

use \Redux;

$classilist_opt_name = Constants::$theme_options;

Redux::setSection(
	$classilist_opt_name,
	[
		'title'   => esc_html__( 'Colors', 'classilist' ),
		'id'      => 'color_section',
		'heading' => '',
		'icon'    => 'el el-eye-open',
		'fields'  => [
			[
				'id'     => 'section-color-sitewide',
				'type'   => 'section',
				'title'  => esc_html__( 'Sitewide Colors', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'primary_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Primary Color', 'classilist' ),
				'default'     => '#1aa78e',
			],
			[
				'id'          => 'secondery_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Secondery Color', 'classilist' ),
				'default'     => '#fcaf01',
			],
			[
				'id'       => 'sitewide_color',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Other Colors', 'classilist' ),
				'options'  => [
					'primary' => esc_html__( 'Primary Color', 'classilist' ),
					'custom'  => esc_html__( 'Custom', 'classilist' ),
				],
				'default'  => 'primary',
				'subtitle' => esc_html__( 'Selecting Primary Color will hide some color options from the below settings and replace them with Primary/Secondery Color', 'classilist' ),
			],
			[
				'id'     => 'section-color-topbar',
				'type'   => 'section',
				'title'  => esc_html__( 'Top Bar', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'top_bar_bgcolor',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Top Bar Background Color', 'classilist' ),
				'default'     => '#111111',
			],
			[
				'id'     => 'section-color-menu',
				'type'   => 'section',
				'title'  => esc_html__( 'Main Menu', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'menu_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Menu Color', 'classilist' ),
				'default'     => '#111111',
			],
			[
				'id'          => 'menu_hover_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Menu Hover Color', 'classilist' ),
				'default'     => '#1aa78e',
				'required'    => [ 'sitewide_color', '=', 'custom' ],
			],
			[
				'id'     => 'section-color-submenu',
				'type'   => 'section',
				'title'  => esc_html__( 'Sub Menu', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'submenu_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Submenu Color', 'classilist' ),
				'default'     => '#111111',
			],
			[
				'id'          => 'submenu_hover_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Submenu Hover Color', 'classilist' ),
				'default'     => '#111111',
			],
			[
				'id'          => 'submenu_hover_bgcolor',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Submenu Hover Background Color', 'classilist' ),
				'default'     => '#fcaf01',
				'required'    => [ 'sitewide_color', '=', 'custom' ],
			],
			[
				'id'     => 'section-color-banner',
				'type'   => 'section',
				'title'  => esc_html__( 'Breadcrumb', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'breadcrumb_link_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Breadcrumb Link Color', 'classilist' ),
				'default'     => '#9e9e9e',
			],
			[
				'id'          => 'breadcrumb_link_hover_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Breadcrumb Link Hover Color', 'classilist' ),
				'default'     => '#1aa78e',
				'required'    => [ 'sitewide_color', '=', 'custom' ],
			],
			[
				'id'          => 'breadcrumb_active_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Active Breadcrumb Color', 'classilist' ),
				'default'     => '#444444',
			],
			[
				'id'          => 'breadcrumb_seperator_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Breadcrumb Seperator Color', 'classilist' ),
				'default'     => '#9e9e9e',
			],
			[
				'id'     => 'section-color-footer',
				'type'   => 'section',
				'title'  => esc_html__( 'Footer Area', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'footer_bgcolor',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Footer Background Color', 'classilist' ),
				'default'     => '#111111',
			],
			[
				'id'          => 'footer_title_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Footer Title Text Color', 'classilist' ),
				'default'     => '#ffffff',
			],
			[
				'id'          => 'footer_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Footer Body Text Color', 'classilist' ),
				'default'     => '#cccccc',
			],
			[
				'id'          => 'footer_link_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Footer Body Link Color', 'classilist' ),
				'default'     => '#cccccc',
			],
			[
				'id'          => 'footer_link_hover_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Footer Body Link Hover Color', 'classilist' ),
				'default'     => '#1aa78e',
				'required'    => [ 'sitewide_color', '=', 'custom' ],
			],
			[
				'id'     => 'section-color-copyright',
				'type'   => 'section',
				'title'  => esc_html__( 'Copyright Area', 'classilist' ),
				'indent' => true,
			],
			[
				'id'          => 'copyright_bgcolor',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Copyright Background Color', 'classilist' ),
				'default'     => '#1d1d1d',
			],
			[
				'id'          => 'copyright_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Copyright Text Color', 'classilist' ),
				'default'     => '#cccccc',
			],
		],
	]
);
