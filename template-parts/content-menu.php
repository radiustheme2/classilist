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

if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
	return;
}

if ( RDTheme::$has_top_bar ){
	get_template_part( 'template-parts/header/header-top' );
}
?>
<div id="meanmenu"></div>
<?php get_template_part( 'template-parts/header/header' ); ?>
<?php get_template_part( 'template-parts/header/header', 'listing-search' ); ?>