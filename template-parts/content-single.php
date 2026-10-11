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

$classilist_thumb_size = Helper::has_sidebar() ? 'rdtheme-size3' : 'rdtheme-size1';
$classilist_has_entry_meta = RDTheme::$options['post_date'] || ( RDTheme::$options['post_cats'] && has_category() ) || RDTheme::$options['post_author_name'] || RDTheme::$options['post_comment_num'] ? true : false;
$classilist_footer_class = RDTheme::$options['post_tags'] && has_tag() && RDTheme::$options['post_social'] ? 'col-md-6 col-sm-12 col-12' : 'col-md-12 col-sm-12 col-12';

$classilist_comments_number = number_format_i18n( get_comments_number() );
$classilist_comments_text   = $classilist_comments_number < 2 ? esc_html__( 'Comment' , 'classilist' ) : esc_html__( 'Comments' , 'classilist' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-each post-each-single' ); ?>>
	<?php do_action( 'classilist_before_content' );?>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-thumbnail"><?php the_post_thumbnail( $classilist_thumb_size );?></div>
	<?php endif; ?>

	<h1 class="single-post-title entry-title"><?php the_title();?></h1>

	<?php if ( $classilist_has_entry_meta ): ?>
		<ul class="post-meta">
			<?php if ( RDTheme::$options['post_date'] ): ?>
				<li><i class="fa fa-calendar" aria-hidden="true"></i><span class="updated published"><?php the_time( get_option( 'date_format' ) );?></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['post_author_name'] ): ?>
				<li><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e( 'By', 'classilist' );?> <span class="vcard author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="fn"><?php the_author(); ?></a></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['post_comment_num'] ): ?>
				<li><i class="fa fa-comments" aria-hidden="true"></i><?php echo esc_html( $classilist_comments_text );?>: <span><?php echo esc_html( $classilist_comments_number );?></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['post_cats'] && has_category() ): ?>
				<li><i class="fa fa-tags" aria-hidden="true"></i><?php the_category( ', ' );?></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>

	<div class="post-content entry-content"><?php the_content();?></div>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after'  => '</div>' ) );?>

	<?php if ( ( RDTheme::$options['post_tags'] && has_tag() ) || RDTheme::$options['post_social'] ): ?>
		<div class="post-footer">
			<div class="row">
				<?php if ( RDTheme::$options['post_tags'] && has_tag() ): ?>
					<div class="<?php echo esc_attr( $classilist_footer_class );?>">
						<div class="post-tags"><?php echo get_the_term_list( $post->ID, 'post_tag' ); ?></div>
					</div>
				<?php endif; ?>
				<?php if ( RDTheme::$options['post_social'] ): ?>
					<div class="<?php echo esc_attr( $classilist_footer_class );?>">
						<div class="post-social">
							<span class="rtin-title"><?php esc_html_e( 'Share', 'classilist' );?></span>
							<i class="rtin-icon fa fa-share-alt" aria-hidden="true"></i>
							<?php get_template_part( 'template-parts/social' );?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( RDTheme::$options['post_about_author'] ): ?>
		<div class="post-author-block">
			<h3 class="post-author-title post-title-block"><?php esc_html_e( 'About Author', 'classilist' );?></h3>
			<div class="post-author-details">
				<div class="rtin-left">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
				</div>
				<div class="rtin-right">
					<h3 class="author-name"><?php the_author_posts_link();?></h3>
					<div class="author-bio"><?php echo esc_html( get_the_author_meta( 'description' ) );?></div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'classilist_after_content' );?>
</article>