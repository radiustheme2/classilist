<?php
/**
 * @package ClassifiedListing/Templates
 * @version 2.2.1.1
 */

use Rtcl\Helpers\Functions;
use radiustheme\ClassiList\RDTheme;

defined('ABSPATH') || exit;

if ( 'full-width' == RDTheme::$layout ){
	$classilist_layout_class = 'col-xl-12 col-lg-12 col-sm-12 col-12';
} else {
	$classilist_layout_class = 'col-xl-9 col-lg-8 col-sm-12 col-12';
}

get_header('listing');

?>
<div class="author-archive-wrap">
	<div class="container">
		<?php
			/**
			 * Hook: rtcl_before_main_content.
			 *
			 * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
			 */
			do_action('rtcl_before_main_content');
		?>
		<div class="row">
			<?php if ( 'left-sidebar' == RDTheme::$layout ): 
					/**
					 * Hook: rtcl_sidebar.
					 *
					 * @hooked rtcl_get_sidebar - 10
					 */
					do_action('rtcl_sidebar');
				endif; 
			?>
			<div class="<?php echo esc_attr( $classilist_layout_class ); ?>">
				<?php Functions::get_template( 'listing/author-content'); ?>
			</div>
			<?php if ( 'right-sidebar' == RDTheme::$layout ): ?>
				<?php 
					/**
					 * Hook: rtcl_sidebar.
					 *
					 * @hooked rtcl_get_sidebar - 10
					 */
					do_action('rtcl_sidebar');
				?>
			<?php endif; ?>
		</div>
		<?php
			/**
			 * Hook: rtcl_after_main_content.
			 *
			 * @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('rtcl_after_main_content');
		?>
	</div>
</div>
<?php 
get_footer('listing');
