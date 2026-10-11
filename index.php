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

$classilist_post_class = Helper::has_sidebar() ? 'col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12';
?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'top' );?>
<div id="primary" class="content-area site-index">
	<div class="container">
		<div class="row">
			<?php
			if ( 'left-sidebar' == RDTheme::$layout ) {
				get_sidebar();
			}
			?>
			<div class="<?php Helper::the_layout_class();?>">
				<main id="main" class="site-content-block">
					<div class="main-content">
						<?php if ( have_posts() ) :?>
							<?php
							if ( ( is_home() || is_archive() ) && 'style2' == RDTheme::$options['blog_style'] ) {
								echo '<div class="post-isotope row">';
								while ( have_posts() ) : the_post();
									echo '<div class="' . esc_attr( $classilist_post_class ) . '">';
									get_template_part( 'template-parts/content-alt' );
									echo '</div>';
								endwhile;
								echo '</div>';
							}
							else {
								while ( have_posts() ) : the_post();
									get_template_part( 'template-parts/content' );
								endwhile;
							}
							?>
						<?php else:?>
							<?php get_template_part( 'template-parts/content', 'none' );?>
						<?php endif;?>
					</div>
				</main>
				<?php get_template_part( 'template-parts/pagination' );?>
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