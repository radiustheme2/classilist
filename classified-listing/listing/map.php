<?php
/**
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var bool    $has_map
 * @var numeric $latitude
 * @var numeric $longitude
 * @var string  $address
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( $has_map ) : ?>
	<div class="content-block-gap"></div>
	<div class="site-content-block classilist-single-map">
		<div class="main-title-block"><h3 class="main-title"><?php esc_html_e( 'Location', 'classilist' ); ?></h3></div>
		<div class="main-content">
			<div class="embed-responsive embed-responsive-16by9">
				<div class="rtcl-map embed-responsive-item">
					<div class="marker" data-latitude="<?php echo esc_attr( $latitude ); ?>" data-longitude="<?php echo esc_attr( $longitude ); ?>" data-address="<?php echo esc_attr( $address ); ?>"><?php echo esc_html( $address ); ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;