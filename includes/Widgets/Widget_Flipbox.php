<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
//use \Elementor\Scheme_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Flipbox extends Widget_Base {
	
	public function get_categories() {
		return [ 'hoo-addons-elements' ];
	}


	public function get_name() {
		return 'hoo-addons-flipbox';
	}

	public function get_title() {
		return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Fancy Flipbox', 'hoo-addons-for-elementor' ) );
	}

	public function get_icon() {
		return 'haicon-map';
	}

	public function get_script_depends() {
        return [ 'hoo-addons-widgets'];
    }

    public function get_style_depends() {
        return [ 'hoo-addons-widgets'];
    }

	public function get_keywords() {
        return [
            'flipbox',
            'hoo flipbox',
            'fancy flipbox',
            'transform',
            'content box',
            'hoo',
            'hoo addons',
        ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'section_texts',
			[
				'label' => __( 'Contents', 'hoo-addons-for-elementor' ),
			]
		);


		$this->add_control(
            'title_tag',
            [
                'label' => __( 'Title HTML Tag', 'hoo-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => __( 'H1',   'hoo-addons-for-elementor' ),
                    'h2'   => __( 'H2',   'hoo-addons-for-elementor' ),
                    'h3'   => __( 'H3',   'hoo-addons-for-elementor' ),
                    'h4'   => __( 'H4',   'hoo-addons-for-elementor' ),
                    'h5'   => __( 'H5',   'hoo-addons-for-elementor' ),
                    'h6'   => __( 'H6',   'hoo-addons-for-elementor' ),
                    'div'  => __( 'div',  'hoo-addons-for-elementor' ),
                    'span' => __( 'Span', 'hoo-addons-for-elementor' ),
                ],
                'default' => 'div',
            ]
        );


		$this->add_control(
            'content_tag',
            [
                'label' => __( 'Description HTML Tag', 'hoo-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'div'  => __( 'div',  'hoo-addons-for-elementor' ),
                    'span' => __( 'Span', 'hoo-addons-for-elementor' ),
                    'p'    => __( 'P',    'hoo-addons-for-elementor' ),
                ],
                'default' => 'div',
            ]
        );


		$this->add_control(
			'flipbox_f_title',
			[
				'label' => __( 'Front Side Title', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => 'Lorem ipsum dolor sit amet',
				'placeholder' => __( 'Please enter the flipbox front title', 'hoo-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'flipbox_f_desc',
			[
				'label' => __( 'Front Side Description', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default'     => 'Lorem ipsum dolor sit amet, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				'placeholder' => '',
			]
		);

		$this->add_control(
			'flipbox_b_title',
			[
				'label' => __( 'Back Side Title', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => __( 'Contact Us', 'hoo-addons-for-elementor' ),
				'placeholder' => __( 'Please enter the flipbox front title', 'hoo-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'flipbox_b_desc',
			[
				'label' => __( 'Back Side Description', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies sem lorem, non ullamcorper neque tincidunt id.', 'hoo-addons-for-elementor' ),
				'placeholder' => __( 'Please enter the flipbox back description', 'hoo-addons-for-elementor' ),
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_type',
			[
				'label' => __( 'FlipBox Type', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'flipbox_style',
            [
                'label' => esc_html__('Style', 'hoo-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'flip-box-style',
                'options' => [
                    'flip-box-style'      => esc_html__('Flip Box',  'hoo-addons-for-elementor'),
                    'rotate-box-style'    => esc_html__('Rotate Style',  'hoo-addons-for-elementor'),
                    'zoomin-box-style'    => esc_html__('Zoom In Style',  'hoo-addons-for-elementor'),
                    'zoomout-box-style'   => esc_html__('Zoom Out Style',  'hoo-addons-for-elementor'),
				],
			]
		);


		$this->add_control(
    		'flipbox_type',
		    [
		        'label' => __( 'Filp Box Type', 'hoo-addons-for-elementor' ),
		        'type' => Controls_Manager::CHOOSE,
						'default'     => __( 'vertical', 'hoo-addons-for-elementor' ),
		        'options' => [
		            'horizontal'    => [
		                'title' => __( 'Horizontal', 'hoo-addons-for-elementor' ),
		                'icon' => 'eicon-v-align-stretch',
		            ],
		            'vertical' => [
		                'title' => __( 'Vertical', 'hoo-addons-for-elementor' ),
		                'icon' => 'eicon-spacer',
		            ]
		        ],
		    ]
		);

		$this->add_control(
			'flipbox_type-min-height',
			[
				'label' => esc_html__( 'Min Height', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => 'Unit in px',
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__holder ' => 'height: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'hoo-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-flipbox__back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'box-shadow',
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .ha-flipbox__back, {{WRAPPER}} .ha-flipbox__front',
			]
		);

		$this->add_control(
			'flipbox_border_color',
			[
				'label' => __( 'Color', 'hoo-addons-for-elementor' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}}  .ha-flipbox__front' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}  .ha-flipbox__back' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'border_border!' => '',
				],
			]
		);

		$this->add_group_control(
			'border',
			[
				'name' => 'border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'hoo-addons-for-elementor' ),
					],
				],
				'selector' => '{{WRAPPER}} .ha-flipbox__back, {{WRAPPER}} .ha-flipbox__front',
			]
		);

		$this->add_control(
			'flipbox_border_radius',
			[
				'label' => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ha-flipbox__back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Background & Colors', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'flipbox_f_icon',
			[
				 'label' => __( 'Front Side Image Icon', 'hoo-addons-for-elementor' ),
				 'type' => Controls_Manager::MEDIA
			]
		);

		$this->add_control(
			'flipbox_f_bg_img',
			[
				 'label' => __( 'Front Side Image background', 'hoo-addons-for-elementor' ),
				 'type' => Controls_Manager::MEDIA,
				 'dynamic' => [
						'active' => true,
				 ],
				 'selectors' => [
 					'{{WRAPPER}} .ha-flipbox__front' => 'background-image: url({{URL}});',
 				]
			]
		);

		$this->add_control(
			'flipbox_f_bg_color',
			[
				'label' => __( 'Front Side Background Color', 'hoo-addons-for-elementor' ),
				'default' => '#52ffaf',
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__front' => 'background-color: {{VALUE}};',
				]
			]

		);

		$this->add_control(
		  'flipbox_b_icon',
		  [
		     'label' => __( 'Back Side Image Icon', 'hoo-addons-for-elementor' ),
		     'type' => Controls_Manager::MEDIA
		  ]
		);

		$this->add_control(
		  'flipbox_b_bg_img',
		  [
		     'label' => __( 'Back Side Image background', 'hoo-addons-for-elementor' ),
			 'type' => Controls_Manager::MEDIA,
			 'dynamic' => [
				'active' => true,
		 		],
				 'selectors' => [
 					'{{WRAPPER}} .ha-flipbox__back' => 'background-image:url({{URL}});',
 				]
		  ]
		);

		$this->add_control(
		  'flipbox_b_bg_color',
		  [
		    'label' => __( 'Back Side Background Color', 'hoo-addons-for-elementor' ),
				'default' => '#ee8cff',
		    'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__back' => 'background-color: {{VALUE}};',
				]
		  ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_typo',
			[
				'label' => __( 'Typography', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(

			Group_Control_Typography::get_type(),
			[
				'name' => 'flipbox_f_title_typo',
				'label' => __( 'Front Side Title Typography', 'hoo-addons-for-elementor' ),
				'scheme' => Typography::TYPOGRAPHY_4,
				'dynamic' => [
					'active' => true,
				],
				'selector' => '{{WRAPPER}} .ha-flipbox__title-front',
			]
		);

		$this->add_group_control(

			Group_Control_Typography::get_type(),
			[
				'name' => 'flipbox_f_desc_typo',
				'label' => __( 'Front Side Description Typography', 'hoo-addons-for-elementor' ),
				'scheme' => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ha-flipbox__desc-front',
			]
		);

		$this->add_group_control(

			Group_Control_Typography::get_type(),
			[
				'name' => 'flipbox_b_title_typo',
				'label' => __( 'Back Side Title Typography', 'hoo-addons-for-elementor' ),
				'scheme' => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ha-flipbox__title-back',
			]
		);


		$this->add_group_control(

			Group_Control_Typography::get_type(),
			[
				'name' => 'flipbox_b_desc_typo',
				'label' => __( 'Back Side Description Typography', 'hoo-addons-for-elementor' ),
				'scheme' => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ha-flipbox__desc-back',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_color',
			[
				'label' => __( 'Texts Colors', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'flipbox_f_title_color',
			[
				'label' => __( 'Front Side Title color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__title-front ' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'flipbox_f_desc_color',
			[
				'label' => __( 'Front Side Description color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__desc-front ' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'flipbox_b_title_color',
			[
				'label' => __( 'Back Side Title color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__title-back ' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'flipbox_b_desc_color',
			[
				'label' => __( 'Back Side Description color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__desc-back ' => 'color: {{VALUE}};',
				]
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button Settings', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'flipbox_show_btn',
			[
				'label' => __( 'Show Button?', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'hoo-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'hoo-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


		$this->add_control(
			'flipbox_b_btn_text',
			[
				'label' => __( 'Button Text', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default'     => __( 'View All', 'hoo-addons-for-elementor' ),
				'placeholder' => __( 'Please enter the flipbox button text', 'hoo-addons-for-elementor' ),
				'condition' => [
					'flipbox_show_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'flipbox_b_btn_url',
			[
				'label' => __( 'Button URL', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'default' => [
				'url' => 'http://',
				'is_external' => '',
				],
				'show_external' => true,
					'condition' => [
					'flipbox_show_btn' => 'yes',
				],
			]
		);


		$this->add_control(
			'flipbox_b_btn_bg_color',
			[
				'label' => __( 'Button Background Color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f96161',
				'condition' => [
					'flipbox_show_btn' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__action a' => 'background-color: {{VALUE}};',
				]
			]
		);


		$this->add_control(
			'flipbox_b_btn_text_color',
			[
				'label' => __( 'Button Text Color', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					'flipbox_show_btn' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__action a' => 'color: {{VALUE}};',
				]
			]
		);


		$this->add_control(
			'flipbox_b_btn_bg_color_hover',
			[
				'label' => __( 'Button Background Color On Hover', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fcb935',
				'condition' => [
					'flipbox_show_btn' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__action a:hover' => 'background-color: {{VALUE}} !important;',
				]
			]
		);


		$this->add_control(
			'flipbox_b_btn_text_color_hover',
			[
				'label' => __( 'Button Text Color On Hover', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f7f7f7',
				'condition' => [
					'flipbox_show_btn' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ha-flipbox__action a:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}


	protected function render() {

		$settings = $this->get_settings_for_display();

		$bg_img_front = $settings['flipbox_f_bg_img'];
		$bg_img_back = $settings['flipbox_b_bg_img'];
		$icon_front = $settings['flipbox_f_icon'];
		$icon_back = $settings['flipbox_b_icon'];
		$flipbox_show_btn = $settings['flipbox_show_btn'];
		$flipbox_f_bg_color = $settings['flipbox_f_bg_color'];
		$id = $this->get_id();
		$css_class = 'ha-flipbox ha-widget '.esc_attr($settings['flipbox_style']).' ha-flipbox--'.esc_attr($settings['flipbox_type']);

		$css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
		
		$output = '<div id="flip-'.$id.'" class="'.$css_class.'">';
		$output .= '    <div class="ha-flipbox__holder" >';
		$output .= '        <div class="ha-flipbox__front" style=" background-color:'.esc_attr($flipbox_f_bg_color).';background-image: url('.esc_url($bg_img_front['url']).');">';

		$output .= '            <div class="ha-flipbox__content">';
		$output .= '                <div class="ha-flipbox__icon-front">';

		$output .= '                    <img src="'.esc_url($icon_front["url"]).'"/>';


		$output .= '                </div>';
		$output .= '                <' . esc_html($settings['title_tag']) . ' class="ha-flipbox__title-front">'.esc_attr($settings['flipbox_f_title']).'</' . esc_html($settings['title_tag']) . '>';
		$output .= '                <' . esc_html($settings['content_tag']) . ' class="ha-flipbox__desc-front">'.do_shortcode( wp_kses_post($settings['flipbox_f_desc']) ).'</' . esc_html($settings['content_tag']) . '>';
		$output .= '            </div>';
		$output .= '        </div>';
		$output .= '        <div class="ha-flipbox__back" style="background-image: url('.esc_url($bg_img_back['url']).');" >';

		$output .= '            <div class="ha-flipbox__content">';
		$output .= '                <div class="ha-flipbox__icon-back">';

		$output .= '                    <img src="'.esc_url($icon_back["url"]).'"/>';


		$output .= '                </div>';
		$output .= '                <' . esc_html($settings['title_tag']) . ' class="ha-flipbox__title-back">'.esc_attr($settings['flipbox_b_title']).'</' . esc_html($settings['title_tag']) . '>';
		$output .= '                <' . esc_html($settings['content_tag']) . ' class="ha-flipbox__desc-back">'.do_shortcode( wp_kses_post($settings['flipbox_b_desc'])).'</' . esc_html($settings['content_tag']) . '>';
		
		if($flipbox_show_btn == "yes"){
			$output .= '               <div class="ha-flipbox__action">';
			$btn_external = "";
			$btn_nofollow = "";
			if( $settings['flipbox_b_btn_url']['is_external'] ) {
				$btn_external = ' target="_blank" ';
			}

			if( $settings['flipbox_b_btn_url']['nofollow'] ) {
				$btn_nofollow = ' rel="nofollow" ';
			}

			$output .= '                    <a ' . $btn_external . ' ' . $btn_nofollow . ' href="'.esc_url($settings['flipbox_b_btn_url']['url']).'" class="ha-flipbox__btn">'.$settings['flipbox_b_btn_text'].'</a>';
			$output .= '                   </div>';
		}
		$output .= '                </div>';
		$output .= '            </div>';

		$output .= '        </div>';
		$output .= '    </div>';
		echo $output;
	}


	protected function content_template() {
		
	}
}