<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.2.4
 */

namespace radiustheme\ClassiList;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Models\Listing;
use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Pagination;
use radiustheme\ClassiList\URI_Helper;
use Rtcl\Services\FormBuilder\FBField;
use Rtcl\Controllers\Hooks\TemplateHooks as FreeTemplateHooks;
use RadiusTheme\RadiusBooking\Integrations\ClassifiedListing\ListingFrontendHooks as RtrbFrontendHooks;

/**
 * This is listing related all custom functions class which is used in theme. It has all the custom functions related to listing.
 */
class Listing_Functions {

	protected static $instance = null;

	/**
	 * Initialize theme hooks and filters.
	 *
	 * Registers all required actions and filters for theme functionality,
	 * including listing customization, settings overrides, UI adjustments,
	 * and plugin integrations.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'theme_support' ] );
		add_filter( 'get_the_archive_title', [ $this, 'archive_title' ] );
		add_filter( 'rtcl_default_placeholder_url', [ $this, 'placeholder_img_url' ] ); // change placeholder image.

		add_action(
			'init',
			function () {
				add_action( 'classilist_listing_list_view_after_content', [ $this, 'fav_listing_delete_btn' ] ); // delete from fav button.
			}
		);

		add_action( 'classilist_listing_list_items_after_content_ends', [ $this, 'top_ad_sign' ] ); // Top Ad sign.

		add_filter( 'classilist_single_listing_time_format', [ $this, 'classilist_change_listing_time_format' ], 20, 1 );
		add_filter( 'classilist_listing_grid_col_class', [ $this, 'classilist_listing_archive_grid' ], 10, 2 );

		// Override plugin options.
		add_filter( 'rtcl_general_settings', [ $this, 'override_general_settings' ] );
		add_filter( 'rtcl_style_settings', [ $this, 'override_style_settings' ] );
		add_filter( 'rtcl_bootstrap_dequeue', '__return_false' );

		// Remove price type from single listing.
		add_filter( 'rtcl_add_price_type_at_price', '__return_empty_string' );

		// Store Filter.
		add_filter( 'rtcl_store_time_options', [ $this, 'classilist_rtcl_store_time_options_rt_cb' ] );

		// Add excerpt in quick view.
		add_action( 'rtcl_quick_view_summary', [ $this, 'listing_excerpt' ], 60 );

		add_filter( 'rtcl_get_listing_display_options', [ $this, 'archive_custom_listing_options' ] );

		// Remove form submit button
		// Profile page.
		remove_action( 'rtcl_before_main_content', [ FreeTemplateHooks::class, 'breadcrumb' ], 6 );
		if ( method_exists( 'Rtcl\Helpers\Functions', 'has_map' ) && Functions::has_map() ) {
			if ( 'geo' === Functions::location_type() ) {
				remove_action( 'rtcl_edit_account_form', [ FreeTemplateHooks::class, 'edit_account_form_geo_location' ], 50 );
			}
			remove_action( 'rtcl_edit_account_form', [ FreeTemplateHooks::class, 'edit_account_map_field' ], 60 );
		}
		add_action( 'admin_notices', [ $this, 'rtcl_merge_notice' ] );

		/* ===== Radius Booking ===== */
		// Must run after the plugin's init_classes() (priority 10) which calls ListingFrontendHooks::init().
		add_action(
			'init',
			function () {
				if ( class_exists( RtrbFrontendHooks::class ) ) {
					remove_action( 'rtcl_single_listing_sidebar', [ RtrbFrontendHooks::class, 'renderBookNowButton' ], 30 );
					// Fallback hooks used by various themes.
					remove_action( 'rtcl_after_single_listing_sidebar', [ RtrbFrontendHooks::class, 'renderBookNowButton' ], 30 );
					remove_action( 'rtcl_single_listing_inner_sidebar', [ RtrbFrontendHooks::class, 'renderBookNowButton' ], 30 );
				}
			},
			20
		);
	}

	/**
	 * Gets the singleton instance of Listing_Functions.
	 *
	 * @return self|null The singleton instance.
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Adds theme support for Rtcl plugin.
	 *
	 * @return void
	 */
	public function theme_support() {
		add_theme_support( 'rtcl' );
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function archive_custom_listing_options( $options ) {
		$options['book_button'] = esc_html__( 'Booking Button', 'classilist' );
		return $options;
	}

	/**
	 * Displays admin notice if Classified Listing Pro version is outdated.
	 *
	 * Checks if the plugin exists and version is less than 2.0.0, then displays
	 * a warning notice. Also displays a notice to switch to parent theme after updates.
	 *
	 * @return void
	 */
	public function rtcl_merge_notice() {
		$rtcl_dir = '';

		if ( defined( 'WP_PLUGIN_DIR' ) ) {
			$rtcl_dir = WP_PLUGIN_DIR . '/classified-listing-pro/classified-listing-pro.php';
		}

		if ( file_exists( $rtcl_dir ) ) {
			$rtcl_info = get_plugin_data( $rtcl_dir );
			$version   = $rtcl_info['Version'];
			if ( version_compare( $version, '2.0.0', '<' ) ) {
				$message = sprintf( __( 'You have to must update <strong>Classified Listing Pro</strong> plugin, otherwise functionality will not work properly.', 'classilist' ) );
				printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
			}
		}

		$class = 'notice notice-warning';

		if ( is_child_theme() ) {
			$link = '<strong><a target="_blank" href="https://www.radiustheme.com/support/">support</a></strong>';
			/* translators: %s is a HTML link to the support page. */
			$child_message = sprintf( __( 'If you face any issue after update, please switch to parent theme and contact with %s.', 'classilist' ), $link );
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $child_message ) );
		}
	}

	/**
	 * Filters and returns custom archive titles for listing archives and taxonomies.
	 *
	 * Returns custom titles for listing post type archives, category taxonomy pages,
	 * and location taxonomy pages. Falls back to standard behavior for other archives.
	 *
	 * @param string $title The archive title to filter.
	 *
	 * @return string The filtered archive title.
	 */
	public function archive_title( $title ) {
		if ( is_post_type_archive( 'rtcl_listing' ) || is_tax( 'rtcl_category' ) || is_tax( 'rtcl_location' ) ) {
			if ( is_tax( 'rtcl_category' ) || is_tax( 'rtcl_location' ) ) {
				$title = single_cat_title( '', false );
			} else {
				$id    = Functions::get_page_id( 'listings' );
				$title = get_the_title( $id );
			}
		}
		return $title;
	}

	/**
	 * Returns the placeholder image URL for listings.
	 *
	 * @return string The URL to the no-image placeholder thumbnail.
	 */
	public function placeholder_img_url() {
		return URI_Helper::get_img( 'noimage-listing-thumb.jpg' );
	}

	/**
	 * Displays listing excerpt in quick view modal.
	 *
	 * @param Listing|null $listing The listing object to display excerpt for.
	 *
	 * @return void
	 */
	public function listing_excerpt( $listing ) {
		if ( ! $listing ) {
			return;
		}
		$listing->the_excerpt();
	}

	/**
	 * Overrides plugin general settings to disable Bootstrap loading.
	 *
	 * @param array $settings Plugin general settings array.
	 *
	 * @return array Modified settings with Bootstrap loading disabled.
	 */
	public function override_general_settings( $settings ) {
		$settings['load_bootstrap'] = '';
		return $settings;
	}

	/**
	 * Overrides plugin style settings with theme color options.
	 *
	 * @param array $settings Plugin style settings array.
	 *
	 * @return array Modified settings with theme colors.
	 */
	public function override_style_settings( $settings ) {
		$prefix          = Constants::$theme_prefix;
		$primary_color   = apply_filters( "{$prefix}_primary_color", RDTheme::$options['primary_color'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
		$secondery_color = apply_filters( "{$prefix}_secondery_color", RDTheme::$options['secondery_color'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound

		$args = [
			'primary'           => $primary_color,
			'link'              => $primary_color,
			'link_hover'        => $secondery_color,
			'button'            => $primary_color,
			'button_hover'      => $secondery_color,
			'button_text'       => '#ffffff',
			'button_hover_text' => '#ffffff',
		];

		$settings = wp_parse_args( $args, $settings );

		return $settings;
	}

	/**
	 * Configures time picker meridian display based on theme option.
	 *
	 * @param array $data Time picker configuration data.
	 *
	 * @return array Modified time picker configuration.
	 */
	public function classilist_rtcl_store_time_options_rt_cb( $data ) {

		$format = isset( RDTheme::$options['time_format'] ) ? RDTheme::$options['time_format'] : true;

		if ( false == $format ) {
			$data['showMeridian'] = false;
		}

		return $data;
	}

	/**
	 * Displays a remove button for favorite listings on the favorites account page.
	 *
	 * @param Listing $listing The listing object to remove from favorites.
	 *
	 * @return void
	 */
	public function fav_listing_delete_btn( $listing ) {
		if ( ! Functions::is_account_page( 'favourites' ) ) {
			return;
		}
		?>
		<div class="rtin-action-btn">
			<a href="#" class="btn rtcl-delete-favourite-listing" data-id="<?php echo esc_attr( $listing->get_id() ); ?>"><?php esc_html_e( 'Remove from Favourites', 'classilist' ); ?></a>
		</div>
		<?php
	}

	/**
	 * Displays a "Top Ad" badge with trophy icon for featured listings.
	 *
	 * @return void
	 */
	public function top_ad_sign() {
		?>
		<div class="topad-sign"><i class="fa fa-trophy" aria-hidden="true"></i><?php esc_html_e( 'Top Ad', 'classilist' ); ?></div>
		<?php
	}

	/**
	 * Builds responsive Bootstrap grid column classes for listing grid layout.
	 *
	 * Combines desktop, tablet, and mobile column settings from theme options
	 * to create responsive Bootstrap grid classes with fallback defaults.
	 *
	 * @return string Responsive Bootstrap column classes for grid layout.
	 *
	 * @since 2.2.4
	 */
	public function classilist_listing_archive_grid() {

		$col_class  = isset( RDTheme::$options['grid_desktop_column'] ) ? 'col-xl-' . RDTheme::$options['grid_desktop_column'] : 'col-xxl-4 col-xl-4';
		$col_class .= isset( RDTheme::$options['grid_tablet_column'] ) ? ' col-md-' . RDTheme::$options['grid_tablet_column'] . ' col-sm-' . RDTheme::$options['grid_tablet_column'] : ' col-lg-6 col-md-6 col-sm-6';
		$col_class .= isset( RDTheme::$options['grid_mobile_column'] ) ? ' col-' . RDTheme::$options['grid_mobile_column'] : ' col-12';

		return $col_class;
	}

	/**
	 * Extracts top listings from a query and modifies the global WP_Query to exclude them.
	 *
	 * This function processes a separate query containing top/featured listings, extracts their IDs,
	 * and then modifies the main WordPress query to exclude these IDs from regular listing results.
	 * This prevents top listings from appearing twice in the results (once as featured, once in regular results).
	 *
	 * The function performs the following operations:
	 * 1. Collects all post IDs from the provided query (top listings)
	 * 2. Stores them in the global $rtclTopListingIds array for later reference
	 * 3. Merges collected IDs with any existing excluded IDs in the main query
	 * 4. Replaces the global $wp_query with a new query that excludes the top listing IDs
	 *
	 * @param \WP_Query $query The WP_Query object containing top/featured listings to be excluded.
	 *
	 * @return void This function has side effects:
	 *              - Sets global $rtclTopListingIds to array of top listing post IDs
	 *              - Modifies global $wp_query to exclude the top listing IDs via post__not_in parameter
	 *
	 * @since 2.2.4
	 * @static
	 * @global array    $rtclTopListingIds Global array storing the IDs of top listings.
	 * @global WP_Query $wp_query          The main WordPress query object, replaced if top IDs exist.
	 *
	 * @example
	 * // Retrieve top listings
	 * $top_query = new WP_Query( [
	 *     'post_type'      => 'rtcl_listing',
	 *     'posts_per_page' => 5,
	 *     'meta_key'       => 'is_top',
	 *     'meta_value'     => 1,
	 * ] );
	 *
	 * // Get regular listings and then exclude tops from them
	 * Listing_Functions::set_top_query_globally( $top_query );
	 * // Result: $wp_query is modified to exclude IDs found in $top_query
	 */
	public static function set_top_query_globally( $query ) {
		global $rtclTopListingIds;

		$rtclTopListingIds = [];
		$paginated         = ! $query->get( 'no_found_rows' );
		$listings          = (object) [
			'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
			'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
			'per_page'     => (int) $query->get( 'posts_per_page' ),
			'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
		];

		Functions::setup_loop(
			[
				'is_shortcode' => true,
				'is_search'    => false,
				'is_paginated' => false,
				'as_top'       => true,
				'total'        => $listings->total,
				'total_pages'  => $listings->total_pages,
				'per_page'     => $listings->per_page,
				'current_page' => $listings->current_page,
			]
		);

		if ( Functions::get_loop_prop( 'total' ) ) {
			while ( $query->have_posts() ) :
				$query->the_post();
				$rtclTopListingIds[] = get_the_ID();
			endwhile;
			wp_reset_postdata();
		}

		Functions::reset_loop();

		if ( ! empty( $rtclTopListingIds ) ) {
			global $wp_query;
			$args             = $wp_query->query_vars;
			$existingExcluded = $wp_query->get( 'post__not_in' );
			if ( ! is_array( $existingExcluded ) ) {
				$existingExcluded = [];
			}
			$args['post__not_in'] = array_merge( $existingExcluded, $rtclTopListingIds );
			$wp_query             = new \WP_Query( $args );
		}
	}

	/**
	 * Generates a formatted pagination text string for displaying listing results count.
	 *
	 * Converts pagination information into a human-readable format displaying the range
	 * of results currently shown and the total number of results. Handles singular and
	 * plural cases, with proper translation support.
	 *
	 * @param array|false $post_num {
	 *     Pagination information array, or false if no results on current page.
	 *
	 *     @type int $first The position number of the first result on the current page.
	 *     @type int $last  The position number of the last result on the current page.
	 *     @type int $total The total number of matching results across all pages.
	 * }
	 *
	 * @return string Formatted pagination text. Examples:
	 *                - "Showing 1 result" (single result)
	 *                - "Showing 1–20 of 150 results" (multiple results)
	 *                - "Showing 0 result" (no results found)
	 *
	 * @since 2.2.4
	 * @static
	 *
	 * @example
	 * $query = new WP_Query( [ 'posts_per_page' => 20, 'paged' => 1 ] );
	 * $post_num = Listing_Functions::listing_post_num( $query );
	 * $text = Listing_Functions::listing_count_text( $post_num );
	 * echo $text; // Output: "Showing 1–20 of 150 results"
	 */
	public static function listing_count_text( $post_num ) {
		if ( $post_num ) {
			if ( 1 == $post_num['total'] ) {
				$post_num_text = esc_html__( 'Showing 1 result', 'classilist' );
			} else {
				/* translators: %1$d is the first result number, %2$d is the last result number, %3$d is the total results count. */
				$post_num_text = sprintf( esc_html__( 'Showing %1$d–%2$d of %3$d results', 'classilist' ), $post_num['first'], $post_num['last'], $post_num['total'] );
			}
		} else {
			$post_num_text = esc_html__( 'Showing 0 result', 'classilist' );
		}
		return $post_num_text;
	}

	/**
	 * Calculates pagination information for a listing query.
	 *
	 * Computes the position numbers of the first and last result on the current page,
	 * along with the total number of results across all pages. This information is
	 * typically used for displaying pagination text like "Showing 1–20 of 150 results".
	 *
	 * @param \WP_Query $rtcl_query The WP_Query object containing the listing results.
	 *                              Must have 'posts_per_page' and 'paged' query parameters set.
	 *
	 * @return array|false {
	 *     An associative array with pagination information, or false if no results on current page.
	 *
	 *     @type int $first The position number of the first result on the current page (1-indexed).
	 *     @type int $last  The position number of the last result on the current page (1-indexed).
	 *     @type int $total The total number of matching results across all pages.
	 * }
	 *
	 * @since 2.2.4
	 * @static
	 *
	 * @example
	 * $query = new WP_Query( [
	 *     'post_type'      => 'rtcl_listing',
	 *     'posts_per_page' => 20,
	 *     'paged'          => 2,
	 * ] );
	 * $pagination = Listing_Functions::listing_post_num( $query );
	 * // Returns: [ 'first' => 21, 'last' => 40, 'total' => 150 ]
	 */
	public static function listing_post_num( $rtcl_query ) {

		$total   = $rtcl_query->found_posts;
		$current = $rtcl_query->post_count;

		if ( $current ) {
			$posts_per_page       = $rtcl_query->query_vars['posts_per_page'];
			$paged                = ! empty( $rtcl_query->query['paged'] ) ? $rtcl_query->query['paged'] : 1;
			$num_of_skipped_items = $posts_per_page * ( $paged - 1 );

			$first = $num_of_skipped_items + 1;
			$last  = $num_of_skipped_items + $current;

			$result = [
				'first' => $first,
				'last'  => $last,
				'total' => $total,
			];
		} else {
			$result = false;
		}

		return $result;
	}

	/**
	 * Renders listing items in grid or list view with optional top listings.
	 *
	 * @param string   $view           The display view type ('grid' or 'list').
	 * @param WP_Query $rtcl_query     The main listings query.
	 * @param WP_Query $rtcl_top_query Optional query for top/featured listings.
	 * @param bool     $map            Whether map view is enabled.
	 *
	 * @return void
	 */
	public static function listing_query( $view, $rtcl_query, $rtcl_top_query = false, $map = false ) {
		$map = false;
		if ( 'grid' == $view ) {
			?>
				<?php
				if ( Fns::is_enable_top_listings() ) {
					if ( is_object( $rtcl_top_query ) && $rtcl_top_query->have_posts() ) {
						$top_listing = true;
						while ( $rtcl_top_query->have_posts() ) :
							$rtcl_top_query->the_post();
							?>
								<?php Functions::get_template( 'custom/grid', compact( 'top_listing', 'map' ) ); ?>
							<?php
						endwhile;
						wp_reset_postdata();
					}
				}

				while ( $rtcl_query->have_posts() ) :
					$rtcl_query->the_post();
					?>
						<?php Functions::get_template( 'custom/grid', compact( 'map' ) ); ?>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			<?php
		} else {
			$layout  = null;
			$display = [];
			if ( $map ) {
				$layout  = 'map';
				$display = [
					'excerpt' => false,
				];
			}

			if ( Fns::is_enable_top_listings() ) {
				if ( is_object( $rtcl_top_query ) && $rtcl_top_query->have_posts() ) {
					$top_listing = true;
					while ( $rtcl_top_query->have_posts() ) :
						$rtcl_top_query->the_post();
						Functions::get_template( 'custom/list', compact( 'top_listing', 'map', 'layout', 'display' ) );
					endwhile;
					wp_reset_postdata();
				}
			}

			while ( $rtcl_query->have_posts() ) :
				$rtcl_query->the_post();
				Functions::get_template( 'custom/list', compact( 'map', 'layout', 'display' ) );
			endwhile;
			wp_reset_postdata();
		}
	}

	/**
	 * Formats listing contact address, location, and zipcode.
	 *
	 * @param Listing $listing The listing object.
	 *
	 * @return string Formatted address HTML.
	 */
	public static function get_single_contact_address( $listing ) {

		$listing_id        = $listing->get_id();
		$listing_locations = $listing->get_locations();

		$render = $loc = '';

		$address = get_post_meta( $listing_id, 'address', true );
		$address = $address && Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', 'address', 'multi_checkbox' ) ? $address : '';

		$zipcode = get_post_meta( $listing_id, 'zipcode', true );
		$zipcode = $zipcode && Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', 'zipcode', 'multi_checkbox' ) ? $zipcode : '';

		$locations = [];
		if ( count( $listing_locations ) ) {
			foreach ( $listing_locations as $location ) {
				$locations[] = $location->name;
			}
			$locations = array_reverse( $locations );
			$loc       = implode( ', ', $locations );
		}

		if ( $address ) {
			$render .= sprintf( '<div>%s</div>', $address );
		}

		if ( $address && $loc && $zipcode ) {
			$render .= sprintf( '<div>%s, %s</div>', $loc, $zipcode );
		} elseif ( $address && $loc ) {
			$render .= sprintf( '<div>%s</div>', $loc );
		} elseif ( $zipcode ) {
			$render .= sprintf( '<div>%s</div>', $zipcode );
		}

		return $render;
	}

	/**
	 * Displays phone, WhatsApp, and Telegram contact information.
	 *
	 * @param string $phone    Phone number.
	 * @param string $whatsapp WhatsApp number.
	 * @param string $telegram Telegram handle.
	 *
	 * @return void
	 */
	public static function the_phone( $phone = '', $whatsapp = '', $telegram = '' ) {

		$mobileClass = wp_is_mobile() ? ' rtcl-mobile' : null;

		if ( $phone ) {
			$mobileClass   = wp_is_mobile() ? ' rtcl-mobile' : null;
			$phone_options = [
				'safe_phone'   => mb_substr( $phone, 0, mb_strlen( $phone ) - 3 ) . apply_filters( 'rtcl_phone_number_placeholder', 'XXX' ),
				'phone_hidden' => mb_substr( $phone, -3 ),
			];
			?>
			<div class='item-number phone reveal-phone<?php echo esc_attr( $mobileClass ); ?>'
				 data-options="<?php echo $phone_options ? esc_attr( wp_json_encode( $phone_options ) ) : ''; ?>">
				<i class="fa fa-phone-alt"></i>
				<div class='numbers'>

					<?php echo esc_html( $phone_options['safe_phone'] ); ?>
				</div>
				<small class='text-muted'><?php esc_html_e( '(Show)', 'classilist' ); ?></small>
			</div>
			<?php
		} if ( $whatsapp && ! Functions::is_field_disabled( 'whatsapp_number' ) ) {
			$mobileClass      = wp_is_mobile() ? ' rtcl-mobile' : null;
			$whatsapp_options = [
				'safe_phone'   => mb_substr( $whatsapp, 0, mb_strlen( $whatsapp ) - 3 ) . apply_filters( 'rtcl_phone_number_placeholder', 'XXX' ),
				'phone_hidden' => mb_substr( $whatsapp, -3 ),
			];
			?>
			<div class='item-number whatsapp reveal-phone<?php echo esc_attr( $mobileClass ); ?>'
				 data-options="<?php echo $whatsapp_options ? esc_attr( wp_json_encode( $whatsapp_options ) ) : ''; ?>">
				<!--                    <i class="fab fa-whatsapp"></i>-->
				<i class="fa-brands fa-square-whatsapp"></i>
				<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $whatsapp ); ?>&text=<?php echo esc_html( get_the_title() ); ?>">
					<div class='numbers'>
						<?php echo esc_html( $whatsapp_options['safe_phone'] ); ?>
					</div>
				</a>
				<small class='text-muted'><?php esc_html_e( '(Show)', 'classilist' ); ?></small>
			</div>
		<?php } if ( $telegram ) { ?>
			<div class='item-number telegram'>
				<i class="rtcl-icon rtcl-icon-telegram mr-2"></i>
				<a class="rtcl-telegram-message" target="_blank" href="tg://resolve?domain=<?php echo esc_attr( $telegram ); ?>">
					<span><?php esc_html_e( 'Call on Telegram', 'classilist' ); ?></span>
				</a>
			</div>
			<?php
		}
	}

	/**
	 * Gets listing type label and icon.
	 *
	 * @param Listing $listing The listing object.
	 *
	 * @return array|false Array with label and icon, or false if no type.
	 */
	public static function get_listing_type( $listing ) {

		$listing_types = Functions::get_listing_types();
		$listing_types = empty( $listing_types ) ? [] : $listing_types;

		$type = $listing->get_ad_type();

		if ( $type && ! empty( $listing_types[ $type ] ) ) {
			$result = [
				'label' => $listing_types[ $type ],
				'icon'  => 'fa-tags',
			];
		} else {
			$result = false;
		}

		return $result;
	}

	/**
	 * Retrieves listings from a store with sorting and pagination.
	 *
	 * @return \WP_Query Store listings query object.
	 */
	public static function store_query() {
		global $post;

		$args = [
			'post_type'      => rtcl()->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => Functions::get_option_item( 'rtcl_archive_listing_settings', 'listings_per_page', 20 ),
			'author'         => get_post_meta( $post->ID, 'store_owner_id', true ),
			'paged'          => Pagination::get_page_number(),
		];

		$archive_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
		$atts             = [
			'orderby' => ! empty( $archive_settings['orderby'] ) ? $archive_settings['orderby'] : 'date',
			'order'   => ! empty( $archive_settings['order'] ) ? $archive_settings['order'] : 'DESC',
		];

		$current_order = Pagination::get_listings_current_order( $atts['orderby'] . '-' . $atts['order'] );
		switch ( $current_order ) {
			case 'title-asc':
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
				break;
			case 'title-desc':
				$args['orderby'] = 'title';
				$args['order']   = 'DESC';
				break;
			case 'date-asc':
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
				break;
			case 'date-desc':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
			case 'price-asc':
				$args['meta_key'] = 'price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Required for ordering by price.
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;
			case 'price-desc':
				$args['meta_key'] = 'price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Required for ordering by price.
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'views-asc':
				$args['meta_key'] = '_views'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Required for ordering by price.
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;
			case 'views-desc':
				$args['meta_key'] = '_views'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Required for ordering by views.
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'rand':
				$args['orderby'] = 'rand';
				break;
		}

		return new \WP_Query( $args );
	}

	/**
	 * Change listing time format.
	 *
	 * @param string $string The time string to format.
	 *
	 * @return mixed|string Formatted time string.
	 */
	public function classilist_change_listing_time_format( $string ) {

		$time_format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
		if ( empty( $time_format ) ) {
			$time_format = $string;
		}
		return $time_format;
	}

	/**
	 * Checks if custom group fields have values for the current listing.
	 *
	 * Iterates through all custom fields in the form and checks if any have values
	 * assigned to the current listing. Returns true if at least one custom field has a value.
	 *
	 * @return bool|void True if custom fields exist with values, false otherwise.
	 */
	public static function form_builder_custom_group_field_check() {
		global $listing;
		$form = $listing->getForm();
		if ( $form ) {
			$fields           = $form->getFieldAsGroup( FBField::CUSTOM );
			$fields_available = false;
			if ( count( $fields ) ) {
				foreach ( $fields as $fieldName => $field ) {
					$field = new FBField( $field );
					$value = $field->getFormattedCustomFieldValue( $listing->get_id() );
					if ( ! empty( $value ) ) {
						return true;
					}
				}
				return $fields_available;
			}
		}
	}

	/**
	 * Displays seller phone number from listing with privacy masking.
	 *
	 * Shows the phone number with the last 3 digits masked for privacy.
	 * Allows users to reveal the full number on demand. Respects the media_type parameter
	 * to conditionally display based on context.
	 *
	 * @param Listing $listing    The listing object.
	 * @param string  $media_type The media type (e.g., 'phone', 'whatsapp').
	 *
	 * @return void
	 */
	public static function seller_phone_number( $listing ): void {
		if ( is_a( $listing, Listing::class ) ) {
			$phone = get_post_meta( $listing->get_id(), 'phone', true );
			if ( $phone ) {
				$mobileClass   = wp_is_mobile() ? ' rtcl-mobile' : null;
				$phone_options = [];
				if ( $phone ) {
					$phone_options = [
						'safe_phone'   => mb_substr( $phone, 0, mb_strlen( $phone ) - 3 ) . apply_filters( 'rtcl_phone_number_placeholder', 'XXX' ),
						'phone_hidden' => mb_substr( $phone, - 3 ),
					];
				}

				$phone_options = apply_filters(
					'rtcl_phone_number_options',
					$phone_options,
					[
						'phone' => $phone,
					]
				)
				?>
				<div class='rtcl-list-group-item reveal-phone<?php echo esc_attr( $mobileClass ); ?>'
					 data-options="<?php echo htmlspecialchars( wp_json_encode( $phone_options ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"
					 data-id="<?php echo esc_attr( $listing->get_id() ); ?>">
					<div class='media'>
						<div class='media-body'>
							<div class='numbers'>
							<?php
							if ( $phone ) {
								echo esc_html( $phone_options['safe_phone'] );
							}
							?>
								</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}

	/**
	 * Displays seller WhatsApp number from listing with privacy masking.
	 *
	 * Shows the WhatsApp number with the last 3 digits masked for privacy.
	 * Only displays if WhatsApp field is enabled. Allows users to reveal the full number
	 * on demand and provides a link to send WhatsApp message.
	 *
	 * @param Listing $listing    The listing object.
	 * @param string  $media_type The media type (e.g., 'whatsapp').
	 *
	 * @return void
	 */
	public static function seller_whatsapp_number( $listing ): void {
		if ( is_a( $listing, Listing::class ) ) {
			$whatsapp_number = get_post_meta( $listing->get_id(), '_rtcl_whatsapp_number', true );
			if ( $whatsapp_number && ! Functions::is_field_disabled( 'whatsapp_number' ) ) {
				$mobileClass   = wp_is_mobile() ? ' rtcl-mobile' : null;
				$phone_options = [];
				if ( $whatsapp_number && ! Functions::is_field_disabled( 'whatsapp_number' ) ) {
					$phone_options['safe_whatsapp_number'] = mb_substr( $whatsapp_number, 0, mb_strlen( $whatsapp_number ) - 3 ) . apply_filters( 'rtcl_phone_number_placeholder', 'XXX' );
					$phone_options['whatsapp_hidden']      = mb_substr( $whatsapp_number, - 3 );
				}
				$phone_options = apply_filters(
					'rtcl_phone_number_options',
					$phone_options,
					[
						'whatsapp_number' => $whatsapp_number,
					]
				)
				?>
				<div class='rtcl-list-group-item reveal-phone<?php echo esc_attr( $mobileClass ); ?>'
					 data-options="<?php echo htmlspecialchars( wp_json_encode( $phone_options ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"
					 data-id="<?php echo absint( $listing->get_id() ); ?>">
					<div class='media'>
						<div class='media-body'>
							<div class='numbers'>
								<?php
								if ( $whatsapp_number ) {
									echo esc_html( $phone_options['safe_whatsapp_number'] );
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
}

Listing_Functions::instance();