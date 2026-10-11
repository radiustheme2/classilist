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
		'title'   => esc_html__( 'Blog Settings', 'classilist' ),
		'id'      => 'blog_settings_section',
		'icon'    => 'el el-tags',
		'heading' => '',
		'fields'  => [
			[
				'id'      => 'blog_style',
				'type'    => 'image_select',
				'title'   => esc_html__( 'Blog/Archive Layout', 'classilist' ),
				'default' => 'style1',
				'options' => [
					'style1' => [
						'title' => '<b>' . esc_html__( 'Layout 1', 'classilist' ) . '</b>',
						'img'   => URI_Helper::get_img( 'blog1.jpg' ),
					],
					'style2' => [
						'title' => '<b>' . esc_html__( 'Layout 2', 'classilist' ) . '</b>',
						'img'   => URI_Helper::get_img( 'blog2.jpg' ),
					],
				],
			],
			[
				'id'      => 'blog_date',
				'type'    => 'switch',
				'title'   => esc_html__( 'Display Date', 'classilist' ),
				'on'      => esc_html__( 'On', 'classilist' ),
				'off'     => esc_html__( 'Off', 'classilist' ),
				'default' => true,
			],
			[
				'id'      => 'blog_author_name',
				'type'    => 'switch',
				'title'   => esc_html__( 'Display Author Name', 'classilist' ),
				'on'      => esc_html__( 'On', 'classilist' ),
				'off'     => esc_html__( 'Off', 'classilist' ),
				'default' => true,
			],
			[
				'id'      => 'blog_cats',
				'type'    => 'switch',
				'title'   => esc_html__( 'Display Categories', 'classilist' ),
				'on'      => esc_html__( 'On', 'classilist' ),
				'off'     => esc_html__( 'Off', 'classilist' ),
				'default' => true,
			],
			[
				'id'      => 'blog_comment_num',
				'type'    => 'switch',
				'title'   => esc_html__( 'Display Comment Number', 'classilist' ),
				'on'      => esc_html__( 'On', 'classilist' ),
				'off'     => esc_html__( 'Off', 'classilist' ),
				'default' => true,
			],
		],
	]
);
