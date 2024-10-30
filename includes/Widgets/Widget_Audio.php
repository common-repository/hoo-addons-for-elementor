<?php
namespace HooAddons\Widget;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
//use \Elementor\Scheme_Typography;
use \Elementor\Plugin;
use \Elementor\Repeater;

use HooAddons\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Audio extends Widget_Base {

  public function get_categories() {
        return [ 'hoo-addons-elements' ];
    }

   public function get_name() {
      return 'hoo-addons-audio';
   }

   public function get_title() {
      return sprintf( '%1$s %2$s', Helper::get_widget_prefix(), __( 'Audio', 'hoo-addons-for-elementor' ) );
   }

   public function get_icon() {
        return 'haicon-music';
   }

   public function get_keywords() {
        return [
            'audio',
            'music',
            'hoo audio',
            'playlist',
            'player',
            'hoo',
            'hoo addons',
        ];
    }

    public function get_script_depends() {
        return [ 'hoo-addons-widgets', 'hoo-addons-audioplayer'];
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

        $repeater = new Repeater();

        $repeater->add_control(
                'title', [
                'label'       => __( 'Title', 'hoo-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
			'singer',
			[
				'label' => __( 'Artist', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
                'label_block' => true,
			]
		);

        $repeater->add_control(
			'songUrl',
			[
				'label' => __( 'MP3 Music File', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com/xxx.mp3', 'hoo-addons-for-elementor' ),
				'show_external' => false,
			]
		);
        $repeater->add_control(
			'imageUrl',
			[
				'label' => __( 'Cover Image', 'hoo-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'placeholder' => __( 'https://your-link.com/xxx.jpg', 'hoo-addons-for-elementor' ),
				'show_external' => false,
			]
		);
        

        $this->add_control(
            'music_info',
            [
                'label'   => __( 'Music Item', 'hoo-addons-for-elementor' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [ ],
                'title_field' => '{{ title }}',
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

        $this->end_controls_section();

   }

	protected function render_editor_script($settings) {
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
        echo '<script>var hoo_addons_music = '.json_encode($audio).'; new HooAddonsPlayer();</script>';
    }

   protected function render( $instance = [] ) {

        $settings = $this->get_settings();
        
        extract($settings);

        $css_class = "ha-widget ha-audio music-player";
        $css_class = apply_filters( 'hooaddons_widget_css_class', $css_class );
        $output = '
        <div class="'.$css_class.'">
            <audio class="music-player__audio" ></audio>
            <div class="music-player__main">
                <div class="music-player__blur"></div>
                <div class="music-player__disc">
                    <div class="music-player__image">
                        <img width="100%" src="" alt="">
                    </div>
                    <div class="music-player__pointer"><img width="100%" src="'.HOO_ADDONS_URL.'assets/frontend/images/cd_tou.png" alt=""></div>
                </div>
                <div class="music-player__controls">
                    <div class="music__info">
                        <h3 class="music__info--title">...</h3>
                        <p class="music__info--singer">...</p>
                    </div>
                    <div class="player-control">
                        <div class="player-control__content">
                            <div class="player-control__btns">
                                <div class="player-control__btn player-control__btn--prev"><i class="iconfont icon-prev"></i></div>
                                <div class="player-control__btn player-control__btn--play"><i class="iconfont icon-play"></i></div>
                                <div class="player-control__btn player-control__btn--next"><i class="iconfont icon-next"></i></div>
                                <div class="player-control__btn player-control__btn--mode"><i class="iconfont icon-loop"></i></div>
                            </div>
                            <div class="player-control__volume">
                                <div class="control__volume--icon player-control__btn"><i class="iconfont icon-volume"></i></div>
                                <div class="control__volume--progress progress"></div>
                            </div>
                        </div>
        
                        <div class="player-control__content">
                            <div class="player__song--progress progress"></div>
                            <div class="player__song--timeProgess nowTime">00:00</div>
                            <div class="player__song--timeProgess totalTime">00:00</div>
                        </div>
        
                    </div>
        
                </div>
            </div>
            <div class="music-player__list">
                <ul class="music__list_content">
                    <!-- <li class="music__list__item play">123</li>
                    <li class="music__list__item">123</li>
                    <li class="music__list__item">123</li> -->
                </ul>
            </div>
        </div>';
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $this->render_editor_script($settings);
        } 
    
        echo $output;
   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}