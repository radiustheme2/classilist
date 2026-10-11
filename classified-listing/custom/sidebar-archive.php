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
<!--<a id="classilist-toggle-sidebar" href="#">--><?php //esc_html_e( 'Toggle Filter', 'classilist' );?><!--</a>-->

<aside class="sidebar-widget-area sidebar-listing-archive">
	<?php do_action( 'classilist_before_sidebar' ); ?>
	<?php
        if ( is_active_sidebar( 'rtcl-archive-sidebar' ) ){
            dynamic_sidebar( 'rtcl-archive-sidebar' );
        }
        else {
            if ( class_exists( 'Rtcl\Widgets\Filter' ) ) {

                $classilist_args = array(
                    'before_widget' => '<div class="widget %s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="widgettitle">',
                    'after_title'   => '</h3>',
                );
                $classilist_instance = array(
                    'title'                        => esc_html__( 'Filter Ads', 'classilist' ),
                    'search_by_category'           => 1,
                    'show_icon_image_for_category' => 0,
                    'search_by_location'           => 1,
                    'search_by_custom_fields'      => 1,
                    'search_by_price'              => 1,
                    'hide_empty'                   => 0,
                    'show_count'                   => 1,
                );

                the_widget( 'Rtcl\Widgets\Filter', $classilist_instance, $classilist_args );
            }
        }

	    do_action( 'classilist_after_sidebar' );
	?>
</aside>