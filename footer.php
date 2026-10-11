<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.16
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php do_action( 'classilist_before_footer' );?>
</div><!-- #content -->
<?php get_template_part( 'template-parts/content', 'footer' );?>
</div><!-- #page -->
<?php wp_footer();?>
</body>
</html>