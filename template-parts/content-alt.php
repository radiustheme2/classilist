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

$classilist_thumb_size = 'rdtheme-size2';

$classilist_has_entry_meta = RDTheme::$options['blog_date'] || ( RDTheme::$options['blog_cats'] && has_category() ) || RDTheme::$options['blog_author_name'] || RDTheme::$options['blog_comment_num'] ? true : false;

$classilist_comments_number = number_format_i18n( get_comments_number() );
$classilist_comments_text   = $classilist_comments_number < 2 ? esc_html__( 'Comment' , 'classilist' ) : esc_html__( 'Comments' , 'classilist' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-each post-each-alt' ); ?>>
	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink();?>"><?php the_post_thumbnail( $classilist_thumb_size );?></a>
		</div>
	<?php endif; ?>
	<h2 class="post-title"><a href="<?php the_permalink();?>" class="entry-title" rel="bookmark"><?php the_title();?></a></h2>
	<?php if ( $classilist_has_entry_meta ): ?>
		<ul class="post-meta">
			<?php if ( RDTheme::$options['blog_date'] ): ?>
				<li><i class="fa fa-calendar" aria-hidden="true"></i><span class="updated published"><?php the_time( get_option( 'date_format' ) );?></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['blog_author_name'] ): ?>
				<li><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e( 'By', 'classilist' );?> <span class="vcard author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="fn"><?php the_author(); ?></a></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['blog_comment_num'] ): ?>
				<li><i class="fa fa-comments" aria-hidden="true"></i><?php echo esc_html( $classilist_comments_text );?>: <span><?php echo esc_html( $classilist_comments_number );?></span></li>
			<?php endif; ?>
			<?php if ( RDTheme::$options['blog_cats'] && has_category() ): ?>
				<li><i class="fa fa-tags" aria-hidden="true"></i><?php the_category( ', ' );?></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
	<div class="post-content entry-summary"><?php the_excerpt();?></div>
	<a href="<?php the_permalink();?>" class="read-more-btn"><?php esc_html_e( 'Read More', 'classilist' );?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
</article>