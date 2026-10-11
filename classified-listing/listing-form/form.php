<?php
/**
 * Listing Form
 *
 * @author    RadiusTheme
 * @package   classified-listing/templates
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;

if (!class_exists('RtclPro')) return;

$classilist_submit_txt = $post_id > 0 ? esc_html__( 'Update Listing', 'classilist' ) : esc_html__( 'Submit Listing', 'classilist' );
?>
<div class="rtcl rtcl-user rtcl-post-form-wrap">
    <?php do_action("rtcl_listing_form_before", $post_id); ?>
	<form action="" method="post" id="rtcl-post-form" class="form-vertical classilist-form">
        <?php do_action("rtcl_listing_form_start", $post_id); ?>
		<div class="rtcl-post">
			<?php do_action("rtcl_listing_form", $post_id); ?>
		</div>
		.
        <?php do_action("rtcl_listing_form_end", $post_id); ?>
	</form>
    <?php do_action("rtcl_listing_form_after", $post_id); ?>
</div>