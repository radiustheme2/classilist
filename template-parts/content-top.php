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

use RtclMarketplace\Hooks\ActionHooks;

$classilist_has_breadcrumb   = '';
$classilist_breadcrumb_title = '';

if ( RDTheme::$classilist_has_breadcrumb ) {
	$classilist_has_breadcrumb = true;
}

if ( ! empty( $page_title ) ) {
	$classilist_breadcrumb_title = $page_title;
} elseif ( is_post_type_archive( 'store' ) ) {
	$classilist_breadcrumb_title = esc_html__( 'Store', 'classilist' );
} elseif ( is_home() ) {
	if ( get_option( 'page_for_posts' ) ) {
		$classilist_breadcrumb_title = get_the_title( get_option( 'page_for_posts' ) );
	} else {
		$classilist_breadcrumb_title = apply_filters( 'classilist_blog_title', esc_html__( 'All Posts', 'classilist' ) );
	}
} elseif ( is_archive() ) {
	$classilist_breadcrumb_title = get_the_archive_title();
} elseif ( is_page() ) {
	$classilist_breadcrumb_title = get_the_title();
} elseif ( is_search() ) {
	$classilist_breadcrumb_title = esc_html__( 'Search Results for : ', 'classilist' ) . get_search_query();
}
?>
<?php if ( $classilist_breadcrumb_title || $classilist_has_breadcrumb ) : ?>
	<div class="top-content">
		<div class="container">

			<?php do_action( 'classilist_header_top' ); ?>

			<?php if ( $classilist_breadcrumb_title ) : ?>
				<h1 class="top-title"><?php echo wp_kses_post( $classilist_breadcrumb_title ); ?></h1>
			<?php endif; ?>

			<?php if ( $classilist_has_breadcrumb ) : ?>
				<div class="main-breadcrumb"><?php Helper::the_breadcrumb(); ?></div>
			<?php endif; ?>

			<?php
			if ( class_exists( 'RtclMarketplace' ) ) {
				ActionHooks::add_wc_notice();
			}
			?>

		</div>
	</div>
<?php else : ?>
	<div class="top-content-none">
		<div class="container">
			<?php do_action( 'classilist_header_top' ); ?>
		</div>
	</div>
<?php endif; ?>
