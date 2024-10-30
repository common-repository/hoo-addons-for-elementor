<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Highlight extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-highlight';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Highlight', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-eye-plus';
   }

   public function get_keywords() {
        return [
            'highlight',
            'hoo highlight',
            'text highlight',
            'text background color',
            'hoo',
            'hoo addons',
        ];
    }

	public function get_custom_help_url() {
		return 'https://www.hoosoft.com/plugins/hoo-addons-for-elementor/highlight-widget/';
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
                'label' => __( 'Hoo Highlight', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
       
        $repeater = new Repeater();

        $repeater->add_control(
                'text', [
                'label'       => __( 'Text to Highlight', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'text_color',
            [
                'label'       => __( 'Text Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set content color color for alert box.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => '#ffffff',
                'type'        => Controls_Manager::COLOR,
            ]
        );

        $repeater->add_control(
            'background_color',
            [
                'label'       => __( 'Text Background Color', 'hoo-addons-for-elementor' ),
                'description' => '',
                'separator'   => 'before',
                'default'     => '#007005',
                'type'        => Controls_Manager::COLOR,
            ]
        );

        $repeater->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
			]
		);


        $this->add_control(
            'highlight_strings',
            [
                'label'   => __( 'Highlight Strings', 'hoo-addons-for-elementor' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'text' => 'consectetur adipiscing elit',
                        'text_color' => '#ffffff',
                        'background_color' => '#007005',
                        'border_radius' => ['top'=>0, 'left'=>0, 'right'=>0, 'bottom'=>0]
                    ],
                    [
                        'text' => 'Ut enim ad minim veniam',
                        'text_color' => '#ffffff',
                        'background_color' => '#A4262C',
                        'border_radius' => ['top'=>0, 'left'=>0, 'right'=>0, 'bottom'=>0]
                    ],
                ],
                'title_field' => '{{ text }}',
            ]
        );

        $this->add_control(
			'content',
			[
				'label' => __( 'Content', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
			]
		);

        $this->end_controls_section();


   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $this->add_render_attribute('highlight_attributes', $this->render_attributes($settings));

        $highlight_strings  = $settings['highlight_strings'];
        $content  = do_shortcode( wp_kses_post($settings['content']));

        if (is_array($highlight_strings)){
            foreach ($highlight_strings as $item) {
                $text   = $item['text'];
                $text_color   = $item['text_color'];
                $background_color   = $item['background_color'];
                $border_radius   = $item['border_radius'];

                $border_radius_ = absint($border_radius['top']).$border_radius['unit'].' ';
                $border_radius_ .= absint($border_radius['right']).$border_radius['unit'].' ';
                $border_radius_ .= absint($border_radius['bottom']).$border_radius['unit'].' ';
                $border_radius_ .= absint($border_radius['left']).$border_radius['unit'];
	   	
	            $style  = sprintf( 'border-radius:%s;', $border_radius_);
	            $style .= sprintf( 'background-color:%s;', $background_color );
                $style .= sprintf( 'color:%s;', $text_color );
                $style .= 'padding: 0 3px;';
                $content = str_replace($text, '<span class="ha-highlight-text" style="'.$style.'">'.$text.'</span>', $content);


            }
        }
        $output = sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'highlight_attributes' ), $content );

        echo $output;
   }

   protected function render_attributes( $args = [] ) {

        $css_class  = 'ha-widget ha-highlight';
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
        $attr['class'] = $css_class;
        return $attr;

    }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}