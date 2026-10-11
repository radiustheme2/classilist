<?php
/**
 *
 * @author        RadiusTheme
 * @package    classified-listing/templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Rtcl\Models\Listing;
use Rtcl\Helpers\Functions;
use radiustheme\ClassiList\RDTheme;
use radiustheme\ClassiList\URI_Helper;
use Rtcl\Services\FormBuilder\FBHelper;

global $listing;
$classilist_enableBuilder = FBHelper::isEnableSingleBuilder( $listing );

$classilist_listing = new Listing( $post->ID );

if ( 'full-width' == RDTheme::$layout ) {
	$classilist_layout_class = 'col-xl-12 col-lg-12 col-sm-12 col-12';
} else {
	$classilist_layout_class = 'col-xl-9 col-lg-8 col-sm-12 col-12';
}

?>
<?php get_header(); ?>


<?php get_template_part( 'template-parts/content', 'top' ); ?>

<?php
if ( $classilist_enableBuilder ) {
	$classilist_form = $classilist_listing->getForm();
	Functions::get_template( 'single-layout/builder', [ 'form' => $classilist_form ] );
} else {
	?>

	<div id="primary" class="content-area classilist-listing-single rtcl">
	<div class="container">
		<div class="row">
			<?php
			if ( 'left-sidebar' == RDTheme::$layout ) {
				URI_Helper::get_custom_listing_template( 'sidebar-single' );
			}
			?>
			<div class="<?php echo esc_attr( $classilist_layout_class ); ?>">

				<?php URI_Helper::get_custom_listing_template( 'content-single' ); ?>

				<?php
				do_action( 'classilist_single_listing_after_product' );

				// Business Hours.
				do_action( 'rtcl_single_listing_business_hours' );

				// Map.
				do_action( 'rtcl_single_listing_content_end', $classilist_listing );

				// Social Profiles.
				do_action( 'rtcl_single_listing_social_profiles' );

				do_action( 'classilist_single_listing_after_location' );

				// Related Listing.
				if ( RDTheme::$options['listing_related'] ) {
					$classilist_listing->the_related_listings();
				}
				do_action( 'classilist_single_listing_after_related' );

				// Review.
				do_action( 'rtcl_single_listing_review' );
				?>
			</div>
			<?php
			if ( 'left-sidebar' != RDTheme::$layout ) {
				URI_Helper::get_custom_listing_template( 'sidebar-single' );
			}
			?>
		</div>
	</div>
</div>

<?php } ?>

<?php get_footer(); ?>