<?php
/**
 * License Utility - Styles, Scripts & Helper Functions
 *
 * @since 1.0.0
 */

namespace RTLC;

/**
 * License Utility
 */
class Utility {
	/**
	 * Class Constructor.
	 */
	public function __construct() {
		add_action( 'admin_head', [ $this, 'style' ] );
		add_action( 'admin_footer', [ $this, 'script' ] );
		add_action( 'in_admin_header', [ $this, 'hide_notices_on_license_page' ], 999 );
	}

	/**
	 * Remove all admin notices on the license page.
	 *
	 * @return void
	 */
	public function hide_notices_on_license_page() {
		if ( ! isset( $_GET['page'] ) || 'rtlc' !== $_GET['page'] ) {
			return;
		}

		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
	}

	/**
	 * License page styles.
	 *
	 * @return void
	 */
	public function style() {
		if ( ! isset( $_GET['page'] ) || 'rtlc' !== $_GET['page'] ) {
			return;
		}
		?>
		<style>
			/* ── Theme Color Variables ── */
			:root {
				--rtlc-primary: #3232ff;
				--rtlc-primary-hover: #0202c9;
				--rtlc-primary-light: #f5f8ff;
				--rtlc-primary-lighter: #eff1ff;
				--rtlc-primary-border: #f9a8b3;
				--rtlc-primary-border-hover: #fff0f2;
				--rtlc-dark: #2d2b55;
				--rtlc-dark-text: #c4c1e0;
				--rtlc-danger: #d63638;
				--rtlc-danger-hover: #b91c1c;
				--rtlc-danger-dark: #dc2626;
				--rtlc-success: #00a32a;
				--rtlc-success-bg: #ecfdf5;
				--rtlc-success-border: #a7f3d0;
				--rtlc-success-text: #065f46;
				--rtlc-info-bg: #eff6ff;
				--rtlc-info-border: #bfdbfe;
				--rtlc-info-text: #1e40af;
				--rtlc-info-icon: #3b82f6;
				--rtlc-warning-bg: #fffbeb;
				--rtlc-warning-border: #fde68a;
				--rtlc-warning-text: #92400e;
				--rtlc-warning-icon: #f59e0b;
			}

			/* ── Page Header ── */
			.rtlc-page-header {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
				align-items: center;
				gap: 24px;
				margin-bottom: 16px;
				max-width: 1240px;
			}

			.rtlc-page-header h1 {
				margin: 0;
			}

			.rtlc-page-header .notice {
				order: 3;
				width: 100%;
			}

			.rtlc-subtitle {
				display: flex;
				align-items: flex-start;
				gap: 12px;
				max-width: 1200px;
				margin: 0 0 24px;
				padding: 14px 18px;
				font-size: 13px;
				line-height: 1.6;
				color: var(--rtlc-info-text);
				background: var(--rtlc-info-bg);
				border: 1px solid var(--rtlc-info-border);
				border-radius: 8px;
			}

			.rtlc-subtitle .dashicons {
				color: var(--rtlc-info-icon);
				flex-shrink: 0;
				margin-top: 1px;
			}

			.rtlc-activation-status {
				display: flex;
				align-items: center;
				gap: 6px;
				white-space: nowrap;
				padding: 6px 14px;
				font-size: 13px;
				font-weight: 500;
				color: #6b7280;
				background: #f3f4f6;
				border: 1px solid #e5e7eb;
				border-radius: 50px;
			}

			.rtlc-status-dot {
				width: 8px;
				height: 8px;
				border-radius: 50%;
				background: var(--rtlc-danger);
				display: inline-block;
			}

			.rtlc-status-active {
				color: var(--rtlc-success-text);
				background: var(--rtlc-success-bg);
				border-color: var(--rtlc-success-border);
			}

			.rtlc-status-active .rtlc-status-dot {
				background: var(--rtlc-success);
			}

			/* ── Two Column Layout ── */
			.rtlc-page-layout {
				display: flex;
				gap: 24px;
				align-items: flex-start;
				max-width: 1240px;
			}

			.rtlc-main {
				flex: 1;
				min-width: 0;
			}

			/* ── Card Container ── */
			.rtlc-license-wrap {
				background: #fff;
				border: 1px solid #e5e7eb;
				border-radius: 8px;
				box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
				overflow: hidden;
			}

			/* ── Theme Info ── */
			.rtlc-theme-info {
				display: flex;
				align-items: center;
				gap: 14px;
				padding: 20px 24px;
				border-bottom: 1px solid #f3f4f6;
			}

			.rtlc-theme-icon {
				width: 44px;
				height: 44px;
				border-radius: 10px;
				background: var(--rtlc-primary);
				display: flex;
				align-items: center;
				justify-content: center;
				flex-shrink: 0;
				font-size: 22px;
				font-weight: 700;
				color: #fff;
				line-height: 1;
			}

			.rtlc-theme-name {
				font-size: 15px;
				font-weight: 600;
				color: #1d2327;
				display: flex;
				align-items: center;
				gap: 8px;
			}

			.rtlc-version {
				font-size: 11px;
				font-weight: 500;
				color: var(--rtlc-primary);
				background: var(--rtlc-primary-lighter);
				padding: 2px 8px;
				border-radius: 50px;
			}

			.rtlc-theme-desc {
				font-size: 13px;
				color: #6b7280;
				margin-top: 2px;
			}

			/* ── Tab Content ── */
			.rtlc-tab-content {
				padding: 24px 24px 28px;
			}

			/* ── Form Fields ── */
			.rtlc-field-group {
				margin-bottom: 20px;
			}

			.rtlc-field-group label {
				display: block;
				font-size: 13px;
				font-weight: 600;
				color: #374151;
				margin-bottom: 6px;
			}

			.rtlc-required {
				color: var(--rtlc-danger);
			}

			.rtlc-tab-content .rtlc-input {
				width: 100%;
				max-width: 100%;
				padding: 10px 14px;
				font-size: 14px;
				border: 1px solid #d1d5db;
				border-radius: 6px;
				background: #fff;
				color: #1d2327;
				box-sizing: border-box;
				transition: border-color 0.15s;
			}

			.rtlc-tab-content .rtlc-input:focus {
				border-color: var(--rtlc-primary);
				box-shadow: none;
				outline: none;
			}

			.rtlc-tab-content .rtlc-input[readonly] {
				background: #f3f4f6;
				color: #6b7280;
				cursor: not-allowed;
			}

			.rtlc-field-desc {
				font-size: 12px;
				color: #9ca3af;
				margin: 6px 0 0;
			}

			/* ── Notice Box ── */
			.rtlc-notice-box {
				display: flex;
				gap: 10px;
				align-items: flex-start;
				padding: 12px 16px;
				background: var(--rtlc-info-bg);
				border: 1px solid var(--rtlc-info-border);
				border-radius: 6px;
				margin-bottom: 20px;
				font-size: 13px;
				color: var(--rtlc-info-text);
				line-height: 1.5;
			}

			.rtlc-notice-box .dashicons {
				color: var(--rtlc-info-icon);
				margin-top: 1px;
				flex-shrink: 0;
			}

			.rtlc-notice-box a {
				color: var(--rtlc-info-text);
				text-decoration: underline;
			}

			.rtlc-notice-warning {
				background: var(--rtlc-warning-bg);
				border-color: var(--rtlc-warning-border);
				color: var(--rtlc-warning-text);
				margin-top: 15px;
			}

			.rtlc-notice-warning .dashicons {
				color: var(--rtlc-warning-icon);
			}

			.rtlc-notice-warning a {
				color: var(--rtlc-warning-text);
			}

			/* ── Status Badge ── */
			.rtlc-status-btn {
				display: inline-block;
				color: #fff;
				padding: 4px 14px;
				border-radius: 50px;
				font-size: 13px;
				font-weight: 500;
				line-height: 1.5;
			}

			.rtlc-unverified {
				background: var(--rtlc-danger);
			}

			.rtlc-verified {
				background: var(--rtlc-success);
			}

			/* ── Activate / Deactivate Button ── */
			.rtlc-activate-btn {
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				width: 100%;
				padding: 12px 20px;
				font-size: 14px;
				font-weight: 600;
				color: #fff;
				background: var(--rtlc-primary);
				border: none;
				border-radius: 6px;
				cursor: pointer;
				transition: background 0.15s;
				text-decoration: none;
				box-sizing: border-box;
			}

			.rtlc-activate-btn:hover {
				background: var(--rtlc-primary-hover);
			}

			.rtlc-activate-btn:focus {
				outline: none;
				box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--rtlc-primary);
			}

