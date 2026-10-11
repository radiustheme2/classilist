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

// Layout class.
if ( 'full-width' == RDTheme::$layout ) {
	$classilist_layout_class = 'col-sm-12 col-12';
} else {
	$classilist_layout_class = 'col-lg-9 col-md-8 col-sm-12 col-12';
}
?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'top' ); ?>
<div id="primary" class="content-area site-search">
	<div class="container">
		<div class="row">
			<?php
			if ( 'left-sidebar' == RDTheme::$layout ) {
				get_sidebar();
			}
			?>
			<div class="<?php echo esc_attr( $classilist_layout_class ); ?>">
				<main id="main" class="site-content-block">
					<div class="main-content">
						<?php if ( have_posts() ) : ?>
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<?php get_template_part( 'template-parts/content', 'search' ); ?>
							<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>
					</div>
				</main>
				<?php get_template_part( 'template-parts/pagination' ); ?>
			</div>
			<?php
			if ( 'right-sidebar' == RDTheme::$layout ) {
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>