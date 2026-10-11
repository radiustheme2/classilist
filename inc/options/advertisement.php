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
$classilist_opt_name = Constants::$theme_ad_options;

$theme = wp_get_theme();
$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $classilist_opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'disable_tracking'     => true,
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Advertisement Options', 'classilist' ),
    'page_title'           => esc_html__( 'Advertisement Options', 'classilist' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    //'google_api_key'       => 'AIzaSyC2GwbfJvi-WnYpScCPBGIUyFZF97LI0xs',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-menu',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    'forced_dev_mode_off'  => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => Constants::$theme_prefix . '-ad-options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => true,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    'footer_credit'        => '&nbsp;',
    // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
);

Redux::set_args( $classilist_opt_name, $args );


function rdtheme_redux_advertisement_fields( $prefix, $title, $subtitle = '' ){
    return array(
        array(
            'id'       =>  $prefix. '_sec',
            'type'     => 'section',
            'title'    => $title,
            'subtitle' => $subtitle,
            'indent'   => true,
        ),
        array(
            'id'       => $prefix. '_activate',
            'type'     => 'switch',
            'title'    => esc_html__( 'Activate Ad', 'classilist' ),
            'on'       => esc_html__( 'Enabled', 'classilist' ),
            'off'      => esc_html__( 'Disabled', 'classilist' ),
            'default'  => false,
        ),
        array(
            'id'       => $prefix. '_type',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Ad Type', 'classilist' ),
            'options'  => array(
                'image'  => esc_html__( 'Image', 'classilist' ),
                'code'   => esc_html__( 'Custom Code', 'classilist' ),
            ),
            'default' => 'image',
            'required' => array(  $prefix. '_activate', 'equals', true )
        ),
        array(
            'id'       => $prefix. '_image',
            'type'     => 'media',
            'title'    => esc_html__( 'Image', 'classilist' ),
            'default'  => '',
            'required' => array(  $prefix. '_type', 'equals', 'image' )
        ),
        array(
            'id'       => $prefix. '_url',
            'type'     => 'text',
            'title'    => esc_html__( 'Link', 'classilist' ),
            'default'  => '',
            'required' => array(  $prefix. '_type', 'equals', 'image' )
        ),
        array(
            'id'       => $prefix. '_newtab',
            'type'     => 'switch',
            'title'    => esc_html__( 'Open Link in New Tab', 'classilist' ),
            'on'       => esc_html__( 'Enabled', 'classilist' ),
            'off'      => esc_html__( 'Disabled', 'classilist' ),
            'default'  => true,
            'required' => array(  $prefix. '_type', 'equals', 'image' )
        ),
        array(
            'id'       => $prefix. '_nofollow',
            'type'     => 'switch',
            'title'    => esc_html__( 'Nofollow', 'classilist' ),
            'on'       => esc_html__( 'Enabled', 'classilist' ),
            'off'      => esc_html__( 'Disabled', 'classilist' ),
            'default'  => true,
            'subtitle' => esc_html__( 'Make Link Nofollow', 'classilist' ),
            'required' => array(  $prefix. '_type', 'equals', 'image' )
        ),
        array(
            'id'       => $prefix. '_code',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Custom Code', 'classilist' ),
            'default'  => '',
            'subtitle' => esc_html__( 'Supports: Shortcode, Adsense, Text, HTML, Scripts', 'classilist' ),
            'required' => array(  $prefix. '_type', 'equals', 'code' )
        ),
    );
}


Redux::setSection( $classilist_opt_name,
    array(
        'title' => esc_html__( 'Advertisements', 'classilist' ),
        'id'    => 'ad_settings_section',
        'icon'  => 'el el-speaker',
    )
);

// Listing Page
$field1 = rdtheme_redux_advertisement_fields( 'ad_listing_header', esc_html__( 'Header', 'classilist') );
$field2 = rdtheme_redux_advertisement_fields( 'ad_listing_before_sidebar', esc_html__( 'Before Sidebar', 'classilist') );
$field3 = rdtheme_redux_advertisement_fields( 'ad_listing_after_sidebar', esc_html__( 'After Sidebar', 'classilist') );
$field4 = rdtheme_redux_advertisement_fields( 'ad_listing_footer', esc_html__( 'Footer', 'classilist') );
$field5 = rdtheme_redux_advertisement_fields( 'ad_listing_before_items', esc_html__( 'Before All Listing Items', 'classilist') );
$field6 = rdtheme_redux_advertisement_fields( 'ad_listing_after_items', esc_html__( 'After All Listing Items', 'classilist') );

$fields = array_merge( $field1, $field2, $field3, $field4, $field5, $field6 );
Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Listing Page', 'classilist' ),
        'id'      => 'ad_settings_listing_section',
        'heading' => '',
        'subsection' => true,
        'fields'  => $fields
    )
);

