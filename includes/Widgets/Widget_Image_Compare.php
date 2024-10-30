<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Image_Compare extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-image-compare';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Image Compare', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-images';
   }

    public function get_script_depends() {
        return [ 'hoo-addons-widgets', 'jquery-twentytwenty', 'jquery-event-move'];
    }

    public function get_style_depends() {
        return [ 'hoo-addons-widgets', 'jquery-twentytwenty'];
    }

   public function get_keywords() {
        return [
            'image compare',
            'image before',
            'image after',
            'image split',
            'image segmentation',
            'image parting',
            'image separation',
            'split',
            'compare',
            'parting',
            'separation',
            'fragmenting',
            'left & right image',
            'top & bottom image',
            'hoo',
            'hoo addons',
            'twentytwenty'
        ];
    }

   protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Hoo Image Compare', 'hoo-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'orientation',
			[
				'label' => __( 'Split Orientation', 'hoo-addons-for-elementor' ),
                'description' => __( 'Select how the image compare display.', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => __( 'Horizontal Split', 'hoo-addons-for-elementor' ),
					'vertical' => __( 'Vertical Split', 'hoo-addons-for-elementor' ),
				],
			]
		);
        $this->add_control(
			'percent',
			[
				'label' => __( 'Percent', 'hoo-addons-for-elementor' ),
                'description' => __( 'How much of the before image is visible when the page loads.', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
			]
		);

        $this->add_control(
			'image_before',
			[
				'label' => __( 'The Before Image', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
                'description' => __( 'Set the image displayed in the left.', 'hoo-addons-for-elementor' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'image_after',
			[
				'label' => __( 'The After Image', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set the image displayed in the right.', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'before_label', [
                'label'       => __( 'Label before', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set a custom before label.', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default' => 'Before',
                'label_block' => true,
                ]
        );

        $this->add_control(
            'after_label', [
                'label'       => __( 'Label After', 'hoo-addons-for-elementor' ),
                'description' => __( 'Set a custom after label.', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default' => 'After',
                'label_block' => true,
                ]
        );

        $this->end_controls_section();

   }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        $orientation = esc_attr($settings['orientation']);
        $percent = absint($settings['percent']['size']);
        $image_before = esc_url($settings['image_before']['url']);
        $image_after = esc_url($settings['image_after']['url']);
        $before_label = esc_attr($settings['before_label']);
        $after_label = esc_attr($settings['after_label']);
        $id = $this->get_id();
        $dom_id = 'image-compare-'.$id;
        $css_class = "ha-image-compare ha-widget twentytwenty-container";
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );

        $output = '<div id="'.$dom_id.'" class="'.$css_class.'" data-before="'.$before_label.'" data-after="'.$after_label.'" data-pct="'.($percent/100).'" data-orientation="'.esc_attr($orientation).'">
				  <img src="'.$image_before.'">
		          <img src="'.$image_after.'">
				</div>' ;

        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script($settings);
        }

		echo $output;
   }

   protected function render_editor_script($settings) {
        $id = $this->get_id();
        $dom_id = 'image-compare-'.$id;
 
        echo '<script>
            jQuery(document).ready(function($){
            var default_offset_pct = $("#'.$dom_id.'").data("pct")
            var orientation = $("#'.$dom_id.'").data("orientation")
            var before_label = $("#'.$dom_id.'").data("before")
            var after_label = $("#'.$dom_id.'").data("after")

            $("#'.$dom_id.'").twentytwenty({
                default_offset_pct: default_offset_pct,
                orientation: orientation,
                before_label: before_label,
                after_label: after_label,
                click_to_move:true
            });
        })
        </script>';
    }


   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}