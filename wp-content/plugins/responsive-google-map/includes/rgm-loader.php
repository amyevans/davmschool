<?php

/**
 * Register all the actions and filters for the Plugin
 * 
 * Maintain a list of all the hooks that are registered throughout
 * the plugin, and register them with the WordPress API.
 * 
 * @package responsive-google-map
 * @subpackage responsive-google-map/includes
 * @author Jogesh Sharma <jogesh.sharma06@gmail.com>
 */
class RGM_Loader {
 
    
        /**
         * The array of actions registered with WordPress
         * 
         * @since 2.1
         * @access protected
         * @var array $actions
         */
        protected $actions;
        
        
        
        
        
        /**
         * The array of filters registered with WordPress
         * 
         * @var array $filters
         */
        protected $filters;
        
        
        
        
        
        
        function __construct() {
            
            $this->actions = array();
            $this->filters = array();
        }
        
        
        
        
        /**
         * Add a new action to the collection to be registered with WordPress
         * 
         * @since 2.1
         * @param string                    $hook
         * @param object                    $component
         * @param string                    $callback
         * @param int       optional        $priority
         * @param int       optional        $accepted_args
         */
        function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
            
            $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args);
        }
        
        
        
        
        /**
         * Add new filter to the collection to be registered with WordPress
         * 
         * @since 2.1
         * @param string                    $hook
         * @param object                    $component
         * @param string                    $callback
         * @param int       optional        $priority
         * @param int       optional        $accepted_args
         */
        function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
            
            $this->filters = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args);
        }
        
        
        
        
        /**
         * A utility function that is used to register the actions and hooks 
         * into a single callback
         * 
         * @since 2.1
         * @access private
         * @param array $hooks
         * @param string $hook
         * @param object $component
         * @param string $callback
         * @param int Optional $priority
         * @param int Optional $accepted_args
         * @return type
         */
        function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {
            
            $hooks[] = array(
                'hook'          => $hook, 
                'component'     => $component, 
                'callback'      => $callback, 
                'priority'      => $priority, 
                'accepted_args' => $accepted_args
            );
            
            return $hooks;
        }
        
        
        
        
        
        /**
         * Register the filters and actions with WordPress
         * 
         * @since 2.1
         */
        function run() {
            
            foreach( $this->filters as $hook ) {
                add_filter( $hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args'] );
            }
            
            foreach( $this->actions as $hook ) {
                add_action( $hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args'] );
            }
        }
    
}