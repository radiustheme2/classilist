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

if ( ! class_exists( 'RtclPro' ) ) {
	return;
}

use Rtcl\Helpers\Link;
use Rtcl\Helpers\Functions;
use RtclMarketplace\Hooks\ActionHooks;
use RtclPro\Controllers\Hooks\TemplateHooks;

$classilist_listing = $listing;
$type               = Listing_Functions::get_listing_type( $classilist_listing );

$classilist_archive_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
$classilist_show_book_button = ! empty( $classilist_archive_settings['display_options'] ) && in_array( 'book_button', (array) $classilist_archive_settings['display_options'], true );

?>
<div class="listing-list-each listing-list-each-alt<?php echo esc_attr( $class ); ?>">
	<div class="rtin-item">
		<div class="rtin-thumb">
			<a class="rtin-thumb-inner rtcl-media" href="<?php the_permalink(); ?>"><?php $classilist_listing->the_thumbnail(); ?></a>
			<?php TemplateHooks::sold_out_banner(); ?>
		</div>
		<div class="rtin-content">
			<h3 class="rtin-title listing-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

			<?php
			if ( $classilist_core_display['label'] ) {
				$classilist_listing->the_badges();
			}
			?>
			<?php
			if ( $classilist_core_display['fields'] ) {
				TemplateHooks::loop_item_listable_fields();
			}
			?>
			<ul class="rtin-meta">
				<?php if ( $classilist_core_display['type'] && $classilist_listing->can_show_ad_type() && $type ) : ?>
					<li class="listing-type">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.015 612.015" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M575.365.256H318.919c-20.227 0-23.936 8.852-43.226 29.021L23.242 280.963c-30.989 30.875-30.989 80.963 0 111.858l196.359 195.767c30.99 30.895 81.213 30.895 112.202 0l252.471-251.686c16.25-16.212 27.74-24.261 27.74-44.449V36.79C611.995 16.602 595.592.256 575.365.256zM303.739 560.619c-15.485 15.447-40.606 15.447-56.11 0L51.288 364.853c-15.485-15.447-15.485-40.492 0-55.939l28.353-28.256 251.857 252.279-27.759 27.682zm271.626-286.424c0 10.094-9.272 24.892-19.156 34.737L359.85 504.699 107.687 252.688 303.739 57.246c9.005-8.985 23.362-20.456 33.476-20.456h219.816c10.113 0 18.315 8.183 18.315 18.258v219.147h.019zM373.883 127.16c-30.99 30.895-30.99 80.964 0 111.858 30.989 30.895 81.212 30.895 112.202 0s30.99-80.964 0-111.858-81.231-30.894-112.202 0zm84.138 83.889c-15.486 15.447-40.606 15.447-56.111 0-15.485-15.447-15.485-40.492 0-55.939s40.606-15.447 56.111 0c15.503 15.448 15.503 40.492 0 55.939z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
						<?php echo esc_html( $type['label'] ); ?>
					</li>
				<?php endif; ?>
				<?php
				if ( $classilist_core_display['auth'] ) {
					if ( $classilist_listing->can_show_user() ) :
						if ( $classilist_listing->can_add_user_link() && ! is_author() ) :
							?>
						<li class="rtin-usermeta">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M437.02 74.981C388.667 26.629 324.38 0 256 0S123.333 26.629 74.98 74.981C26.629 123.333 0 187.62 0 256s26.629 132.667 74.98 181.019C123.333 485.371 187.62 512 256 512s132.667-26.629 181.02-74.981C485.371 388.667 512 324.38 512 256s-26.629-132.667-74.98-181.019zM256 482c-60.844 0-116.142-24.177-156.812-63.419C121.212 351.287 184.487 305 256 305s134.788 46.287 156.813 113.582C372.142 457.823 316.844 482 256 482zm-75-282c0-41.355 33.645-75 75-75s75 33.645 75 75-33.645 75-75 75-75-33.645-75-75zm254.34 193.354c-22.07-51.635-65.404-90.869-117.777-108.35C343.863 265.904 361 234.918 361 200c0-57.897-47.103-105-105-105s-105 47.103-105 105c0 34.918 17.137 65.904 43.438 85.004-52.374 17.481-95.708 56.715-117.778 108.35C47.414 355.259 30 307.628 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 51.628-17.414 99.259-46.66 137.354z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
							<a href="<?php echo esc_url( $classilist_listing->get_the_author_url() ); ?>"><?php $classilist_listing->the_author(); ?></a>
							<?php do_action( 'rtcl_after_author_meta', $classilist_listing->get_owner_id() ); ?>
						</li>
						<?php else : ?>
							<li class="rtin-usermeta">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M437.02 74.981C388.667 26.629 324.38 0 256 0S123.333 26.629 74.98 74.981C26.629 123.333 0 187.62 0 256s26.629 132.667 74.98 181.019C123.333 485.371 187.62 512 256 512s132.667-26.629 181.02-74.981C485.371 388.667 512 324.38 512 256s-26.629-132.667-74.98-181.019zM256 482c-60.844 0-116.142-24.177-156.812-63.419C121.212 351.287 184.487 305 256 305s134.788 46.287 156.813 113.582C372.142 457.823 316.844 482 256 482zm-75-282c0-41.355 33.645-75 75-75s75 33.645 75 75-33.645 75-75 75-75-33.645-75-75zm254.34 193.354c-22.07-51.635-65.404-90.869-117.777-108.35C343.863 265.904 361 234.918 361 200c0-57.897-47.103-105-105-105s-105 47.103-105 105c0 34.918 17.137 65.904 43.438 85.004-52.374 17.481-95.708 56.715-117.778 108.35C47.414 355.259 30 307.628 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 51.628-17.414 99.259-46.66 137.354z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
								<?php $classilist_listing->the_author(); ?>
								<?php do_action( 'rtcl_after_author_meta', $classilist_listing->get_owner_id() ); ?>
							</li>
							<?php
						endif;
					endif;
				}
				?>

				<?php if ( $classilist_core_display['date'] ) : ?>
					<li class="listing-date">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 379.5 379.5" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m81.425 332.434-18.563 28.563c-3.593 5.569-2.036 12.994 3.533 16.587 2.036 1.317 4.252 1.916 6.527 1.916 3.952 0 7.785-1.916 10.06-5.449l18.144-27.905c25.988 15.449 56.288 24.372 88.624 24.372 32.396 0 62.695-8.922 88.624-24.431l18.084 27.905c2.275 3.533 6.168 5.449 10.06 5.449 2.216 0 4.491-.599 6.527-1.916 5.569-3.593 7.126-11.018 3.533-16.587l-18.503-28.563c39.761-31.797 65.33-80.72 65.33-135.511 0-95.75-77.905-173.655-173.655-173.655S16.095 101.113 16.095 196.863c0 54.791 25.569 103.714 65.33 135.571zM189.75 47.16c82.576 0 149.703 67.127 149.703 149.703S272.326 346.566 189.75 346.566 40.047 279.439 40.047 196.863 107.174 47.16 189.75 47.16z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M229.751 247.822c2.275 1.976 5.09 2.934 7.904 2.934a12.03 12.03 0 0 0 9.042-4.072c4.371-4.97 3.832-12.515-1.138-16.886l-43.833-38.384V95.065c0-6.587-5.389-11.976-11.976-11.976s-11.976 5.389-11.976 11.976v101.798c0 3.473 1.497 6.767 4.072 9.042zM40.047 62.31c3.114 0 6.228-1.198 8.563-3.593C62.862 44.166 79.03 32.01 96.575 22.549c5.808-3.114 8.024-10.359 4.91-16.228-3.114-5.808-10.359-8.024-16.228-4.91-19.76 10.599-37.844 24.192-53.832 40.54-4.611 4.731-4.551 12.335.18 16.946 2.394 2.276 5.448 3.413 8.442 3.413zM282.925 22.549c17.605 9.401 33.713 21.617 47.965 36.168 2.335 2.395 5.449 3.593 8.563 3.593a12.03 12.03 0 0 0 8.383-3.413c4.731-4.611 4.79-12.216.18-16.946-15.928-16.288-34.072-29.941-53.833-40.539-5.868-3.114-13.114-.898-16.228 4.91-3.054 5.868-.898 13.113 4.97 16.227z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
						<?php $classilist_listing->the_time(); ?>
					</li>
				<?php endif; ?>
				<?php if ( $classilist_core_display['location'] && $classilist_listing->has_location() ) : ?>
					<li class="lisging-location">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 150 150" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M72.214 128.574c.843.567 1.816.85 2.789.85s1.946-.283 2.789-.85c1.968-1.323 48.193-32.907 48.193-77.512C125.985 22.907 103.114 0 75.003 0 46.891 0 24.02 22.907 24.02 51.062c0 44.605 46.226 76.189 48.194 77.512zM75.003 10c22.598 0 40.982 18.42 40.982 41.062 0 33.366-31.336 59.82-40.982 67.172-9.651-7.355-40.983-33.809-40.983-67.172C34.02 28.42 52.404 10 75.003 10z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="M94.888 49.828c0-10.976-8.918-19.905-19.88-19.905-10.968 0-19.891 8.93-19.891 19.905 0 10.982 8.923 19.917 19.891 19.917 10.962-.001 19.88-8.935 19.88-19.917zm-29.771 0c0-5.462 4.437-9.905 9.891-9.905 5.448 0 9.88 4.443 9.88 9.905 0 5.468-4.432 9.917-9.88 9.917-5.454-.001-9.891-4.45-9.891-9.917zM75 150c28.765 0 57.885-8.573 57.885-24.959 0-5.186-3.071-12.584-17.701-18.383a5 5 0 1 0-3.685 9.297c8.404 3.331 11.387 6.977 11.387 9.086C122.885 130.996 103.786 140 75 140s-47.885-9.004-47.885-14.959c0-2.11 2.982-5.756 11.387-9.086a5.002 5.002 0 0 0-3.685-9.297c-14.63 5.799-17.701 13.198-17.701 18.383C17.115 141.427 46.235 150 75 150z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
						<?php $classilist_listing->the_locations( true, true ); ?>
					</li>
				<?php endif; ?>
				<?php
				if ( $classilist_core_display['cat'] ) :
					if ( $classilist_listing->has_category() && $classilist_listing->can_show_category() ) {
						$classilist_categories = $classilist_listing->get_categories();
						?>
						<li class="lisging-category">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m24.92 7.42-5.5-5.09a5.07 5.07 0 0 0-6.84 0l-5.5 5.09a4.91 4.91 0 0 0-2.08 4v14.65A5 5 0 0 0 10 31h12a5 5 0 0 0 5-4.93V11.42a4.91 4.91 0 0 0-2.08-4zM25 26.07A3 3 0 0 1 22 29H10a3 3 0 0 1-3-2.93V11.42A2.93 2.93 0 0 1 8.27 9l.11-.09 5.56-5.11a3.05 3.05 0 0 1 4.12 0l5.56 5.13.11.09a2.93 2.93 0 0 1 1.27 2.4z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="M16 7a3.5 3.5 0 1 0 3.5 3.5A3.5 3.5 0 0 0 16 7zm0 5a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 16 12z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
							<?php
							foreach ( $classilist_categories as $classilist_category ) {
								echo wp_kses_post( $classilist_glue ?? '' );
								?>
								<a href="<?php echo esc_url( get_term_link( $classilist_category ) ); ?>"><?php echo esc_html( $classilist_category->name ); ?></a>
								<?php
								$classilist_glue = '<span class="rtcl-separator">, </span>';
							}
							?>
						</li>
						<?php
					}
				endif;
				?>
			</ul>

			<?php if ( $classilist_core_display['price'] ) : ?>
				<div class="rtin-price"><?php Functions::print_html( $classilist_listing->get_price_html() ); ?></div>
			<?php endif; ?>

			<?php do_action( 'classilist_listing_list_view_after_content', $classilist_listing ); ?>

			<?php
			if ( class_exists( 'RtclMarketplace' ) ) {
				ActionHooks::add_buy_button();
			}
			?>

			<?php
			if ( function_exists( 'rtrb_cl_booking_button' ) ) {
				if ( $classilist_show_book_button ) {
					rtrb_cl_booking_button();
				}
			}
			?>

		</div>

	</div>
	<?php
	if ( $map ) {
		$classilist_listing->the_map_lat_long();}
	?>
</div>