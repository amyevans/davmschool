<?php
/**
 * Plugin Name: Clean Protected and Private Page Titles
 * Plugin URI: http://seemeroar.com/plugins/cleantitles
 * Description: Some themes prefix page titles with 'Protected' or 'Private'; this plugin removes those words from titles
 * Version: 0.1
 * Author: Jon Peck
 * Author URI: http://seemeroar.com
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
/*  Copyright 2015  Jon Peck  (email : plugins@seemeroar.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function the_title_clean($title) {
	return preg_replace(array('#Protected:#','#Private:#'),array('',''), attribute_escape($title));
}
add_filter('the_title', 'the_title_clean');