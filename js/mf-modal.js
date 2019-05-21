jQuery(function($) {
    $(document).ready(function(){
            $('#insert-mf-modal-map').click(open_media_window);
			
			$('#mf-admin-btn').click(function(e){
				e.preventDefault();

				//Now retrieve all values
				var mapid = $('select[name=map_select]').val();
			
				if($('input[name="mf_insert"]').is(':checked')){
				 var mf_insert = $('input[name="mf_insert"]:checked').val();
				}
				
				if(mapid==''){
					$('#mf-error').html('Map field is required');
					return;
				}
				//Now Create Link
				var insert='';
				if(mf_insert!=""){
					 insert = 'insert="'+mf_insert+'"';
				}
                if(mf_insert == 'icon'){
					var mtext = 'text="'+$('input[name=mf_text]').val()+'"';
					var linkcode = '['+MF_PLUGIN_NAME_FORMATED+' mapid="' + mapid +'"]';
					
				}else{
					
					var linkcode = '['+MF_PLUGIN_NAME_FORMATED+' mapid="' + mapid +'"]';
				}					
				
				//var linkcode = '['+MF_PLUGIN_NAME_FORMATED+' mapid="' + mapid + '"' + ' ' + icon + ' ' + direct + ']';
				send_to_editor(linkcode);
				
				/* //Reset
				$('#mf-map-id').val('');
				$('#mf-map-width').val('500');
				$('#mf-map-height').val('500');
				$('#mf-map-text').val('Map'); */
				tb_remove();
			});
	
        });
 
    function open_media_window() {
		tb_show('<i class="fa fa-leaf fa-2"></i> '+MF_PLUGIN_NAME_FORMATED+' Map', '#TB_inline?height=400&width=305&inlineId=mf-admin-input&modal=false', null);	
		var tbWindow = $('#TB_window');
				w = 350;		h = 200;				tbWindow.width(w);
		tbWindow.height(h);		tbWindow.css('top',($(window).height()-h)/2);		tbWindow.css('left',($(window).width()-w)/2);		tbWindow.css('margin-left',0);		
		return false;
    }
	

	
	
});