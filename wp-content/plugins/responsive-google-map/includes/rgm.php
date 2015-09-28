<?php

/**
 * Core Plugin Class
 * 
 * @since 2.1
 * @package responsive-google-map
 * @subpackage responsive-google-map/includes
 * @author Jogesh Sharma <jogesh.sharma06@gmail.com>
 */
class RGM {
    
    
        /**
         * Responsible for maintaining and registering all hooks that 
         * power the plugin
         * 
         * @var RGM_Loader  $loader 
         */
        protected $loader;
    
    
    
        /**
         * Unique Identifier for the plugin
         * 
         * @var string  $plugin_name
         */
        protected $plugin_name;
        
        
        
        /**
         * Current Version of the Plugin
         * 
         * @var string $version
         */
        protected $version;
        
        
        
        
        
        function __construct() {
            
            $this->plugin_name = "responsive-gmap";
            $this->version = 2.1;
            
            $this->load_dependencies();
            $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }
    
        
        
        
        /**
         * Load the required dependencies for the plugin
         * 
         * @since 2.1
         * @access private
         */
        function load_dependencies() {
            
            require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/rgm-loader.php';
            
            /**
             * The class responsible for defining internationalization functionality
             */
            require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/rgm-i18n.php';
            
            
            /**
             * The class responsible for defining all actions that occur in Dashboard
             */
            require_once plugin_dir_path( dirname(__FILE__) ) . 'admin/rgm-admin.php';
            
            
            
            require_once plugin_dir_path( dirname(__FILE__) ) . 'public/rgm-shortcode.php';
            
            
            /**
             * The class responsible for defining all actions that occur in public-facing 
             * side of the site
             */
            require_once plugin_dir_path( dirname(__FILE__) ) . 'public/rgm-public.php';
            
            $this->loader = new RGM_Loader();
        }
        
        
        
        
        
        /**
         * Define the locale for this plugin for internationalization
         * 
         * @since 2.1
         * @access private
         */
        private function set_locale() {
            
            $rgm_i18n = new RGM_i18n();
            $rgm_i18n->set_domain( $this->get_plugin_name() );
            
            
            $this->loader->add_action( 'plugins_loaded', $rgm_i18n, 'load_plugin_textdomain');
        }
        
        
        
        
        /**
         * Register all the hooks related to the dashboard functionality
         * 
         * @since 2.1
         * @access private
         */
        private function define_admin_hooks() {
            
            $rgm_admin = new RGM_Admin( $this->get_plugin_name(), $this->get_plugin_version() );
            
            
            $this->loader->add_action("admin_enqueue_scripts", $rgm_admin, "enqueue_scripts");
            $this->loader->add_action("admin_enqueue_scripts", $rgm_admin, "enqueue_styles");
            $this->loader->add_action("admin_menu", $rgm_admin, "register_settings");
            //$this->loader->add_action("admin_head", $rgm_admin, "rgm_integration");
            $this->loader->add_action("wp_ajax_om-map", $rgm_admin, "admin_settings_request");
            $this->loader->add_action("wp_ajax_nopriv_om-map", $rgm_admin, "admin_settings_request");
            $this->loader->add_action("admin_init", $rgm_admin, "rgm_attach");
        }
        
        
        
        /**
         * Register all the hooks related to the public facing functionality
         */
        private function define_public_hooks() {
            
            $rgm_public = new RGM_Public( $this->get_plugin_name(), $this->get_plugin_version() );
            $rgm_shortcode = new RGM_Shortcode($this->get_plugin_name(), $this->get_plugin_version());
            
            $this->loader->add_action("wp_enqueue_scripts", $rgm_public, "enqueue_styles");
            add_shortcode("om_gmap", array($rgm_shortcode, "gmap_initiate"));
            
        }
        
        
        
        /**
         * Run all the loader to execute all the hooks with WordPress
         * 
         * @since 2.1
         */
        function run() {
            $this->loader->run();
        }
        
        
        
        
        /**
         * The name of the plugin used to unique indentify 
         * and to define internationalization functionality
         * 
         * @since 2.1
         * @return string       The name of the plugin
         */
        function get_plugin_name() {
            return $this->plugin_name;
        }
        
        
        
        /**
         * Retrieve the version number of the plugin
         * 
         * @since 2.1
         * @return string       The version number of the plugin
         */
        function get_plugin_version() {
            return $this->version;
        }
        
        
        
        
        /**
         * The reference to the class
         * 
         * @since 2.1
         * @return RGM_Loader
         */
        function get_loader() {
            return $this->loader;
        }
    
}