<?php
/**
 * Listing Form Contact
 *
 * @author     RadiusTheme
 * @package    classified-listing/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Text;

Functions::print_notices();
?>

<div class="rtcl-listing-info-selecting classilist-form">
	<?php if ( ! Functions::is_ad_type_disabled() ) : ?>
		<div id="rtcl-ad-type-selection">
			<div class="classified-listing-form-title">
				<i class="fa fa-tags" aria-hidden="true"></i><h3><?php esc_html_e( 'Select Type', 'classilist' ); ?></h3>
			</div>
			<div class="row">
				<div class="col-sm-3 col-12">
					<label class="control-label"><?php esc_html_e( 'Ad Type', 'classilist' ); ?><span> *</span></label>
				</div>
				<div class="col-sm-9 col-12">
					<div class="form-group">
						<select class="rtcl-select2 form-control" id="rtcl-ad-type" name="type" required>
							<option value="">--<?php esc_html_e( 'Select Type', 'classilist' ); ?>--</option>
							<?php
							$classilist_types = Functions::get_listing_types();
							if ( ! empty( $classilist_types ) ) :
								foreach ( $classilist_types as $classilist_type_id => $type ) :
									$classilist_tSlt = $classilist_type_id == $selected_type ? ' selected' : '';
									echo "<option value='" . esc_attr( $classilist_type_id ) . "'" . esc_attr( $classilist_tSlt ) . '>' . esc_html( $type ) . '</option>';
								endforeach;
							endif;
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="rtcl-ad-category-selection"
		 style="display: <?php echo esc_attr( ( ( $selected_type && in_array( $selected_type, array_keys( Functions::get_listing_types() ) ) ) || Functions::is_ad_type_disabled() ) ? 'block' : 'none' ); ?>">
		<div class="classified-listing-form-title">
			<i class="fa fa-tags" aria-hidden="true"></i><h3><?php esc_html_e( 'Select Category', 'classilist' ); ?></h3>
		</div>
		<div class="rtcl-post-category">

			<div class="row" id="cat-row">
				<div class="col-sm-3 col-12">
					<label class="control-label"><?php esc_html_e( 'Category', 'classilist' ); ?><span> *</span></label>
				</div>
				<div class="col-sm-9 col-12">
					<div class="form-group">
						<select class="rtcl-select2 form-control" id="rtcl-category" name="category" required>
							<option value=""><?php echo esc_html( Text::get_select_category_text() ); ?></option>
							<?php
							$classilist_cats          = Functions::get_one_level_categories( 0, $selected_type );
							$classilist_parent_cat_id = isset( $classilist_parent_cat_id ) ? $classilist_parent_cat_id : 0;
							if ( ! empty( $classilist_cats ) ) {
								foreach ( $classilist_cats as $cat ) {
									$classilist_slt = $classilist_parent_cat_id == $cat->term_id ? ' selected' : '';
									echo "<option value='" . esc_attr( $cat->term_id ) . "'" . esc_attr( $classilist_slt ) . '>' . esc_html( $cat->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>

			<?php $classilist_child_cats = $classilist_parent_cat_id ? Functions::get_one_level_categories( $classilist_parent_cat_id ) : []; ?>

			<div class="row <?php echo empty( $classilist_child_cats ) ? ' rtcl-hide' : ''; ?>" id="sub-cat-row">
				<div class="col-sm-3 col-12">
					<label class="control-label"><?php esc_html_e( 'Sub Category', 'classilist' ); ?><span> *</span></label>
				</div>
				<div class="col-sm-9 col-12" id="rtcl-sub-category-wrap">
					<div class="form-group">
						<?php if ( ! empty( $classilist_child_cats ) ) : ?>
							<select class="form-control rtcl-select2" id="rtcl-sub-category" name="sub_category" required>
								<?php
								echo "<option value=''>" . esc_html( Text::get_select_category_text() ) . '</option>';
								foreach ( $classilist_child_cats as $cat ) {
									echo "<option value='" . absint( $cat->term_id ) . "'>" . esc_html( $cat->name ) . '</option>';
								}
								?>
							</select>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>