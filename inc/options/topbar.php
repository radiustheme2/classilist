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
        'title'   => esc_html__( 'Top Bar & Socials', 'classilist' ),
        'id'      => 'topbar_settings_section',
        'heading' => '',
        'icon'    => 'el el-twitter',
        'fields'  => array( 
            array(
                'id'       => 'top_bar',
                'type'     => 'switch',
                'title'    => esc_html__( 'Top Bar', 'classilist' ),
                'on'       => esc_html__( 'Enabled', 'classilist' ),
                'off'      => esc_html__( 'Disabled', 'classilist' ),
                'default'  => false,
            ),
            array(
                'id'       => 'phone',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'email',
                'type'     => 'text',
                'title'    => esc_html__( 'Email', 'classilist' ),
                'validate' => 'email',
                'default'  => '',
            ),
            array(
                'id'       => 'address',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Address', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_facebook',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_twitter',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_linkedin',
                'type'     => 'text',
                'title'    => esc_html__( 'Linkedin', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_youtube',
                'type'     => 'text',
                'title'    => esc_html__( 'Youtube', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_pinterest',
                'type'     => 'text',
                'title'    => esc_html__( 'Pinterest', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_instagram',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram', 'classilist' ),
                'default'  => '',
            ),
            array(
                'id'       => 'social_rss',
                'type'     => 'text',
                'title'    => esc_html__( 'RSS', 'classilist' ),
                'default'  => '',
            ),
	        array(
		        'id'       => 'social_tiktok',
		        'type'     => 'text',
		        'title'    => esc_html__( 'Tiktok', 'classilist' ),
		        'default'  => '',
	        ),
        )
    )
);