<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
//use \Elementor\Scheme_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Alert extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-alert';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Alert', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-warning';
   }

   public function get_keywords() {
        return [
            'alert',
            'hoo alert',
            'warning',
            'content box',
            'hoo',
            'hoo addons',
        ];
    }

    public function get_custom_help_url() {
		return 'https://www.hoosoft.com/plugins/hoo-addons-for-elementor/alert-widget/';
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
                'icon', [
                'label'       => __( 'Icon', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value' => 'fas fa-exclamation-triangle',
                    'library' => 'fa-solid'
                ],
                'description' => __( 'Click an icon to select.', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
                'content', [
                'label'       => __( 'Alert Content', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Warning! Better check yourself, you\'re not looking too good.', 'hoo-addons-for-elementor' ),
                'description' => __( 'Insert the content for the alert.', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
			'dismissable',
			[
				'label' => __( 'Dismissable', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'hoo-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'hoo-addons-for-elementor' ),
				'return_value' => '1',
				'default' => '1',
                'description' => __( 'The alert box is dismissable.', 'hoo-addons-for-elementor' ),
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => __( 'Typography', 'hoo-addons-for-elementor' ),
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .alert .alert-content',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'       => __( 'Text Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set content color color for alert box.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#777777',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .alert .alert-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'       => __( 'Icon Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set icon color for alert box.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#777777',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .alert i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'       => __( 'Background Color', 'hoo-addons-for-elementor' ),
                'description' => '',
                'separator'   => 'before',
                'default'     => '#FDF270',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .alert' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();

   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $dismissable = $settings['dismissable'];
        $icon = $settings['icon'];
        $content = $settings['content'];
        $icon_str = '';
        $css_class = 'ha-widget alert ha-alert';
        
        if( '1' == $dismissable ){
            $icon_str .= '<button type="button" class="close" data-dismiss="alert" aria-label="'.esc_attr__( 'Close', 'hoo-addons-for-elementor' ).'"><span aria-hidden="true">×</span></button>';
            $css_class .= ' alert-dismissible';
        }

        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
            
        if( isset($icon['value']) ):
            $icon_str .= '<i class="'.esc_attr($icon['value']).'"></i>';    
        endif;
	
        $output = $icon_str;
        $output .= '<span class="alert-content">';
        $output .= do_shortcode( wp_kses_post($content) );
        $output .= '</span>';
        $output    = sprintf('<div class="%s" role="alert">%s</div>', $css_class, $output);

        echo $output;
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}