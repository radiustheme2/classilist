<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 *
 * @var $phone string
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$classilist_mobileClass = wp_is_mobile() ? ' rtcl-mobile' : null;
$classilist_last        = substr( $phone, - 3 );
$classilist_phone       = substr_replace( $phone, 'XXX', - 3 );
?>
<div class="rtcl-contact-reveal-wrapper reveal-phone<?php echo esc_attr( $classilist_mobileClass ); ?>" data-last="<?php echo esc_attr( $classilist_last ); ?>">
	<div class='numbers'><?php echo esc_html( $classilist_phone ); ?></div>
	<small class='text-muted'><?php esc_html_e( 'Click to reveal phone number', 'classilist' ); ?></small>
</div>