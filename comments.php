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

if ( post_password_required() ) {
    return;
}

if ( !have_comments() && !comments_open() ) {
    return;
}

$classilist_comments_number = number_format_i18n( get_comments_number() );
/* translators: %s is the number of comments. */
$classilist_comments_html   = sprintf( _n( '%s Comment', '%s Comments', $classilist_comments_number, 'classilist' ), number_format_i18n( $classilist_comments_number ) );

$classilist_commenter = wp_get_current_commenter();        
$classilist_req       = get_option( 'require_name_email' );
$classilist_aria_req  = ( $classilist_req ? " required" : '' );

$classilist_fields =  array(
    'author' =>
    '<div class="row"><div class="col-sm-4"><div class="form-group comment-form-author"><input type="text" id="author" name="author" value="' . esc_attr( $classilist_commenter['comment_author'] ) . '" placeholder="'.esc_attr__( 'Name', 'classilist' ).( $classilist_req ? ' *' : '' ).'" class="form-control"' . $classilist_aria_req . '></div></div>',

    'email' =>
    '<div class="col-sm-4 comment-form-email"><div class="form-group"><input id="email" name="email" type="email" value="' . esc_attr(  $classilist_commenter['comment_author_email'] ) . '" class="form-control" placeholder="'.esc_attr__( 'Email', 'classilist' ).( $classilist_req ? ' *' : '' ).'"' . $classilist_aria_req . '></div></div>',   

    'url' =>
    '<div class="col-sm-4 comment-form-website"><div class="form-group"><input id="website" name="website" type="text" value="' . esc_attr(  $classilist_commenter['comment_author_url'] ) . '" class="form-control" placeholder="'.esc_attr__( 'Website', 'classilist' ).( $classilist_req ? '' : '' ).'"' . $classilist_aria_req . '></div></div></div>',
);

$classilist_args = array(
    'class_submit'  => 'submit btn-send',
    'submit_field'  => '<div class="form-group form-submit">%1$s %2$s</div>',
    'comment_field' =>  '<div class="form-group comment-form-comment"><textarea id="comment" name="comment" required placeholder="'.esc_attr__( 'Comment *', 'classilist' ).'" class="textarea form-control" rows="10" cols="40"></textarea></div>',
    'fields' => apply_filters( 'comment_form_default_fields', $classilist_fields ), // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
);
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ): ?>
        <h3 class="comment-title post-title-block"><?php echo esc_html( $classilist_comments_html );?></h3>
        <?php
        $classilist_avatar = get_option( 'show_avatars' );
        ?>
        <ul class="comment-list<?php echo empty( $classilist_avatar ) ? ' avatar-disabled' : '';?>">
            <?php
            wp_list_comments(
                array(
                    'style'        => 'ul',
                    'callback'     => 'radiustheme\ClassiList\Helper::comments_callback',
                    'reply_text'   => esc_html__( 'Reply', 'classilist' ),
                    'avatar_size'  => 100,
                    'format'       => 'html5'
                ) 
            );
            ?>
        </ul>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :?>
            <nav class="comment-pagination">
                <ul>
                    <li><?php previous_comments_link( esc_html__( 'Older Comments', 'classilist' ) ); ?></li>
                    <li><?php next_comments_link( esc_html__( 'Newer Comments', 'classilist' ) ); ?></li>
                </ul>
            </nav>
        <?php endif;?>

    <?php endif;?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="comments-closed"><?php esc_html_e( 'Comments are closed.', 'classilist' ); ?></p>
    <?php endif;?>

    <?php
    if ( comments_open() ){
        comment_form( $classilist_args );
    }
    ?>
</div>