// Single Listing Page
$field1 = rdtheme_redux_advertisement_fields( 'ad_single_header', esc_html__( 'Header', 'classilist') );
$field2 = rdtheme_redux_advertisement_fields( 'ad_single_before_sidebar', esc_html__( 'Before Sidebar', 'classilist') );
$field3 = rdtheme_redux_advertisement_fields( 'ad_single_after_sidebar', esc_html__( 'After Sidebar', 'classilist') );
$field4 = rdtheme_redux_advertisement_fields( 'ad_single_footer', esc_html__( 'Footer', 'classilist') );
$field5 = rdtheme_redux_advertisement_fields( 'ad_single_before_contents', esc_html__( 'Before Item Contents', 'classilist') );
$field6 = rdtheme_redux_advertisement_fields( 'ad_single_after_contents', esc_html__( 'After Item Contents', 'classilist') );
$field7 = rdtheme_redux_advertisement_fields( 'ad_single_after_product', esc_html__( 'After Item Block', 'classilist') );
$field8 = rdtheme_redux_advertisement_fields( 'ad_single_after_location', esc_html__( 'After Location Block', 'classilist') );
$field9 = rdtheme_redux_advertisement_fields( 'ad_single_after_related', esc_html__( 'After Related Items Block', 'classilist') );

$fields = array_merge( $field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9 );
Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Single Listing Page', 'classilist' ),
        'id'      => 'ad_settings_single_listing_section',
        'heading' => '',
        'subsection' => true,
        'fields'  => $fields
    )
);

// Blog/Archive
$field1 = rdtheme_redux_advertisement_fields( 'ad_blog_header', esc_html__( 'Header', 'classilist') );
$field2 = rdtheme_redux_advertisement_fields( 'ad_blog_before_sidebar', esc_html__( 'Before Sidebar', 'classilist') );
$field3 = rdtheme_redux_advertisement_fields( 'ad_blog_after_sidebar', esc_html__( 'After Sidebar', 'classilist') );
$field4 = rdtheme_redux_advertisement_fields( 'ad_blog_footer', esc_html__( 'Footer', 'classilist') );

$fields = array_merge( $field1, $field2, $field3, $field4 );
Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Blog/Archive', 'classilist' ),
        'id'      => 'ad_settings_blog_section',
        'heading' => '',
        'subsection' => true,
        'fields'  => $fields
    )
);

// Single Post
$field1 = rdtheme_redux_advertisement_fields( 'ad_post_header', esc_html__( 'Header', 'classilist') );
$field2 = rdtheme_redux_advertisement_fields( 'ad_post_before_sidebar', esc_html__( 'Before Sidebar', 'classilist') );
$field3 = rdtheme_redux_advertisement_fields( 'ad_post_after_sidebar', esc_html__( 'After Sidebar', 'classilist') );
$field4 = rdtheme_redux_advertisement_fields( 'ad_post_footer', esc_html__( 'Footer', 'classilist') );
$field5 = rdtheme_redux_advertisement_fields( 'ad_post_before_content', esc_html__( 'Before Post Contents', 'classilist') );
$field6 = rdtheme_redux_advertisement_fields( 'ad_post_after_content', esc_html__( 'After Post Contents', 'classilist') );

$fields = array_merge( $field1, $field2, $field3, $field4, $field5, $field6 );
Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Single Post', 'classilist' ),
        'id'      => 'ad_settings_post_section',
        'heading' => '',
        'subsection' => true,
        'fields'  => $fields
    )
);

// Page
$field1 = rdtheme_redux_advertisement_fields( 'ad_page_header', esc_html__( 'Header', 'classilist') );
$field2 = rdtheme_redux_advertisement_fields( 'ad_page_before_sidebar', esc_html__( 'Before Sidebar', 'classilist') );
$field3 = rdtheme_redux_advertisement_fields( 'ad_page_after_sidebar', esc_html__( 'After Sidebar', 'classilist') );
$field4 = rdtheme_redux_advertisement_fields( 'ad_page_footer', esc_html__( 'Footer', 'classilist') );
$field5 = rdtheme_redux_advertisement_fields( 'ad_page_before_content', esc_html__( 'Before Page Contents', 'classilist') );
$field6 = rdtheme_redux_advertisement_fields( 'ad_page_after_content', esc_html__( 'After Page Contents', 'classilist') );

$fields = array_merge( $field1, $field2, $field3, $field4, $field5, $field6 );
Redux::setSection( $classilist_opt_name,
    array(
        'title'   => esc_html__( 'Page', 'classilist' ),
        'id'      => 'ad_settings_page_section',
        'heading' => '',
        'subsection' => true,
        'fields'  => $fields
    )
);

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound