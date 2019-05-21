// JavaScript Document
jQuery.fn.SelectTag = function( options ) {
 
    // Bob's default settings:
    var defaults = {
        width: jQuery(this).data("width"),
        height: jQuery(this).data("height")
        
    };
 
    var settings = jQuery.extend( {}, defaults, options );
 
    return this.each(function() {
        
		jQuery(this).click(function()
		{
			var text=jQuery(this).data("mapid");
			var width=jQuery(this).data("width");
			var height=jQuery(this).data("height");
			var url=jQuery(this).data("url");
			if(!width) width=settings.width;if(!height) height=settings.height
			jQuery.colorbox({iframe:true,innerWidth:width,innerHeight:height,href:url+"?mapid="+text});
		})
    });
 
};