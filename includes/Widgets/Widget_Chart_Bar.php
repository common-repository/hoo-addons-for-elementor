<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Repeater;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Chart_Bar extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-chart-bar';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Chart Bar', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-stats-bars';
   }

   public function get_script_depends() {
        return [ 'hoo-addons-widgets', 'chart'];
   }

    public function get_style_depends() {
        return [ 'hoo-addons-widgets', 'chart'];
    }

    public function get_keywords() {
        return [
            'chart',
            'stats',
            'hoo chart',
            'chart bar',
            'stats bar',
            'hoo',
            'hoo addons',
        ];
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
            'label', [
                'label'       => __( 'Label For Line', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'January, February, March, April, May, June', 'hoo-addons-for-elementor' ),
                'description' => __( 'separate multiple tags added to chart line with commas', 'hoo-addons-for-elementor' ),
                'label_block' => true,
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
			'data',
			[
				'label' => __( 'Data', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '456,479,324,569,702,600',
			]
		);

        $repeater->add_control(
            'fill_color',
            [
                'label'       => __( 'Fill Color', 'hoo-addons-for-elementor' ),
                'description' => __( 'Chart bar background color.', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => 'rgba(172, 194, 109, 0.6)',
                'type'        => Controls_Manager::COLOR,
            ],
        );

        $repeater->add_control(
            'border_color',
            [
                'label'       => __( 'Border Color', 'hoo-addons-for-elementor' ),
                'separator'   => 'before',
                'default'     => 'rgba(191, 121, 121, 0.8)',
                'type'        => Controls_Manager::COLOR,
            ],
        );

        $this->add_control(
            'chart_bars',
            [
                'label'   => __( 'Repeater Item', 'hoo-addons-for-elementor' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => sprintf(__( 'Data group %s', 'hoo-addons-for-elementor' ), 1),
                        'data' => '356,379,314,569,650,500',
                        'fill_color' => 'rgba(172, 194, 109, 0.6)',
                        'border_color' => 'rgba(172, 194, 109, 0.6)',
                    ],
                    [
                        'title' => sprintf(__( 'Data group %s', 'hoo-addons-for-elementor' ), 2),
                        'data' => '456,479,324,569,702,600',
                        'fill_color' => 'rgba(191, 121, 121, 0.8)',
                        'border_color' => 'rgba(191, 121, 121, 0.8)',
                    ],

                ],
                'title_field' => '{{ title }}',
            ]
        );

        $this->end_controls_section();

   }

   protected function get_chart_info($settings){

    $labels = [];
    $datasets = [];
    if (is_array($settings)){

        $chart_bars = $settings['chart_bars'];
        $label = $settings['label'];
        $labels = explode(',', esc_attr($label));
        $labels_num = count($labels);
        
        $datasets = [];
        $i = 0;
        foreach ($chart_bars as $item){
            extract($item);

            $datasets[$i]['label'] = '# '.esc_attr($title);
            $backgroundColor = [];
            $borderColor = [];
            for($j=0; $j<$labels_num;$j++){
                $backgroundColor[$j] = $item['fill_color'];
                $borderColor[$j] = $item['border_color'];
            }
            $datasets[$i]['backgroundColor'] = $backgroundColor;
            $datasets[$i]['borderColor'] = $borderColor;
            $datasets[$i]['data'] = explode(',', esc_attr($data));
            $i++;
        }
        
    }
    return ['labels'=>$labels, 'datasets'=>$datasets];
   }

   protected function render_editor_script($settings) {
        $id = $this->get_id();
        $dom_id = 'chart-'.$id;
        $chart_info = $this->get_chart_info($settings);
        $inline_script = 'hooaddons_label[\''.$dom_id.'\'] = '.json_encode($chart_info['labels']).';';
        $inline_script .= 'hooaddons_datasets[\''.$dom_id.'\'] = '.json_encode($chart_info['datasets']).';';
        echo '<script>'.$inline_script.'
        var ctx = document.getElementById("'.$dom_id.'").getContext("2d");
        var barData = {
            type: "bar",
            data: {
                labels : hooaddons_label[\''.$dom_id.'\'],
                datasets : hooaddons_datasets[\''.$dom_id.'\']
            }
        }
        new Chart(ctx, barData);</script>';
    }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        
        $id = $this->get_id();
		$id = 'chart-'.$id;
        $css_class = 'ha-widget ha-chart-bar';
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
		$output = '<canvas id="'.esc_attr($id).'" class="'.esc_attr($css_class).'"></canvas>';
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script($settings);
        }
        echo $output;
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}