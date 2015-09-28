(function($){
    $(document).ready(function(){
        
        // Submit Settings
        $('#gmapSettings').submit(function(e){
            e.stopPropagation();
            
            var $this = $(this);
            $('#submit').prop('disabled', true).next('span').show();
            
            $.ajax({
                url: OM.ajaxurl, 
                type: 'POST', 
                data: { action: "om-map", gmap_nonce: OM.gmap_nonce, data: $this.serialize() }, 
                dataType: 'json', 
                success: function(response){
                    $('#submit').prop('disabled', false).next('span').hide();
                    alert('Settings Saved Successfully!');
                }
            });
            
            return false;
        });
        
        
        
        // Tab Settings
        $('.om_tab a').click(function(e){
            e.preventDefault();
            
            $('#gmapSettings > div').hide();
            $('.om_tab a').removeClass('nav-tab-active');
            
            var ID = $(this).attr('href');
            $(this).addClass('nav-tab-active');
            $(ID).show();
        });
        
        
        
        // Hover Effect
        $('.map_markers li').hover(
            function(){
                $('.marker', this).addClass('hover');
            }, 
            function(){
                $('.marker', this).removeClass('hover');
            }
        ).click(function(e){
            e.preventDefault();
            
            $('.map_markers li .marker').removeClass('active');
            $('.map_markers li input[type="radio"]').removeAttr('checked');
            $('.marker', this).addClass('active');
            $('.marker input[type="radio"]', this).attr("checked", true);
        });
        
    });
})(jQuery);

function insertAfter(e,t){e.parentNode.insertBefore(t,e.nextSibling)}window.onload=function(){var e=document.getElementById("gmap_title");var t=document.createElement("div");t.style.width="147px";t.style.height="47px";t.style.position="relative";t.style.top="50px";t.style.styleFloat="right";t.style.cssFloat="right";t.innerHTML='<h3 style="text-align:center;">Please support continued development of this plugin by making a donation</h3>\n<a href="http://bit.ly/1paGVHd" target="_blank"><p><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"></p></a>';insertAfter(e,t)}