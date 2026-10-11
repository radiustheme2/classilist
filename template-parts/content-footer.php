<?php
/**
 * @author  RadiusTheme
 * @since   1.16
 * @version 1.16
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
	return;
}
$classilist_footer_columns = 0;

foreach ( range( 1, 4 ) as $classilist_i ) {
	if ( is_active_sidebar( 'footer-' . $classilist_i ) ) {
		$classilist_footer_columns++;
	}
}

switch ( $classilist_footer_columns ) {
	case '1':
		$classilist_footer_class = 'col-sm-12 col-12';
		break;
	case '2':
		$classilist_footer_class = 'col-sm-6 col-12';
		break;
	case '3':
		$classilist_footer_class = 'col-md-4 col-sm-12 col-12';
		break;
	default:
		$classilist_footer_class = 'col-lg-3 col-sm-6 col-12';
		break;
}
$classilist_copyright_class = RDTheme::$options['payment_icons'] ? 'col-md-8 col-sm-12 col-12' : 'col-sm-12 col-12 text-center';
?>
<footer>
	<?php if ( $classilist_footer_columns ) : ?>
		<div class="footer-top-area">
			<div class="container">
				<div class="row">
					<?php
					foreach ( range( 1, 4 ) as $classilist_i ) {
						if ( ! is_active_sidebar( 'footer-' . $classilist_i ) ) {
							continue;
						}
						echo '<div class="' . esc_attr( $classilist_footer_class ) . '">';
						dynamic_sidebar( 'footer-' . $classilist_i );
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>			
	<?php endif; ?>
	<?php if ( RDTheme::$options['copyright_area'] ) : ?>
		<div class="footer-bottom-area">
			<div class="container">
				<div class="row">
					<div class="<?php echo esc_attr( $classilist_copyright_class ); ?>"><?php echo wp_kses_post( RDTheme::$options['copyright_text'] ); ?></div>
					<?php if ( RDTheme::$options['payment_icons'] ) : ?>
						<div class="col-md-4 col-sm-12 col-12">
							<ul class="payment-icons">
								<?php if ( RDTheme::$options['payment_img'] ) : ?>
									<?php
									$classilist_cards = explode( ',', RDTheme::$options['payment_img'] );
									?>
									<?php foreach ( $classilist_cards as $classilist_card ) : ?>
										<li><?php echo wp_get_attachment_image( $classilist_card ); ?></li>
									<?php endforeach; ?>
								<?php else : ?>
									<li><img alt="payment" src="<?php echo esc_url( URI_Helper::get_img( 'payment-method1.jpg' ) ); ?>"></li>
									<li><img alt="payment" src="<?php echo esc_url( URI_Helper::get_img( 'payment-method2.jpg' ) ); ?>"></li>
									<li><img alt="payment" src="<?php echo esc_url( URI_Helper::get_img( 'payment-method3.jpg' ) ); ?>"></li>
									<li><img alt="payment" src="<?php echo esc_url( URI_Helper::get_img( 'payment-method4.jpg' ) ); ?>"></li>
								<?php endif; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</footer>