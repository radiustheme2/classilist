<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<section class="no-results not-found">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p><?php
		/* translators: %1$s is the URL to create a new post. */
		printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>', 'classilist' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	<?php elseif ( is_search() ) : ?>
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'classilist' ); ?></p>
		<?php get_search_form(); ?>
	<?php else : ?>
		<p><?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'classilist' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</section>