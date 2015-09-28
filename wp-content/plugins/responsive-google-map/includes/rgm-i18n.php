<?php

/**
 * Define the internationalization functionality
 * 
 * Loads and defines the internationalization files for the plugin
 * 
 * @since 2.1
 * @package responsive-google-map
 * @subpackage responsive-google-map/includes
 * @author Jogesh Sharma <jogesh.sharma06@gmail.com>
 */
class RGM_i18n {
    
    
        /**
         * The Domain specific for this plugin
         * 
         * @var string $domain
         */
        private $domain;
        
        
        
        
        /**
         * Load the plugin text domain for the translation
         * 
         * @since 2.1
         */
        function load_plugin_textdomain() {
            
            load_plugin_textdomain(
                    $this->domain, 
                    false, 
                    dirname( dirname( plugin_basename(__FILE__) ) ) . '/languages/'
            );
        }
        
        
        
        /**
         * Set the domain equal to that of the specific domain
         * 
         * @since 2.1
         * @param string $domain
         */
        function set_domain( $domain ) {
            $this->domain = $domain;
        }
    
    
}