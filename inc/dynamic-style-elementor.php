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

/*-------------------------------------
INDEX
=======================================
#. EL: Owl Nav
#. EL: Info Box
#. EL: CTA
#. EL: Pricing Box
#. EL: Accordian
#. EL: Listing Category Box
-------------------------------------*/

$classilist_prefix = Constants::$theme_prefix;
$classilist_primary_color    = apply_filters( "{$classilist_prefix}_primary_color", RDTheme::$options['primary_color'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
$classilist_secondery_color  = apply_filters( "{$classilist_prefix}_secondery_color", RDTheme::$options['secondery_color'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
$classilist_primary_rgb      = Helper::hex2rgb( $classilist_primary_color ); // 26, 167, 142
$classilist_secondery_rgb    = Helper::hex2rgb( $classilist_secondery_color ); // 252, 175, 1
?>

<?php /* EL: Owl Nav */ ?>
.owl-custom-nav-area .owl-custom-nav-title:after {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.owl-custom-nav-area .owl-custom-nav .owl-prev:hover,
.owl-custom-nav-area .owl-custom-nav .owl-next:hover {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php /* EL: Info Box */ ?>
body .rt-el-info-box .rtin-icon i {
	color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}

<?php /* EL: CTA 1 */ ?>
.rt-el-cta-1 .btn {
	background: <?php echo esc_html( $classilist_secondery_color ); ?>;
}

<?php /* EL: CTA 2 */ ?>
.rt-el-cta-2 .rtin-right a i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php /* EL: Accordian */ ?>
.rt-el-accordian .card .card-header a {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php /* EL: Listing Category Box */ ?>
.rt-el-listing-cat-box .rtin-item .rtin-icon {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rt-el-listing-cat-box .rtin-item:hover .rtin-icon {
	color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.rt-el-listing-cat-box .rtin-item:hover .rtin-title {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}