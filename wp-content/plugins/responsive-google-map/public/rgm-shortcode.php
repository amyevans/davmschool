<?php


/**
 * The Dashboard specific Shortcodes
 *
 * @link http://webomnizz.com 
 * @since 2.1
 * 
 * @package responsive-google-map
 * @subpackage responsive-google-map/admin
 */
class RGM_Shortcode {

    
        
        /**
         * The ID of the plugin
         * 
         * @since 2.1
         * @access private
         * @var string
         */
        private $plugin_name;
        
        
        
        
        /**
         * The Version of the plugin
         * 
         * @since 2.1
         * @access private
         * @var string
         */
        private $version;
    
        
        
        
        /**
         * Initialize the plugin and set its properties
         * 
         * @since 2.1
         * @param string $plugin_name       The Name of the plugin
         * @param string $version           The version of the plugin
         */
        function __construct($plugin_name, $version) {
            
            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }
        
        
        
        
        /**
         * Generate GMAP options for users to select
         * 
         * @since 2.1
         * @param string $atts
         * @return type
         */
        function gmap_initiate($atts) {
            
            // Get Cached Data
            if( ( $options = get_transient("_om_gmap_settings") ) === FALSE ) {
                $options = get_option('om_gmap_settings');
            }


            $Map_Type = isset($options['map_types']) ? "google.maps.MapTypeId." . strtoupper($options['map_types']) : "google.maps.MapTypeId.TERRAIN";
            $Scroll_Wheel = isset( $options['scrollzoom'] ) ? false : true; 
            $Draggable = isset( $options['draggable'] ) ? true : false;
            $Marker_Status = isset( $options['marker'] ) ? true : false;
            $Circle = isset($options['draw_circle']) ? true : false;
            $NMarker = isset( $options['om_marker'] ) && ! empty($options['om_marker']) ? plugin_dir_url(__FILE__) . "images/marker_" . $options['om_marker'] . ".png" : false;


            // Contact Form Stylesheet
            //$this->style_string = $options['wpcf_css'];


            extract( shortcode_atts( array(
                'zoom'=>'2', 
                'lat'=>'28.9285745', 
                'lng'=>'77.09149350000007', 
                'marker'=>'', 
                'height'=>'300', 
                'infowindow'=>'', 
                'styles'=>''
                //'wpcf'=>''
            ), $atts));

            if( !empty($infowindow) ) {
                $infowindow = str_replace("/\n/g", "<br>", $infowindow);
            }
            else {
                $infowindow = '';
            }

            if( !empty($wpcf) ) {
                $form = '[contact-form-7 id="'.$wpcf.'" title="Contact form"]';
            }
            else {
                $form = "";
            }


            $Settings_Params = array(
                'zoom'=>$zoom, 
                'lat'=>$lat, 
                'lng'=>$lng, 
                'infoWindow'=>$infowindow, 
                'cMarker'=>$marker, 
                'Styles'=>$styles, 
                'Map_Type'=>$Map_Type, 
                'Scroll_Wheel'=>$Scroll_Wheel, 
                'Draggable'=>$Draggable, 
                'Marker_Status'=>$Marker_Status, 
                'Circle'=>$Circle, 
                'Marker'=>$NMarker, 
                'Meter'=>1609.34, 
                'CircleBG'=>$options['circle_bg_color'], 
                'Stroke'=>$options['circle_border_color'], 
                'Miles'=>$options['circle_range']
            );

            wp_enqueue_script( "google-map-v3", "https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false" );
            wp_register_script("om_wpgmap", plugin_dir_url(__FILE__)."js/om_wpgmap.js", array('google-map-v3'), $this->version, true);
            wp_enqueue_script("om_wpgmap");
            wp_localize_script( "om_wpgmap", 'OM', $Settings_Params);


            return "<div id='om_container'><div id='location-canvas' style='".(empty($form) ? "height:{$height}px;" : "")."width:100%;'></div></div>";
        }
}
