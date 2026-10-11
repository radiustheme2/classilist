<?php
/**
 * Listing Form Contact
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var array   $hidden_fields
 * @var string  $state_text
 * @var string  $city_text
 * @var string  $town_text
 * @var string  $zipcode
 * @var string  $phone
 * @var string  $whatsapp_number
 * @var boolean $enable_post_for_unregister
 * @var string  $website
 * @var bool    $latitude
 * @var bool    $longitude
 * @var string  $email
 * @var string  $address
 * @var string  $geo_address
 * @var integer $selected_locations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$labelColumn = is_admin() ? 'col-sm-2' : 'col-sm-3';
$inputColumn = is_admin() ? 'col-sm-10' : 'col-sm-9';
?>
<div class="rtcl-post-contact-details rtcl-post-section">
	<?php if ( ! is_admin() ) : ?>
		<div class="classified-listing-form-title">
			<i class="fa fa-user" aria-hidden="true"></i><h3><?php esc_html_e( 'Contact Details', 'classilist' ); ?></h3>
		</div>
	<?php endif; ?>

	<?php if ( method_exists( 'Rtcl\Helpers\Functions', 'location_type' ) && 'local' === Functions::location_type() ) : ?>

		<?php if ( ! in_array( 'location', $hidden_fields, true ) ) : ?>
			<div class="row" id="rtcl-location-row">
				<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
					<label class="control-label"><?php echo esc_html( $state_text ); ?><span class="require-star"> *</span></label>
				</div>
				<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
					<div class="form-group">
						<select id="rtcl-location" name="location" class="rtcl-select2 rtcl-select form-control rtcl-map-field" required>
							<option value="">--<?php esc_html_e( 'Select Location', 'classilist' ); ?>--</option>
							<?php
							$locations = Functions::get_one_level_locations();
							if ( ! empty( $locations ) ) {
								foreach ( $locations as $location ) {
									$slt = '';
									if ( in_array( $location->term_id, $selected_locations, true ) ) {
										$location_id = $location->term_id;
										$slt         = ' selected';
									}
									echo "<option value='" . esc_attr( $location->term_id ) . "'" . esc_attr( $slt ) . '>' . esc_html( $location->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<?php
			$sub_locations = [];
			if ( $location_id ) {
				$sub_locations = Functions::get_one_level_locations( $location_id );
			}
			?>
			<div class="row <?php echo empty( $sub_locations ) ? ' rtcl-hide' : ''; ?>" id="sub-location-row">
				<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
					<label class="control-label"><?php echo esc_html( $city_text ); ?><span class="require-star"> *</span></label>
				</div>
				<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
					<div class="form-group">
						<select id="rtcl-sub-location" name="sub_location" class="rtcl-select2 rtcl-select form-control rtcl-map-field" required>
							<option value="">--<?php esc_html_e( 'Select Location', 'classilist' ); ?>--</option>
							<?php
							if ( ! empty( $sub_locations ) ) {
								foreach ( $sub_locations as $location ) {
									$slt = '';
									if ( in_array( $location->term_id, $selected_locations, true ) ) {
										$sub_location_id = $location->term_id;
										$slt             = ' selected';
									}
									echo "<option value='" . esc_attr( $location->term_id ) . "'" . esc_attr( $slt ) . '>' . esc_html( $location->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<?php
			$sub_sub_locations = [];
			if ( $sub_location_id ) {
				$sub_sub_locations = Functions::get_one_level_locations( $sub_location_id );
			}
			?>
			<div class="row <?php echo empty( $sub_sub_locations ) ? ' rtcl-hide' : ''; ?>" id="sub-sub-location-row">
				<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
					<label class="control-label"><?php echo esc_html( $town_text ); ?><span class="require-star"> *</span></label>
				</div>
				<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
					<div class="form-group">
						<select id="rtcl-sub-sub-location" name="sub_sub_location" class="rtcl-select2 rtcl-select form-control rtcl-map-field" required>
							<option value="">--<?php esc_html_e( 'Select Location', 'classilist' ); ?>--</option>
							<?php
							if ( ! empty( $sub_sub_locations ) ) {
								foreach ( $sub_sub_locations as $location ) {
									$slt = '';
									if ( in_array( $location->term_id, $selected_locations, true ) ) {
										$slt = ' selected';
									}
									echo "<option value='" . esc_attr( $location->term_id ) . "'" . esc_attr( $slt ) . '>' . esc_html( $location->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! in_array( 'zipcode', $hidden_fields, true ) ) : ?>
			<div class="row classilist-form-zip-row">
				<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
					<label class="control-label"><?php esc_html_e( 'Zip Code', 'classilist' ); ?></label>
				</div>
				<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
					<div class="form-group">
						<input type="text" name="zipcode" value="<?php echo esc_attr( $zipcode ); ?>" class="rtcl-map-field form-control" id="rtcl-zipcode"/>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! in_array( 'address', $hidden_fields, true ) ) : ?>
			<div class="row classilist-form-address-row">
				<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
					<label class="control-label"><?php esc_html_e( 'Address', 'classilist' ); ?></label>
				</div>
				<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
					<div class="form-group">
						<textarea name="address" rows="2" class="rtcl-map-field form-control" id="rtcl-address"><?php echo esc_textarea( $address ); ?></textarea>
					</div>
				</div>
			</div>
		 <?php endif; ?>

	<?php endif; ?>

	<?php if ( method_exists( 'Rtcl\Helpers\Functions', 'location_type' ) && 'geo' === Functions::location_type() ) : ?>
		<div class="row classilist-form-geo-address-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label for="rtcl-geo-address" class="control-label"><?php esc_html_e( 'Location', 'classilist' ); ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="rtcl-geo-address-field form-group">
					<input type="text" name="rtcl_geo_address" autocomplete="off"
						   value="<?php echo esc_attr( $geo_address ); ?>"
						   id="rtcl-geo-address"
						   placeholder="<?php esc_attr_e( 'Select a location', 'classilist' ); ?>"
						   class="form-control rtcl-geo-address-input rtcl_geo_address_input"/>
					<i class="rtcl-get-location rtcl-icon rtcl-icon-target" id="rtcl-geo-loc-form"></i>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! in_array( 'phone', $hidden_fields, true ) ) : ?>
		<div class="row classilist-form-phone-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label class="control-label"><?php esc_html_e( 'Phone', 'classilist' ); ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="form-group">
					<input type="text" class="form-control" id="rtcl-phone" name="phone" value="<?php echo esc_attr( $phone ); ?>"/>
					<?php do_action( 'rtcl_listing_form_phone_warning' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if ( ! in_array( 'whatsapp_number', $hidden_fields, true ) ) : ?>
		<div class="row classilist-form-whatsapp-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label class="control-label"><?php esc_html_e( 'Whatsapp Number', 'classilist' ); ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="form-group">
					 <input type="text" class="form-control" id="rtcl-whatsapp-number" name="_rtcl_whatsapp_number" value="<?php echo esc_attr( $whatsapp_number ); ?>"/>
				</div>
			</div>
		</div>
	 <?php endif; ?>

	<?php if ( ! in_array( 'email', $hidden_fields, true ) || $enable_post_for_unregister ) : ?>
		<div class="row classilist-form-email-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label class="control-label"><?php esc_html_e( 'Email', 'classilist' ); ?>
				<?php
				if ( $enable_post_for_unregister ) :
					?>
					<span> *</span><?php endif; ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="form-group">
					<input type="email" class="form-control" id="rtcl-email" name="email" value="<?php echo esc_attr( $email ); ?>" <?php echo esc_html( $enable_post_for_unregister ? ' required' : '' ); ?> />
					<?php if ( $enable_post_for_unregister ) : ?>
						<p class="description"><?php esc_html_e( 'This will be your username', 'classilist' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! in_array( 'website', $hidden_fields, true ) ) : ?>
		<div class="row classilist-form-website-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label class="control-label"><?php esc_html_e( 'Website', 'classilist' ); ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="form-group">
					<input type="url" class="form-control" id="rtcl-website" value="<?php echo esc_url( $website ); ?>" name="website"/>
				</div>
			</div>
		</div>
	 <?php endif; ?>

	<?php
	if ( method_exists( 'Rtcl\Helpers\Functions', 'has_map' ) && Functions::has_map() ) :
		$hide_map = $post_id && get_post_meta( $post_id, 'hide_map', true );
		?>
		<div class="row classilist-form-map-row">
			<div class="col-12 <?php echo esc_attr( $labelColumn ); ?>">
				<label class="control-label"><?php esc_html_e( 'Map', 'classilist' ); ?></label>
			</div>
			<div class="col-12 <?php echo esc_attr( $inputColumn ); ?>">
				<div class="form-group">
					<div class="rtcl-map-wrap">
						<div class="rtcl-map" data-type="input">
							<div class="marker" data-latitude="<?php echo esc_attr( $latitude ); ?>" data-longitude="<?php echo esc_attr( $longitude ); ?>" data-address="<?php echo esc_attr( $address ); ?>"><?php echo ( method_exists( 'Rtcl\Helpers\Functions', 'location_type' ) && 'geo' === Functions::location_type() ) ? esc_attr( $geo_address ) : esc_html( $address ); ?></div>
						</div>
						<div class="rtcl-form-check">
							<input class="rtcl-form-check-input" id="rtcl-hide-map" type="checkbox" name="hide_map" value="1" <?php checked( $hide_map, 1 ); ?>>
							<label class="rtcl-form-check-label" for="rtcl-hide-map"><?php esc_html_e( "Don't show the Map", 'classilist' ); ?></label>
						</div>
					</div>
					<!-- Map Hidden field-->
					<input type="hidden" name="latitude" value="<?php echo esc_attr( $latitude ); ?>" id="rtcl-latitude"/>
					<input type="hidden" name="longitude" value="<?php echo esc_attr( $longitude ); ?>" id="rtcl-longitude"/>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound