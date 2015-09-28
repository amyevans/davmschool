(function($){
    tinymce.create('tinymce.plugins.omgmap', {
        init: function(ed, url){
            ed.addButton('omgmap', {
                title: 'OM Gmap', 
                image: url + '/map_16.png', 
                onclick: function(){
                    tb_show( 'GMAP Shortcode', '#TB_inline?width=640&inlineId=gmap-options' );
                }
            });
        }, 
        createControl: function(n, cm){
            return null;
        }, 
        getInfo: function(){
            return {
                longname : "OM Gmap",
                author : 'Jogesh Sharma',
                authorurl : 'http://webomnizz.com',
                infourl : 'http://webomnizz.com',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add( "omgmap", tinymce.plugins.omgmap);
    
    
    $(document).ready(function(){
        
        var styles = {'_retro':'Retro', '_blue_water':'Blue Water', '_subtle_gray':'Subtle Gray', 
                        '_midnigh_commander':'Midnight Commander', '_light_monochrome':'Light Monochrome', 
                        '_maps_esque':'Maps Esque', '_flat_map':'Flat Map', '_map_box':'Map Box', 
                        '_bright_bubbly':'Bright Bubbly', '_icy_blue':'Icy Blue', '_hopper':'Hopper', '_cobalt':'Cobalt', 
                        '_red_hues':'Red Hue', '_nature':'Nature', '_red_alert':'Red Alert', '_bluish':'Bluish', 
                        '_blue_essence':'Blue Essence', '_souldisco':'Souldisco', '_vintage_blue':'Vintage Blue', 
                        '_hot_pink':'Hot Pink', '_vitamin_c':'Vitamin C', '_mixed':'Mixed', '_neon_world':'Neon World', 
                        '_muted_blue':'Muted Blue'}, 
            options = '<option value="">-- Select --</option>';
              
        for( var k in styles ) {
            options += '<option value="'+k+'">'+styles[k]+'</option>';
        }
        
        
        $('#rgm_styles').html( options );
        
        $('#get_latlng').click(function(e){
            e.preventDefault();
            
            var $this = $(this);
            var GMap = 'http://maps.googleapis.com/maps/api/geocode/json';
            var User_Add = $.trim($('#map-address').val());
            
            $this.attr('disabled', true);
            
            if( User_Add.length > 0 ){
                $.getJSON( GMap, {
                    address: User_Add, 
                    sensor: true
                }).done(function(response){
                    $this.removeAttr('disabled');
                    
                    if( response.status == "OK" ){
                        $.each( response.results, function(i, data){
                            $('#map_lat').val( data.geometry.location.lat );
                            $('#map_lng').val( data.geometry.location.lng );
                        } );
                    }
                });
            } 
        });
        
        $('input[name="map_insert"]').click(function(){
            var zoom = $('#map_zoom').val(), 
                lat = $.trim( $('#map_lat').val() ).length > 0 ? $.trim( $('#map_lat').val() ) : "28.9285745", 
                lng = $.trim( $('#map_lng').val() ).length > 0 ? $.trim( $('#map_lng').val() ) : "77.09149350000007", 
                infowindow = $.trim( $('#info-window-address').val() ), 
                customMarker = $.trim( $('#map_cMarker').val() ), 
                styles = $('#rgm_styles').val(); 
                
                
            var omCMD = '[om_gmap zoom="'+zoom+'" lat="'+lat+'" lng="'+lng+'" ';
                omCMD += infowindow == "" ? "" : 'infowindow="'+infowindow+'" ';
                omCMD += customMarker == "" ? "" : 'marker="'+customMarker+'" ';
                omCMD += styles == "" || styles == undefined ? "" : 'styles="'+styles+'"'
                omCMD += ']';
                
            tinyMCE.activeEditor.execCommand('mceInsertContent', false, omCMD);
            tb_remove();
        });
            
    });
    
})(jQuery);