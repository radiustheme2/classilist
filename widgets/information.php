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

use \WP_Widget;
use \RT_Widget_Fields;

class Information_Widget extends WP_Widget {
	public function __construct() {
		$id = Constants::$theme_prefix . '_information';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'ClassiList: Contact Info', 'classilist' ), // Name
            array( 'description' => esc_html__( 'ClassiList: Contact Info', 'classilist' )
        ) );
	}

	public function widget( $args, $instance ){
		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . wp_kses_post( apply_filters( 'widget_title', esc_html( $instance['title'] ) ) ) . wp_kses_post( $args['after_title'] );
		}
		?>
		<ul>
			<?php 
			if( !empty( $instance['address'] ) ){
				?><li><i class="fas fa-map-marker-alt"></i> <?php echo wp_kses_post( $instance['address'] ); ?></li><?php
			}
			if( !empty( $instance['phone'] ) ){
				?><li><i class="fas fa-phone-volume"></i> <a href="tel:<?php echo esc_attr( $instance['phone'] ); ?>"><?php echo esc_html( $instance['phone'] ); ?></a></li><?php
			}
			if( !empty( $instance['email'] ) ){
				?><li><i class="far fa-envelope"></i> <a href="mailto:<?php echo esc_attr( $instance['email'] ); ?>"><?php echo esc_html( $instance['email'] ); ?></a></li><?php
			}
			if( !empty( $instance['fax'] ) ){
				?><li><i class="fas fa-fax"></i> <?php echo esc_html( $instance['fax'] ); ?></li><?php
			}
			?>
		</ul>

		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['address']   = ( ! empty( $new_instance['address'] ) ) ? wp_kses_post( $new_instance['address'] ) : '';
		$instance['phone']     = ( ! empty( $new_instance['phone'] ) ) ? sanitize_text_field( $new_instance['phone'] ) : '';
		$instance['email']     = ( ! empty( $new_instance['email'] ) ) ? sanitize_email( $new_instance['email'] ) : '';
		$instance['fax']       = ( ! empty( $new_instance['fax'] ) ) ? sanitize_text_field( $new_instance['fax'] ) : '';
		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'   => esc_html__( 'Contact Info' , 'classilist' ),
			'address' => '',
			'phone'   => '',
			'email'   => '',
			'fax'     => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'     => array(
				'label' => esc_html__( 'Title', 'classilist' ),
				'type'  => 'text',
			),
			'address'   => array(
				'label' => esc_html__( 'Address', 'classilist' ),
				'type'  => 'textarea',
			),
			'phone'     => array(
				'label' => esc_html__( 'Phone', 'classilist' ),
				'type'  => 'text',
			),
			'fax'       => array(
				'label' => esc_html__( 'Fax', 'classilist' ),
				'type'  => 'text',
			),
			'email'     => array(
				'label' => esc_html__( 'Email', 'classilist' ),
				'type'  => 'text',
			),
		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}