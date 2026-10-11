<?php
/**
 *
 * @author     RadiusTheme
 * @package    classified-listing-store/templates
 * @version    1.0.0
 */

use Rtcl\Helpers\Functions as RtclFunctions;
use radiustheme\ClassiList\RDTheme;
use radiustheme\ClassiList\URI_Helper;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

RDTheme::$layout = 'right-sidebar'; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'top' );?>
<div id="primary" class="content-area classilist-store-single rtcl">
    <div class="container">
        <?php
        while ( have_posts() ) : the_post();
            RtclFunctions::get_template_part('content', 'single-store');
        endwhile;
        ?>
    </div>
</div>
<?php get_footer(); ?>