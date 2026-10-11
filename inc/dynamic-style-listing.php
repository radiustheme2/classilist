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
// . Listing Search
// . Single Listing
// . Archive Listing
// . Grid View
// . List View
// . Listing Form
// . My Account
// . Checkout
// . WooCommerce
// . Store
-------------------------------------*/

$classilist_prefix        = Constants::$theme_prefix;
$classilist_primary_color = apply_filters( "{$classilist_prefix}_primary_color", RDTheme::$options['primary_color'] ); // #1aa78e.
$classilist_secondery_color          = apply_filters( "{$classilist_prefix}_secondery_color", RDTheme::$options['secondery_color'] ); // #fcaf01.
$classilist_primary_rgb              = Helper::hex2rgb( $classilist_primary_color ); // 26, 167, 142
$classilist_secondery_rgb            = Helper::hex2rgb( $classilist_secondery_color ); // 252, 175, 1
?>

<?php
/*
-------------------------------------
// . Listing Search
---------------------------------------*/
?>
.classilist-listing-search .rtcl-search-inline-form .rtcl-search-input-button {
	border-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-search .rtcl-search-inline-form .rtcl-search-input-button:before {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-search .rtcl-search-inline-form .rtin-search-btn {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-search .rtcl-search-inline-form .rtin-search-btn:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.rtcl-ui-modal .rtcl-modal-wrapper .rtcl-modal-content .rtcl-ui-select-list-wrap .rtcl-ui-select-list ul li a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php
/*
-------------------------------------
// . Single Listing
---------------------------------------*/
?>
.classilist-listing-single .owl-carousel .owl-nav [class*=owl-] {
	border-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-single .owl-carousel .owl-nav [class*=owl-]:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-single .classilist-single-details .rtin-slider-box #rtcl-slider-wrapper .rtcl-listing-gallery__trigger {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.classilist-listing-single .classilist-single-details .single-listing-meta-wrap .single-listing-meta li i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-listing-single .classilist-single-details .rtin-price {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.classilist-listing-single .classilist-single-details .rtcl-single-listing-action li a:hover {
	color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
#classilist-mail-to-seller .btn {
	 background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#classilist-mail-to-seller .btn:hover,
#classilist-mail-to-seller .btn:active {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.review-area .comment .comment-meta .comment-meta-left .comment-info .c-author {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-social-profile-wrap .rtcl-social-profiles a:hover i {
	color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . Archive Listing
---------------------------------------*/
?>
a#classilist-toggle-sidebar {
	background: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.sidebar-widget-area .widget .rtcl-widget-categories ul.rtcl-category-list li a:hover,
.sidebar-widget-area .widget .rtcl-widget-categories ul.rtcl-category-list li.rtcl-active > a {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.sidebar-widget-area .rtcl-widget-filter-class .panel-block .ui-accordion-item .ui-accordion-content .filter-list li.has-sub .arrow {
	border-top-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.sidebar-widget-area .rtcl-widget-filter-class .panel-block .ui-accordion-item .ui-accordion-content .filter-list li .sub-list li a:before {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.sidebar-widget-area .rtcl-widget-filter-class .panel-block .rtcl-filter-form .ui-buttons .btn {
  background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.site-content .listing-archive-top .listing-sorting .rtcl-view-switcher > a.active i,
.site-content .listing-archive-top .listing-sorting .rtcl-view-switcher > a:hover i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.topad-sign {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-range-slider-field input[type=range]::-webkit-slider-thumb {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-range-slider-field input[type=range]::-moz-range-thumb {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-range-slider-field input[type=range]::-ms-thumb {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-range-slider-field input[type=range]:focus::-ms-fill-lower {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-range-slider-field input[type=range]::-ms-fill-lower {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtrs-review-wrap .rtrs-review-form .rtrs-form-group .rtrs-submit-btn {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?> !important;
}
.rtrs-review-wrap .rtrs-review-form .rtrs-form-group .rtrs-submit-btn:hover,
.rtrs-review-wrap .rtrs-review-box .rtrs-review-body .rtrs-reply-btn .rtrs-item-btn:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?> !important;
}
<?php
/*
-------------------------------------
// . Grid View
---------------------------------------*/
?>
.listing-grid-each .rtin-item .rtin-content .rtin-meta li i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-grid-each.featured-listing .rtin-thumb:after {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-grid-each-1 .rtin-item .rtin-content .rtin-title a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-grid-each-2 .rtin-listing-features > div a {
	background-color: rgba(<?php echo esc_html( $classilist_primary_rgb ); ?>, 0.7);
}
.listing-grid-each-2 .rtin-listing-features > div a:hover {
	background-color: rgba(<?php echo esc_html( $classilist_primary_rgb ); ?>, 1);
}
.rtcl-quick-view-container .rtcl-qv-summary .rtcl-qv-price,
.rtcl-quick-view-container .rtcl-qv-summary .rtcl-qv-title a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#rtcl-compare-wrap .rtcl-compare-item h4.rtcl-compare-item-title a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-grid-each-2 .rtin-item .rtin-content .rtin-title a:hover,
.rtcl-compare-table .rtcl-compare-table-title h3 a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#rtcl-compare-panel-btn span.rtcl-compare-listing-count {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
#rtcl-compare-btn-wrap a.rtcl-compare-btn:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.listing-list-each-2 .rtin-item .rtin-right .rtin-price {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . List View
---------------------------------------*/
?>
.listing-list-each.featured-listing .rtin-thumb:after {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-list-each-1 .rtin-item .rtin-content .rtin-title a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-list-each-2 .rtin-item .rtin-content .rtin-meta li i,
.listing-list-each-1 .rtin-item .rtin-content .rtin-meta li i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-list-each-1 .rtin-item .rtin-right .rtin-price {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.listing-list-each-alt .rtin-item .rtin-content .rtin-title a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-list-each-2 .rtin-item .rtin-listing-features > div .rtcl-icon,
.listing-list-each-2 .rtin-item .rtin-listing-features > div i.fa,
.listing-list-each-alt .rtin-item .rtin-content .rtin-meta li i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.listing-list-each-2 .rtin-item .rtin-content .rtin-title a:hover,
.listing-list-each-2 .rtin-item .rtin-listing-features a:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#rtcl-compare-btn-wrap a.rtcl-compare-btn,
#rtcl-compare-panel-btn {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php
/*
-------------------------------------
// . Listing Details
---------------------------------------*/
?>
.classilist-listing-single .classilist-single-details .single-listing-meta-wrap .single-listing-meta li a:hover,
.rtcl-user-single-wrapper .rtcl-user-info-wrap .rtcl-user-info a:hover {
	
}

<?php
/*
-------------------------------------
// . Listing Form
---------------------------------------*/
?>
.classilist-form .classified-listing-form-title i {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-form .rtcl-gallery-uploads .rtcl-gallery-upload-item a {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-form .rtcl-gallery-uploads .rtcl-gallery-upload-item a:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.classilist-form .rtcl-submit-btn {
	background: linear-gradient(to bottom, rgba(<?php echo esc_html( $classilist_secondery_rgb ); ?>, 0.8), <?php echo esc_html( $classilist_secondery_color ); ?>);
}
.classilist-form .rtcl-submit-btn:hover,
.classilist-form .rtcl-submit-btn:active {
	background: <?php echo esc_html( $classilist_secondery_color ); ?>;
}

<?php
/*
-------------------------------------
// . My Account
---------------------------------------*/
?>
.classilist-myaccount .sidebar-widget-area .rtcl-MyAccount-navigation li.is-active,
.classilist-myaccount .sidebar-widget-area .rtcl-MyAccount-navigation li:hover {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-myaccount .sidebar-widget-area .rtcl-MyAccount-navigation li.rtcl-MyAccount-navigation-link--chat span.rtcl-unread-badge {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.classilist-myaccount .sidebar-widget-area .rtcl-MyAccount-navigation li.rtcl-MyAccount-navigation-link--chat:hover span.rtcl-unread-badge {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}


#rtcl-user-login-wrapper .btn,
.rtcl .rtcl-login-form-wrap .btn,
#rtcl-lost-password-form .btn {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#rtcl-user-login-wrapper .btn:hover,
.rtcl .rtcl-login-form-wrap .btn:hover,
#rtcl-lost-password-form .btn:hover,
#rtcl-user-login-wrapper .btn:active,
.rtcl .rtcl-login-form-wrap .btn:active,
#rtcl-lost-password-form .btn:active {
	background: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.rtcl-account .rtcl-ui-modal .rtcl-modal-wrapper .rtcl-modal-content .rtcl-modal-body .btn-success {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
	border-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-account .rtcl-ui-modal .rtcl-modal-wrapper .rtcl-modal-content .rtcl-modal-body .form-control:focus {
	border-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
#rtcl-store-managers-content .rtcl-store-manager-action .rtcl-store-invite-manager:hover,
#rtcl-store-managers-content .rtcl-store-manager-action .rtcl-store-invite-manager:active,
#rtcl-store-managers-content .rtcl-store-manager-action .rtcl-store-invite-manager:focus {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
	border-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.rtcl-store-content .rtcl-store-manager .rtcl-store-m-info a:hover,
.rtcl-account-sub-menu ul li.active a,
.rtcl-account-sub-menu ul li:hover a {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.rtcl-MyAccount-content .rtcl-listings .rtcl-account-sub-menu ul li.active a,
.rtcl-MyAccount-content .rtcl-listings .rtcl-account-sub-menu ul a:hover {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
<?php
/*
-------------------------------------
// . Checkout
---------------------------------------*/
?>
.rtcl-checkout-form-wrap .btn:hover,
.rtcl-checkout-form-wrap .btn:active,
.rtcl-checkout-form-wrap .btn:focus {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?> !important;
}

<?php
/*
-------------------------------------
// . WooCommerce
---------------------------------------*/
?>
.woocommerce button.button {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce button.button:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.woocommerce-info {
	border-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce-info:before {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce-checkout .woocommerce .checkout #payment .place-order button#place_order,
.woocommerce form .woocommerce-address-fields #payment .place-order button#place_order {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce-checkout .woocommerce .checkout #payment .place-order button#place_order:hover,
.woocommerce form .woocommerce-address-fields #payment .place-order button#place_order:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}
.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a,
.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a:hover,
.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li a:hover {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php
/*
-------------------------------------
// . Store
---------------------------------------*/
?>
.classilist-store-single .classilist-store-contents .rtin-store-label:after {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}

<?php
/*
-------------------------------------
// . WooCommerce
---------------------------------------*/
?>
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce .widget_products ul.product_list_widget li a:hover,
.woocommerce ul.products li.product .woocommerce-loop-product__title:hover {
	color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt, .woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce span.onsale,
.woocommerce ul.products li.product .button {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce #respond input#submit.alt.disabled,
.woocommerce #respond input#submit.alt.disabled:hover,
.woocommerce #respond input#submit.alt:disabled,
.woocommerce #respond input#submit.alt:disabled:hover,
.woocommerce #respond input#submit.alt:disabled[disabled],
.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
.woocommerce a.button.alt.disabled,
.woocommerce a.button.alt.disabled:hover,
.woocommerce a.button.alt:disabled,
.woocommerce a.button.alt:disabled:hover,
.woocommerce a.button.alt:disabled[disabled],
.woocommerce a.button.alt:disabled[disabled]:hover,
.woocommerce button.button.alt.disabled,
.woocommerce button.button.alt.disabled:hover,
.woocommerce button.button.alt:disabled,
.woocommerce button.button.alt:disabled:hover,
.woocommerce button.button.alt:disabled[disabled],
.woocommerce button.button.alt:disabled[disabled]:hover,
.woocommerce input.button.alt.disabled,
.woocommerce input.button.alt.disabled:hover,
.woocommerce input.button.alt:disabled,
.woocommerce input.button.alt:disabled:hover,
.woocommerce input.button.alt:disabled[disabled],
.woocommerce input.button.alt:disabled[disabled]:hover {
	background-color: <?php echo esc_html( $classilist_primary_color ); ?>;
}
.woocommerce #respond input#submit:hover,
.woocommerce a.button:hover,
.woocommerce button.button:hover,
.woocommerce input.button:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce .woocommerce-product-search button:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce ul.products li.product .button:hover {
	background-color: <?php echo esc_html( $classilist_secondery_color ); ?>;
}