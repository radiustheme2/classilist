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
        'title'   => esc_html__( 'Error Page Settings', 'classilist' ),
        'id'      => 'error_settings_section',
        'heading' => '',
        'icon'    => 'el el-error-alt',
        'fields'  => array( 
            array(
                'id'       => 'error_bodybanner',
                'type'     => 'media',
                'title'    => esc_html__( 'Featured Image', 'classilist' ),
                'default'  => array(
                    'url'=> URI_Helper::get_img( '404.png' )
                ),
            ), 
            array(
                'id'       => 'error_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Error Text', 'classilist' ),
                'default'  => esc_html__( "We can't find the page you're looking for", 'classilist' ),
            ), 
            array(
                'id'       => 'error_buttontext',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Text', 'classilist' ),
                'default'  => esc_html__( 'Go To Home Page', 'classilist' ),
            )
        )
    )
);