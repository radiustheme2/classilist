<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\ClassiList;

use radiustheme\ClProperty\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

URI_Helper::requires( 'updater/theme-updater.php' );

if ( ! defined( 'RT_DEBUG' ) || ! RT_DEBUG ) {
	URI_Helper::requires( 'updater/theme-updater.php' );
	URI_Helper::requires( 'updater/lc-utility.php' );
	URI_Helper::requires( 'updater/lc-helper.php' );
}

URI_Helper::requires( 'class-tgm-plugin-activation.php' );
URI_Helper::requires( 'helper.php' );
URI_Helper::requires( 'tgm-config.php' );
URI_Helper::requires( 'activation.php' );
URI_Helper::requires( 'options/init.php' );
URI_Helper::requires( 'rdtheme.php' );
URI_Helper::requires( 'general.php' );
URI_Helper::requires( 'scripts.php' );
URI_Helper::requires( 'layout-settings.php' );
URI_Helper::requires( 'sidebar-generator.php' );
URI_Helper::requires( 'ad-management.php' );
URI_Helper::requires( 'init.php', 'widgets' );

if ( class_exists( 'Rtcl' ) ) {
	URI_Helper::requires( 'custom/functions.php', 'classified-listing' );
	URI_Helper::requires( 'custom/shortcode.php', 'classified-listing' );
}

if ( class_exists( 'WooCommerce' ) ) {
	URI_Helper::requires( 'woocommerce.php', 'inc' );
}
