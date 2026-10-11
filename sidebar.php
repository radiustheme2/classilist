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
<div class="<?php Helper::the_sidebar_class(); ?>">
	<aside class="sidebar-widget-area">
		<?php
			do_action( 'classilist_before_sidebar' );

		if ( RDTheme::$sidebar ) {
			if ( is_active_sidebar( RDTheme::$sidebar ) ) {
				dynamic_sidebar( RDTheme::$sidebar );
			}
		} else {
			if ( is_active_sidebar( 'sidebar' ) ) {
				dynamic_sidebar( 'sidebar' );
			}
		}

			do_action( 'classilist_after_sidebar' );
		?>
	</aside>
</div>