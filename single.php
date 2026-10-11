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
<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'top' );?>
<div id="primary" class="content-area site-single">
	<div class="container">
		<div class="row">
			<?php
			if ( 'left-sidebar' == RDTheme::$layout ) {
				get_sidebar();
			}
			?>
			<div class="<?php Helper::the_layout_class();?>">
				<main id="main" class="site-content-block">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="main-content">
							<?php
							get_template_part( 'template-parts/content-single' );
							if ( comments_open() || get_comments_number() ){
								comments_template();
							}
							?>
						</div>
					</main>
				<?php endwhile; ?>
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