<?php
/**
 *
 * @author      RadiusTheme
 * @package     classified-listing/templates
 * @version     1.0.0
 *
 * @var boolean $can_add_favourites
 * @var boolean $can_report_abuse
 * @var boolean $social
 * @var integer $listing_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Models\Listing;
use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use radiustheme\ClassiList\Listing_Functions;
use RtclClaimListing\Helpers\Functions as ClaimFunctions;

$classilist_listing = new Listing( $listing_id );
$type    = Listing_Functions::get_listing_type( $classilist_listing );

if ( ! $can_add_favourites && ! $can_report_abuse && ! $social && ! $classilist_listing->can_show_views() ) {
	return;
}

?>
<ul class='list-group list-group-flush rtcl-single-listing-action'>
	<?php if ( $classilist_listing->can_show_ad_type() && $type ) : ?>
		<li class="list-group-item rtin-icon-common"><i class="fa fa-fw <?php echo esc_attr( $type['icon'] ); ?>" aria-hidden="true"></i><?php echo esc_html( $type['label'] ); ?></li>
	<?php endif; ?>
	<?php if ( $classilist_listing->can_show_views() ) : ?>
		<li class="list-group-item rtin-icon-common"><span class='rtcl-icon rtcl-icon-eye'></span>
		<?php
		/* translators: %s is the number of views. */
		echo sprintf( esc_html__( '%s views', 'classilist' ), esc_html( number_format_i18n( $classilist_listing->get_view_counts() ) ) );
		?>
		</li>
	<?php endif; ?>

	<?php if ( $can_add_favourites ) : ?>
		<li class="list-group-item rtin-icon-common" id="rtcl-favourites"><?php echo wp_kses_post( Functions::get_favourites_link( $listing_id ) ); ?></li>
	<?php endif; if ( Fns::is_enable_compare() ) { ?>
		<li class="meta-compare rtin-icon-common">
			<span class="rtcl-icon rtcl-icon-exchange"></span>
			<?php
				$classilist_compare_ids    = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
				$classilist_selected_class = '';
			if ( is_array( $classilist_compare_ids ) && in_array( $classilist_listing->get_id(), $classilist_compare_ids, true ) ) {
				$classilist_selected_class = ' selected';
			}
			?>
			<a class="rtcl-compare <?php echo esc_attr( $classilist_selected_class ); ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Compare', 'classilist' ); ?>" data-listing_id="<?php echo absint( $classilist_listing->get_id() ); ?>">
				<?php esc_html_e( 'Add to Compare', 'classilist' ); ?>
			</a>
		</li>
	<?php } if ( $can_report_abuse ) : ?>
		<li class='list-group-item rtin-icon-common'>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="javascript:void(0)" data-toggle="modal" data-target="#rtcl-report-abuse-modal"><span class='rtcl-icon rtcl-icon-trash-1'></span><?php esc_html_e( 'Report Abuse', 'classilist' ); ?></a>
			<?php else : ?>
				<a href="javascript:void(0)" class="rtcl-require-login"><span class='rtcl-icon rtcl-icon-trash-1'></span><?php esc_html_e( 'Report Abuse', 'classilist' ); ?></a>
			<?php endif; ?>
		</li>
	<?php endif; ?>

	<?php if ( function_exists( 'rtclClaimListing' ) && ClaimFunctions::claim_listing_enable() ) : ?>
		<li class='list-group-item rtin-icon-common'>
			<?php if ( is_user_logged_in() ) : ?>
				<span data-toggle="tooltip" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
					<a href="javascript:void(0)" data-toggle="modal" data-target="#rtcl-claim-listing-modal">
						<i class="fas fa-exclamation-circle"></i>
						<?php esc_html_e( 'Claim to this listing', 'classilist' ); ?>
					</a>
				</span>
			<?php else : ?>
				<a href="javascript:void(0)" data-toggle="tooltip" class="rtcl-require-login" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
					<i class="fas fa-exclamation-circle"></i>
					<?php esc_html_e( 'Claim to this listing', 'classilist' ); ?>
				</a>
			<?php endif; ?>
		</li>
	<?php endif; ?>

	<?php if ( $social ) : ?>
		<li class="list-group-item rtcl-sidebar-social">
			<div class="share-label rtin-icon-common"><i class="fa fa-fw fa-share-alt" aria-hidden="true"></i><?php esc_html_e( 'Share this Ad:', 'classilist' ); ?></div>
			<div class="buttons-list">
				<?php echo wp_kses_post( $social ); ?>
			</div>
		</li>
	<?php endif; ?>
</ul>

<?php do_action( 'rtcl_single_listing_after_action', $listing_id ); ?>

<div class="modal fade " id="rtcl-report-abuse-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="rtcl-report-abuse-form" class="form-vertical">
				<div class="modal-header">
					<h5 class="modal-title" id="rtcl-report-abuse-modal-label"><?php esc_html_e( 'Report Abuse', 'classilist' ); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="rtcl-report-abuse-message"><?php esc_html_e( 'Your Complaint', 'classilist' ); ?><span class="rtcl-star">*</span></label>
						<textarea class="form-control" name="message" id="rtcl-report-abuse-message" rows="3" placeholder="<?php esc_attr_e( 'Message...', 'classilist' ); ?>" required></textarea>
					</div>
					<div id="rtcl-report-abuse-g-recaptcha"></div>
					<div id="rtcl-report-abuse-message-display"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Submit', 'classilist' ); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>