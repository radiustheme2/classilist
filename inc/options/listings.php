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
        'title'   => esc_html__( 'Listing Settings', 'classilist' ),
        'id'      => 'listing_settings_section',
        'icon'    => 'el el-align-left',
        'heading' => '',
        'fields'  => array(
            // Listing Grid
            array(
                'id'       => 'section-listing-grid',
                'type'     => 'section',
                'title'    => esc_html__( 'Grid View Settings', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'       =>'listing_grid_style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Grid View Style', 'classilist' ),
                'options'  => array(
                    '1' => esc_html__( 'Style 1', 'classilist' ),
                    '2' => esc_html__( 'Style 2', 'classilist' ),
                ),
                'default' => '1'
            ),
            array(
                'id'      => 'listing_grid_fields',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom fileds on grid view', 'classilist' ),
                'on'      => esc_html__( 'On', 'classilist' ),
                'off'     => esc_html__( 'Off', 'classilist' ),
                'default' => false,
            ),
            array(
                'id'       =>'grid_desktop_column',
                'type'     => 'select',
                'title'    => esc_html__( 'Desktop', 'classilist' ),
                'options'  => array(
                    '12'   => esc_html__( '1 Column', 'classilist' ),
                    '6'    => esc_html__( '2 Column', 'classilist' ),
                    '4'    => esc_html__( '3 Column', 'classilist' ),
                    '3'    => esc_html__( '4 Column', 'classilist' ),
                ),
                'default' => '4'
            ),
            array(
                'id'       =>'grid_tablet_column',
                'type'     => 'select',
                'title'    => esc_html__( 'Tablet', 'classilist' ),
                'options'  => array(
                    '12'   => esc_html__( '1 Column', 'classilist' ),
                    '6'    => esc_html__( '2 Column', 'classilist' ),
                    '4'    => esc_html__( '3 Column', 'classilist' ),
                    '3'    => esc_html__( '4 Column', 'classilist' ),
                ),
                'default' => '6'
            ),
            array(
                'id'       =>'grid_mobile_column',
                'type'     => 'select',
                'title'    => esc_html__( 'Mobile', 'classilist' ),
                'options'  => array(
                    '12'   => esc_html__( '1 Column', 'classilist' ),
                    '6'    => esc_html__( '2 Column', 'classilist' ),
                    '4'    => esc_html__( '3 Column', 'classilist' ),
                    '3'    => esc_html__( '4 Column', 'classilist' ),
                ),
                'default' => '12'
            ),

            // Listing List
            array(
                'id'       => 'section-listing-list',
                'type'     => 'section',
                'title'    => esc_html__( 'List View Settings', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'       =>'listing_list_style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'List View Style', 'classilist' ),
                'options'  => array(
                    '1' => esc_html__( 'Style 1', 'classilist' ),
                    '2' => esc_html__( 'Style 2', 'classilist' ),
                ),
                'default' => '1'
            ),
            array(
                'id'       => 'listing_excerpt',
                'type'     => 'text',
                'title'    => esc_html__( 'Excerpt Length', 'classilist' ),
                'default'  => '12',
            ),
            array(
                'id'      => 'listing_list_fields',
                'type'    => 'switch',
                'title'   => esc_html__( 'Custom fileds on list view', 'classilist' ),
                'on'      => esc_html__( 'On', 'classilist' ),
                'off'     => esc_html__( 'Off', 'classilist' ),
                'default' => true,
            ),
            // Listing Details
            array(
                'id'       => 'section-listing-details',
                'type'     => 'section',
                'title'    => esc_html__( 'Listing Details Settings', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'      => 'listing_related',
                'type'    => 'switch',
                'title'   => esc_html__( 'Display Related Listing', 'classilist' ),
                'on'      => esc_html__( 'On', 'classilist' ),
                'off'     => esc_html__( 'Off', 'classilist' ),
                'default' => true,
            ),
            // Listing Search
            array(
                'id'       => 'section-listing-search',
                'type'     => 'section',
                'title'    => esc_html__( 'Listing Search Settings', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'       =>'listing_search_style',
                'type'     => 'select',
                'title'    => esc_html__( 'Listing Search Style', 'classilist' ),
                'options'  => array(
                    'popup'      => esc_html__( 'Popup', 'classilist' ),
                    'standard'   => esc_html__( 'Standard', 'classilist' ),
                    'suggestion' => esc_html__( 'Auto Suggestion', 'classilist' ),
                    'dependency' => esc_html__( 'Dependency Selection', 'classilist' ),
                ),
                'default' => 'popup'
            ),
            array(
                'id'      => 'listing_search_items',
                'type'    => 'checkbox',
                'class'   => 'redux-custom-inline',
                'title'   => esc_html__( 'Listing Search Items', 'classilist'),
                'options' => array(
                    'location'  => 'Location',
                    'radius'    => 'Radius',
                    'category'  => 'Category',
                    'type'      => 'Type',
                    'keyword'   => 'Keyword',
                ),
                'default' => array(
                    'location'  => '1',
                    'radius'    => '0',
                    'category'  => '1',
                    'keyword'   => '1',
                    'type'      => '0',
                ),
            ),
        )
    ) 
);