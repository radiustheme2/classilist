<?php
/**
 * Display single listing reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/classified-listing/single-rtcl_listing-reviews.php.
 *
 * @see
 * @author     RadiusTheme
 * @package    classified-listing/Templates
 * @version    1.0.0
 */

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;
use RtclPro\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

global $post;
$listing = rtcl()->factory->get_listing( $post->ID );

/*
-------------------------------------
// . Review List
---------------------------------------*/
?>
<?php if ( have_comments() ) : ?>
	<?php
	$comments_number  = $listing->get_review_count();
	$comments_text    = $comments_number < 2 ? esc_html__( 'Review', 'classilist' ) : esc_html__( 'Reviews', 'classilist' );
	$comments_html    = number_format_i18n( $comments_number ) . ' ' . $comments_text;
	$comment_args     = [
		'callback' => [ Fns::class, 'comments' ],
	];
	$comment_nav_args = [
		'prev_text'          => esc_html__( 'Older Reviews', 'classilist' ),
		'next_text'          => esc_html__( 'Newer Reviews', 'classilist' ),
		'screen_reader_text' => esc_html__( 'Reviews navigation', 'classilist' ),
	];
	$average_rating   = $listing->get_average_rating();
	$rating_count     = $listing->get_rating_count();
	?>

	<div class="content-block-gap"></div>
	<div class="site-content-block">
		<div class="main-title-block review-title-block">
			<h3 class="main-title"><?php echo esc_html( $comments_html ); ?></h3>
			<div><?php echo wp_kses_post( Functions::get_rating_html( $average_rating, $rating_count ) ); ?></div>
		</div>
		<div class="main-content">
			<div class="review-area">
				<ul class="comment-list">
					<?php wp_list_comments( $comment_args ); ?>
				</ul>
				<?php the_comments_navigation( $comment_nav_args ); ?>

				<?php if ( ! comments_open() ) : ?>
					<div class="comments-closed"><?php esc_html_e( 'Reviews are closed.', 'classilist' ); ?></div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<?php
endif;


/*
-------------------------------------
// . Review Form
---------------------------------------*/

$commenter = wp_get_current_commenter();

$comment_form = [
	'title_reply'         => '',
	'title_reply_to'      => '',
	'title_reply_before'  => '',
	'title_reply_after'   => '',
	'comment_notes_after' => '',
	'fields'              => [
		'author' => '<div class="comment-form-author form-group">' . '<label for="author">' . esc_html__( 'Your Name', 'classilist' ) . '&nbsp;<span class="required">*</span></label> ' .
		'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></div>',
		'email'  => '<div class="comment-form-email form-group"><label for="email">' . esc_html__( 'Your Email', 'classilist' ) . '&nbsp;<span class="required">*</span></label> ' .
		'<input id="email" name="email" class="form-control" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></div>',
	],
	'label_submit'        => esc_html__( 'Submit', 'classilist' ),
	'class_submit'        => 'submit btn-send',
	'logged_in_as'        => '',
	'comment_field'       => '',
];

if ( $account_page_url = Link::get_my_account_page_link() ) {
	/* translators: %s is the URL to the login page. */
	$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'classilist' ), esc_url( $account_page_url ) ) . '</p>';
}

if ( Functions::get_option_item( 'rtcl_single_listing_settings', 'enable_review_rating', false, 'checkbox' ) ) {
	$comment_form['comment_field']  = '<div class="comment-form-title  form-group"><label for="title">' . esc_html__( 'Review Title', 'classilist' ) . '&nbsp;<span class="required">*</span></label><input type="text" class="form-control" name="title" id="title"  aria-required="true" required/></div>';
	$comment_form['comment_field'] .= '<div class="comment-form-rating  form-group"><label for="rating">' . esc_html__( 'Your Rating', 'classilist' ) . '<span class="required">*</span></label><select name="rating" id="rating" class="form-control" required>
	<option value="">' . esc_html__( 'Rate&hellip;', 'classilist' ) . '</option>
	<option value="5">' . esc_html__( 'Perfect', 'classilist' ) . '</option>
	<option value="4">' . esc_html__( 'Good', 'classilist' ) . '</option>
	<option value="3">' . esc_html__( 'Average', 'classilist' ) . '</option>
	<option value="2">' . esc_html__( 'Not that bad', 'classilist' ) . '</option>
	<option value="1">' . esc_html__( 'Very poor', 'classilist' ) . '</option>
	</select></div>';
}

$comment_form['comment_field'] .= '<div class="comment-form-comment  form-group"><label for="comment">' . esc_html__( 'Your Review', 'classilist' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" required></textarea></div>';
?>

<div class="content-block-gap"></div>
<div class="site-content-block">
	<div class="main-title-block"><h3 class="main-title"><?php esc_html_e( 'Leave a Review', 'classilist' ); ?></h3></div>
	<div class="main-content review-area">
		<?php comment_form( $comment_form ); ?>
	</div>
</div>

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound