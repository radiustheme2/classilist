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
use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RtclPro\Controllers\Hooks\TemplateHooks;

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

$id                 = get_the_id();
$classilist_listing = new Listing( $id );

$classilist_prefix = Constants::$theme_prefix;

$classilist_video = [];
if ( ! Functions::is_video_urls_disabled() ) {
	$classilist_video = get_post_meta( $classilist_listing->get_id(), '_rtcl_video_urls', true );
	$classilist_video = ! empty( $classilist_video ) && is_array( $classilist_video ) ? $classilist_video : [];
}
$classilist_images        = Functions::get_listing_images( $id );
$classilist_slider_class  = ! empty( $classilist_video ) || Functions::get_listing_images( $id ) ? '' : ' no-gallery-image';
$classilist_slider_class .= method_exists( 'RtclPro\Helpers\Fns', 'is_mark_as_sold' ) && Fns::is_mark_as_sold( $classilist_listing->get_id() ) ? ' is-sold' : '';

$classilist_time_format = apply_filters( 'classilist_single_listing_time_format', 'F j, Y g:i a' );
$classilist_date        = date_i18n( $classilist_time_format, get_the_time( 'U' ) );

?>

<div class="site-content-block classilist-single-details">
	<div class="main-content">
		<?php do_action( 'classilist_single_listing_before_contents' ); ?>
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
		<?php
		if ( ! empty( $classilist_images || $classilist_video ) ) {
			?>
		<div class="rtin-slider-box<?php echo esc_attr( $classilist_slider_class ); ?>">
			<?php TemplateHooks::sold_out_banner(); ?>
			<?php $classilist_listing->the_gallery(); ?>
		</div>
		<?php } if ( $classilist_listing->can_show_price() ) : ?>
			<div class="rtin-price"><?php Functions::print_html( $classilist_listing->get_price_html() ); ?></div>
		<?php endif; ?>

		<div class="row">
			<div class="col-12 col-md-8">
				<div class="rtin-content"><?php $classilist_listing->the_content(); ?></div>
			</div>
			<div class="col-12 col-md-4">
				<?php $classilist_listing->the_actions(); ?>
			</div>
		</div>
		<?php do_action( 'classilist_single_listing_after_contents' ); ?>
	</div>
</div>

<?php
if ( Functions::isEnableFb() ) {
	URI_Helper::get_custom_listing_template( 'form-builder-cfg' );
} else {
	$classilist_listing->the_custom_fields();
}
?>