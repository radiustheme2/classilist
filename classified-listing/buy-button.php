<?php
/**
 * @var string $button_text
 * @var bool   $is_enable_quantity
 * @var bool   $is_enable_buy_button
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $listing;

$classilist_selected_cats = \RtclMarketplace\Helpers\Functions::get_marketplace_categories();
$classilist_selected_cats = is_array( $classilist_selected_cats ) ? $classilist_selected_cats : [];
$classilist_listing_cat   = $listing->get_parent_category()->term_id ?? 0;

if ( ! empty( $classilist_selected_cats ) && ! in_array( $classilist_listing_cat, $classilist_selected_cats ) ) {
	return;
}

do_action( 'rtcl_marketplace_before_buy_button' );
?>
    <div class="rtcl-add-to-cart-form-wrapper">
        <form action="<?php echo esc_url( get_the_permalink() ); ?>" method="post" class="rtcl-add-to-cart-form">
            <input name="add-to-cart" type="hidden" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
			<?php if ( $is_enable_quantity ) : ?>
                <input name="quantity" type="number" value="1" min="1" <?php echo esc_attr( \RtclMarketplace\Helpers\Functions::get_max_attribute( get_the_ID() ) ); ?>/>
			<?php endif; ?>
            <input name="submit" type="submit" class="btn" value="<?php echo esc_html( $button_text ); ?>"
				<?php
				    echo \RtclMarketplace\Helpers\Functions::disable_cart_button( get_the_ID() ) ? 'disabled' : '';
				?>
            />
        </form>
    </div>
<?php
do_action( 'rtcl_marketplace_after_buy_button' );