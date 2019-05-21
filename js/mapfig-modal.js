jQuery(function($) {
    $(document).ready(function(){
            $('#insert-mpfig-modal-map').click(open_media_window);
			
			$('#mapfig-admin-btn').click(function(e){
				e.preventDefault();

				//Now retrieve all values
				var mapid = $('select[name=map_select]').val();
			
				if($('input[name="mapfig_insert"]').is(':checked')){
				 var mapfig_insert = $('input[name="mapfig_insert"]:checked').val();
				}
				
				if(mapid==''){
					$('#mapfig-error').html('Map field is required');
					return;
				}
				//Now Create Link
				var insert='';
				if(mapfig_insert!=""){
					 insert = 'insert="'+mapfig_insert+'"';
				}
                if(mapfig_insert == 'icon'){
					var mtext = 'text="'+$('input[name=mapfig_text]').val()+'"';
					var linkcode = '[Mapfig mapid="' + mapid +'"]';
					
				}else{
					
					var linkcode = '[Mapfig mapid="' + mapid +'"]';
				}					
				
				//var linkcode = '[Mapfig mapid="' + mapid + '"' + ' ' + icon + ' ' + direct + ']';
				send_to_editor(linkcode);
				
				/* //Reset
				$('#mapfig-map-id').val('');
				$('#mapfig-map-width').val('500');
				$('#mapfig-map-height').val('500');
				$('#mapfig-map-text').val('Map'); */
				tb_remove();
			});
	
        });
 
    function open_media_window() {
		tb_show('<i class="fa fa-leaf fa-2"></i> AcuGIS Map', '#TB_inline?height=400&width=305&inlineId=mapfig-admin-input&modal=false', null);	
		var tbWindow = $('#TB_window');
				w = 350;		h = 200;				tbWindow.width(w);
		tbWindow.height(h);		tbWindow.css('top',($(window).height()-h)/2);		tbWindow.css('left',($(window).width()-w)/2);		tbWindow.css('margin-left',0);		
		return false;
    }
	

	
	
});