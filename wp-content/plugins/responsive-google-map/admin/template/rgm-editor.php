<div id="gmap-options" style="display:none;">
    <div class="rgm clrfix">
        <div class="lft_section">
            <div class="box">
                <div class="bx_grp">
                    <label><?php _e('Enter Your Address', $this->plugin_name); ?>:</label>
                    <div class="bx_grp_btn">
                        <input size="30" type="text" name="map-address" class="bx_control" id="map-address" />
                        <div class="bx_grp_btn_grp">
                            <input type="button" class="button bx_btn-group" value="Get Lat Lng" id="get_latlng" name="get_latlng" />
                        </div>
                    </div>
                </div>
                <div class="bx_grp bx_seprator">
                    <span><?php _e('OR', $this->plugin_name); ?></span>
                </div>
                <div class="bx_grp clrfix">
                    <div class=bx_grp_b" style="width:49%;float:left;">
                        <label><?php _e('Lat', $this->plugin_name); ?>:</label>
                        <input type="text" size="20" id="map_lat" class="bx_control" name="map_lat" value="" />
                    </div>
                    <div class="bx_grp_b" style="width:49%;float:right;" >
                        <label><?php _e('Lng', $this->plugin_name); ?>:</label>
                        <input type="text" size="20" id="map_lng" class="bx_control" name="map_lng" value="" />
                    </div>
                </div>
                <div class="bx_grp">
                    <label><?php _e('Info Window', $this->plugin_name); ?>:</label>
                    <textarea style="resize:none;height:80px;" cols="40" class="bx_control" name="info-window-address" id="info-window-address"></textarea>
                </div>
                <div class="bx_grp">
                    <label><?php _e('Marker URL', $this->plugin_name); ?>:</label>
                    <input type="text" placeholder="http://webomnizz.com/images/marker.png" id="map_cMarker" class="bx_control" name="map_cMarker" />
                    <p class="description" style="color:#ff0000;"><?php _e('Full Image URL, Best Size 22x30', $this->plugin_name); ?></p>
                </div>
            </div>
        </div>
        <div class="rgt_section">
            <div class="box">
                <div class="bx_grp">
                    <label><?php _e('Zoom', $this->plugin_name); ?>:</label><br>
                    <input type="text" size="5" id="map_zoom" name="map_zoom" value="9" />
                </div>
                <div class="bx_grp">
                    <label><?php _e('Styles', $this->plugin_name); ?>:</label>
                    <select name="rgm_style" id="rgm_styles" class="bx_control">
                        <option>-- Select --</option>
                    </select>
                </div>
                <div class="bx_grp">
                    <input type="button" class="button button-primary button-large" value="<?php _e('Insert Map', $this->plugin_name); ?>" name="map_insert" />
                </div>
                <div class="bx_grp">
                    <hr>
                    <div><h4 style="width:150px;margin:0 auto;position:relative;top:10px;text-align:center;">Please support continued development of this plugin by making a donation.</h4><a href="http://bit.ly/1paGVHd" target="_blank"><p style="text-align:center;"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"></p></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .rgm .rgt_section{float:right;width:240px}.rgm .lft_section .box{padding-right:25px;border-right:1px solid #efefef}.rgm .lft_section{width:373px;float:left}.clrfix:after,.clrfix:before{content:"";display:table}.clrfix:after{clear:both}.rgm .bx_grp{margin-top:15px}.rgm label{font-weight:700}.rgm .bx_control{width:100%}.rgm .bx_grp_btn .bx_control{width:73%}.rgm .bx_grp_btn .bx_grp_btn_grp{float:right}.rgm .bx_seprator{position:relative;text-align:center}.rgm .bx_seprator:before{content:"";position:absolute;width:100%;height:1px;background:#ccc;top:10px;left:0}.rgm .bx_seprator span{display:inline-block;padding:0 15px;position:relative;z-index:9;background:#fff;font-style:italic}
</style>