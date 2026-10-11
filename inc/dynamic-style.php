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

/*
-------------------------------------
INDEX
=======================================
// . Defaults
// . Typography
// . Header
// . Breadcrumb
// . Footer
// . Theme Defaults
// . Widgets
// . Contents Area
-------------------------------------*/

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$classilist_prefix = Constants::$theme_prefix;
$primary_color     = apply_filters( "{$classilist_prefix}_primary_color", RDTheme::$options['primary_color'] ); // #1aa78e
$secondery_color   = apply_filters( "{$classilist_prefix}_secondery_color", RDTheme::$options['secondery_color'] ); // #fcaf01
$primary_rgb       = Helper::hex2rgb( $primary_color ); // 26, 167, 142
$secondery_rgb     = Helper::hex2rgb( $secondery_color ); // 252, 175, 1

$typo_body = RDTheme::$options['typo_body'];
$typo_h1   = RDTheme::$options['typo_h1'];
$typo_h2   = RDTheme::$options['typo_h2'];
$typo_h3   = RDTheme::$options['typo_h3'];
$typo_h4   = RDTheme::$options['typo_h4'];
$typo_h5   = RDTheme::$options['typo_h5'];
$typo_h6   = RDTheme::$options['typo_h6'];

$menu_typo    = RDTheme::$options['menu_typo'];
$submenu_typo = RDTheme::$options['submenu_typo'];
$resmenu_typo = RDTheme::$options['resmenu_typo'];


$top_bar_bgcolor       = RDTheme::$options['top_bar_bgcolor'];
$menu_color            = RDTheme::$options['menu_color'];
$menu_hover_color      = RDTheme::$options['sitewide_color'] == 'custom' ? RDTheme::$options['menu_hover_color'] : $primary_color;
$submenu_color         = RDTheme::$options['submenu_color'];
$submenu_hover_color   = RDTheme::$options['submenu_hover_color'];
$submenu_hover_bgcolor = RDTheme::$options['sitewide_color'] == 'custom' ? RDTheme::$options['submenu_hover_bgcolor'] : $secondery_color;


$breadcrumb_link_color       = RDTheme::$options['breadcrumb_link_color'];
$breadcrumb_link_hover_color = RDTheme::$options['sitewide_color'] == 'custom' ? RDTheme::$options['breadcrumb_link_hover_color'] : $primary_color;
$breadcrumb_active_color     = RDTheme::$options['breadcrumb_active_color'];
$breadcrumb_seperator_color  = RDTheme::$options['breadcrumb_seperator_color'];


$footer_bgcolor          = RDTheme::$options['footer_bgcolor'];
$footer_title_color      = RDTheme::$options['footer_title_color'];
$footer_color            = RDTheme::$options['footer_color'];
$footer_link_color       = RDTheme::$options['footer_link_color'];
$footer_link_hover_color = RDTheme::$options['sitewide_color'] == 'custom' ? RDTheme::$options['footer_link_hover_color'] : $primary_color;
$copyright_bgcolor       = RDTheme::$options['copyright_bgcolor'];
$copyright_color         = RDTheme::$options['copyright_color'];
?>

<?php
/*
-------------------------------------
// . Defaults
---------------------------------------*/
?>
.primary-color {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.secondery-color {
	color: <?php echo esc_html( $secondery_color ); ?>;
}
.primary-bgcolor {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.secondery-bgcolor {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"] {
  background-color: <?php echo esc_html( $primary_color ); ?>;
}
a:link,
a:visited {
  color: <?php echo esc_html( $primary_color ); ?>;
}
a:hover,
a:focus,
a:active {
  color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . Typography
---------------------------------------*/
?>
body, ul li {
	font-family: <?php echo esc_html( $typo_body['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_body['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_body['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_body['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_body['font-style'] ) ? 'normal' : $typo_body['font-style'] ); ?>;
}
h1 {
	font-family: <?php echo esc_html( $typo_h1['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h1['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h1['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h1['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h1['font-style'] ) ? 'normal' : $typo_h1['font-style'] ); ?>;
}
h2 {
	font-family: <?php echo esc_html( $typo_h2['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h2['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h2['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h2['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h2['font-style'] ) ? 'normal' : $typo_h2['font-style'] ); ?>;
}
h3 {
	font-family: <?php echo esc_html( $typo_h3['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h3['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h3['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h3['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h3['font-style'] ) ? 'normal' : $typo_h3['font-style'] ); ?>;
}
h4 {
	font-family: <?php echo esc_html( $typo_h4['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h4['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h4['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h4['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h4['font-style'] ) ? 'normal' : $typo_h4['font-style'] ); ?>;
}
h5 {
	font-family: <?php echo esc_html( $typo_h5['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h5['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h5['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h5['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h5['font-style'] ) ? 'normal' : $typo_h5['font-style'] ); ?>;
}
h6 {
	font-family: <?php echo esc_html( $typo_h6['font-family'] ); ?>, sans-serif;
	font-size: <?php echo esc_html( $typo_h6['font-size'] ); ?>;
	line-height: <?php echo esc_html( $typo_h6['line-height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_h6['font-weight'] ); ?>;
	font-style: <?php echo esc_attr( empty( $typo_h6['font-style'] ) ? 'normal' : $typo_h6['font-style'] ); ?>;
}

.main-header .main-navigation-area .main-navigation ul li a {
	font-family: <?php echo esc_html( $menu_typo['font-family'] ); ?>, sans-serif;
	font-size : <?php echo esc_html( $menu_typo['font-size'] ); ?>;
	font-weight : <?php echo esc_html( $menu_typo['font-weight'] ); ?>;
	line-height : <?php echo esc_html( $menu_typo['line-height'] ); ?>;
	text-transform : <?php echo esc_html( $menu_typo['text-transform'] ); ?>;
	font-style: <?php echo esc_attr( empty( $menu_typo['font-style'] ) ? 'normal' : $menu_typo['font-style'] ); ?>;
}
.main-header .main-navigation-area .main-navigation ul li ul li a {
	font-family: <?php echo esc_html( $submenu_typo['font-family'] ); ?>, sans-serif;
	font-size : <?php echo esc_html( $submenu_typo['font-size'] ); ?>;
	font-weight : <?php echo esc_html( $submenu_typo['font-weight'] ); ?>;
	line-height : <?php echo esc_html( $submenu_typo['line-height'] ); ?>;
	text-transform : <?php echo esc_html( $submenu_typo['text-transform'] ); ?>;
	font-style: <?php echo esc_attr( empty( $submenu_typo['font-style'] ) ? 'normal' : $submenu_typo['font-style'] ); ?>;
}
.mean-container .mean-nav ul li a {
	font-family: <?php echo esc_html( $resmenu_typo['font-family'] ); ?>, sans-serif;
	font-size : <?php echo esc_html( $resmenu_typo['font-size'] ); ?>;
	font-weight : <?php echo esc_html( $resmenu_typo['font-weight'] ); ?>;
	line-height : <?php echo esc_html( $resmenu_typo['line-height'] ); ?>;
	text-transform : <?php echo esc_html( $resmenu_typo['text-transform'] ); ?>;
	font-style: <?php echo esc_attr( empty( $resmenu_typo['font-style'] ) ? 'normal' : $resmenu_typo['font-style'] ); ?>;
}

<?php
/*
-------------------------------------
// . Footer
---------------------------------------*/
?>
.footer-top-area {
	background-color: <?php echo esc_html( $footer_bgcolor ); ?>;
}
.footer-top-area .widget > h3 {
	color: <?php echo esc_html( $footer_title_color ); ?>;
}
.footer-top-area .widget {
	color: <?php echo esc_html( $footer_color ); ?>;
}
.footer-top-area a:link,
.footer-top-area a:visited {
	color: <?php echo esc_html( $footer_link_color ); ?>;
}
.footer-top-area .widget a:hover,
.footer-top-area .widget a:active {
	color: <?php echo esc_html( $footer_link_hover_color ); ?>;
}
.footer-bottom-area {
	background-color: <?php echo esc_html( $copyright_bgcolor ); ?>;
	color: <?php echo esc_html( $copyright_color ); ?>;
}

<?php
/*
-------------------------------------
// . Header
---------------------------------------*/
?>

<?php // Top Bar. ?>
.top-header {
	background-color: <?php echo esc_html( $top_bar_bgcolor ); ?>;
}
.top-header .top-header-inner .tophead-info li .fa {
	color: <?php echo esc_html( $secondery_color ); ?>;
}
.top-header .top-header-inner .tophead-social li a:hover {
	color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php // Main Menu Color. ?>
.main-header .main-navigation-area .main-navigation ul.menu>li.menu-item-has-children:after,
.main-header .main-navigation-area .main-navigation ul li a,
a.header-login-icon .rtin-text,
a.header-login-icon i,
a.header-chat-icon:link {
	color: <?php echo esc_html( $menu_color ); ?>;
}
.main-header .main-navigation-area .main-navigation ul.menu>li.menu-item-has-children:hover:after,
.main-header .main-navigation-area .main-navigation ul.menu > li > a:hover,
a.header-login-icon:hover:visited .rtin-text,
a.header-login-icon:hover:link .rtin-text,
a.header-login-icon:hover i,
a.header-chat-icon:hover:link {
	color: <?php echo esc_html( $menu_hover_color ); ?>;
}
.main-header .main-navigation-area .main-navigation ul.menu > li.current-menu-item > a,
.main-header .main-navigation-area .main-navigation ul.menu > li.current > a {
	color: <?php echo esc_html( $menu_hover_color ); ?>;
}

<?php // Sub Menu. ?>
.main-header .main-navigation-area .main-navigation ul li ul li a {
	color: <?php echo esc_html( $submenu_color ); ?>;
}
.main-header .main-navigation-area .main-navigation ul li ul li:hover > a {
	color: <?php echo esc_html( $submenu_hover_color ); ?>;
	background-color: <?php echo esc_html( $submenu_hover_bgcolor ); ?>;
}

<?php // Multi Column Menu. ?>
.main-header .main-navigation-area .main-navigation ul li.mega-menu > ul.sub-menu > li > a {
	background-color: <?php echo esc_html( $submenu_hover_bgcolor ); ?>;
}

<?php // Mean Menu. ?>
.mean-container .mean-bar {
	border-color: <?php echo esc_html( $primary_color ); ?>;
}
.mean-container a.meanmenu-reveal,
.mean-container .mean-nav ul li a:hover,
.mean-container .mean-nav > ul > li.current-menu-item > a,
.mean-container .mean-nav ul li a.mean-expand {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.mean-container a.meanmenu-reveal span {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.mean-container a.meanmenu-reveal span:before {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.mean-container a.meanmenu-reveal span:after {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}

<?php // Header icon and button. ?>
.header-style-2 .header-mobile-icons a.header-login-icon i,
.header-style-2 .header-mobile-icons a.header-chat-icon i,
a.header-login-icon .rtin-text:hover {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.header-btn-area .btn {
	background: linear-gradient(to bottom, rgba(<?php echo esc_html( $secondery_rgb ); ?>, 0.9), <?php echo esc_html( $secondery_color ); ?>);
}
.header-btn-area .btn:hover {
	background: <?php echo esc_html( $secondery_color ); ?>;
}

<?php // Meanmenu Header button. ?>
.header-mobile-icons .header-menu-btn {
	background: linear-gradient(to bottom, rgba(<?php echo esc_html( $secondery_rgb ); ?>, 0.9), <?php echo esc_html( $secondery_color ); ?>);
	background: -webkit-gradient(linear, left top, left bottom, from(rgba(<?php echo esc_html( $secondery_rgb ); ?>, 0.9)), to(<?php echo esc_html( $secondery_color ); ?>));
}

<?php // Header Layout 2. ?>
.header-style-2 .main-header {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.header-style-2 .main-header .main-navigation-area .main-navigation ul.menu > li > a:hover {
	color: <?php echo esc_html( $secondery_color ); ?>;
}
.header-style-2 .main-header .main-navigation-area .main-navigation ul.menu > li.current-menu-item > a,
.header-style-2 .main-header .main-navigation-area .main-navigation ul.menu > li.current > a {
	  color: <?php echo esc_html( $secondery_color ); ?>;
}
.header-style-2 a.header-login-icon .rtin-text:hover {
	color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php // Header Listing Search. ?>
.header-style-1 .header-listing-search .header-listing-inner .classilist-listing-search {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.header-style-1 .header-listing-search .header-listing-inner .classilist-listing-search .rtin-search-btn i {
	color: <?php echo esc_html( $primary_color ); ?>;
}

<?php
/*
-------------------------------------
// . Breadcrumb
---------------------------------------*/
?>
.main-breadcrumb {
	color: <?php echo esc_html( $breadcrumb_seperator_color ); ?>;
}
.main-breadcrumb a span {
	color: <?php echo esc_html( $breadcrumb_link_color ); ?>;
}
.main-breadcrumb span {
	color: <?php echo esc_html( $breadcrumb_active_color ); ?>;
}
.main-breadcrumb a span:hover {
	color: <?php echo esc_html( $breadcrumb_link_hover_color ); ?>;
}

<?php
/*
-------------------------------------
// . Theme Defaults
---------------------------------------*/
?>
blockquote {
	border-color: <?php echo esc_html( $primary_color ); ?>;
}
blockquote:before {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
a.scrollToTop {
	background-color: rgba(<?php echo esc_html( $primary_rgb ); ?>, 0.3);
	color: <?php echo esc_html( $primary_color ); ?>;
	border-color: <?php echo esc_html( $primary_color ); ?>;
}
a.scrollToTop:hover,
a.scrollToTop:focus {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
a.rdtheme-button-1,
.rdtheme-button-1 {
	background: linear-gradient(to bottom, rgba(<?php echo esc_html( $secondery_rgb ); ?>, 0.8), <?php echo esc_html( $secondery_color ); ?>);
}
a.rdtheme-button-1:hover,
.rdtheme-button-1:hover {
	background: <?php echo esc_html( $secondery_color ); ?>;
}
a.rdtheme-button-3,
.rdtheme-button-3 {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
a.rdtheme-button-3:hover,
.rdtheme-button-3:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . Widgets
---------------------------------------*/
?>
.widget a:hover {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.widget h3:after {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.widget.widget_tag_cloud a :hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
	border-color: <?php echo esc_html( $secondery_color ); ?>;
}
.sidebar-widget-area .widget a:hover {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.sidebar-widget-area .widget ul li:before {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.sidebar-widget-area .widget.widget_tag_cloud a:hover {
	border-color: <?php echo esc_html( $secondery_color ); ?>;
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.sidebar-widget-area .widget.rtcl-widget-filter-class h3 {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.widget.widget_classilist_about ul li a:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.widget.widget_classilist_information ul li i {
	color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . Contents Area
---------------------------------------*/
?>
.pagination-area ul li:not(:first-child):not(:last-child) a:hover,
.pagination-area ul li:not(:first-child):not(:last-child).active a {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.pagination-area ul li.pagi-previous a:hover,
.pagination-area ul li.pagi-next a:hover,
.pagination-area ul li.pagi-previous span:hover,
.pagination-area ul li.pagi-next span:hover {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.pagination-area ul li.pagi-previous i,
.pagination-area ul li.pagi-next i {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.search-form .custom-search-input button.btn {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.post-each .post-meta li i {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.post-each .post-title a.entry-title:hover {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.classilist-listing-single-sidebar .classified-seller-info .rtin-box-each.rtin-socials .fa-share-alt,
.post-each .read-more-btn {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.post-each .read-more-btn i {
	color: <?php echo esc_html( $primary_color ); ?>;
}
.post-each.post-each-single .post-footer .post-tags a:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
	border-color: <?php echo esc_html( $secondery_color ); ?>;
}
.post-title-block:after,
.comment-reply-title:after {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.comments-area .main-comments .comment-meta .reply-area a {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.comments-area .comment-pagination ul li a {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
#respond form .btn-send {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
#respond form .btn-send:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.error-page .error-btn {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.error-page .error-btn:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.wpcf7-form .wpcf7-submit {
	background: linear-gradient(to bottom, rgba(<?php echo esc_html( $secondery_rgb ); ?>, 0.8), <?php echo esc_html( $secondery_color ); ?>);
}
.wpcf7-form .wpcf7-submit:hover,
.wpcf7-form .wpcf7-submit:active {
	background: <?php echo esc_html( $secondery_color ); ?>;
}

.rtcl.rtcl-elementor-widget .rtcl-list-view .rtin-el-button a.rtcl-phone-reveal:focus,
.rtcl.rtcl-elementor-widget .rtcl-list-view .rtin-el-button a.rtcl-phone-reveal:hover,
.rtcl.rtcl-elementor-widget .rtcl-list-view .rtin-el-button a:focus, 
.rtcl.rtcl-elementor-widget .rtcl-list-view .rtin-el-button a:hover {
	color: #ffffff;
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.rtcl.rtcl-elementor-widget .rtcl-grid-view .rtin-el-button a.rtcl-phone-reveal:focus,
.rtcl.rtcl-elementor-widget .rtcl-grid-view .rtin-el-button a.rtcl-phone-reveal:hover {
	color: #ffffff;
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.rt-el-listing-slider .owl-prev, 
.rt-el-listing-slider .owl-next,
.swiper-button-next, 
.swiper-button-prev {
	background-color: <?php echo esc_html( $primary_color ); ?>;
}
.rtcl.rtcl-elementor-widget .rtcl-listings .listing-item.is-featured .listing-thumb:after,
.rt-el-listing-slider .owl-prev:hover, 
.rt-el-listing-slider .owl-next:hover {
	background-color: <?php echo esc_html( $secondery_color ); ?>;
}
.top-header .top-header-inner .tophead-info li i {
	color: <?php echo esc_html( $secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . Defaults
---------------------------------------*/
?>
:root {
	--classilist-white-color: #ffffff;
	--classilist-primary-color: <?php echo esc_html( $primary_color ? $primary_color : '#1aa78e' ); ?>;
	--classilist-secondary-color: <?php echo esc_html( $secondery_color ? $secondery_color : '#fcaf01' ); ?>;
	<!-- rgb -->
	--classilist-primary-rgb-color: <?php echo esc_html( $primary_rgb ? $primary_rgb : '26, 167, 142' ); ?>;
	--classilist-secondary-rgb-color: <?php echo esc_html( $secondery_rgb ? $secondery_rgb : '252, 175, 1' ); ?>;
}

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound