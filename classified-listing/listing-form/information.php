<?php
/**
 * Login Form Information
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var Listing    $listing
 * @var int    $title_limit
 * @var array  $hidden_fields
 * @var string $selected_type
 * @var string $title
 * @var string $price_type
 * @var string $price
 * @var string $post_content
 * @var string $editor
 * @var int    $category_id
 * @var int    $post_id
 * @var int    $description_limit
 * @var int    $listing_pricing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Models\Listing;
use Rtcl\Resources\Options;

?>
<div class="rtcl-post-details rtcl-post-section rtcl-post-section-info">
	<div class="classified-listing-form-title">
		<i class="fa fa-folder-open" aria-hidden="true"></i><h3><?php esc_html_e( 'Product Information', 'classilist' ); ?></h3>
	</div>
	<div class="row classilist-form-title-row">
		<div class="col-sm-3 col-12">
			<label class="control-label"><?php esc_html_e( 'Title', 'classilist' ); ?><span> *</span></label>
		</div>
		<div class="col-sm-9 col-12">
			<div class="form-group">
				<input type="text"
					<?php echo $title_limit ? 'data-max-length="3" maxlength="' . esc_attr( $title_limit ) . '"' : ''; ?>
					  class="form-control"
					  value="<?php echo esc_attr( $title ); ?>"
					  id="rtcl-title"
					  name="title"
					  required/>
				<?php
				if ( $title_limit ) {
					/* translators: %s is the character limit number. */
					$classilist_char_limit_text = sprintf( __( "Character limit <span class='target-limit'>%s</span>", 'classilist' ), $title_limit );
					echo sprintf(
						'<div class="rtcl-hints">%s</div>',
						wp_kses_post( apply_filters( 'rtcl_title_character_limit_hints', $classilist_char_limit_text ) )
					);
				}
				?>
			</div>
		</div>
	</div>

  <?php
	if ( ! in_array( 'pricing_type', $hidden_fields, true ) || ! in_array( 'price_type', $hidden_fields, true ) || ! in_array( 'price', $hidden_fields, true ) ) :
		$classilist_listingPricingTypes = Options::get_listing_pricing_types();
		?>
	  <div id="rtcl-pricing-wrap">
		<?php if ( ! in_array( 'pricing_type', $hidden_fields, true ) ) { ?>
		<div class="row" id="rtcl-form-pricing-type-wrap">
		  <div class="col-sm-3 col-12">
			<label class="control-label"><?php esc_html_e( 'Pricing', 'classilist' ); ?></label>
		  </div>
		  <div class="col-sm-9 col-12">
			<?php
			foreach ( $classilist_listingPricingTypes as $classilist_type_id => $type ) {
				?>
				  <div class="rtcl-checkbox rtcl-listing-pricing-type">
					  <input type="radio" name="_rtcl_listing_pricing"
							 id="_rtcl_listing_pricing_<?php echo esc_attr( $classilist_type_id ); ?>"
						<?php echo $listing_pricing === $classilist_type_id ? 'checked' : ''; ?>
							 value="<?php echo esc_attr( $classilist_type_id ); ?>">
					  <label for="_rtcl_listing_pricing_<?php echo esc_attr( $classilist_type_id ); ?>">
						<?php echo esc_html( $type ); ?>
					  </label>
				  </div>
				  <?php
			}
			?>
		  </div>
		</div>
		<?php } if ( ! in_array( 'price_type', $hidden_fields, true ) || ! in_array( 'price', $hidden_fields, true ) ) { ?>
		<div id="rtcl-pricing-items" class="<?php echo esc_attr( 'rtcl-pricing-' . $listing_pricing ); ?>">
			<?php if ( ! in_array( 'price_type', $hidden_fields, true ) && ! Functions::is_price_type_disabled() ) { ?>
			  <div class="row" id="rtcl-form-price-wrap">
				  <div class="col-sm-3 col-12">
					  <label class="control-label"><?php esc_html_e( 'Price Type', 'classilist' ); ?><span> *</span></label>
				  </div>
				  <div class="col-sm-9 col-12">
					  <div class="form-group">
						  <select class="form-control rtcl-select2" id="rtcl-price-type" name="price_type">
							  <?php
								$classilist_price_types = Options::get_price_types();
								foreach ( $classilist_price_types as $classilist_key => $type ) {
									$classilist_slt = $price_type == $classilist_key ? ' selected' : null;
									echo "<option value='" . esc_attr( $classilist_key ) . "'" . esc_attr( $classilist_slt ) . ">" . esc_html( $type ) . "</option>";
								}
								?>
						  </select>
					  </div>
				  </div>
			  </div>
			<?php } if ( ! in_array( 'price', $hidden_fields, true ) ) { ?>
				<?php do_action( 'rtcl_listing_form_price_items', $listing ); ?>
			<div id="rtcl-price-items" class="rtcl-pricing-item<?php echo ! Functions::is_price_type_disabled() ? ( ' rtcl-price-type-' . esc_attr( $price_type ) ) : ''; ?>">
				<div class="rtcl-price-item" id="rtcl-price-wrap">
				  <div class="price-wrap">
					<div class="row">
					  <div class="col-md-3 col-12">
						<label class="control-label">
						  <?php
							echo sprintf(
								'<span class="price-label">%s [<span class="rtcl-currency-symbol">%s</span>]</span>',
								esc_html__( 'Price', 'classilist' ),
								esc_html( apply_filters( 'rtcl_listing_price_currency_symbol', Functions::get_currency_symbol(), $listing ) )
							);
							?>
						  <span> *</span>
						</label>
					  </div>
					  <div class="col-md-9 col-12">
						<div class="form-group">
						  <input type="text" class="form-control"
							value="<?php echo $listing ? esc_attr( $listing->get_price() ) : ''; ?>"
							name="price"
							id="rtcl-price"<?php echo esc_attr( ! $price_type || 'fixed' == $price_type ? ' required' : '' ); ?>>
						</div>
					  </div>
					</div>
				  </div>
				  <div class="price-wrap rtcl-max-price rtcl-hide">
					<div class="row">
					  <div class="col-lg-4 col-md-3 col-12">
						<label class="control-label" for="rtcl-max-price">
						  <?php
							echo sprintf(
								'<span class="price-label">%s [<span class="rtcl-currency-symbol">%s</span>]</span>',
								esc_html__( 'Max Price', 'classilist' ),
								esc_html( apply_filters( 'rtcl_listing_price_currency_symbol', Functions::get_currency_symbol(), $listing ) )
							);
							?>
						  <span class="require-star">*</span>
						</label>
					  </div>
					  <div class="col-lg-8 col-md-9 col-12">
						<div class="form-group">
						  <input type="text" class="form-control rtcl-price"
							value="<?php echo $listing ? esc_attr( $listing->get_max_price() ) : ''; ?>"
							name="_rtcl_max_price"
							id="rtcl-max-price"<?php echo esc_attr( ! $price_type || 'fixed' == $price_type ? ' required' : '' ); ?>>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<?php do_action( 'rtcl_listing_form_price_unit', $listing, $category_id ); ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	  </div>
	<?php endif; ?>

	<div id="rtcl-custom-fields-list" data-post_id="<?php echo esc_attr( $post_id ); ?>">
		<?php do_action( 'wp_ajax_rtcl_custom_fields_listings', $post_id, $category_id ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound ?>
	</div>

	<?php if ( ! in_array( 'description', $hidden_fields, true ) ) : ?>
		<div class="row classilist-form-des-row">
			<div class="col-sm-3 col-12">
				<label class="control-label"><?php esc_html_e( 'Description', 'classilist' ); ?></label>
			</div>
			<div class="col-sm-9 col-12">
				<div class="form-group">
					<?php
					if ( 'textarea' == $editor ) {
						?>
			  <textarea
			  id="description"
			  name="description"
			  class="form-control"
						<?php echo $description_limit ? 'maxlength="' . esc_attr( $description_limit ) . '"' : ''; ?>
			  rows="8"><?php Functions::print_html( $post_content ); ?></textarea>
						<?php
					} else {
						wp_editor(
							$post_content,
							'description',
							[
								'media_buttons' => false,
								'editor_height' => 200,
							]
						);
					}
					if ( $description_limit ) {
						/* translators: %s is the character limit number. */
						$classilist_char_limit_text = sprintf( __( "Character limit <span class='target-limit'>%s</span>", 'classilist' ), $description_limit );
						echo sprintf(
							'<div class="rtcl-hints">%s</div>',
							wp_kses_post( apply_filters( 'rtcl_description_character_limit_hints', $classilist_char_limit_text ) )
						);
					}
					?>
				</div>
			</div>
		</div>
	<?php endif; ?>

  <?php if ( ! in_array( 'tags', $hidden_fields, true ) ) : ?>
	<div class="form-group">
	  <label for="description"><?php esc_html_e( 'Tags', 'classilist' ); ?></label>
	  <div class="rtcl-tags-input-wrap">
		<div class="rtcl-tags-input">
		  <?php
			$classilist_tags_data = [];
			if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
				foreach ( $tags as $tag ) {
					echo '<div><span class="rtcl-tag-term">' . esc_html( $tag->name ) . '</span><span class="remove">x</span></div>';
					$classilist_tags_data[] = esc_html( $tag->name );
				}
			}
			?>
		  <input type="text" autocomplete="off" id="new-tag-rtcl_tag" class="form-control" placeholder="<?php esc_attr_e( 'Put tags with comma ","', 'classilist' ); ?>"/>
		</div>
		<input type="hidden" id="rtcl_listing_tag" name="rtcl_listing_tag" value="<?php echo esc_attr( implode( ',', $classilist_tags_data ) ); ?>"/>
	  </div>
	</div>
  <?php endif; ?>

</div>