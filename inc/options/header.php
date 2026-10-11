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

Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Header', 'classilist' ),
        'id'      => 'header_section',
        'heading' => '',
        'icon'    => 'el el-flag',
        'fields'  => array(
            array(
                'id'       => 'resmenu_width',
                'type'     => 'slider',
                'title'    => esc_html__( 'Responsive Header Screen Width', 'classilist' ),
                'subtitle' => esc_html__( 'Screen width in which mobile menu activated. Recommended value is: 992', 'classilist' ),
                'default'  => 992,
                'min'      => 0,
                'step'     => 1,
                'max'      => 2000,
            ),
            array(
                'id'       => 'sticky_menu',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Header', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
                'subtitle' => esc_html__( 'Show header at the top when scrolling down', 'classilist' ),
            ),
            array(
                'id'       => 'header_style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Header Layout', 'classilist' ),
                'default'  => '1',
                'options' => array(
                    '1' => array(
                        'title' => '<b>'. esc_html__( 'Layout 1', 'classilist' ) . '</b>',
                        'img' => URI_Helper::get_img( 'header-1.png' ),
                    ),
                    '2' => array(
                        'title' => '<b>'. esc_html__( 'Layout 2', 'classilist' ) . '</b>',
                        'img' => URI_Helper::get_img( 'header-2.png' ),
                    ),
                ),
            ),
            array(
                'id'       => 'header_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Header Login Icon', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'header_chat_icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Header Chat Icon', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'header_icon_text_guest',
                'type'     => 'text',
                'title'    => esc_html__( 'Header Login Icon Text (Guest Mode)', 'classilist' ),
                'default'  => esc_html__( 'Login/ Register', 'classilist' ),
                'subtitle' => esc_html__( "Used when user isn't logged in", 'classilist' ),
                'required' => array( 'header_icon', 'equals', true )
            ),
            array(
                'id'       => 'header_icon_text_logged',
                'type'     => 'text',
                'title'    => esc_html__( 'Header Login Icon Text (Logged in Mode)', 'classilist' ),
                'default'  => esc_html__( 'My Account', 'classilist' ),
                'subtitle' => esc_html__( "Used when user is logged in", 'classilist' ),
                'required' => array( 'header_icon', 'equals', true )
            ),
            array(
                'id'       => 'header_btn_txt',
                'type'     => 'text',
                'title'    => esc_html__( 'Header Button Text', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'header_btn_url',
                'type'     => 'text',
                'title'    => esc_html__( 'Header Button URL', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'header_search',
                'type'     => 'switch',
                'title'    => esc_html__( 'Header Search', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__( 'Breadcrumb', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
        )
    ) 
);