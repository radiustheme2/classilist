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

use Rtcl\Models\Listing;
use Rtcl\Helpers\Link;
use Rtcl\Helpers\Functions;
use RtclPro\Helpers\Fns;

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$classilist_id          = get_the_id();
$listing                = new Listing( $classilist_id );
$email                  = get_post_meta( $classilist_id, 'email', true );
$website                = get_post_meta( $classilist_id, 'website', true );
$phone                  = get_post_meta( $classilist_id, 'phone', true );
$whatsapp               = get_post_meta( $classilist_id, '_rtcl_whatsapp_number', true );
$has_contact_form       = Functions::get_option_item( 'rtcl_single_listing_settings', 'has_contact_form', false, 'checkbox' );
$alternate_contact_form = Functions::get_option_item( 'rtcl_moderation_settings', 'alternate_contact_form_shortcode' );


$classilist_status      = apply_filters( 'rtcl_user_offline_text', 'offline' );
$classilist_status_text = esc_html__( 'Offline Now', 'classilist' );
if ( Fns::is_online( $listing->get_owner_id() ) ) {
	$classilist_status      = apply_filters( 'rtcl_user_online_text', 'online' );
	$classilist_status_text = esc_html__( 'Online Now', 'classilist' );
}
?>
<div class="classified-seller-info widget">
	<h3 class="widgettitle"><?php esc_html_e( 'Seller Information', 'classilist' ); ?></h3>
	<div class="rtin-box">

		<?php if ( $listing->can_show_user() ) : ?>
			<div class="rtin-box-each media rtin-name">
				<div class="rtin-left pull-left">
					<i class="fa fa-user" aria-hidden="true"></i>
					<span class="<?php echo esc_attr( $classilist_status ); ?> js-btn-tooltip" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo esc_attr( $classilist_status_text ); ?>"></span>
				</div>
				<div class="media-body">
					<div class="rtin-label"><?php esc_html_e( 'Posted By', 'classilist' ); ?></div>
					<div class="rtin-title">
						<?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
							<a class="author-link" href="<?php echo esc_url( $listing->get_the_author_url() ); ?>">
								<?php echo esc_html( $listing->get_author_name() ); ?>
							</a>
						<?php else : ?>
							<?php echo wp_kses_post( $listing->get_author_name() ); ?>
						<?php endif; ?>
						<?php do_action( 'rtcl_after_author_meta', $listing->get_owner_id() ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( Fns::registered_user_only( 'listing_seller_information' ) && ! is_user_logged_in() ) { ?>
			<p class="login-message"><?php /* translators: %s is the URL to the login/my account page. */ echo wp_kses( sprintf( __( "Please <a href='%s'>login</a> to view the seller information.", 'classilist' ), esc_url( Link::get_my_account_page_link() ) ), [ 'a' => [ 'href' => [] ] ] ); ?></p>
		<?php } else { ?>

			<?php
			$address = Listing_Functions::get_single_contact_address( $listing );
			if ( $address ) :
				?>
				<div class="rtin-box-each media rtin-location">
					<div class="rtin-left pull-left"><i class="fas fa-map-marker-alt"></i></div>
					<div class="media-body">
						<div class="rtin-label"><?php esc_html_e( 'Location', 'classilist' ); ?></div>
						<div class="rtin-title"><?php echo wp_kses_post( $address ); ?></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $phone && Functions::check_visibility( $listing->get_author_id(), 'phone' ) ) : ?>
				<div class="rtin-box-each media rtin-phone">
					<div class="rtin-left pull-left"><i class="fas fa-mobile-alt"></i></div>
					<div class="media-body">
						<div class="rtin-label"><?php esc_html_e( 'Phone Number', 'classilist' ); ?></div>
						<div class="rtin-title"><?php Listing_Functions::seller_phone_number( $listing ); ?></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $whatsapp && Functions::check_visibility( $listing->get_author_id(), 'whatsapp' ) ) : ?>
				<div class="rtin-box-each media rtin-whatsapp">
					<div class="rtin-left pull-left"><i class="fab fa fa-whatsapp"></i></div>
					<div class="media-body">
						<div class="rtin-label"><?php esc_html_e( 'Whatsapp Number', 'classilist' ); ?></div>
						<div class="rtin-title"><?php Listing_Functions::seller_whatsapp_number( $listing ); ?></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $email && Functions::check_visibility( $listing->get_author_id(), 'email' ) ) : ?>
				<div class="rtin-box-each media rtin-mail">
					<div class="rtin-left pull-left"><i class="fa-regular fa-envelope"></i></div>
					<div class="media-body">
						<div class="rtin-label"><?php esc_html_e( 'Email Address', 'classilist' ); ?></div>
						<div class="rtin-title"><a href="emailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $website ) : ?>
				<div class="rtin-box-each media rtin-website">
					<div class="rtin-left pull-left"><i class="fa fa-globe" aria-hidden="true"></i></div>
					<div class="media-body">
						<div class="rtin-label"><?php esc_html_e( 'Visit Website', 'classilist' ); ?></div>
						<div class="rtin-title"><a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php esc_html_e( 'Click Here', 'classilist' ); ?></a></div>
					</div>
				</div>
			<?php endif; ?>

			<?php
			if ( Fns::is_enable_chat() && ( ( is_user_logged_in() && $listing->get_author_id() !== get_current_user_id() ) || ! is_user_logged_in() ) ) :
					$chat_btn_class = [ 'rtcl-chat-link' ];
					$chat_url       = Link::get_my_account_page_link();
				if ( is_user_logged_in() ) {
					$chat_url = '#';
					array_push( $chat_btn_class, 'rtcl-contact-seller' );
				} else {
					array_push( $chat_btn_class, 'rtcl-no-contact-seller' );
				}
				?>
				<div class="rtin-box-each media rtin-chat">
					<div class="rtin-left pull-left"><i class="fa fa-comments" aria-hidden="true"></i></div>
					<div class="media-body">
						<div class="rtin-title"><a class="<?php echo esc_attr( implode( ' ', $chat_btn_class ) ); ?>" data-listing_id="<?php the_ID(); ?>" href="<?php echo esc_url( $chat_url ); ?>"><?php esc_html_e( 'Chat with Seller', 'classilist' ); ?></a></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $has_contact_form && ( $email || $alternate_contact_form ) ) : ?>
				<div class="rtin-box-each media rtin-email">
					<div class="rtin-left pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></div>
					<div class="media-body">
						<div class="rtin-title"><a data-toggle="modal" data-target="#classilist-mail-to-seller" href="#"><?php esc_html_e( 'Email to Seller', 'classilist' ); ?></a></div>
					</div>
				</div>
			<?php endif; ?>
		<?php } ?>
	</div>
</div>

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound