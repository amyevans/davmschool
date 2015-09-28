<?php



/**
 * Public facing functionality of the plugin
 *
 * @link http://webomnizz.com 
 * @since 2.1
 * 
 * @package responsive-google-map
 * @subpackage responsive-google-map/public
 * @author jogesh
 */
class RGM_Public {

    
    
        /**
         * The ID of the plugin
         * 
         * @since 2.1
         * @access private
         * @var string
         */
        private $plugin_name;
        
        
        
        /**
         * The version of the plugin
         * 
         * @access private
         * @since 2.1
         * @var string
         */
        private $version;
        
        
        
        /**
         * Initiatize the class and set its properties
         * 
         * @since 2.1
         * @param string $plugin_name           The Plugin name
         * @param string $version               The version of the plugin
         */
        function __construct($plugin_name, $version) {
            
            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }
        
        
        
        
        /**
         * Register the stylesheet for the plugin
         * 
         * @since 2.1
         */
        function enqueue_styles() {
            
            wp_enqueue_style($this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/om-map.css', array(), $this->version, 'all');
        }
        
        
        
        
        /**
         * Register the scripts for the plugin
         * 
         * @since 2.1
         */
        function enqueue_scripts() { }
}
