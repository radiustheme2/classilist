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

$classilist_url   = rawurlencode( get_permalink() );
$classilist_title = rawurlencode( get_the_title() );

$classilist_defaults = [
	'facebook'  => [
		'url'  => "http://www.facebook.com/sharer.php?u=$classilist_url",
		'icon' => 'fab fa-facebook-f',
	],
	'twitter'   => [
		'url'  => "https://twitter.com/intent/tweet?source=$classilist_url&text=$classilist_title:$classilist_url",
		'icon' => 'fa-brands fa-x-twitter',
	],
	'linkedin'  => [
		'url'  => "http://www.linkedin.com/shareArticle?mini=true&url=$classilist_url&title=$classilist_title",
		'icon' => 'fa-brands fa-linkedin-in',
	],
	'pinterest' => [
		'url'  => "http://pinterest.com/pin/create/button/?url=$classilist_url&description=$classilist_title",
		'icon' => 'fab fa-pinterest',
	],
	'tumblr'    => [
		'url'  => "http://www.tumblr.com/share?v=3&u=$classilist_url &quote=$classilist_title",
		'icon' => 'fab fa-tumblr',
	],
	'reddit'    => [
		'url'  => "http://www.reddit.com/submit?url=$classilist_url&title=$classilist_title",
		'icon' => 'fab fa-reddit-alien',
	],
	'vk'        => [
		'url'  => "http://vkontakte.ru/share.php?url=$classilist_url",
		'icon' => 'fab fa-vk',
	],
];

foreach ( RDTheme::$options['post_share'] as $classilist_key => $classilist_value ) {
	if ( ! $classilist_value ) {
		unset( $classilist_defaults[ $classilist_key ] );
	}
}

$classilist_sharers = apply_filters( 'classilist_social_sharing_icons', $classilist_defaults );

?>
<ul class="post-social-sharing">
	<?php
	foreach ( $classilist_sharers as $classilist_key => $classilist_sharer ) :
		$classilist_icon = $classilist_sharer['icon'];
		$classilist_a    = explode( ' ', $classilist_icon );
		$classilist_b    = explode( '-', $classilist_icon );
		?>
		<li class="social-<?php echo esc_attr( $classilist_b[1] ); ?>"><a href="<?php echo esc_url( $classilist_sharer['url'] ); ?>" target="_blank"><i class="<?php echo esc_attr( $classilist_sharer['icon'] ); ?>"></i></a></li>
	<?php endforeach; ?>
</ul>