<div class="wrap">
    <h2 id="gmap_title" class="gmap_title"><?php _e("Google Map Settings", $this->plugin_name) ?></h2>
    <br>
    <h2 class="om_tab nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href="#settings"><?php _e("Settings", $this->plugin_name) ?></a>
    </h2>
    <form id="gmapSettings" method="post" action="">
        <div id="settings">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="map_types"><?php _e("MAP Types", $this->plugin_name); ?></label></th>
                    <td>
                        <select name="map_types" id="map_types">
                            <?php
                                $Map_Types = array(
                                    'Roadmap', 'Satellite', 'Hybrid', 'Terrain' 
                                );
                                
                                foreach( $Map_Types as $map_type ){
                                    if( isset( $options ) && $options['map_types'] == $map_type ){
                                        echo "<option value='{$map_type}' selected=''>{$map_type}</option>";
                                    }
                                    else{
                                        echo "<option value='{$map_type}'>{$map_type}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <span class="description"><?php _e("Please Select Map Type", $this->plugin_name) ?></span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="scrollzoom"><?php _e("Scroll Zoom", $this->plugin_name) ?></label></th>
                    <td>
                        <label for="users_can_register">
                            <?php if( isset($options) && $options['scrollzoom'] == "1" ): ?>
                            <input type="checkbox" value="1" checked="" id="scrollzoom" name="scrollzoom">
                            <?php else: ?>
                            <input type="checkbox" value="1" id="scrollzoom" name="scrollzoom">
                            <?php endif; ?>
                            <?php _e("Disable zoom in/out over map", $this->plugin_name) ?>.
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="scrollzoom"><?php _e("Drag Map", $this->plugin_name) ?></label></th>
                    <td>
                        <label for="users_can_register">
                            <?php if( isset( $options['draggable'] ) ): ?>
                            <input type="checkbox" value="1" checked="" id="draggable" name="draggable">
                            <?php else: ?>
                            <input type="checkbox" value="1" id="draggable" name="draggable">
                            <?php endif; ?>
                            <?php _e("Enable Draggable MAP", $this->plugin_name) ?>.
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="marker"><?php _e("Enable Marker", $this->plugin_name) ?></label></th>
                    <td>
                        <label for="enable_marker">
                            <?php if( isset( $options['marker'] ) ): ?>
                            <input type="checkbox" value="1" checked="" id="marker" name="marker">
                            <?php else: ?>
                            <input type="checkbox" value="1" id="marker" name="marker">
                            <?php endif; ?>
                            <?php _e("Enable Marker on Map", $this->plugin_name) ?>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="marker"><?php _e("Draw Circle", $this->plugin_name) ?></label></th>
                    <td>
                        <label for="enable_marker">
                            <?php if( isset( $options['draw_circle'] ) ): ?>
                            <input type="checkbox" value="1" checked="" id="draw_circle" name="draw_circle">
                            <?php else: ?>
                            <input type="checkbox" value="1" id="draw_circle" name="draw_circle">
                            <?php endif; ?>
                            <?php _e("Draw Circle around Lat,Lng point", $this->plugin_name) ?>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="circlerange"><?php _e("Circle Range", $this->plugin_name) ?></label></th>
                    <td>
                        <input type="text" size="5" value="<?php echo isset($options['circle_range']) ? $options['circle_range'] : "10" ?>" name="circle_range" id="circle_range">
                        <select name="range_unit" id="range_unit">
                            <option value="miles">Miles</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="circlerange"><?php _e("Circle Background Color", $this->plugin_name) ?></label></th>
                    <td>
                        <input type="text" size="10" value="<?php echo isset($options['circle_bg_color']) ? $options['circle_bg_color'] : "#FF0000" ?>" name="circle_bg_color" id="circle_bg_color">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="circlerange"><?php _e("Circle Border Color", $this->plugin_name) ?></label></th>
                    <td>
                        <input type="text" size="10" value="<?php echo isset($options['circle_border_color']) ? $options['circle_border_color'] : "#FF0000" ?>" name="circle_border_color" id="circle_border_color">
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
                
                
        <p class="submit" style="width:150px;">
            <input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
            <span class="spinner"></span>
        </p>
    </form>
</div>