<?php
/**
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var WP_Query $rtcl_related_query
 * @var array $slider_options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use radiustheme\ClassiList\URI_Helper;

if ( ! $rtcl_related_query->have_posts() ) {
	return;
}

$related_count  = $rtcl_related_query->post_count;
$posts_per_page = $rtcl_related_query->get( 'posts_per_page' );
if ( $posts_per_page <= $related_count ) {
	$slider_options['loop'] = true;
}

$style = 1;
?>

<div class="listing-archive-wrapper related-listing-main">
		<div class="rtcl mb-3 rtcl-related-listing rtcl-listings">
			<div class="rtcl-related-title"><h2><?php esc_html_e( 'See More Related Listing', 'clawyer' ); ?></h2></div>
			<div class="rtcl-related-listings">
				<div class="rtcl-related-slider-wrap">
					<div class="rtcl-related-slider rtcl-carousel-slider" id="rtcl-related-slider" data-options="<?php echo esc_attr( wp_json_encode( $slider_options ) ); ?>">
						<div class="swiper-wrapper">
							<?php
							global $post;
							while ( $rtcl_related_query->have_posts() ) :
								$rtcl_related_query->the_post();
								$listing = rtcl()->factory->get_listing( get_the_ID() );
								?>
								<div class="swiper-slide rtcl-related-slider-item listing-item rtcl-listing-item">
									<?php URI_Helper::get_template_part( 'classified-listing/custom/grid', [ 'layout' => $style ] ); ?>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
						<?php if ( $related_count > $posts_per_page ) { ?>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
