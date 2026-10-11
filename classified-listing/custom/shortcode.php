<?php
/**
 * jetpack.
 *
 * @link https://jetpack.com/
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RtclPro\Helpers\Fns;
use Rtcl\Models\Listing;
use Rtcl\Helpers\Functions;
use RtclMarketplace\Hooks\ActionHooks;
use RtclPro\Controllers\Hooks\TemplateHooks;

/**
 * ThemeJetpack Class
 */
class Shortcode {

	/**
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * @var array[]
	 */
	public static $shortcode_list = [
		'header'         => [
			'tag'      => 'classilsit_listing_header',
			'callback' => 'render_listing_header',
		],
		'gallery_slider' => [
			'tag'      => 'classilsit_gallery_slider',
			'callback' => 'render_listing_gallery_slider',
		],
		'description'    => [
			'tag'      => 'classilsit_listing_description',
			'callback' => 'render_listing_description',
		],
		'custom_fields'  => [
			'tag'      => 'classilsit_listing_custom_fields',
			'callback' => 'render_listing_custom_fields',
		],
		'video'          => [
			'tag'      => 'classilsit_listing_video',
			'callback' => 'render_listing_video',
		],
		'map'            => [
			'tag'      => 'classilsit_listing_map',
			'callback' => 'render_listing_map',
		],
		'review'         => [
			'tag'      => 'classilsit_listing_review',
			'callback' => 'render_listing_review',
		],
		'sidebar'        => [
			'tag'      => 'classilsit_listing_sidebar',
			'callback' => 'render_listing_sidebar',
		],
	];

	/**
	 * register default hooks and actions for WordPress
	 *
	 * @return
	 */
	public function __construct() {
		add_filter(
			'rtcl/fb/single_layout/fields',
			function ( $fields ) {
				$shortcode_hints = '';
				foreach ( self::$shortcode_list as $label => $shortcode ) {
					$shortcode_hints .= '<br><b>' . ucfirst( $label ) . ":</b> [{$shortcode['tag']}]";
				}

				$fields['shortcode']['editor']['hints']['value'] = 'Available Shortcodes: ' . $shortcode_hints;

				return $fields;
			}
		);

		foreach ( self::$shortcode_list as $shortcode ) {
			add_shortcode( $shortcode['tag'], [ $this, $shortcode['callback'] ] );
		}
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return false|string
	 */
	public function render_listing_header() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		$id                     = get_the_id();
		$classilist_listing     = new Listing( $id );
		$classilist_time_format = apply_filters( 'classilist_single_listing_time_format', 'F j, Y g:i a' );
		$classilist_date        = date_i18n( $classilist_time_format, get_the_time( 'U' ) );

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();
			?>
			<div class="classilist-single-details">
				<div class="single-listing-meta-wrap">
					<div class="rtin-left">
						<h1 class="single-listing-title"><?php the_title(); ?></h1>
						<ul class="single-listing-meta">
							<?php
							if ( $classilist_listing->can_show_user() ) :
								if ( $classilist_listing->can_add_user_link() && ! is_author() ) :
									?>
									<li class="rtin-usermeta"><i class="far fa-user"></i>
										<a href="<?php echo esc_url( $classilist_listing->get_the_author_url() ); ?>">
											<?php $classilist_listing->the_author(); ?>
											<?php do_action( 'rtcl_after_author_meta', $classilist_listing->get_owner_id() ); ?>
										</a>
									</li>
								<?php else : ?>
									<li class="rtin-usermeta"><i class="far fa-user"></i>
										<?php $classilist_listing->the_author(); ?>
										<?php do_action( 'rtcl_after_author_meta', $classilist_listing->get_owner_id() ); ?>
									</li>
									<?php
								endif;
							endif;
							?>
							<?php if ( $classilist_listing->can_show_date() ) : ?>
								<li><i class="far fa-clock"></i><?php echo esc_html( $classilist_date ); ?></li>
							<?php endif; ?>

							<?php if ( $classilist_listing->has_location() && $classilist_listing->can_show_location() ) : ?>
								<li><i class="fas fa-map-marker-alt"></i><?php $classilist_listing->the_locations( true, true ); ?></li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="rtin-right">
						<?php $classilist_listing->the_badges(); ?>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_gallery_slider() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		$id                 = get_the_id();
		$classilist_listing = new Listing( $id );

		$classilist_video = [];
		if ( ! Functions::is_video_urls_disabled() ) {
			$classilist_video = get_post_meta( $classilist_listing->get_id(), '_rtcl_video_urls', true );
			$classilist_video = ! empty( $classilist_video ) && is_array( $classilist_video ) ? $classilist_video : [];
		}
		$classilist_images        = Functions::get_listing_images( $id );
		$classilist_slider_class  = ! empty( $classilist_video ) || Functions::get_listing_images( $id ) ? '' : ' no-gallery-image';
		$classilist_slider_class .= method_exists( 'RtclPro\Helpers\Fns', 'is_mark_as_sold' ) && Fns::is_mark_as_sold( $classilist_listing->get_id() ) ? ' is-sold' : '';

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();
			?>

			<?php
			if ( ! empty( $classilist_images || $classilist_video ) ) {
				?>
				<div class="rtin-slider-box<?php echo esc_attr( $classilist_slider_class ); ?>">
					<?php TemplateHooks::sold_out_banner(); ?>
					<?php $classilist_listing->the_gallery(); ?>
				</div>
			<?php } ?>

			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_description() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		$id                 = get_the_id();
		$classilist_listing = new Listing( $id );

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();
			?>

			<!-- Description -->
			<div class="classilist-single-details">
				<?php if ( $classilist_listing->can_show_price() ) : ?>
					<div class="rtin-price"><?php Functions::print_html( $classilist_listing->get_price_html() ); ?></div>
				<?php endif; ?>
				<?php if ( $listing->get_the_content() ) { ?>
					<div class="row">
						<div class="col-12 col-md-8">
							<div class="rtin-content"><?php $classilist_listing->the_content(); ?></div>
						</div>
						<div class="col-12 col-md-4">
							<?php $classilist_listing->the_actions(); ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_custom_fields() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		$id                 = get_the_id();
		$classilist_listing = new Listing( $id );

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			if ( Functions::isEnableFb() && Listing_Functions::form_builder_custom_group_field_check() ) {
				URI_Helper::get_custom_listing_template( 'form-builder-cfg' );
			} else {
				$classilist_listing->the_custom_fields();
			}

			return ob_get_clean();
		}

		return '';
	}


	/**
	 * @return false|string
	 */
	public function render_listing_video() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			$video_urls = [];
			if ( ! Functions::is_video_urls_disabled() ) {
				$video_urls = get_post_meta( $listing->get_id(), '_rtcl_video_urls', true );
				$video_urls = ! empty( $video_urls ) && is_array( $video_urls ) ? $video_urls : [];
			}

			?>

			<!-- Video -->
			<?php if ( ! empty( $video_urls ) ) { ?>
			<div class="content-block-gap"></div>
			<div class="classilsit-listing-video">
				<div class="rtcl-section-heading">
					<h3><?php esc_html_e( 'Video', 'classilsit' ); ?></h3>
				</div>
				<div class="ratio ratio-16x9">
					<iframe class="rtcl-lightbox-iframe" src="<?php echo esc_url( Functions::get_sanitized_embed_url( $video_urls[0] ) ); ?>"></iframe>
				</div>
			</div>
			<?php } ?>

			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_map() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			$id                 = get_the_id();
			$classilist_listing = new Listing( $id );

			// Map.
			do_action( 'rtcl_single_listing_content_end', $classilist_listing );

			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_review() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			// Review.
			do_action( 'rtcl_single_listing_review' );

			return ob_get_clean();
		}

		return '';
	}

	/**
	 * Listing sidebar
	 *
	 * @return false|string
	 */
	public function render_listing_sidebar() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		$id                                = get_the_id();
		$classilist_listing                = new Listing( $id );
		$classilist_alternate_contact_form = Functions::get_option_item( 'rtcl_moderation_settings', 'alternate_contact_form_shortcode' );

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			?>

			<aside class="sidebar-widget-area">
				<div class="classilist-listing-single-sidebar">

					<?php
					if ( class_exists( 'RtclMarketplace' ) ) {
						ActionHooks::add_buy_button();
					}
					?>

					<?php do_action( 'classilist_before_sidebar' ); ?>

					<?php URI_Helper::get_custom_listing_template( 'seller-info' ); ?>

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

			<?php
			return ob_get_clean();
		}

		return '';
	}
}

Shortcode::instance();
