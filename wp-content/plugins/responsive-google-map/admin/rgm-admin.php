<?php

/**
 * The dashboard specific functionality
 * 
 * @link http://webomnizz.com 
 * @since 2.1
 * 
 * @package responsive-google-map
 * @subpackage responsive-google-map/admin
 */
class RGM_Admin {
    
    
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
         * @since 2.1
         * @access private
         * @var string
         */
        private $version;
        
        
        
        
        /**
         * The settings of the plugin
         * 
         * @since 2.1
         * @access private
         * @var string
         */
        private $plugin_options;
        
        
        
        
        /**
         * Initialize the plugin and set its properties
         * 
         * @since 2.1
         * @param string $plugin_name       The name of the plugin
         * @param string $version           The version of the plugin
         */
        function __construct($plugin_name, $version) {
            
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            $this->plugin_options = "om_gmap_settings";
        }
        
        
        
        
        /**
         * Register the stylesheet for the dashboard
         * 
         * @since 2.1
         */
        function enqueue_styles() {
            global $current_screen;
        
            $Settings_Params = array(
                'ajaxurl'=>admin_url('admin-ajax.php'), 
                'gmap_nonce'=>wp_create_nonce('om_gmap_nonce')
            );

            wp_register_script( 'om-admin-ui-js', plugin_dir_url(__FILE__) . 'js/tabs.min.js');
            wp_register_script( "om-settings", plugin_dir_url(__FILE__) . 'js/settings.js');

            if( $current_screen && ( $current_screen->base == "edit" || $current_screen->base == "post" ) ){
                wp_enqueue_script("om-admin-ui-js");
                wp_enqueue_style( "om-tabs-ui", plugin_dir_url(__FILE__) . 'css/map-ui.css' );
            }

            if( $current_screen && $current_screen->base == "settings_page_gmap_settings" ){
                wp_enqueue_style( "om-map-settings", plugin_dir_url(__FILE__) . 'css/map_settings.css' );
                wp_enqueue_script( "om-settings" );
                wp_localize_script( "om-settings", 'OM', $Settings_Params);
            }
        }
        
        
        
        
        /**
         * Register the scripts for the dashboard
         * 
         * @since 2.1
         */
        function enqueue_scripts() {
            
            //wp_enqueue_script("om-custom-gmap", plugin_dir_url(__FILE__) . 'js/om-gmap.js', array('jquery'), $this->version, FALSE);
        }
        
        
        
        
        
        
        
        /**
         * Register plugin settings page
         *
         * @since 2.1 
         */
        function register_settings() {
            
            add_options_page( __("Google Map Options", $this->plugin_name), __("GMap Settings", $this->plugin_name), "manage_options", "gmap_settings", array($this, "settings_page_template"));
        }
        
        
        
        
        
        /**
         * Integrate Third-party plugin 
         * with RGM Plugin
         * 
         * @since 2.1
         */
        function rgm_integration() {}
        
        
        
        
        /**
         * Attach RGM with Editor
         * 
         * @since 2.1
         * @global string $pagenow
         */
        function rgm_attach() {
            
            if( !current_user_can("edit_posts") && !current_user_can("edit_pages") ) {
                return;
            }


            if( get_user_option("rich_editing") == true ) {
                global $pagenow;
                if( $pagenow == "post.php" || $pagenow == "post-new.php" ){
                    add_filter( "mce_external_plugins", array( $this, 'add_map_plugin' ) );
                    add_filter( "mce_buttons", array( $this, 'register_map_button' ) );
                }
            }
        }
        
        
        
        
        
        /**
         * Handle Ajax Request for RMG Admin Settings
         * 
         * @since 2.1
         */
        function admin_settings_request() {
            
            if( ! wp_verify_nonce( $_POST['gmap_nonce'], 'om_gmap_nonce' ) ){
                die('Un-trusted Request!');
            }
                
            $d = $this->str2arr( $_POST['data'] );
            $data = array_map("urldecode", $d);
                
            // Transients API
            if( get_transient("_om_gmap_settings") ) {
                    
                delete_transient("_om_gmap_settings");                    
                update_option( "om_gmap_settings", $data );
                set_transient("_om_gmap_settings", $data);
            }
            else {
                    
                update_option( "om_gmap_settings", $data );
                set_transient("_om_gmap_settings", $data);
            }
                
            echo json_encode( $data );
            die(0);
        }
        
        
        
        
        
        function add_map_plugin($plugin_array) {
            global $pagenow;
        
            if( is_admin() && $pagenow == "post.php" || $pagenow == "post-new.php" ){
                $plugin_array['omgmap'] = plugin_dir_url(__FILE__) . '/js/om-gmap.js';
                
                include_once plugin_dir_path( dirname(__FILE__) ).'admin/template/rgm-editor.php';
                return $plugin_array;
            }
        }
        
        
        
        
        function str2arr( $str ){
        
            $return = array();
            $exp = explode( "&", $str );

            foreach( $exp as $e ){
                $ex = explode( "=", $e );
                $return[$ex[0]] = $ex[1];
            }

            return $return;
        }
        
        
        
        
        
        function register_map_button($buttons) {
            array_push( $buttons, "|", "omgmap" );
            return $buttons;
        }
        
        
        
        
        
        
        
        function settings_page_template() {
            
            $options = get_option( $this->plugin_options );
            
            include_once plugin_dir_path( dirname(__FILE__) ) . 'admin/template/rgm-admin-options.php';
        }
}