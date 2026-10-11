<?php
/**
 *
 * @author     RadiusTheme
 * @package    classified-listing-store/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="classilist-store-info widget">
    <h3 class="widgettitle"><?php esc_html_e( "Store Information", 'classilist' ); ?></h3>
    <div class="rtin-store-info clearfix">
        <?php if ( $store->has_logo() ): ?>
            <div class="pull-left rtin-store-logo">
                <a href="<?php $store->the_permalink(); ?>"><?php $store->the_logo() ?></a>
            </div>
        <?php endif; ?>
        <div class="rtin-store-name"><a href="<?php $store->the_permalink(); ?>"><?php $store->the_title() ?></a></div>
        <div class="rtin-store-slogan"><?php $store->the_slogan(); ?></div>      
    </div>
</div>