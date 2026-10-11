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

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$classilist_opt_name = Constants::$theme_options;

function rdtheme_redux_post_type_fields( $prefix ){
    return array(
        array(
            'id'       => $prefix. '_layout',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Layout', 'classilist' ),
            'options'  => array(
                'left-sidebar'  => esc_html__( 'Left Sidebar', 'classilist' ),
                'full-width'    => esc_html__( 'Full Width', 'classilist' ),
                'right-sidebar' => esc_html__( 'Right Sidebar', 'classilist' ),
            ),
            'default' => 'right-sidebar'
        ),
        array(
            'id'       => $prefix. '_sidebar',
            'type'     => 'select',
            'title'    => esc_html__( 'Custom Sidebar', 'classilist' ),
            'options'  => Helper::custom_sidebar_fields(),
            'default'  => 'sidebar',
            'required' => array( $prefix. '_layout', '!=', 'full-width' ),
        ),
        array(
            'id'       => $prefix. '_top_bar',
            'type'     => 'select',
            'title'    => esc_html__( 'Top Bar', 'classilist'), 
            'options'  => array(
                'default' => esc_html__( 'Default',  'classilist' ),
                'on'      => esc_html__( 'Enabled', 'classilist' ),
                'off'     => esc_html__( 'Disabled', 'classilist' ),
            ),
            'default'  => 'default',
        ),
        array(
            'id'       => $prefix. '_header_style',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Layout', 'classilist'), 
            'options'  => array(
                'default' => esc_html__( 'Default',  'classilist' ),
                '1'       => esc_html__( 'Layout 1', 'classilist' ),
                '2'       => esc_html__( 'Layout 2', 'classilist' ),
            ),
            'default'  => 'default',
        ),
        array(
            'id'       => $prefix. '_header_search',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Search', 'classilist'), 
            'options'  => array(
                'default' => esc_html__( 'Default',  'classilist' ),
                'on'      => esc_html__( 'Enabled', 'classilist' ),
                'off'     => esc_html__( 'Disabled', 'classilist' ),
            ),
            'default'  => 'default',
        ),
        array(
            'id'       => $prefix. '_breadcrumb',
            'type'     => 'select',
            'title'    => esc_html__( 'Breadcrumb', 'classilist'), 
            'options'  => array(
                'default' => esc_html__( 'Default',  'classilist' ),
                'on'      => esc_html__( 'Enabled', 'classilist' ),
                'off'     => esc_html__( 'Disabled', 'classilist' ),
            ),
            'default'  => 'default',
        ),
    );
}

Redux::setSection( $classilist_opt_name,
    array(
        'title' => esc_html__( 'Layout Defaults', 'classilist' ),
        'id'    => 'layout_defaults',
        'icon'  => 'el el-th',
    )
);

// Page
$rdtheme_page_fields = rdtheme_redux_post_type_fields( 'page' );
$rdtheme_page_fields[0]['default'] = 'full-width';
Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Page', 'classilist' ),
        'id'         => 'pages_section',
        'subsection' => true,
        'fields'     => $rdtheme_page_fields     
    )
);

//Post Archive
$rdtheme_post_archive_fields = rdtheme_redux_post_type_fields( 'blog' );
Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Blog / Archive', 'classilist' ),
        'id'         => 'blog_section',
        'subsection' => true,
        'fields'     => $rdtheme_post_archive_fields
    )
);

// Single Post
$rdtheme_single_post_fields = rdtheme_redux_post_type_fields( 'single_post' );
Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Post Single', 'classilist' ),
        'id'         => 'single_post_section',
        'subsection' => true,
        'fields'     => $rdtheme_single_post_fields           
    ) 
);

// Search
$rdtheme_search_fields = rdtheme_redux_post_type_fields( 'search' );
Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Search Layout', 'classilist' ),
        'id'         => 'search_section',
        'subsection' => true,
        'fields'     => $rdtheme_search_fields            
    )
);

// Error 404 Layout
$rdtheme_error_fields = rdtheme_redux_post_type_fields( 'error' );
unset($rdtheme_error_fields[0]);
Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Error 404 Layout', 'classilist' ),
        'id'         => 'error_section',
        'subsection' => true,
        'fields'     => $rdtheme_error_fields           
    )
);

// Listing
$rdtheme_fields = rdtheme_redux_post_type_fields( 'listing_archive' );
$rdtheme_fields[0]['options'] = array(
    'left-sidebar'  => esc_html__( 'Left Sidebar', 'classilist' ),
    'full-width'  => esc_html__( 'Full Width', 'classilist' ),
    'right-sidebar' => esc_html__( 'Right Sidebar', 'classilist' ),
);
$rdtheme_fields[0]['default'] = 'left-sidebar';

Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Listing Archive', 'classilist' ),
        'id'         => 'listing_archive_section',
        'subsection' => true,
        'fields'     => $rdtheme_fields            
    )
);

// Listing Single
$rdtheme_fields = rdtheme_redux_post_type_fields( 'listing_single' );
$rdtheme_fields[0]['options'] = array(
    'left-sidebar'  => esc_html__( 'Left Sidebar', 'classilist' ),
    'full-width'  => esc_html__( 'Full Width', 'classilist' ),
    'right-sidebar' => esc_html__( 'Right Sidebar', 'classilist' ),
);

Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Listing Single', 'classilist' ),
        'id'         => 'listing_single_section',
        'subsection' => true,
        'fields'     => $rdtheme_fields            
    )
);

// Listing Account
$rdtheme_fields = rdtheme_redux_post_type_fields( 'listing_account' );
$rdtheme_fields[0]['options'] = array(
    'left-sidebar'  => esc_html__( 'Left Sidebar', 'classilist' ),
    'full-width'  => esc_html__( 'Full Width', 'classilist' ),
    'right-sidebar' => esc_html__( 'Right Sidebar', 'classilist' ),
);
$rdtheme_fields[0]['default'] = 'left-sidebar';

Redux::setSection( $classilist_opt_name,
    array(
        'title'      => esc_html__( 'Listing Account Page', 'classilist' ),
        'id'         => 'listing_account_section',
        'subsection' => true,
        'fields'     => $rdtheme_fields            
    )
);

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound