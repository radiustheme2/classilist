<?php
/**
 * Login Form Gallery
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var string $post_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Resources\Gallery;

?>
<div class="rtcl-post-gallery rtcl-post-section">
	<div class="classified-listing-form-title">
		<i class="fa fa-picture-o" aria-hidden="true"></i><h3><?php esc_html_e( 'Images', 'classilist' ); ?></h3>
	</div>
	<?php Gallery::rtcl_gallery_content( get_post( $post_id ), [ 'post_id_input' => '#_post_id' ] ); ?>
</div>