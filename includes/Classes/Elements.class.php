<?php
namespace HooAddons\Classes;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use Elementor\Plugin;

class Elements {

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
     
   }

   public function widgets_registered() {

      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
      
         foreach (glob(HOO_ADDONS_INCLUDE_DIR."/Widgets/*.php") as $filename) {

            $template_file = $filename;
            
            if ( is_file($template_file) && is_readable( $template_file ) ) {
                  require_once $template_file;
                  $className = 'HooAddons\\Widget\\'.basename($template_file, ".php");
                  if (class_exists( $className )) Plugin::instance()->widgets_manager->register_widget_type( new $className );
               }
         }
      
      }
   }

}





