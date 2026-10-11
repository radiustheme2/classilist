<?php
/**
 * RadiusTheme License Page
 *
 * @since 1.0.0
 */

namespace RTLC;

/**
 * RadiusTheme License Helper
 */
class Helper {

	/**
	 * Theme Name
	 *
	 * @var string
	 */
	private $theme_name = '';

	/**
	 * Theme Slug
	 *
	 * @var string
	 */
	private $theme_slug = '';

	/**
	 * Class Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'theme_menu' ] );

		$theme_info = wp_get_theme();
		$theme_info = ( $theme_info->parent() ) ? $theme_info->parent() : $theme_info;
		$theme_name = $theme_info->get( 'Name' );

		$this->theme_name = $theme_name;
		$this->theme_slug = strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $theme_name ) ) );
	}

	/**
	 * Add options page
	 */
	public function theme_menu() {
		add_theme_page(
			esc_html__( 'Theme License', 'classilist' ),
			esc_html__( 'Theme License', 'classilist' ),
			'manage_options',
			'rtlc',
			[ $this, 'create_admin_page' ],
			99
		);
	}

	/**
	 * Options page callback
	 *
	 * @return void
	 */
	public function create_admin_page() {
		$theme_info = wp_get_theme();
		$theme_info = ( $theme_info->parent() ) ? $theme_info->parent() : $theme_info;
		$theme_name    = $theme_info->get( 'Name' );
		$theme_version = $theme_info->get( 'Version' );

		$is_valid  = rtlc_is_valid();
		$activated = ! empty( $is_valid['success'] );
		$support_url = 'https://www.radiustheme.com/contact/';
		?>
		<div class="wrap">
			<!-- Page Header -->
			<div class="rtlc-page-header">
				<h1><?php esc_html_e( 'Theme License', 'classilist' ); ?></h1>
				<div class="rtlc-activation-status <?php echo $activated ? 'rtlc-status-active' : ''; ?>">
					<span class="rtlc-status-dot"></span>
					<?php echo $activated ? esc_html__( 'Activated', 'classilist' ) : esc_html__( 'Not activated', 'classilist' ); ?>
				</div>
			</div>

			<?php settings_errors(); ?>

			<!-- Subtitle Banner -->
			<div class="rtlc-subtitle">
				<span class="dashicons dashicons-info-outline"></span>
				<span>
					<?php
					printf(
						/* translators: %s: theme name */
						__( 'Activate %s to unlock one-click demo import, automatic updates, bundled plugin installation, and premium support.', 'classilist' ),
						'<strong>' . esc_html( $theme_name ) . '</strong>'
					);
					?>
				</span>
			</div>

			<!-- Two Column Layout -->
			<div class="rtlc-page-layout">
				<!-- Main Content -->
				<div class="rtlc-main">
					<div class="rtlc-license-wrap">
						<!-- Theme Info -->
						<div class="rtlc-theme-info">
							<div class="rtlc-theme-icon">
								<?php echo esc_html( mb_substr( $theme_name, 0, 1 ) ); ?>
							</div>
							<div>
								<div class="rtlc-theme-name">
									<?php echo esc_html( $theme_name ); ?>
									<span class="rtlc-version">v<?php echo esc_html( $theme_version ); ?></span>
								</div>
								<div class="rtlc-theme-desc"><?php esc_html_e( 'Classified Ads WordPress Theme', 'classilist' ); ?> &middot; <?php esc_html_e( 'by RadiusTheme', 'classilist' ); ?></div>
							</div>
						</div>

						<!-- License Form Content -->
						<div class="rtlc-tab-content">
							<?php
							global $obitore_edd_updater;
							if ( $obitore_edd_updater && method_exists( $obitore_edd_updater, 'license_page_content' ) ) {
								$obitore_edd_updater->license_page_content();
							}
							?>
						</div>
					</div>
				</div>

				<!-- Sidebar -->
				<div class="rtlc-sidebar">
					<!-- Where's my key -->
					<div class="rtlc-sidebar-card">
						<h3><span class="dashicons dashicons-search"></span> <?php esc_html_e( "Where's my license key?", 'classilist' ); ?></h3>
						<ol class="rtlc-steps">
							<li><?php esc_html_e( 'Log in to your account at RadiusTheme.com.', 'classilist' ); ?></li>
							<li><?php esc_html_e( 'Go to Downloads, then License keys.', 'classilist' ); ?></li>
							<li><?php printf( esc_html__( 'Copy the key for %s.', 'classilist' ), esc_html( $theme_name ) ); ?></li>
						</ol>
						<a href="https://www.radiustheme.com/my-account/" target="_blank" class="rtlc-sidebar-link"><?php esc_html_e( 'Open RadiusTheme account', 'classilist' ); ?> &#8599;</a>
					</div>

					<!-- Need a hand -->
					<div class="rtlc-sidebar-card rtlc-help-card">
						<h3><?php esc_html_e( 'Need a hand?', 'classilist' ); ?></h3>
						<p><?php esc_html_e( 'Activation issues are usually a mistyped code or a license already in use on another domain.', 'classilist' ); ?></p>
						<a href="<?php echo esc_url( $support_url ); ?>" target="_blank" class="rtlc-support-btn">
							<span class="dashicons dashicons-format-chat"></span>
							<?php esc_html_e( 'Contact Support Center', 'classilist' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( is_admin() ) {
	new Helper();
}
