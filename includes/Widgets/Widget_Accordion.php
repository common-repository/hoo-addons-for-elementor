<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
//use \Elementor\Scheme_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Repeater;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Accordion extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-accordion';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Accordion', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-list';
   }

   public function get_keywords() {
        return [
            'accordion',
            'hoo accordion',
            'hoo advanced accordion',
            'toggle',
            'collapsible',
            'faq',
            'group',
            'expand',
            'collapse',
            'hoo',
            'hoo addons',
        ];
    }

	public function get_custom_help_url() {
		return 'https://www.hoosoft.com/plugins/hoo-addons-for-elementor/accordion-widget/';
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
			'title_icon',
			[
				'label' => __( 'Title Icon', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
			]
		);
        $repeater = new Repeater();

        $repeater->add_control(
                'title', [
                'label'       => __( 'Title', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
			'status',
			[
				'label' => __( 'Expand', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'hoo-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'hoo-addons-for-elementor' ),
				'return_value' => 'in',
				'default' => '',
			]
		);

        $repeater->add_control(
			'content',
			[
				'label' => __( 'Description', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'hoo-addons-for-elementor' ),
			]
		);


        $this->add_control(
            'accordions',
            [
                'label'   => __( 'Accordion Item', 'hoo-addons-for-elementor' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __( 'Title 1', 'hoo-addons-for-elementor' ),
                        'status' => 'in',
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    ],
                    [
                        'title' => __( 'Title 2', 'hoo-addons-for-elementor' ),
                        'status' => '',
                        'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                    ],
                ],
                'title_field' => '{{ title }}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_layout_settings',
            [
                'label' => __( 'Layout', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'style',
			[
				'label' => __( 'Style', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple'  => __( 'Simple Style', 'hoo-addons-for-elementor' ),
					'boxed' => __( 'Boxed Style', 'hoo-addons-for-elementor' ),
					'spacing' => __( 'Spacing Style', 'hoo-addons-for-elementor' ),
				],
			]
		);

        $this->add_control(
			'type',
			[
				'label' => __( 'Status Icon', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'  => __( 'Arrow', 'hoo-addons-for-elementor' ),
					'2' => __( 'Plus', 'hoo-addons-for-elementor' ),
					'3' => __( 'None', 'hoo-addons-for-elementor' ),
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_layout_title',
            [
                'label' => __( 'Style Title', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography_title',
                'label'    => __( 'Typography', 'hoo-addons-for-elementor' ),
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .panel-title',
            ]
        );
        $this->add_control(
            'title_font_color',
            [
                'label'       => __( 'Title Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Font color', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#777777',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .panel-title, {{WRAPPER}} .panel-title i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'header_background_color',
            [
                'label'       => __( 'Header Background Color', 'hoo-addons-for-elementor' ),
                'description' => '',
                'separator'   => 'before',
                'default'     => '',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ha-accordion .panel-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_layout_description',
            [
                'label' => __( 'Style Description', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography_description',
                'label'    => __( 'Typography', 'hoo-addons-for-elementor' ),
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .panel-body',
            ]
        );
        $this->add_control(
            'description_font_color',
            [
                'label'       => __( 'Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Font color', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#24282D',
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .panel-body' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        $type  = $settings['type'];
        $style = $settings['style'];
        $title_icon = $settings['title_icon']['value'];
        $accordions = $settings['accordions'];
 
        $class = ' style'.$type;
		$uniqid = 'accordion-'.$this->get_id();
        $i = 0;
        $css_class = 'ha-widget panel-group ha-accordion accordion-'.esc_attr($style).' '.esc_attr($class).'';
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
		$output = '<div class="'.$css_class.'" role="tablist" aria-multiselectable="true">';
        
        if (is_array($accordions)){
            foreach ($accordions as $item) {

                $title   = $item['title'];
                $status  = $item['status'];
                $content = $item['content'];

                $icon_str = '';
                if ( $status == "in" ) {
                    $expanded = "true";
                    $collapse = "";
                }
                else {
                    $expanded = "false";
                    $collapse = "collapsed";
                }

                if ( $title_icon !== '' ):
                    $icon_str = '<i class="'.esc_attr($title_icon).'"></i>';
                endif;

                $itemId = 'collapse-'.$uniqid."-".$i;
		        $addclass = 'panel-css-'.$i;

                $output .= '<div class="panel panel-default '.$addclass.'">';
                $output .= '
                    <div class="panel-heading" role="tab" id="heading-'.$itemId.'">
                        <a class="accordion-toggle '.$collapse.'" href="#" data-toggle="collapse"  aria-expanded="'.$expanded.'" aria-controls="#'.$itemId.'">
                            <h4 class="panel-title">
                                    '.$icon_str.esc_attr($title).'
                            </h4>
                        </a>
                    </div>
                    <div id="'.$itemId.'" class="panel-collapse collapse '.esc_attr($status).'" role="tabpanel" >
                        <div class="panel-body">
                            '.do_shortcode( wp_kses_post($content) ).'
                            <div class="clear"></div>
                        </div>
                    </div>';
                $output .= '</div>';
                $i++;
            }
        }

        $output .= '</div>';

        echo $output;
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}