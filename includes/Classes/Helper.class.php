<?php
namespace HooAddons\Classes;

class Helper{

    /**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

    /**
	 * Initialize integration hooks
	 *
	 * @return void
	 */
    function __construct(){
        add_action( 'elementor/frontend/after_register_scripts', array( $this,'register_scripts') );
        add_action( 'elementor/frontend/after_register_styles', array( $this,'register_styles') );
        add_action( 'wp_enqueue_scripts', array( $this,'enqueue_frontend_scripts') );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this,'enqueue_editor_scripts') );
        add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_widget_categories') );
        add_action( 'elementor/frontend/widget/before_render', array( $this, 'before_widget_render') );
    }

    function before_widget_render(\Elementor\Element_Base $element){

        $settings = $element->get_settings();

        if ( 'hoo-addons-chart-bar' === $element->get_name() ) {
            
            if (!empty( $settings)){
                $id = $element->get_id();
                $chart_info = $this->get_chart_info($settings);
                $inline_script = 'hooaddons_label[\'chart-'.$id.'\'] = '.json_encode($chart_info['labels']).';';
                $inline_script .= 'hooaddons_datasets[\'chart-'.$id.'\'] = '.json_encode($chart_info['datasets']).';';
    
                wp_add_inline_script('hoo-addons-widgets', $inline_script, 'before');
            }
        }

        if ( 'hoo-addons-audio' === $element->get_name() ) {
 
            if (!empty($settings)) {
                $settings = $settings;
                $music_info = $settings['music_info'];
                $audio = [];
                if($music_info){
                    $i = 0;
                    foreach( $music_info as $item ){
                        $audio[$i]['id'] = $i+1;
                        $audio[$i]['title'] = esc_attr($item['title']);
                        $audio[$i]['singer'] = esc_attr($item['singer']);
                        $audio[$i]['songUrl'] = esc_url($item['songUrl']['url']);
                        $audio[$i]['imageUrl'] = esc_url($item['imageUrl']['url']);
                        $i++;
                    }
                }
                $this->audio = $audio;
                $inline_script = 'var hoo_addons_music = '.json_encode($audio).';';
                wp_add_inline_script('hoo-addons-audioplayer', $inline_script, 'before');
            }
        }

        if ( 'hoo-addons-modal' === $element->get_name() ) {

            if ( ! empty( $settings['ha_modal_modal_size']['size'] ) ) :
             
				$css = '@media (min-width: 992px) {';
                $css .= '#ha-modal-'.$element->get_id().' .ha-modal-modal-dialog {width: '.$settings['ha_modal_modal_size']['size'] . $settings['ha_modal_modal_size']['unit'].'}';
                $css .=  '}';
            wp_add_inline_style('hoo-addons-widgets', $css, 'after');
			endif;
        }
        
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
    /**
	 * Load frontend scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function enqueue_frontend_scripts(){
        $inline_script = 'var hooaddons_label = [];var hooaddons_datasets = []; var hoo_addons_url="'.HOO_ADDONS_URL.'";';
        wp_add_inline_script('hoo-addons-widgets', $inline_script, 'before');
        
    }

    /**
	 * Get widget title prefix
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string
	 */
	public static function get_widget_prefix() {

		$prefix = __( 'Hoo', 'hoo-addons-for-elementor' );

		return $prefix;
	}

    /**
	 * Load Elementor editor scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function enqueue_editor_scripts(){
        wp_register_style(
            'haicon',
            HOO_ADDONS_URL . 'assets/admin/css/haicon.css',
            '',
            HOO_ADDONS_VERSION,
        );
        wp_enqueue_style('haicon');
    }

    /**
	 * register styles.
	 *
	 * @since 1.0.1
	 * @access public
	 */
    public function register_styles(){

        $min_suffix = Utils::is_script_debug() ? '' : '.min';

        wp_register_style(
            'hoo-addons-widgets',
            HOO_ADDONS_URL . 'assets/frontend/css/widgets'.$min_suffix.'.css',
            [],
            HOO_ADDONS_VERSION,
        );

        wp_register_style(
            'chart', 
            HOO_ADDONS_URL.'assets/vendor/chart/Chart'.$min_suffix.'.css',
            [],
            '2.9.4',
        );

        wp_register_style(
            'jquery-twentytwenty', 
            HOO_ADDONS_URL.'assets/vendor/twentytwenty/css/twentytwenty.css',
            [],
            '',
        );
        
    }
    /**
	 * register scripts.
	 *
	 * @since 1.0.1
	 * @access public
	 */
    public function register_scripts(){

        $min_suffix = Utils::is_script_debug() ? '' : '.min';

        wp_register_script(
            'hoo-addons-widgets',
            HOO_ADDONS_URL . 'assets/frontend/js/widgets'.$min_suffix.'.js',
            array( 'jquery' ),
            HOO_ADDONS_VERSION,
            true
        );

        wp_register_script(
            'hoo-addons-audioplayer',
            HOO_ADDONS_URL . 'assets/frontend/js/audioplayer'.$min_suffix.'.js',
            array( 'jquery' ),
            HOO_ADDONS_VERSION,
            false
        );

        wp_register_script(
            'chart',
            HOO_ADDONS_URL.'assets/vendor/chart/Chart'.$min_suffix.'.js',
            array( 'jquery'),
            '2.9.4',
            true
        );

        wp_register_script(
            'jquery-twentytwenty',
            HOO_ADDONS_URL.'assets/vendor/twentytwenty/js/jquery.twentytwenty.js',
            array( 'jquery'),
            '',
            true
        );

        wp_register_script(
            'jquery-event-move',
            HOO_ADDONS_URL.'assets/vendor/twentytwenty/js/jquery.event.move.js',
            array( 'jquery'),
            '',
            true
        );

        wp_register_script(
            'hoo-addons-lottie',
            HOO_ADDONS_URL.'assets/vendor/lottie/lottie.js',
            array( 'jquery'),
            '',
            true
        );

        wp_register_script(
            'hoo-addons-modal',
            HOO_ADDONS_URL.'assets/vendor/modal/modal.js',
            array( 'jquery'),
            '',
            true
        );

    }

        /**
	 * Load elements.
	 *
	 * Load hooaddons elementor widget.
	 *
	 * @since 1.0.0
	 * @access private
	 */
    public function elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'hoo-addons-elements',
            [
                'title' => __( 'Hoo Addons', 'hoo-addons-for-elementor' ),
            ]
        );
    }

    
    /**
	 *
	 * Creates and returns an instance of the class
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
