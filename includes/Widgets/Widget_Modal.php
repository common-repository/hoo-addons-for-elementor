<?php
namespace HooAddons\Widget;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use \Elementor\Core\Schemes\Color as Scheme_Color;
//use Elementor\Scheme_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;
use HooAddons\Classes\Utils as HooAddons_Utils;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Modal extends Widget_Base {

	public function get_categories() {
		return [ 'hoo-addons-elements' ];
	}

	public function get_name() {
		return 'hoo-addons-modal';
	}

	public function check_rtl() {
		return is_rtl();
	}

	public function get_title() {
		return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Modal', 'hoo-addons-for-elementor' ) );
	}

	public function get_icon() {
        return 'haicon-newspaper';
   }

   public function get_keywords() {
        return [
            'modal',
            'popup',
            'modal box',
            'hoo',
            'hoo addons',
        ];
    }

	public function get_script_depends() {
		return [ 'hoo-addons-widgets', 'hoo-addons-modal', 'hoo-addons-lottie', 'elementor-waypoints' ];
	}

	public function get_style_depends() {
        return [ 'hoo-addons-widgets'];
    }

	public function get_custom_help_url() {
		return '';
	}

	/**
	 * Register Modal Box controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'ha_modal_selector_content_section',
			[
				'label' => __( 'Content', 'hoo-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'ha_modal_header_switcher',
			[
				'label'       => __( 'Header', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => 'show',
				'label_off'   => 'hide',
				'default'     => 'yes',
				'description' => __( 'Enable or disable modal header', 'hoo-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'ha_modal_icon_selection',
			[
				'label'       => __( 'Icon Type', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'noicon'    => __( 'None', 'hoo-addons-for-elementor' ),
					'fonticon'  => __( 'Icon', 'hoo-addons-for-elementor' ),
					'image'     => __( 'Custom Image', 'hoo-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'hoo-addons-for-elementor' ),
				],
				'default'     => 'noicon',
				'condition'   => [
					'ha_modal_header_switcher' => 'yes',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'ha_modal_font_icon_updated',
			[
				'label'            => __( 'Select Icon', 'hoo-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'ha_modal_font_icon',
				'condition'        => [
					'ha_modal_icon_selection'  => 'fonticon',
					'ha_modal_header_switcher' => 'yes',
				],
				'label_block'      => true,
			]
		);

		$this->add_control(
			'ha_modal_image_icon',
			[
				'label'       => __( 'Upload Image', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [ 'active' => true ],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'ha_modal_icon_selection'  => 'image',
					'ha_modal_header_switcher' => 'yes',
				],
				'label_block' => true,
			],
		);

		$this->add_control(
			'header_lottie_url',
			[
				'label'       => __( 'Animation JSON URL', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => [
					'ha_modal_icon_selection'  => 'animation',
					'ha_modal_header_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_lottie_loop',
			[
				'label'        => __( 'Loop', 'hoo-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'condition'    => [
					'ha_modal_icon_selection'  => 'animation',
					'ha_modal_header_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_lottie_reverse',
			[
				'label'        => __( 'Reverse', 'hoo-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'ha_modal_icon_selection'  => 'animation',
					'ha_modal_header_switcher' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ha_modal_font_icon_size',
			[
				'label'      => __( 'Icon Size', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-title i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ha-modal-modal-title img' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ha-modal-modal-title svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'ha_modal_icon_selection!' => 'noicon',
					'ha_modal_header_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'ha_modal_title',
			[
				'label'       => __( 'Title', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => __( 'Add a title for the modal box', 'hoo-addons-for-elementor' ),
				'default'     => 'Modal Box Title',
				'condition'   => [
					'ha_modal_header_switcher' => 'yes',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'ha_modal_content_heading',
			[
				'label' => __( 'Content', 'hoo-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			],
		);

		$this->add_control(
			'ha_modal_content_type',
			[
				'label'       => __( 'Content to Show', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'editor'   => __( 'Text Editor', 'hoo-addons-for-elementor' ),
					'template' => __( 'Elementor Template', 'hoo-addons-for-elementor' ),
				],
				'default'     => 'editor',
				'label_block' => true,
			]
		);

		$this->add_control(
			'ha_modal_content_temp',
			[
				'label'       => __( 'Content', 'hoo-addons-for-elementor' ),
				'description' => __( 'Modal content is a template which you can choose from Elementor library', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => HooAddons_Utils::get_elementor_templates_list(),
				'condition'   => [
					'ha_modal_content_type' => 'template',
				],
			]
		);

		$this->add_control(
			'ha_modal_content',
			[
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => 'Modal Box Content',
				'selector'   => '{{WRAPPER}} .ha-modal-modal-body',
				'dynamic'    => [ 'active' => true ],
				'condition'  => [
					'ha_modal_content_type' => 'editor',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'ha_modal_upper_close',
			[
				'label'     => __( 'Upper Close Button', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'ha_modal_header_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'ha_modal_lower_close',
			[
				'label'   => __( 'Lower Close Button', 'hoo-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ha_modal_close_text',
			[
				'label'       => __( 'Text', 'hoo-addons-for-elementor' ),
				'default'     => __( 'Close', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [
					'ha_modal_lower_close' => 'yes',
				],
			]
		);

		$this->add_control(
			'ha_modal_animation',
			[
				'label'              => __( 'Entrance Animation', 'hoo-addons-for-elementor' ),
				'type'               => Controls_Manager::ANIMATION,
				'default'            => 'fadeInDown',
				'label_block'        => true,
				'frontend_available' => true,
				'render_type'        => 'template',

			],
		);

		$this->add_control(
			'ha_modal_animation_duration',
			[
				'label'     => __( 'Animation Duration', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fast',
				'options'   => [
					'slow' => __( 'Slow', 'hoo-addons-for-elementor' ),
					''     => __( 'Normal', 'hoo-addons-for-elementor' ),
					'fast' => __( 'Fast', 'hoo-addons-for-elementor' ),
				],
				'condition' => [
					'ha_modal_animation!' => '',
				],
			]
		);

		$this->add_control(
			'ha_modal_animation_delay',
			[
				'label'              => __( 'Animation Delay', 'hoo-addons-for-elementor' ) . ' (s)',
				'type'               => Controls_Manager::NUMBER,
				'default'            => '',
				'step'               => 0.1,
				'condition'          => [
					'ha_modal_animation!' => '',
				],
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_content_section',
			[
				'label' => __( 'Trigger Options', 'hoo-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'ha_modal_display_on',
			[
				'label'       => __( 'Trigger', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'description' => __( 'Choose where would you like the modal box appear on', 'hoo-addons-for-elementor' ),
				'options'     => [
					'button'    => __( 'Button', 'hoo-addons-for-elementor' ),
					'image'     => __( 'Image', 'hoo-addons-for-elementor' ),
					'text'      => __( 'Text', 'hoo-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'hoo-addons-for-elementor' ),
					'pageload'  => __( 'On Page Load', 'hoo-addons-for-elementor' ),
				],
				'label_block' => true,
				'default'     => 'button',
			]
		);

		$this->add_control(
			'ha_modal_button_text',
			[
				'label'       => __( 'Button Text', 'hoo-addons-for-elementor' ),
				'default'     => __( 'Hoo Modal', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [
					'ha_modal_display_on' => 'button',
				],
			]
		);

		$this->add_control(
			'ha_modal_icon_switcher',
			[
				'label'       => __( 'Icon', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => [
					'ha_modal_display_on' => 'button',
				],
				'description' => __( 'Enable or disable button icon', 'hoo-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'ha_modal_button_icon_selection_updated',
			[
				'label'            => __( 'Icon', 'hoo-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'ha_modal_button_icon_selection',
				'default'          => [
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				],
				'label_block'      => true,
				'condition'        => [
					'ha_modal_display_on'    => 'button',
					'ha_modal_icon_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'ha_modal_icon_position',
			[
				'label'       => __( 'Icon Position', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'before',
				'options'     => [
					'before' => __( 'Before', 'hoo-addons-for-elementor' ),
					'after'  => __( 'After', 'hoo-addons-for-elementor' ),
				],
				'label_block' => true,
				'condition'   => [
					'ha_modal_display_on'    => 'button',
					'ha_modal_icon_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'ha_modal_icon_before_size',
			[
				'label'     => __( 'Icon Size', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn i' => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .ha-modal-trigger-btn svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
				],
				'condition' => [
					'ha_modal_display_on'    => 'button',
					'ha_modal_icon_switcher' => 'yes',
				],
			]
		);

		if ( ! $this->check_rtl() ) {
			$this->add_control(
				'ha_modal_icon_before_spacing',
				[
					'label'     => __( 'Icon Spacing', 'hoo-addons-for-elementor' ),
					'type'      => Controls_Manager::SLIDER,
					'condition' => [
						'ha_modal_display_on'    => 'button',
						'ha_modal_icon_switcher' => 'yes',
						'ha_modal_icon_position' => 'before',
					],
					'default'   => [
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .ha-modal-trigger-btn i' => 'margin-right: {{SIZE}}px',
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'ha_modal_icon_after_spacing',
				[
					'label'     => __( 'Icon Spacing', 'hoo-addons-for-elementor' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .ha-modal-trigger-btn i' => 'margin-left: {{SIZE}}px',
					],
					'separator' => 'after',
					'condition' => [
						'ha_modal_display_on'    => 'button',
						'ha_modal_icon_switcher' => 'yes',
						'ha_modal_icon_position' => 'after',
					],
				]
			);
		}

		if ( $this->check_rtl() ) {
			$this->add_control(
				'ha_modal_icon_rtl_before_spacing',
				[
					'label'     => __( 'Icon Spacing', 'hoo-addons-for-elementor' ),
					'type'      => Controls_Manager::SLIDER,
					'condition' => [
						'ha_modal_display_on'    => 'button',
						'ha_modal_icon_switcher' => 'yes',
						'ha_modal_icon_position' => 'before',
					],
					'default'   => [
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .ha-modal-trigger-btn i' => 'margin-left: {{SIZE}}px',
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'ha_modal_icon_rtl_after_spacing',
				[
					'label'     => __( 'Icon Spacing', 'hoo-addons-for-elementor' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .ha-modal-trigger-btn i' => 'margin-right: {{SIZE}}px',
					],
					'separator' => 'after',
					'condition' => [
						'ha_modal_display_on'    => 'button',
						'ha_modal_icon_switcher' => 'yes',
						'ha_modal_icon_position' => 'after',
					],
				]
			);
		}

		$this->add_control(
			'ha_modal_button_size',
			[
				'label'       => __( 'Button Size', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'sm'    => __( 'Small', 'hoo-addons-for-elementor' ),
					'md'    => __( 'Medium', 'hoo-addons-for-elementor' ),
					'lg'    => __( 'Large', 'hoo-addons-for-elementor' ),
					'block' => __( 'Block', 'hoo-addons-for-elementor' ),
				],
				'label_block' => true,
				'default'     => 'lg',
				'condition'   => [
					'ha_modal_display_on' => 'button',
				],
			]
		);

		$this->add_control(
			'ha_modal_image_src',
			[
				'label'       => __( 'Image', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [ 'active' => true ],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'label_block' => true,
				'condition'   => [
					'ha_modal_display_on' => 'image',
				],
			]
		);

		$this->add_control(
			'ha_modal_selector_text',
			[
				'label'       => __( 'Text', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'default'     => __( 'Hoo Modal', 'hoo-addons-for-elementor' ),
				'condition'   => [
					'ha_modal_display_on' => 'text',
				],
			]
		);

		$this->add_control(
			'lottie_url',
			[
				'label'       => __( 'Animation JSON URL', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_control(
			'lottie_loop',
			[
				'label'        => __( 'Loop', 'hoo-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'condition'    => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_control(
			'lottie_reverse',
			[
				'label'        => __( 'Reverse', 'hoo-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_control(
			'lottie_hover',
			[
				'label'        => __( 'Only Play on Hover', 'hoo-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_responsive_control(
			'trigger_image_animation_size',
			[
				'label'      => __( 'Size', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 800,
					],
					'em' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-trigger-img, {{WRAPPER}} .ha-modal-trigger-animation'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'ha_modal_display_on' => [ 'image', 'animation' ],
				],
			]
		);

		$this->add_control(
			'ha_modal_popup_delay',
			[
				'label'       => __( 'Delay in Popup Display (Sec)', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'When should the popup appear during page load? The value are counted in seconds', 'hoo-addons-for-elementor' ),
				'default'     => 1,
				'label_block' => true,
				'condition'   => [
					'ha_modal_display_on' => 'pageload',
				],
			]
		);

		$this->add_responsive_control(
			'ha_modal_selector_align',
			[
				'label'     => __( 'Alignment', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'hoo-addons-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hoo-addons-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'hoo-addons-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-container' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on!' => 'pageload',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_selector_style_section',
			[
				'label'     => __( 'Trigger', 'hoo-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ha_modal_display_on!' => 'pageload',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'trigger_css_filters',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-animation',
				'condition' => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'trigger_hover_css_filters',
				'label'     => __( 'Hover CSS Filters', 'hoo-addons-for-elementor' ),
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-animation:hover',
				'condition' => [
					'ha_modal_display_on' => 'animation',
				],
			]
		);

		$this->add_control(
			'ha_modal_button_text_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn, {{WRAPPER}} .ha-modal-trigger-text' => 'color:{{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text' ],
				],
			]
		);

		$this->add_control(
			'ha_modal_button_text_color_hover',
			[
				'label'     => __( 'Hover Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn:hover, {{WRAPPER}} .ha-modal-trigger-text:hover' => 'color:{{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text' ],
				],
			]
		);

		$this->add_control(
			'ha_modal_button_icon_color',
			[
				'label'     => __( 'Icon Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn i' => 'color:{{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => [ 'button' ],
				],
			]
		);

		$this->add_control(
			'ha_modal_button_icon_hover_color',
			[
				'label'     => __( 'Icon Hover Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn:hover i' => 'color:{{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => [ 'button' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'selectortext',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-btn, {{WRAPPER}} .ha-modal-trigger-text',
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text' ],
				],
			]
		);

		$this->start_controls_tabs( 'ha_modal_button_style' );

		$this->start_controls_tab(
			'ha_modal_tab_selector_normal',
			[
				'label'     => __( 'Normal', 'hoo-addons-for-elementor' ),
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			]
		);

		$this->add_control(
			'ha_modal_selector_background',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn'   => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => 'button',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'selector_border',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-btn,{{WRAPPER}} .ha-modal-trigger-text, {{WRAPPER}} .ha-modal-trigger-img',
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			],
		);

		$this->add_control(
			'ha_modal_selector_border_radius',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-trigger-btn, {{WRAPPER}} .ha-modal-trigger-text, {{WRAPPER}} .ha-modal-trigger-img'     => 'border-radius:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
				'separator'  => 'after',
			],
		);

		$this->add_responsive_control(
			'ha_modal_selector_padding',
			[
				'label'      => __( 'Padding', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'unit'   => 'px',
					'top'    => 10,
					'right'  => 20,
					'bottom' => 10,
					'left'   => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-trigger-btn, {{WRAPPER}} .ha-modal-trigger-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [
					'ha_modal_display_on' => [ 'button', 'text' ],
				],
			],
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label'     => __( 'Shadow', 'hoo-addons-for-elementor' ),
				'name'      => 'ha_modal_selector_box_shadow',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-btn, {{WRAPPER}} .ha-modal-trigger-img',
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'image' ],
				],
			],
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'ha_modal_selector_text_shadow',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-text',
				'condition' => [
					'ha_modal_display_on' => 'text',
				],
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ha_modal_tab_selector_hover',
			[
				'label'     => __( 'Hover', 'hoo-addons-for-elementor' ),
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			],
		);

		$this->add_control(
			'ha_modal_selector_hover_background',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-trigger-btn:hover' => 'background: {{VALUE}};',
				],
				'condition' => [
					'ha_modal_display_on' => 'button',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'selector_border_hover',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-btn:hover,
                    {{WRAPPER}} .ha-modal-trigger-text:hover, {{WRAPPER}} .ha-modal-trigger-img:hover',
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			],
		);

		$this->add_control(
			'ha_modal_selector_border_radius_hover',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-trigger-btn:hover,{{WRAPPER}} .ha-modal-trigger-text:hover, {{WRAPPER}} .ha-modal-trigger-img:hover'     => 'border-radius:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			],
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label'     => __( 'Shadow', 'hoo-addons-for-elementor' ),
				'name'      => 'ha_modal_selector_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .ha-modal-trigger-btn:hover, {{WRAPPER}} .ha-modal-trigger-text:hover, {{WRAPPER}} .ha-modal-trigger-img:hover',
				'condition' => [
					'ha_modal_display_on' => [ 'button', 'text', 'image' ],
				],
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_header_settings',
			[
				'label'     => __( 'Header', 'hoo-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ha_modal_header_switcher' => 'yes',
				],
			],
		);

		$this->add_control(
			'ha_modal_header_text_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-title' => 'color: {{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headertext',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ha-modal-modal-title',
			],
		);

		$this->add_control(
			'ha_modal_header_background',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-header'  => 'background: {{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ha_modal_header_border',
				'selector' => '{{WRAPPER}} .ha-modal-modal-header',
			],
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_upper_close_button_section',
			[
				'label'     => __( 'Upper Close Button', 'hoo-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ha_modal_upper_close'     => 'yes',
					'ha_modal_header_switcher' => 'yes',
				],
			],
		);

		$this->add_responsive_control(
			'ha_modal_upper_close_button_size',
			[
				'label'      => __( 'Size', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-header button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			],
		);

		$this->start_controls_tabs( 'ha_modal_upper_close_button_style' );

		$this->start_controls_tab(
			'ha_modal_upper_close_button_normal',
			[
				'label' => __( 'Normal', 'hoo-addons-for-elementor' ),
			],
		);

		$this->add_control(
			'ha_modal_upper_close_button_normal_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-close' => 'color: {{VALUE}};',
				],
			],
		);

		$this->add_control(
			'ha_modal_upper_close_button_background_color',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-close' => 'background:{{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ha_modal_upper_border',
				'selector' => '{{WRAPPER}} .ha-modal-modal-close',
			],
		);

		$this->add_control(
			'ha_modal_upper_border_radius',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-close'     => 'border-radius:{{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after',
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ha_modal_upper_close_button_hover',
			[
				'label' => __( 'Hover', 'hoo-addons-for-elementor' ),
			],
		);

		$this->add_control(
			'ha_modal_upper_close_button_hover_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-close:hover' => 'color: {{VALUE}};',
				],
			],
		);

		$this->add_control(
			'ha_modal_upper_close_button_background_color_hover',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-close:hover' => 'background:{{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ha_modal_upper_border_hover',
				'selector' => '{{WRAPPER}} .ha-modal-modal-close:hover',
			],
		);

		$this->add_control(
			'ha_modal_upper_border_radius_hover',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-close:hover'     => 'border-radius:{{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after',
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'ha_modal_upper_close_button_padding',
			[
				'label'      => __( 'Padding', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			],
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_lower_close_button_section',
			[
				'label'     => __( 'Lower Close Button', 'hoo-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ha_modal_lower_close' => 'yes',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lowerclose',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ha-modal-modal-lower-close',
			],
		);

		$this->add_responsive_control(
			'ha_modal_lower_close_button_width',
			[
				'label'      => __( 'Width', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'em' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-lower-close' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			],
		);

		$this->start_controls_tabs( 'ha_modal_lower_close_button_style' );

		$this->start_controls_tab(
			'ha_modal_lower_close_button_normal',
			[
				'label' => __( 'Normal', 'hoo-addons-for-elementor' ),
			],
		);

		$this->add_control(
			'ha_modal_lower_close_button_normal_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-lower-close' => 'color: {{VALUE}};',
				],
			],
		);

		$this->add_control(
			'ha_modal_lower_close_button_background_normal_color',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-lower-close' => 'background-color: {{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ha_modal_lower_close_border',
				'selector' => '{{WRAPPER}} .ha-modal-modal-lower-close',
			],
		);

		$this->add_control(
			'ha_modal_lower_close_border_radius',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-lower-close' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after',
			],
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ha_modal_lower_close_button_hover',
			[
				'label' => __( 'Hover', 'hoo-addons-for-elementor' ),
			],
		);

		$this->add_control(
			'ha_modal_lower_close_button_hover_color',
			[
				'label'     => __( 'Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-lower-close:hover' => 'color: {{VALUE}};',
				],
			],
		);

		$this->add_control(
			'ha_modal_lower_close_button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-lower-close:hover' => 'background-color: {{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ha_modal_lower_close_border_hover',
				'selector' => '{{WRAPPER}} .ha-modal-modal-lower-close:hover',
			],
		);

		$this->add_control(
			'ha_modal_lower_close_border_radius_hover',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-lower-close:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after',
			],
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'ha_modal_lower_close_button_padding',
			[
				'label'      => __( 'Padding', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-lower-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			],
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ha_modal_style',
			[
				'label' => __( 'Modal Box', 'hoo-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			],
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'content_typography',
				'selector'  => '{{WRAPPER}} .ha-modal-modal-body',
				'condition' => [
					'ha_modal_content_type' => 'editor',
				],
			],
		);

		$this->add_control(
			'ha_modal_content_background',
			[
				'label'     => __( 'Content Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-body'  => 'background: {{VALUE}};',
				],
			],
		);

		$this->add_control(
			'ha_modal_modal_size',
			[
				'label'       => __( 'Width', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%', 'em' ],
				'range'       => [
					'px' => [
						'min' => 50,
						'max' => 1000,
					],
				],
				'separator'   => 'before',
				'label_block' => true,
			],
		);

		$this->add_responsive_control(
			'ha_modal_modal_max_height',
			[
				'label'       => __( 'Max Height', 'hoo-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', 'em' ],
				'range'       => [
					'px' => [
						'min' => 50,
						'max' => 1000,
					],
				],
				'label_block' => true,
				'selectors'   => [
					'{{WRAPPER}} .ha-modal-modal-dialog'  => 'max-height: {{SIZE}}{{UNIT}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'ha_modal_modal_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ha-modal-modal',
			],
		);

		$this->add_control(
			'ha_modal_footer_background',
			[
				'label'     => __( 'Footer Background Color', 'hoo-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-modal-modal-footer'  => 'background: {{VALUE}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'contentborder',
				'selector' => '{{WRAPPER}} .ha-modal-modal-content',
			],
		);

		$this->add_control(
			'ha_modal_border_radius',
			[
				'label'      => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-content'     => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			],
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ha_modal_shadow',
				'selector' => '{{WRAPPER}} .ha-modal-modal-dialog',
			],
		);

		$this->add_responsive_control(
			'ha_modal_margin',
			[
				'label'      => __( 'Margin', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-dialog' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			],
		);

		$this->add_responsive_control(
			'ha_modal_padding',
			[
				'label'      => __( 'Padding', 'hoo-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ha-modal-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			],
		);

		$this->end_controls_section();
	}


	protected function render_header_icon( $new, $migrate ) {

		$settings = $this->get_settings_for_display();

		$header_icon = $settings['ha_modal_icon_selection'];

		if ( 'fonticon' === $header_icon ) {
			if ( $new || $migrate ) :
				Icons_Manager::render_icon( $settings['ha_modal_font_icon_updated'], [ 'aria-hidden' => 'true' ], );
			else : ?>
				<i <?php echo $this->get_render_attribute_string( 'title_icon' ); ?>></i>
				<?php
			endif;
		} elseif ( 'image' === $header_icon ) {
			?>
			<img <?php echo $this->get_render_attribute_string( 'title_icon' ); ?>>
			<?php
		} elseif ( 'animation' === $header_icon ) {
			$this->add_render_attribute(
				'header_lottie',
				[
					'class'               => [
						'ha-modal-header-lottie',
						'ha-lottie-animation',
					],
					'data-lottie-url'     => $settings['header_lottie_url'],
					'data-lottie-loop'    => $settings['header_lottie_loop'],
					'data-lottie-reverse' => $settings['header_lottie_reverse'],
				],
			);
			?>
				<div <?php echo $this->get_render_attribute_string( 'header_lottie' ); ?>></div>
			<?php
		}
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$trigger = $settings['ha_modal_display_on'];

		$this->add_inline_editing_attributes( 'ha_modal_selector_text' );

		$this->add_render_attribute( 'trigger', 'data-toggle', 'ha-modal' );

		$this->add_render_attribute( 'trigger', 'data-target', '#ha-modal-' . $this->get_id() );

		if ( 'button' === $trigger ) {
			if ( ! empty( $settings['ha_modal_button_icon_selection'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['ha_modal_button_icon_selection'] );
				$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
			}

			$migrated = isset( $settings['__fa4_migrated']['ha_modal_button_icon_selection_updated'] );
			$is_new   = empty( $settings['ha_modal_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();

			$this->add_render_attribute( 'trigger', 'type', 'button' );

			$this->add_render_attribute(
				'trigger',
				'class',
				[
					'ha-modal-trigger-btn',
					'ha-btn-' . $settings['ha_modal_button_size'],
				],
			);

		} elseif ( 'image' === $trigger ) {

			$this->add_render_attribute( 'trigger', 'class', 'ha-modal-trigger-img' );

			$this->add_render_attribute( 'trigger', 'src', $settings['ha_modal_image_src']['url'] );

			$alt = Control_Media::get_image_alt( $settings['ha_modal_image_src'] );
			$this->add_render_attribute( 'trigger', 'alt', $alt );

		} elseif ( 'text' === $trigger ) {
			$this->add_render_attribute( 'trigger', 'class', 'ha-modal-trigger-text' );
		} elseif ( 'animation' === $trigger ) {

			$this->add_render_attribute(
				'trigger',
				[
					'class'               => [
						'ha-modal-trigger-animation',
						'ha-lottie-animation',
					],
					'data-lottie-url'     => $settings['lottie_url'],
					'data-lottie-loop'    => $settings['lottie_loop'],
					'data-lottie-reverse' => $settings['lottie_reverse'],
					'data-lottie-hover'   => $settings['lottie_hover'],
				],
			);

		}

		if ( 'template' === $settings['ha_modal_content_type'] ) {
			$template = $settings['ha_modal_content_temp'];
		}

		if ( 'yes' === $settings['ha_modal_header_switcher'] ) {

			$header_icon = $settings['ha_modal_icon_selection'];

			$header_migrated = false;
			$header_new      = false;

			if ( 'fonticon' === $header_icon ) {

				if ( ! empty( $settings['ha_modal_font_icon'] ) ) {
					$this->add_render_attribute( 'title_icon', 'class', $settings['ha_modal_font_icon'] );
					$this->add_render_attribute( 'title_icon', 'aria-hidden', 'true' );
				}

				$header_migrated = isset( $settings['__fa4_migrated']['ha_modal_font_icon_updated'] );
				$header_new      = empty( $settings['ha_modal_font_icon'] ) && Icons_Manager::is_migration_allowed();
			} elseif ( 'image' === $header_icon ) {

				$this->add_render_attribute( 'title_icon', 'src', $settings['ha_modal_image_icon']['url'] );

				$alt = Control_Media::get_image_alt( $settings['ha_modal_image_icon'] );
				$this->add_render_attribute( 'title_icon', 'alt', $alt );

			}
		}

		$modal_settings = [
			'trigger' => $trigger,
		];

		if ( 'pageload' === $trigger ) {
			$modal_settings['delay'] = $settings['ha_modal_popup_delay'];
		}

		$css_class = 'container ha-modal-container ha-widget ha-modal';
		$css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );

		$this->add_render_attribute( 'modal', 'class', explode(' ', $css_class) );

		$this->add_render_attribute( 'modal', 'data-settings', wp_json_encode( $modal_settings ) );

		$this->add_render_attribute( 'dialog', 'class', 'ha-modal-modal-dialog' );

		$animation_class = $settings['ha_modal_animation'];
		if ( '' != $settings['ha_modal_animation_duration'] ) {
			$animation_dur = 'animated-' . $settings['ha_modal_animation_duration'];
		} else {
			$animation_dur = 'animated-';
		}
		$this->add_render_attribute(
			'dialog',
			'data-modal-animation',
			[
				$animation_class,
				$animation_dur,
			],
		);

		$this->add_render_attribute( 'dialog', 'data-delay-animation', $settings['ha_modal_animation_delay'] );

		?>

		<div <?php echo $this->get_render_attribute_string( 'modal' ); ?>>
			<div class="ha-modal-trigger-container">
				<?php
				if ( 'button' === $trigger ) :
					?>
					<button <?php echo $this->get_render_attribute_string( 'trigger' ); ?>>
						<?php
						if ( 'yes' === $settings['ha_modal_icon_switcher'] && $settings['ha_modal_icon_position'] === 'before' ) :
							if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['ha_modal_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
							else :
								?>
								<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
								<?php
						endif;
						endif;
						?>
						<span><?php echo $settings['ha_modal_button_text']; ?></span>
						<?php
						if ( 'yes' === $settings['ha_modal_icon_switcher'] && $settings['ha_modal_icon_position'] === 'after' ) :
							if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['ha_modal_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
							else :
								?>
								<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
								<?php
						endif;
						endif;
						?>
					</button>
				<?php elseif ( $trigger === 'image' ) : ?>
					<img <?php echo $this->get_render_attribute_string( 'trigger' ); ?>>
				<?php elseif ( $trigger === 'text' ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'trigger' ); ?>>
						<div <?php echo $this->get_render_attribute_string( 'ha_modal_selector_text' ); ?>><?php echo $settings['ha_modal_selector_text']; ?></div>
					</span>
				<?php elseif ( $trigger === 'animation' ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'trigger' ); ?>></div>
				<?php endif; ?>
			</div>

			<div id="ha-modal-<?php echo $this->get_id(); ?>" class="ha-modal-modal" role="dialog">
				<div <?php echo $this->get_render_attribute_string( 'dialog' ); ?>>
					<div class="ha-modal-modal-content">
						<?php if ( $settings['ha_modal_header_switcher'] === 'yes' ) : ?>
							<div class="ha-modal-modal-header">
								<?php if ( ! empty( $settings['ha_modal_title'] ) ) : ?>
									<h3 class="ha-modal-modal-title">
										<?php
										$this->render_header_icon( $header_new, $header_migrated );
										echo $settings['ha_modal_title'];
										?>
									</h3>
								<?php endif; ?>
								<?php if ( $settings['ha_modal_upper_close'] === 'yes' ) : ?>
									<div class="ha-modal-close-button-container">
										<button type="button" class="ha-modal-modal-close" data-dismiss="ha-modal">&times;</button>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="ha-modal-modal-body">
							<?php
							if ( $settings['ha_modal_content_type'] === 'editor' ) :
								echo $this->parse_text_editor( $settings['ha_modal_content'] );
							else :
								echo HooAddons_Utils::get_template_content( $template );
							endif;
							?>
						</div>
						<?php if ( $settings['ha_modal_lower_close'] === 'yes' ) : ?>
							<div class="ha-modal-modal-footer">
								<button type="button" class="ha-modal-modal-lower-close" data-dismiss="ha-modal">
									<?php echo $settings['ha_modal_close_text']; ?>
								</button>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}