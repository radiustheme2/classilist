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

$classilist_error_img = empty( RDTheme::$options['error_bodybanner']['url'] ) ? Helper::get_img( '404.png' ) : RDTheme::$options['error_bodybanner']['url'];

?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'top' ); ?>
<div id="primary" class="content-area">
	<div class="container">
		<div class="error-page">
			<img src="<?php echo esc_url( $classilist_error_img ); ?>" alt="<?php esc_attr_e( '404', 'classilist' ); ?>">
			<h3><?php echo esc_html( RDTheme::$options['error_text'] ); ?></h3>
			<a class="error-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( RDTheme::$options['error_buttontext'] ); ?></a>
		</div>
	</div>
</div>
<?php get_footer(); ?>