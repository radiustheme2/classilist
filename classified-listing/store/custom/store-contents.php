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

use Rtcl\Helpers\Functions;

global $store;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$store_oh_type  = get_post_meta( $store->get_id(), 'oh_type', true );
$store_oh_hours = get_post_meta( $store->get_id(), 'oh_hours', true );
$store_oh_hours = is_array( $store_oh_hours ) ? $store_oh_hours : ( $store_oh_hours ? (array) $store_oh_hours : [] );
$today          = strtolower( gmdate( 'l' ) );

$days = [
	esc_html__( 'Sunday', 'classilist' ),
	esc_html__( 'Monday', 'classilist' ),
	esc_html__( 'Tuesday', 'classilist' ),
	esc_html__( 'Wednesday', 'classilist' ),
	esc_html__( 'Thursday', 'classilist' ),
	esc_html__( 'Friday', 'classilist' ),
	esc_html__( 'Saturday', 'classilist' ),
];

$store_ads_query = Listing_Functions::store_query();

if ( isset( $_GET['view'] ) && in_array( $_GET['view'], [ 'grid', 'list' ], true ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$view = sanitize_text_field( wp_unslash( $_GET['view'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
} else {
	$view = Functions::get_option_item( 'rtcl_archive_listing_settings', 'default_view', 'list' );
}

$view = 'rtcl-' . $view . '-view rtcl-listing-wrapper';

?> 
<div class="site-content-block classilist-single-details classilist-store-contents">
	<div class="main-content">

		<?php if ( $store_description = $store->get_the_description() ) : ?>
			<h3 class="rtin-store-label"><?php esc_html_e( 'Details', 'classilist' ); ?></h3>
			<div class="rtin-store-description mb30"><?php echo wp_kses_post( $store_description ); ?></div>
		<?php endif; ?>

		<h3 class="rtin-store-label"><?php esc_html_e( 'Opening Hours', 'classilist' ); ?></h3>
		<div class="rtin-store-hours-list">
			<?php if ( 'selected' == $store_oh_type ) : ?>
				<?php if ( ! empty( $store_oh_hours ) && is_array( $store_oh_hours ) ) : ?>
					<?php foreach ( $store_oh_hours as $hKey => $oh_hour ) : ?>
						<div class="row<?php echo esc_attr( ( $today == $hKey ) ? ' current-store-hour' : '' ); ?>">
							<div class="col-4">
								<span class="hour-day"><?php echo esc_html( $days[ $hKey ] ); ?></span>
							</div>
							<div class="col-8">
								<?php if ( isset( $oh_hour['active'] ) ) : ?>
									<div class="oh-hours">
										<span><?php echo isset( $oh_hour['open'] ) ? esc_html( $oh_hour['open'] ) : ''; ?></span>
										<span>-</span>
										<span><?php echo isset( $oh_hour['close'] ) ? esc_html( $oh_hour['close'] ) : ''; ?></span>
									</div>
								<?php else : ?>
									<div class="oh-hours"><?php esc_html_e( 'Closed', 'classilist' ); ?></div>
								<?php endif; ?>
							</div>
						</div>

					<?php endforeach; ?>
				<?php else : ?>
					<div class="oh-always always-close"><?php esc_html_e( 'Permanently Closed', 'classilist' ); ?></div>
				<?php endif; ?>
			<?php elseif ( 'always' == $store_oh_type ) : ?>
				<div class="oh-always always-open"><?php esc_html_e( 'Always Open', 'classilist' ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="content-block-gap"></div>

<div class="listing-archive-top">
	<h2 class="rtin-title"><?php /* translators: %s is the store name. */ printf( esc_html__( 'All Ads from %s', 'classilist' ), esc_html( $store->get_the_title() ) ); ?></h2>
</div>

<div class="rtcl rtcl-listings store-ad-listing-wrapper">
	<div <?php Functions::listing_loop_start_class( [ $view ] ); ?> data-pagination='{"max_num_pages":<?php echo esc_attr( $store_ads_query->max_num_pages ); ?>, "current_page": 1, "found_posts":<?php echo esc_attr( $store_ads_query->found_posts ); ?>, "posts_per_page":<?php echo esc_attr( $store_ads_query->query_vars['posts_per_page'] ); ?>}'>
		<?php
		while ( $store_ads_query->have_posts() ) :
			$store_ads_query->the_post();
			Functions::get_template( 'content-listing' );
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</div>

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound