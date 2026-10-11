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

use Rtcl\Helpers\Link;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$nav_menu_args = Helper::nav_menu_args();
$menu          = wp_nav_menu(
	[
		'echo'        => false,
		'fallback_cb' => '__return_false',
	]
);

$logo_dark  = empty( RDTheme::$options['logo_dark']['url'] ) ? URI_Helper::get_img( 'logo-dark.png' ) : RDTheme::$options['logo_dark']['url'];
$logo_light = empty( RDTheme::$options['logo_light']['url'] ) ? URI_Helper::get_img( 'logo-light.png' ) : RDTheme::$options['logo_light']['url'];
$logo       = 2 == RDTheme::$header_style ? $logo_light : $logo_dark;
$logo_width = (int) RDTheme::$options['logo_width'];
$menu_width = 12 - $logo_width;
$logo_class = "col-md-{$logo_width} col-sm-12 col-12";
$menu_class = "col-md-{$menu_width} col-sm-12 col-12";

$login_icon = is_user_logged_in() ? 'fa fa-user-o' : 'fa fa-lock';
$login_text = is_user_logged_in() ? RDTheme::$options['header_icon_text_logged'] : RDTheme::$options['header_icon_text_guest'];

if ( ! empty( RDTheme::$options['header_btn_url'] ) ) {
	$button_url = RDTheme::$options['header_btn_url'];
} else {
	if ( class_exists( 'Rtcl' ) ) {
		$button_url = Link::get_listing_form_page_link();
	}
}
?>
<div id="main-header" class="main-header">
	<div class="container">
		<div class="row align-items-center">
			<div class="<?php echo esc_attr( $logo_class ); ?>">
				<div class="site-branding">
					<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>"></a>
				</div>
			</div>
			<div class="<?php echo esc_attr( $menu_class ); ?>">
				<div class="main-navigation-area">
					<?php if ( RDTheme::$options['header_btn_txt'] && RDTheme::$options['header_btn_url'] ) : ?>
						<div class="header-btn-area">
							<a class="btn rdtheme-button-1" href="<?php echo esc_url( $button_url ); ?>"><i class="fa fa-plus" aria-hidden="true"></i><?php echo esc_html( RDTheme::$options['header_btn_txt'] ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( RDTheme::$options['header_icon'] && class_exists( 'Rtcl' ) ) : ?>
						<a class="header-login-icon" href="<?php echo esc_url( Link::get_my_account_page_link() ); ?>"><i class="<?php echo esc_attr( $login_icon ); ?>" aria-hidden="true"></i><span class="rtin-text"><?php echo esc_html( $login_text ); ?></span></a>
					<?php endif; ?>

					<?php if ( RDTheme::$options['header_chat_icon'] && class_exists( 'Rtcl' ) ) : ?>
						<a class="header-chat-icon rtcl-chat-unread-count" title="<?php esc_attr_e( 'Chat', 'classilist' ); ?>" href="<?php echo esc_url( Link::get_my_account_page_link( 'chat' ) ); ?>"><i class="far fa-comments"></i></a>
					<?php endif; ?>

					<div id="main-navigation" class="main-navigation">
						<?php
						if ( ! empty( $menu ) ) {
							wp_nav_menu( $nav_menu_args );
						} else {
							if ( is_user_logged_in() ) {
								echo '<ul id="menu" class="fallbackcd-menu-item"><li><a class="fallbackcd" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'classilist' ) . '</a></li></ul>';
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound