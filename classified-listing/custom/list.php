<?php
/**
 * @author  RadiusTheme
 * @since   1.18
 * @version 1.18
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

use Rtcl\Models\Listing;
use RtclPro\Helpers\Fns;
use radiustheme\ClassiList\RDTheme;
use radiustheme\ClassiList\URI_Helper;
use radiustheme\ClassiList\Listing_Functions;

if ( ! isset( $listing ) ) {
	$listing = new Listing(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Template variable.
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$listing_post = $listing->get_listing();

$category = $listing->get_categories();
$category = end( $category );

$type = Listing_Functions::get_listing_type( $listing );

$class  = ' rtcl-listing-item';
$class .= isset( $top_listing ) ? ' rtin-top' : '';
$class .= $listing->is_featured() ? ' featured-listing' : '';
$class .= method_exists( 'RtclPro\Helpers\Fns', 'is_mark_as_sold' ) && Fns::is_mark_as_sold( $listing->get_id() ) ? ' is-sold' : '';

if ( ! isset( $classilist_core_layout ) ) {
	$classilist_core_layout = RDTheme::$options['listing_list_style'];
}

if ( ! isset( $classilist_core_display ) ) {
	$classilist_core_display = [];
}

if ( ! isset( $map ) ) {
	$map = false;
}

$fields = RDTheme::$options['listing_list_fields'] ? true : false;

$display_defaults = [
	'cat'      => $listing->can_show_category(),
	'excerpt'  => $listing->can_show_excerpt(),
	'date'     => $listing->can_show_date(),
	'user'     => $listing->can_show_user(),
	'location' => $listing->can_show_location(),
	'views'    => $listing->can_show_views(),
	'price'    => $listing->can_show_price(),
	'fields'   => $fields,
	'label'    => true,
	'type'     => true,
];

$classilist_core_display = wp_parse_args( $classilist_core_display, $display_defaults );
$classilist_core_display = apply_filters( 'classilist_list_view_display_args', $classilist_core_display );

if ( ! $category ) {
	$classilist_core_display['cat'] = false;
}

URI_Helper::get_custom_listing_template( 'list-items/archive-list-' . $classilist_core_layout, true, compact( 'listing', 'listing_post', 'category', 'class', 'classilist_core_display', 'type', 'map' ) );

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound