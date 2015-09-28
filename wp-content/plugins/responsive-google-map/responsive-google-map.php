<?php

/**
 * Plugin Bootsrap file
 * 
 * 
 * @link http://webomnizz.com 
 * @since 2.1
 * @package responsive-google-map
 * 
 * 
 * 
 * Plugin Name: Responsive Google MAP
 * Plugin URI: http://webomnizz.com
 * Description: Responsive Google MAP, Anywhere.
 * Version: 2.2
 * Author: Jogesh Sharma
 * Text Domain: responsive-gmap
 * Author URI: http://webomnizz.com/blog
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */


/*
    Copyright 2014 Jogesh Sharma (email: jogesh at webomnizz.com)
 
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
 */


// Prevent Direct Access
if( ! defined('WPINC') ) die;

   

/**
 * The code that run during plugin activation
 */
function activate_rgm() {
    
    require_once plugin_dir_path(__FILE__) . 'includes/rgm-activator.php';
    RGM_Activator::activate();
}



function deactivate_rgm() {
    
    require_once plugin_dir_path(__FILE__) . 'includes/rgm-deactivator.php';
    RGM_Deactivator::deactivate();
}



register_activation_hook( __FILE__, "activate_rgm");
register_deactivation_hook( __FILE__, "deactivate_rgm");


/**
 * The core plugin class that is used to define internationalization
 * 
 */
require_once plugin_dir_path(__FILE__) . 'includes/rgm.php';



/**
 * Begin execution of the plugin
 * 
 * @since 2.1
 */
function run_rgm() {
    
    $rgm = new RGM();
    $rgm->run();
}
run_rgm();

?>