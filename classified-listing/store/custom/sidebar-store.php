<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.15
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;
use RtclPro\Helpers\Fns;

global $store;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$store_oh_type  = get_post_meta( $store->get_id(), 'oh_type', true );
$store_oh_hours = get_post_meta( $store->get_id(), 'oh_hours', true );
$store_oh_hours = is_array( $store_oh_hours ) ? $store_oh_hours : ( $store_oh_hours ? (array) $store_oh_hours : [] );
$today          = strtolower( gmdate( 'l' ) );

$oh_current_hour = [];
$now_status      = '';
$now_open        = false;

if ( 'selected' == $store_oh_type && ! empty( $store_oh_hours ) && isset( $store_oh_hours[ $today ]['active'] ) ) {
	$oh_current_hour = $store_oh_hours[ $today ];
	$now_status      = esc_attr__( 'Close now', 'classilist' );
	$local           = get_date_from_gmt( gmdate( 'Y-m-d H:i:s' ) );
	$now             = \DateTime::createFromFormat( 'Y-m-d H:i:s', $local );
	$date_open       = new \DateTime( $store_oh_hours[ $today ]['open'] ?? '9:00 AM' );
	$date_close      = new \DateTime( $store_oh_hours[ $today ]['close'] ?? '9:00 PM' );
	if ( $now >= $date_open && $now <= $date_close ) {
		$now_status = esc_attr__( 'Open now', 'classilist' );
		$now_open   = true;
	}
}

$store_address  = $store->get_address();
$store_phone    = $store->get_phone();
$store_whatsapp = $store->get_whatsapp();
$store_website  = $store->get_website();
$store_email    = $store->get_email();

?>
<div class="classilist-listing-single-sidebar classilist-store-sidebar">
	<div class="classified-seller-info widget">
		<h3 class="widgettitle"><?php esc_html_e( 'Store Information', 'classilist' ); ?></h3>
		<div class="rtin-box">

			<?php if ( Fns::registered_user_only( 'store_contact' ) && ! is_user_logged_in() ) { ?>
				<div class="rtin-box-each media rtin-logoutp-info-box">
					<?php /* translators: %s is the URL to the login/my account page. */ echo wp_kses( sprintf( __( "Please <a href='%s'>login</a> to view the store contact.", 'classilist' ), esc_url( Link::get_my_account_page_link() ) ), [ 'a' => [ 'href' => [] ] ] ); ?>
				</div>
			<?php } else { ?>
				<div class="rtin-box-each media rtin-name">
					<div class="rtin-left pull-left"><i class="far fa-clock" aria-hidden="true"></i></div>
					<div class="media-body">
						<div class="rtin-store-time">
							<?php
							URI_Helper::get_custom_store_template(
								'store-time',
								true,
								[
									'store_oh_type'   => $store_oh_type,
									'store_oh_hours'  => $store_oh_hours,
									'oh_current_hour' => $oh_current_hour,
									'now_status'      => $now_status,
									'now_open'        => $now_open,
									'today'           => $today,
								]
							);
							?>
						</div>
					</div>
				</div>

				<?php if ( $store_address ) : ?>
					<div class="rtin-box-each media rtin-location">
						<div class="rtin-left pull-left"><i class="fas fa-map-marker-alt"></i></div>
						<div class="media-body">
							<div class="rtin-label"><?php esc_html_e( 'Location', 'classilist' ); ?></div>
							<div class="rtin-title"><?php echo esc_html( $store_address ); ?></div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $store_phone && Functions::check_visibility( $store->owner_id(), 'whatsapp' ) ) : ?>
					<div class="rtin-box-each media rtin-phone">
						<div class="rtin-left pull-left"><i class="fa fa-mobile" aria-hidden="true"></i></div>
						<div class="media-body">
							<div class="rtin-label"><?php esc_html_e( 'Contact Number', 'classilist' ); ?></div>
							<div class="rtin-title"><?php Listing_Functions::the_phone( $store_phone ); ?></div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $store_whatsapp && Functions::check_visibility( $store->owner_id(), 'whatsapp' ) ) : ?>
					<div class="rtin-box-each media rtin-phone">
						<div class="rtin-left pull-left"><i class="fa fa-mobile" aria-hidden="true"></i></div>
						<div class="media-body">
							<div class="rtin-label"><?php esc_html_e( 'Whatsapp Number', 'classilist' ); ?></div>
							<div class="rtin-title"><?php Listing_Functions::the_phone( $store_whatsapp ); ?></div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $store->get_social_media() ) : ?>
					<div class="rtin-box-each media rtin-socials classilist-store-socials">
						<div class="rtin-left pull-left"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
						<div class="media-body">
							<div class="rtin-title"><?php echo wp_kses_post( $store->get_social_media_html() ); ?></div>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ( $store_website ) : ?>
					<div class="rtin-box-each media rtin-website">
						<div class="rtin-left pull-left"><i class="fa fa-globe" aria-hidden="true"></i></div>
						<div class="media-body">
							<div class="rtin-title"><a target="_blank" href="<?php echo esc_url_raw( $store_website ); ?>"><?php esc_html_e( 'Visit Website', 'classilist' ); ?></a></div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $store_email && Functions::check_visibility( $store->owner_id(), 'email' ) ) : ?>
					<div class="rtin-box-each media rtin-email">
						<div class="rtin-left pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></div>
						<div class="media-body">
							<div class="rtin-title"><a data-toggle="modal" data-target="#classilist-mail-to-seller" href="#"><?php esc_html_e( 'Email to Store Owner', 'classilist' ); ?></a></div>
						</div>
					</div>
					<div class="modal fade" id="classilist-mail-to-seller" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body" data-hide="0"><?php Functions::get_template( 'store/contact-form', null, '', rtclStore()->get_plugin_template_path() ); ?></div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php } ?>
		</div>
	</div>
</div>