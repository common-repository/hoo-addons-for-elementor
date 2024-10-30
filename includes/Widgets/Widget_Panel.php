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

class Widget_Panel extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-panel';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Panel', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-pencil2';
   }

   public function get_keywords() {
        return [
            'panel',
            'header',
            'hoo panel',
            'content box',
            'hoo',
            'hoo addons',
            'layout box'
        ];
    }

    public function get_custom_help_url() {
		return 'https://www.hoosoft.com/plugins/hoo-addons-for-elementor/panel-widget/';
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
                    'value' => 'fas fa-newspaper',
                    'library' => 'fa-solid'
                ],
                'description' => __( 'Click an icon to select.', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title', [
                'label'       => __( 'Panel Title', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Create layout boxes with different styles', 'hoo-addons-for-elementor' ),
                'description' => __( 'Insert the title for the panel.', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
                'content', [
                'label'       => __( 'Panel Content', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Panels provide a flexible and extensible content container with multiple variants. These options include, but are in no way limited to headers and footers, a wide variety of content, contextual background colors, and powerful display options. Panels are similar to cards, but they don\'t include media.', 'hoo-addons-for-elementor' ),
                'description' => __( 'Insert the content for the panel.', 'hoo-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_title_style_settings',
            [
                'label' => __( 'Header Style', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'       => __( 'Title Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set title color for panel box.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#333',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} h3.panel-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Title Typography', 'hoo-addons-for-elementor' ),
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} h3.panel-title',
            ]
        );

        $this->add_control(
            'header_background_color',
            [
                'label'       => __( 'Header Background Color', 'hoo-addons-for-elementor' ),
                'description' => '',
                'separator'   => 'before',
                'default'     => '#f5f5f5',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .panel-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'       => __( 'Icon Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set icon color for panel header.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#333',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .panel-heading i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 17,
                ],
				'selectors' => [
					'{{WRAPPER}} .panel-title i' => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .panel-title svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
				],
			]
		);

        $this->add_control(
            'icon_after_spacing',
            [
                'label'     => __( 'Icon After Spacing', 'hoo-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .panel-title i' => 'margin-right: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'icon_before_spacing',
            [
                'label'     => __( 'Icon Before Spacing', 'hoo-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .panel-title i' => 'margin-left: {{SIZE}}px',
                ],
                'separator' => 'after',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_content_style_settings',
            [
                'label' => __( 'Content Style', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'       => __( 'Content Box Border Color', 'hoo-addons-for-elementor' ),
                'description' => '',
                'separator'   => 'before',
                'default'     => '#ddd',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ha-panel' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
                'default'     => ['size'=>4, 'unit'=>'px'],
				'selectors'  => array(
					'{{WRAPPER}} .ha-panel' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => __( 'Typography', 'hoo-addons-for-elementor' ),
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .panel-body',
            ]
        );
        
        $this->end_controls_section();

   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        $title = $settings['title'];
        $content = $settings['content'];
        $icon = $settings['icon'];
        $icon_str = '';
        if( isset($icon['value']) ):
            $icon_str = '<i class="'.esc_attr($icon['value']).'"></i>';    
        endif;

        $css_class = 'ha-widget ha-panel';
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );

        $output    = sprintf('<div class="%1$s">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">%2$s %3$s</h3>
                                        </div>
                                        <div class="panel-body">
                                        %4$s
                                        </div>
                                    </div>', $css_class, $icon_str, $title, do_shortcode($content));
		
		echo $output;
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}