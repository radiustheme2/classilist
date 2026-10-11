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
        'title'  => esc_html__( 'Typography', 'classilist' ),
        'id'     => 'typo_section',
        'icon'   => 'el el-text-width',
        'fields' => array(
            array(
                'id'       => 'typo_body',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets'  => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Roboto',
                    'font-weight' => '400',
                    'font-size'   => '15px',
                    'line-height' => '28px',
                ),
            ),
            array(
                'id'       => 'typo_h1',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h1', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'    => false,
                'subsets'  => false,
                'default'  => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '600',
                    'font-size'   => '38px',
                    'line-height' => '42px',
                ),
            ),
            array(
                'id'       => 'typo_h2',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h2', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets'  => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '600',
                    'font-size'   => '30px',
                    'line-height' => '36px',
                ),
            ),
            array(
                'id'       => 'typo_h3',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h3', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets' => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '600',
                    'font-size'   => '24px',
                    'line-height' => '32px',
                ),
            ),
            array(
                'id'       => 'typo_h4',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h4', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets'  => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '600',
                    'font-size'   => '22px',
                    'line-height' => '30px',
                ),
            ),
            array(
                'id'       => 'typo_h5',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h5', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets'  => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '600',
                    'font-size'   => '18px',
                    'line-height' => '28px',
                ),
            ),
            array(
                'id'       => 'typo_h6',
                'type'     => 'typography',
                'title'    => esc_html__( 'Header h6', 'classilist' ),
                'text-align'  => false,
                'font-weight' => false,
                'color'   => false,
                'subsets'  => false,
                'default' => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                    'font-size'   => '15px',
                    'line-height' => '20px',
                ),
            ),
            array(
                'id'       => 'section-mainmenu',
                'type'     => 'section',
                'title'    => esc_html__( 'Main Menu Items', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'menu_typo',
                'type'     => 'typography',
                'title'    => esc_html__( 'Menu Font', 'classilist' ),
                'text-align' => false,
                'color'   => false,
                'subsets'  => false,
                'text-transform' => true,
                'default'     => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                    'font-size'   => '15px',
                    'line-height' => '26px',
                    'text-transform' => 'none',
                ),
            ),
            array(
                'id'       => 'section-submenu',
                'type'     => 'section',
                'title'    => esc_html__( 'Sub Menu Items', 'classilist' ),
                'indent'   => true,
            ), 
            array(
                'id'       => 'submenu_typo',
                'type'     => 'typography',
                'title'    => esc_html__( 'Submenu Font', 'classilist' ),
                'text-align'   => false,
                'color'   => false,
                'subsets'  => false,
                'text-transform' => true,
                'default'     => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                    'font-size'   => '14px',
                    'line-height' => '26px',
                    'text-transform' => 'none',
                ),
            ),
            array(
                'id'       => 'section-resmenu',
                'type'     => 'section',
                'title'    => esc_html__( 'Mobile Menu', 'classilist' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'resmenu_typo',
                'type'     => 'typography',
                'title'    => esc_html__( 'Mobile Menu Font', 'classilist' ),
                'text-align' => false,
                'color'   => false,
                'subsets'  => false,
                'text-transform' => true,
                'default'     => array(
                    'google'      => true,
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                    'font-size'   => '14px',
                    'line-height' => '21px',
                    'text-transform' => 'none',
                ),
            ),
        )
    )
);