/*
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2015, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
jQuery(document).ready(function(){

	//call to use colorpicker
	jQuery( '.hexcolor' ).wpColorPicker();

	/*
	 * This script enhances the error message used in the theme options section.
	 */
	var error_msg = jQuery("#message p[class='setting-error-message']");  
    // look for admin messages with the "setting-error-message" error class  
    if (error_msg.length != 0) {  
        // get the title  
        var error_setting = error_msg.attr('title');  
  
        // look for the label with the "for" attribute=setting title and give it an "error" class (style this in the css file!)  
        jQuery("label[for='" + error_setting + "']").addClass('error');  
  
        // look for the input with id=setting title and add a red border to it.  
        jQuery("input[id='" + error_setting + "']").attr('style', 'border-color: red'); 
    }
    
    //This script is to provide upload buttons for the service box images
    
    jQuery('#katb_upload_button').click(function() {
		formfield = jQuery('#katb_upload_image').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});

	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#katb_upload_image').val(imgurl);
		tb_remove();
	}

});