			.rtlc-activate-btn .dashicons {
				font-size: 18px;
				width: 18px;
				height: 18px;
			}

			.rtlc-deactivate-btn {
				background: var(--rtlc-danger-dark);
			}

			.rtlc-deactivate-btn:hover {
				background: var(--rtlc-danger-hover);
			}

			.rtlc-deactivate-btn:focus {
				box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--rtlc-danger-dark);
			}

			/* ── Sidebar ── */
			.rtlc-sidebar {
				width: 300px;
				flex-shrink: 0;
				display: flex;
				flex-direction: column;
				gap: 16px;
			}

			.rtlc-sidebar-card {
				background: #fff;
				border: 1px solid #e5e7eb;
				border-radius: 8px;
				padding: 20px;
				box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
			}

			.rtlc-sidebar-card h3 {
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 14px;
				font-weight: 600;
				color: #1d2327;
				margin: 0 0 14px;
			}

			.rtlc-sidebar-card h3 .dashicons {
				color: var(--rtlc-primary);
				font-size: 18px;
				width: 18px;
				height: 18px;
			}

			/* Numbered Steps */
			.rtlc-steps {
				margin: 0 0 14px;
				padding: 0;
				list-style: none;
				counter-reset: rtlc-step;
			}

			.rtlc-steps li {
				counter-increment: rtlc-step;
				display: flex;
				align-items: flex-start;
				gap: 10px;
				font-size: 13px;
				color: #4b5563;
				line-height: 1.5;
				margin-bottom: 10px;
			}

			.rtlc-steps li::before {
				content: counter(rtlc-step);
				display: flex;
				align-items: center;
				justify-content: center;
				min-width: 22px;
				height: 22px;
				font-size: 12px;
				font-weight: 600;
				color: var(--rtlc-primary);
				background: var(--rtlc-primary-lighter);
				border-radius: 50%;
				flex-shrink: 0;
			}

			.rtlc-sidebar-link {
				font-size: 13px;
				font-weight: 500;
				color: var(--rtlc-primary);
				text-decoration: none;
			}

			.rtlc-sidebar-link:hover {
				text-decoration: underline;
				color: var(--rtlc-primary);
			}

			/* Help Card */
			.rtlc-help-card {
				background: var(--rtlc-dark);
				border-color: var(--rtlc-dark);
			}

			.rtlc-help-card h3 {
				color: #fff;
			}

			.rtlc-help-card h3 .dashicons {
				color: var(--rtlc-primary-border);
			}

			.rtlc-help-card p {
				color: var(--rtlc-dark-text);
				font-size: 13px;
				line-height: 1.5;
				margin: 0 0 14px;
			}

			.rtlc-support-btn {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				padding: 8px 16px;
				font-size: 13px;
				font-weight: 500;
				color: #fff;
				background: transparent;
				border: 1px solid rgba(255, 255, 255, 0.3);
				border-radius: 6px;
				text-decoration: none;
				transition: background 0.15s, border-color 0.15s;
			}

			.rtlc-support-btn:focus,
			.rtlc-support-btn:hover {
				background: rgba(255, 255, 255, 0.1);
				border-color: rgba(255, 255, 255, 0.5);
				color: #fff;
				box-shadow: none;
			}

			.rtlc-support-btn .dashicons {
				font-size: 16px;
				width: 16px;
				height: 16px;
			}

			/* ── Responsive ── */
			@media screen and (max-width: 960px) {
				.rtlc-page-layout {
					flex-direction: column;
				}

				.rtlc-sidebar {
					width: 100%;
				}

				.rtlc-page-header {
					flex-direction: column;
				}
			}

		</style>
		<?php
	}

	/**
	 * Plugin restriction scripts.
	 *
	 * @return void
	 */
	public function script() {
		if ( ! wp_script_is( 'jquery', 'done' ) ) {
			return;
		}

		if ( rtlc_is_valid()['success'] ) {
			return;
		}

		if ( isset( $_GET['page'] ) && 'fw-backups-demo-content' === $_GET['page'] ) {
			?>
			<script type="text/javascript">
				jQuery("#fw-ext-backups-demo-list .theme-actions a").on("click", function (e) {
					e.preventDefault();
					alert('<?php esc_html_e( 'Please activate your theme license to install demo data.', 'classilist' ); ?>');
					return false;
				});
			</script>
			<?php
		}

		if ( isset( $_GET['page'] ) && 'classilist-install-plugins' === $_GET['page'] ) {
			?>
			<script type="text/javascript">
				jQuery(".row-actions a").on("click", function (e) {
					if (jQuery(this).closest('td').next().has('span').length > 0) { //find pre packaged
						e.preventDefault();
						alert('<?php esc_html_e( 'Please activate your theme license to use this plugin.', 'classilist' ); ?>');
						return false;
					}
				});

				jQuery(".check-column input").on("change", function (e) {
					if (!jQuery(e.target).is(':checked')) return;

					if (jQuery(this).parent().hasClass('column-cb')) { //all checked or not
						jQuery('table.wp-list-table > tbody  > tr').each(function (index, tr) {
							if (jQuery(tr).find('.column-source').has('span').length > 0) {
								jQuery(tr).find('.check-column input').prop('checked', false);
							}
						});
					} else {
						if (jQuery(this).closest('th').next().next().has('span').length > 0) { //find pre packaged
							jQuery(this).prop('checked', false);
							alert('<?php esc_html_e( 'Please activate your theme license to use this plugin.', 'classilist' ); ?>');
						}
					}
				});
			</script>
			<?php
		}
	}
}

if ( is_admin() ) {
	new Utility();
}

if ( ! function_exists( 'rtlc_is_valid' ) ) {
	/**
	 * License Validity Check.
	 *
	 * Checks the RadiusTheme (EDD) license status.
	 *
	 * @return array
	 */
	function rtlc_is_valid() {
		// Check RadiusTheme Site (EDD) license.
		// The EDD theme slug is 'classilist' as configured in theme-updater.php
		$edd_status = get_option( 'classilist_license_key_status', '' );
		if ( 'valid' === $edd_status ) {
			return [
				'success'      => true,
				'domain_match' => true,
			];
		}

		return [
			'success' => false,
		];
	}
}

if ( ! function_exists( 'rtlc_get_domain_name' ) ) {
	/**
	 * Get Domain Name.
	 *
	 * @return string
	 */
	function rtlc_get_domain_name( $url = null ) {
		$protocols = [ 'http://', 'https://', 'http://www.', 'https://www.', 'www.' ];

		return str_replace( $protocols, '', esc_url( ! empty( $url ) ? $url : site_url() ) );
	}
}
