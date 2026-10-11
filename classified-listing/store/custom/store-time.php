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

?>
<?php if ( 'selected' == $store_oh_type ) : ?>
	<?php if ( ! empty( $oh_current_hour ) ) : ?>
		<?php
			$classilist_class = $now_open ? ' rtin-store-status-open' : ' rtin-store-status-close';
			$status           = $now_open ? esc_html__( 'Open Now', 'classilist' ) : esc_html__( 'Closed Now', 'classilist' );
		?>
		<div class="rtin-store-status <?php echo esc_attr( $classilist_class ); ?>"><?php echo esc_html( $status ); ?></div>

		<?php if ( isset( $oh_current_hour['open'] ) ) : ?>
			<div class="rtin-store-opening-hour">
				<span class="label"><?php esc_html_e( 'Open:', 'classilist' ); ?></span>
				<span class="rtin-store-hour-text"><?php echo esc_html( $oh_current_hour['open'] ); ?></span>
			</div>
		<?php endif; ?>

		<?php if ( isset( $oh_current_hour['close'] ) ) : ?>
			<div class="rtin-store-opening-hour">
				<span class="label"><?php esc_html_e( 'Close:', 'classilist' ); ?></span>
				<span class="rtin-store-hour-text"><?php echo esc_html( $oh_current_hour['close'] ); ?></span>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<div class="mt10 rtin-store-status rtin-store-status-close"><?php esc_html_e( 'Closed Today', 'classilist' ); ?></div>
	<?php endif; ?>
<?php else : ?>
	<div class="mt10 rtin-store-status rtin-store-status-open"><?php esc_html_e( 'Always Open', 'classilist' ); ?></div>
<?php endif; ?>