<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
//use \Elementor\Scheme_Typography;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Dropcap extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-dropcap';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Dropcap', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-bold';
   }

   public function get_keywords() {
        return [
            'dropcap',
            'hoo dropcap',
            'ucwords',
            'ucfirst',
            'first letter',
            'upper',
            'content box',
            'hoo',
            'hoo addons',
        ];
    }

    public function get_script_depends() {
        return [ 'hoo-addons-widgets'];
    }

    public function get_style_depends() {
        return [ 'hoo-addons-widgets'];
    }

   protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
                'dropcap', [
                'label'       => __( 'Dropcap Letter', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'L',
                'description' => __( 'Add the letter to be used as dropcap', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'content', [
                'label'       => __( 'Dropcap Letter', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'description' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
			'boxed',
			[
				'label' => __( 'Boxed Dropcap', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'hoo-addons-for-elementor' ),
				'label_off' => __( 'No', 'hoo-addons-for-elementor' ),
				'return_value' => '1',
				'default' => '',
                'description' => __( 'The dropcap box is dismissable.', 'hoo-addons-for-elementor' ),
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ha-dropcap' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_style_settings',
            [
                'label' => __( 'Style', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color',
            [
                'label'       => __( 'Dropcap Letter Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#fdd200',
                'type'        => Controls_Manager::COLOR,
            ]
        );

        $this->end_controls_section();

   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        $this->add_render_attribute('dropcap_attributes', $this->render_attributes($settings));
        $output = sprintf( '<span %s>%s</span> %s', $this->get_render_attribute_string( 'dropcap_attributes' ), esc_attr($settings['dropcap']), do_shortcode( wp_kses_post($settings['content']) ) );
		
		echo $output;
   }

   protected function render_attributes( $args = [] ) {

        $css_class = 'ha-widget ha-dropcap dropcap';
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
        $attr['class'] = $css_class;
		$attr['style'] = '';
		
		if( $args['boxed'] == '1' ) {
			$attr['class'] .= ' dropcap-boxed';

			$attr['style'] .= sprintf( 'background-color:%s;', $args['color'] );	
		} else {
			$attr['style'] .= sprintf( 'color:%s;', $args['color'] );
		}
		
		return $attr;
    }


   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}