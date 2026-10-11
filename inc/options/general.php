<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.1
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \Redux;

$classilist_opt_name = Constants::$theme_options;

Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'General', 'classilist' ),
        'id'      => 'general_section',
        'heading' => '',
        'icon'    => 'el el-network',
        'fields'  => array(
            array(
                'id'       => 'logo_dark',
                'type'     => 'media',
                'title'    => esc_html__( 'Main Logo', 'classilist' ),
                'default'  => array(
                    'url'=> URI_Helper::get_img( 'logo-dark.png' )
                ),
            ),
            array(
                'id'       => 'logo_light',
                'type'     => 'media',
                'title'    => esc_html__( 'Light Logo', 'classilist' ),
                'default'  => array(
                    'url'=> URI_Helper::get_img( 'logo-light.png' )
                ),
                'subtitle' => esc_html__( 'Used when Transparent Header is enabled', 'classilist' ),
            ),
            array(
                'id'       => 'logo_width',
                'type'     => 'select',
                'title'    => esc_html__( 'Logo Area Width', 'classilist'), 
                'subtitle' => esc_html__( 'Width is defined by the number of bootstrap columns. Please note, navigation menu width will be decreased with the increase of logo width', 'classilist' ),
                'options'  => array(
                    '1' => esc_html__( '1 Column', 'classilist' ),
                    '2' => esc_html__( '2 Column', 'classilist' ),
                    '3' => esc_html__( '3 Column', 'classilist' ),
                    '4' => esc_html__( '4 Column', 'classilist' ),
                ),
                'default'  => '2',
            ),
            array(
                'id'       => 'breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__( 'Breadcrumb', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'time_format',
                'type'     => 'switch',
                'title'    => esc_html__( 'Time Format', 'classilist' ),
                'on'       => esc_html__( '12 Hour', 'classilist' ),
                'off'      => esc_html__( '24 Hour', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'preloader_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Preloader Image', 'classilist' ),
                'subtitle' => esc_html__( 'Please upload your choice of preloader image. Transparent GIF format is recommended', 'classilist' ),
                'default'  => array(
                    'url'=> URI_Helper::get_img( 'preloader.gif' )
                ),
                'required' => array( 'preloader', 'equals', true )
            ),
            array(
                'id'       => 'back_to_top',
                'type'     => 'switch',
                'title'    => esc_html__( 'Back to Top Arrow', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
            array(
                'id'       => 'restrict_admin_area',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide Admin Bar', 'classilist' ),
                'subtitle' => esc_html__( 'Hide Admin Bar for subscribers', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => true,
            ),
        )            
    ) 
);