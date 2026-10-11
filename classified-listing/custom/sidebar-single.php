<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.2.16
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Models\Listing;
use Rtcl\Helpers\Functions;
use RtclMarketplace\Hooks\ActionHooks;

$id                                = get_the_id();
$classilist_listing                = new Listing( $id );
$classilist_alternate_contact_form = Functions::get_option_item( 'rtcl_moderation_settings', 'alternate_contact_form_shortcode' );

$booking = get_post_meta( get_the_ID(), '_rtrb_booking_enabled', true );

?>
<div class="col-xl-3 col-lg-4 col-sm-12 col-12">
	<aside class="sidebar-widget-area">
		<div class="classilist-listing-single-sidebar">

			<?php

			if ( class_exists( 'RtclMarketplace' ) ) {
				ActionHooks::add_buy_button();
			}
			?>

			<?php do_action( 'classilist_before_sidebar' ); ?>

			<?php URI_Helper::get_custom_listing_template( 'seller-info' ); ?>
			
			<?php
			if ( function_exists( 'rtrb_cl_booking_button' ) ) {
				rtrb_cl_booking_button();
			}
			?>

			<?php do_action( 'rtcl_after_single_listing_sidebar', $classilist_listing->get_id() ); ?>
			
			<?php
			do_action( 'rtcl_add_user_information', $id );

			if ( is_active_sidebar( 'rtcl-single-sidebar' ) ) {
				dynamic_sidebar( 'rtcl-single-sidebar' );
			}
			do_action( 'classilist_after_sidebar' );
			?>

			<div class="modal fade" id="classilist-mail-to-seller" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" data-hide="0">
							<?php
							if ( $classilist_alternate_contact_form ) {
								echo sprintf( '<div id="rtcl-contact-form">%s</div>', do_shortcode( $classilist_alternate_contact_form ) );
							} else {
								$classilist_listing->email_to_seller_form();
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
</div>