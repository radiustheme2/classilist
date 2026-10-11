<?php
/**
 * Store single content
 *
 * @author     RadiusTheme
 * @package    classified-listing/templates
 * @version    1.3.21
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use radiustheme\ClassiList\URI_Helper;
use Rtcl\Helpers\Functions;
use RtclStore\Helpers\Functions as StoreFunctions;

global $store;

if ( StoreFunctions::is_store_expired() ) {
	do_action( 'rtcl_single_store_expired_content' );
	return;
}

$classilist_banner_class = $store->get_banner_url() ? '' : ' rtin-noimage';
?>
<div class="rtin-banner-wrap">
	<div class="rtin-banner-img<?php echo esc_attr( $classilist_banner_class ); ?>">
		<?php if ( ! $classilist_banner_class ) : ?>
			<?php $store->the_banner(); ?>
		<?php endif; ?>
	</div>
	<div class="rtin-banner-content">
		<?php if ( $store->get_logo_url() ) : ?>
			<div class="rtin-logo"><?php $store->the_logo(); ?></div>
		<?php endif; ?>
		<div class="rtin-store-title-area">
			<h1 class="rtin-store-title"><?php $store->the_title(); ?></h1>
			<?php if ( $store->get_the_slogan() ) : ?>
				<div class="rtin-store-slogan"><?php $store->the_slogan(); ?></div>
			<?php endif; ?>
			<div class="rating-category">
				<?php if ( $store->is_rating_enable() ) : ?>
					<div class="store-rating">
						<?php if ( $store->get_review_counts() ) : ?>
							<?php echo wp_kses_post( Functions::get_rating_html( $store->get_average_rating(), $store->get_review_counts() ) ); ?><span class="reviews-rating-count">(<?php echo absint( $store->get_review_counts() ); ?>)</span>
						<?php else : ?>
							<span class="no-rating"><?php esc_html_e( 'No Ratings', 'classilist' ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $store->get_category() ) : ?>
					<div class="rtcl-store-cat">
						<i class="rtcl-icon rtcl-icon-tags"></i>
						<?php Functions::print_html( $store->get_category() ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-9 col-lg-8 col-sm-12 col-12">
		<?php URI_Helper::get_custom_store_template( 'store-contents', true, get_defined_vars() ); ?>
	</div>
	<div class="col-xl-3 col-lg-4 col-sm-12 col-12">
		<aside class="sidebar-widget-area">
			<?php URI_Helper::get_custom_store_template( 'sidebar-store', true, get_defined_vars() ); ?>
		</aside>
	</div>
</div>