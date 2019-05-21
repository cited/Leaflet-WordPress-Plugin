<?PHP
	global $_HEIGHT;
	global $_WIDTH;
	global $_HEIGHT_PARAMETER;
	global $_WIDTH_PARAMETER;
	global $_ZOOM;
	global $_LAT;
	global $_LNG;
	global $_DEFAULT_LAYER;
	global $_BASE_LAYERS;
	global $_DATA;
	global $_SHOW_SIDEBAR;
	global $_SHOW_MEASURE;
	global $_SHOW_SEARCH;
	global $_SHOW_MINIMAP;
	global $_SHOW_SVG;
	global $_SHOW_EXPORT;
	
	global $_IS_DRAW;
?>

<?PHP 
	if($_IS_DRAW) { echo '<div id="map_canvas" class="col-md-12" style="height: 500px;"></div>'; }
	else { 
		if(isset($_GET['height']) && isset($_GET['width'])) {
			echo '<div id="map_canvas" class="col-md-12" style="height: '.$_GET['height'].'; width: '.$_GET['width'].';"></div>';
		}
		else {
			echo '<div id="map_canvas" class="col-md-12" style="height: '.$_HEIGHT . $_HEIGHT_PARAMETER . '; width: '.$_WIDTH . $_WIDTH_PARAMETER . ';"></div>';
		}
	}
?>

<style>
	body {
		padding: 0 !important;
		margin: 0 !important;
	}
	#sidebar-buttons {
		display: none; z-index: 999999; opacity: 0; left: -50px; margin-top: 4px;position: absolute;padding: 5px; min-width: 200px;height: auto; color: rgb(51, 51, 51); border-radius: 4px; background-color: rgb(255, 255, 255);border: 1px solid #CCC;
	}
	#sidebar-buttons ul.leaflet-sidebar li a{
		cursor:pointer;
		text-decoration: none;
		display: inline;
		outline:none;
		color:#000;
	}
	#sidebar-buttons ul.leaflet-sidebar{
		list-style: none;
		margin: 0;
	}
	#sidebar-buttons ul.leaflet-sidebar li input[type=checkbox]{
		outline:none;
	}
	#sidebar-buttons ul.leaflet-sidebar li{
		display: inline;
	}
	.clear{
		clear:both;
	}
	
	.pac-container {
		/*top: 230px !important;*/
		z-index: 1100;
	}
	.colpick {
		z-index : 1041;
	}
	.leaflet-popup img {
		max-width: 100%!important;
	}
	.leaflet-popup-close-button {
	  color: white !important;
	  border-radius: 50% !important;
	  background: black !important;
	  padding: 3px !important;
	  width: auto !important;
	  height: auto !important;
	  top: -10px !important;
	  right: -10px !important;
	  -webkit-box-shadow: 0px 0px 7px 1px #414141 !important;
	  -moz-box-shadow: 0px 0px 7px 1px #414141 !important;
	  box-shadow: 0px 0px 7px 1px #414141 !important;
	}
	
.bubble.static {
	z-index: 1005;
	overflow-y: auto;
	position: absolute;
	background: #fff;
	border-radius: 2px;
	color: #000;
	padding: 1em;
	max-height: 90%;
	max-width: 400px;
	left: 70px;
	top: 20px;
	opacity: .85;
}
.bubble.static.selected {
	opacity: .9;
}
.bubble.static.bound {
	display: block;
}
.bubble.static .title {
	display: inline;
	font-size: 2em;
	line-height: 1em;
}
.bubble.static .content {
	margin-top: .7em;
}
.leaflet-popup-content-wrapper {
	max-height: 280px;
	overflow-y: auto;
}
</style>

<div class="bubble static bound selected" id="static-popup" style="display: none;">
	<a name="close" class="close" id="static-popup-close" onClick="mapClosePopup();"><i class="fa fa-close"></i></a>
	<div class="content body" rv-html="record:body" rv-show="record:body" id="static-popup-content"></div>
</div>
<div class="modal fade" style="display:none;z-index:1041;" id="mapfig_myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title">Add/Edit Properties And Styles</h4>
      </div>
      <div class="modal-body">
            
            <div role="tabpanel">

              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-justified" role="tablist" style="padding: 1px;">
                <li role="presentation" class="active"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab">Properties</a></li>
                <li role="presentation"><a href="#advanced" aria-controls="advanced" role="tab" data-toggle="tab">Advanced</a></li>
                <li role="presentation"><a href="#style" aria-controls="style" role="tab" data-toggle="tab">Styles</a></li>
                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content" style="padding: 10px 20px; border-style: solid; border-width: 0 1px 1px 1px; border-color: #dde6e9;">
                <div role="tabpanel" class="tab-pane active" id="properties"> 
                                     
                    <table style="border:0" id="menuBasic" class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td><label for="">Location</label></td>
                                <td><input type="text" id="autoFillAddress" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="">Description</label></td>
                                <td><textarea id="description"></textarea></td>
                            </tr>   
                        </tbody>                                             
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="advanced">

                    <table id="menuCustomProperties" class="table table-striped table-bordered table-hover"><tbody></tbody></table>
                </div>
                <div role="tabpanel" class="tab-pane" id="style">
                    <table id="menuStyle" class="table table-striped table-bordered table-hover"><tbody></tbody></table>
                </div>         

              </div>

            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit_modal">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<textarea style="display:none;" id="geo_image_olverlays"><?PHP echo $_IMAGE_OVERLAYS?></textarea>

<script>
	var featureGroup = L.featureGroup();
	var show_sidebar = <?=$_SHOW_SIDEBAR?>;
	var show_search  = <?=$_SHOW_SEARCH?>;
	var show_measure = <?=$_SHOW_MEASURE?>;
	var show_minimap = <?=$_SHOW_MINIMAP?>;
	var show_export  = <?=$_SHOW_EXPORT?>;
	var show_svg = <?=$_SHOW_SVG?>;
	var mbAttribution = ' contributors | <a href="https://www.<?=MF_MAIN_DOMAIN?>" target="_blank"><?=MF_PLUGIN_NAME_FORMATED?></a>';
	var defaultLayer = <?=$_DEFAULT_LAYER?>;
	var defaultLayerMiniMap = <?=$_DEFAULT_LAYER?>;
	
	var editMode = false;
	
	var baseLayers = <?=$_BASE_LAYERS?>;
	var overlays = {
		"Map Points": featureGroup
	};
	var layerSelector = L.control.layers(baseLayers, overlays);
	var map = null;
	
	$(document).ready(function() {
		map = L.map('map_canvas', { dragging: true, touchZoom: true, scrollWheelZoom: true, doubleClickZoom: true, boxzoom: true, trackResize: true, worldCopyJump: false, closePopupOnClick: true, keyboard: true, keyboardPanOffset: 80, keyboardZoomOffset: 1, inertia: true, inertiaDeceleration: 3000, inertiaMaxSpeed: 1500, zoomControl: true, crs: L.CRS.EPSG3857, fullscreenControl: true, layers: [defaultLayer, featureGroup] });
		map.setView([<?=$_LAT?>,<?=$_LNG?>], <?=$_ZOOM?>);
		
		L.control.locate({
			position: 'bottomright', 
			drawCircle: true,
			follow: true,
			setView: true,
			keepCurrentZoomLevel: true,
			remainActive: false,
			circleStyle: {},
			markerStyle: {},
			followCircleStyle: {},
			followMarkerStyle: {},
			icon: 'icon-cross-hairs',
			circlePadding: [0,0],
			metric: true,
			showPopup: true,
			strings: {
				title: 'I am Here',
				popup: 'You are within {distance} {unit} from this point',
				outsideMapBoundsMsg: 'You seem located outside the boundaries of the map'
			},
			locateOptions: { watch: true }
		}).addTo(map);
		L.control.scale({position:'bottomleft', maxWidth: 100, metric: true, imperial: true, updateWhenIdle: false}).addTo(map);
		map.addControl(L.control.search());
		new L.Control.MiniMap(defaultLayerMiniMap, {toggleDisplay: true}).addTo(map)._minimize(true);
		map.addControl(L.exportControl({ codeid: '?action=ajax_mapExport', position: 'topleft', endpoint: '<?PHP echo admin_url('admin-ajax.php')?>', getFormatFrom: '?action=ajax_getFormats', mapid: <?=$_POST['mid']?> }));
		
		
		jQuery('#map_canvas .leaflet-top.leaflet-left').append('<div id="sidebarhideshow" class="leaflet-control-sidebar leaflet-bar leaflet-control" style="z-index:11;">' + '<a class="leaflet-control-sidebar-button leaflet-bar-part" id="sidebar-button-reorder" href="#" onClick="return false;" title="Sidebar Toggle"><i class="fa fa-reorder"></i></a>' + '<div id="sidebar-buttons" class="sidebar-buttons" style="max-height: 300px; overflow: auto;">' + '<ul class="list-unstyled leaflet-sidebar">' + '</ul>' + '</div>' + '</div>');
		jQuery('#map_canvas .leaflet-top.leaflet-left').append('<div id="edit_image_overlays" class="leaflet-control-sidebar leaflet-bar leaflet-control" style="z-index:10;"><a class="leaflet-control-sidebar-button leaflet-bar-part" href="#" onclick="return false;"><i class="fa fa-image"></i></a></div>');
		
		<?PHP if($_IS_DRAW) { ?>
		  var drawControl = new L.Control.Draw({
			draw : {        
				circle : false
			},
			edit: {
			  featureGroup: featureGroup
			}
		  }).addTo(map);
		<?PHP } ?>
		
		var data = JSON.parse("<?=$_DATA?>");
		jsonData.addData(data); 
	});
	
	var jsonData = L.geoJson(null, {

			style: function (feature) {
				return {color: "#f06eaa",  "weight": 4, "opacity": 0.5, "fillOpacity": 0.2};
			},
			onEachFeature: function (feature, layer) {
				featureGroup.addLayer(layer);
				
				layer.on("click", function(){
					if(editMode) {
						showModal("edit", layer);
						setTimeout(function(){
							map.closePopup();
						},50);
					}
					else {
						if(show_svg) {
							map.closePopup();
							if(layer instanceof L.Marker) {
								map.panTo(layer.getLatLng());
							}
							else {
								map.fitBounds(new L.featureGroup([layer]).getBounds());
							}
							setTimeout(function() {
								openPopup(layer);
							}, 300);
						}
						else {
							openPopup(layer);
						}
					}
				});            

				properties1 = feature.properties;
				var properties = new Array();
				for(var i=0; i<properties1.length; i++){
					row = {};
					row['name']  = properties1[i].name;
					row['value'] = properties1[i].value;
					row['defaultProperty'] = properties1[i].defaultProperty;
					properties.push(row);
				}
				
				layerProperties.push(new Array(layer, properties));
				
				var style = feature.style;
				var cp    = feature.customProperties;

				if(style) {
					if(layer instanceof L.Marker) {
						if(style.markerColor) {
							layer.setIcon(L.AwesomeMarkers.icon(style));
						}
					}
					else {
						layer.setStyle(style);
					}
				}

				shapeStyles.push(style); //styles is JSON Object
				shapeCustomProperties.push(cp);
				bindPopup(layer);

				renderSideBar(layer);
			}
		})

	function updateSidebar() {
		if (show_sidebar)
			$('#sidebarhideshow').show();
		else {
			$('#sidebarhideshow').hide();
		}
	}
	function updateSearch() {
		if (show_search)
			$('.leaflet-control-search').show();
		else {
			$('.leaflet-control-search').hide();
		}
	}
	function updateMeasure() {
		if (show_measure)
			$('.leaflet-control-draw-measure').show();
		else {
			$('.leaflet-control-draw-measure').hide();
		}
	}
	function updateMinimap() {
		if (show_minimap)
			$('.leaflet-control-minimap').show();
		else {
			$('.leaflet-control-minimap').hide();
		}
	}
	function updateExport() {
		if (show_export)
			$('.leaflet-control-export').show();
		else {
			$('.leaflet-control-export').hide();
		}
	}
	function updateSVG() {
		if (show_svg) {
			$("body").append('\
				<style id="svg-style">\
					path {\
						fill-opacity: .2;\
					}\
					path:hover {\
						fill-opacity: .4;\
					}\
					\
					.travelMarker {\
						fill: yellow;\
						opacity: 0.75;\
					}\
					.waypoints {\
						fill: black;\
						opacity: 0;\
					}\
					.drinks {\
						stroke: black;\
						fill: red;\
					}\
					.lineConnect {\
						fill: none;\
						stroke: black;\
						opacity: 1;\
					}\
					.locnames {\
						fill: black;\
						text-shadow: 1px 1px 1px #FFF, 3px 3px 5px #000;\
						font-weight: bold;\
						font-size: 13px;\
					}\
				</style>\
			');
		}
		else {
			$('#svg-style').remove();
		}
	}
	
	jQuery(document).ready(function($) {
		$ = jQuery;
		$('.leaflet-control-minimap .leaflet-control-sidebar, .leaflet-control-minimap #edit_image_overlays').remove();
		
		$("body").append('\<style id="svg-style">path {fill-opacity: .2;}path:hover {fill-opacity: .4;}.travelMarker {fill: yellow;opacity: 0.75;}.waypoints {fill: black;opacity: 0;}.drinks {stroke: black;fill: red;}.lineConnect {fill: none;stroke: black;opacity: 1;}.locnames {fill: black;text-shadow: 1px 1px 1px #FFF, 3px 3px 5px #000;font-weight: bold;font-size: 13px;}</style>');
		setTimeout(function(){
			$("#label_show_sidebar, #label_show_sidebar ins").click(function(){
				show_sidebar = !show_sidebar;
				updateSidebar();
			});
			$("#label_show_search, #label_show_search ins").click(function(){
				show_search = !show_search;
				updateSearch();
			});
			$("#label_show_measure, #label_show_measure ins").click(function(){
				show_measure = !show_measure;
				updateMeasure();
			});
			$("#label_show_minimap, #label_show_minimap ins").click(function(){
				show_minimap = !show_minimap;
				updateMinimap();
			});
			$("#label_show_svg, #label_show_svg ins").click(function(){
				show_svg = !show_svg;
				updateSVG();
			});
			$("#label_show_export, #label_show_export ins").click(function(){
				show_export = !show_export;
				updateExport();
			});
		}, 1000);
		
		jQuery('#geo_json').click(function(){
			var type = jQuery(this).attr("data-type");
			jQuery('#mapfig_type').val(type);

			var finalShapeData = new Array();
					
			var shapes = getShapes(featureGroup);
			
			jQuery.each(shapes, function(index, shape) {
				properties = getPropertiesByLayer(shape);

				var index = getLayerIndex(shape);
				shpJson = shape.toGeoJSON();
				shpJson.properties = properties;
				shpJson.customProperties = shapeCustomProperties[index];
				shpJson.style = shapeStyles[index];
				finalShapeData.push(shpJson);
			});

			finalShapeData = JSON.stringify(finalShapeData);
			
			jQuery("#lat").val(map.getCenter().lat);
			jQuery("#lng").val(map.getCenter().lng);
			jQuery("#geo_json_str").val(finalShapeData);
			jQuery('#save_map_form').submit();       
		
		})

		jQuery('#submit_modal').click(function(){

			properties = new Array();
			var name = jQuery('#autoFillAddress').val();
			var description = tinyMCE.get('description').getContent();
			
			row = {};
			row['name']            = "Name";
			row['value']           = name;
			row['defaultProperty'] = true;
			
			properties.push(row);

			row = {};
			row['name']     = "Description";
			row['value']    = description;
			row['defaultProperty'] = true;
			
			properties.push(row);


			stl = {};
			jQuery('#menuStyle tbody tr input, #menuStyle tbody tr select').each(function(){
				name  = $(this).attr('id');
				value = $(this).val();
				
				stl[name]  = value;
			});
			
			cp = {};
			jQuery('#menuCustomProperties tbody tr input[type=checkbox]').each(function(){
				name  = $(this).attr('id');
				value = $(this).is(':checked');
				
				cp[name]  = value;
			});

			for(i=0; i<layerProperties.length; i++) {
				if(layerProperties[i][0] == currentLayer) {
					layerProperties[i][1] = properties;
					shapeStyles[i] = stl;
					shapeCustomProperties[i] = cp;
					break;
				}
			}
			bindPopup(currentLayer);
			reRenderShapeStylesOnMap(currentLayer);
			renderSideBar(currentLayer);
			jQuery('#mapfig_myModal').modal("hide");
		})   
	   
		 var animating = false;
		jQuery('#sidebar-button-reorder').click(function() {
			if (animating) return;
			var element = jQuery('#sidebar-buttons');
			animating = true;
			if (element.css('left') == '-50px') {
				element.show();
				element.animate({
					opacity: '1',
					left: '0px'
				}, 400, function() {
					animating = false;
				});
			} else {
				element.animate({
					opacity: '0',
					left: '-50px'
				}, 400, function() {
					animating = false;
					element.hide();
				});
			}
		});
	});
	
	function renderSideBar(layer) {
			target = jQuery('#sidebar-buttons ul.leaflet-sidebar');
			currentIndex = getLayerIndex(layer);
		 //   console.log(layerProperties[currentIndex]);
			lable = layerProperties[currentIndex][1][0].value;
			//alert(lable);
			if (lable == "") {
				lable = "No Location";
			}
			target.append('<li><input type="checkbox" data-index="' + currentIndex + '" onClick="changeAddressCheckbox(this)" checked><a data-index="' + currentIndex + '" onClick="clickOnSidebarAddress(this)">' + lable + '</a><div class="clear"></div></li>');
		}

		function changeAddressCheckbox(obj) {
			var layers = getLayers();
			
			index = jQuery(obj).attr("data-index");
			
			if (jQuery(obj).is(':checked')) {
				featureGroup.addLayer(layers[index]);
			} else {
				featureGroup.removeLayer(layers[index]);
			}
		}

	function clickOnSidebarAddress(obj) {
		var layers = getLayers();
		index = jQuery(obj).attr("data-index");
		setTimeout(function() {
			//openPopup(layers[index]);
			//layers[index].openPopup();
			layers[index].fire("click");
		}, 50);
	}
	</script>
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			layerSelector.addTo(map);
			map.addControl(L.Control.measureControl({position:'topright'}));
			jQuery('#map_canvas .leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
				map.removeLayer(defaultLayer);
			});
			
			updateSidebar();
			updateSearch();
			updateMeasure();
			updateMinimap();
			updateExport();
			updateSVG();
			
			imageOverlaysUpdate();
		});
		
		
		
		
		var imageOverlays   = JSON.parse(JSON.parse('"' + jQuery("#geo_image_olverlays").val() + '"'));
		var imageOverlaysLayers = [];
		var imageOverlaysPopups = [];
		var globalTempI = 0;
		
		jQuery('input[name=geo_image_olverlays]').val(imageOverlays);
		
		function imageOverlaysUpdate(update) {
			var imageBounds = null;
			
			jQuery.each(imageOverlaysLayers, function(key, value) {
				map.removeLayer(value);
			});
			
			imageOverlaysLayers = [];
			imageOverlaysPopups = [];
			
			jQuery.each(imageOverlays, function(key, value) {
				var imageUrl = value.src;
				var pcon = value.popupcontent;
				// This is the trickiest part - you'll need accurate coordinates for the
				// corners of the image. You can find and create appropriate values at
				// http://maps.nypl.org/warper/ or
				// http://www.georeferencer.org/
				imageBounds = L.latLngBounds(JSON.parse(value.bounds));
				
				// See full documentation for the ImageOverlay type:
				// http://leafletjs.com/reference.html#imageoverlay
				var overlay = L.imageOverlay(imageUrl, imageBounds)
					.addTo(map);
				
				var popup = L.popup().setContent(pcon);
				popup.setLatLng([imageBounds.getCenter().lat,imageBounds.getCenter().lng]);
				imageOverlaysPopups.push(popup);
				
				if(!value.opacity) {
					value.opacity = 1;
				}
				jQuery(overlay._image).css('opacity', value.opacity);
				
				L.DomEvent.on(overlay._image, 'click', function(e) {
					globalTempI = 0;
					var dis = this;
					jQuery.each(imageOverlaysLayers, function(k, v) {
						if(dis == v._image) {
							setTimeout(function(){
								imageOverlaysPopups[globalTempI].addTo(map);
							}, 100);
							return false;
						}
						globalTempI++;
					});
				});
				
				imageOverlaysLayers.push(overlay);
			});
			
			if(update && imageOverlaysLayers.length > 0) {
				map.fitBounds(imageBounds);
			}
			
			jQuery('#geo_image_olverlays, input[name=geo_image_olverlays]').val(JSON.stringify(imageOverlays));
		}
	</script>
	
	
	
	
	<?PHP if($_IS_DRAW) { ?>
	<script type="text/javascript">
		function layers_id_ajax(id) {
			var data = {
				'action': 'ajax_getLayer',
				'id': id
			};
			$.ajax({
				  url:     '<?=admin_url('admin-ajax.php')?>',
				  type:    'POST',
				  data:    data,
				  success: function(data){
					map.removeLayer(defaultLayer);
					data = jQuery.parseJSON(data);
					
					defaultLayer = new L.TileLayer(data.url, {'id' : data.lkey, 'token' : data.accesstoken, maxZoom: 18, attribution: data.attribution+mbAttribution});
					
					map.addLayer(defaultLayer);
				  }
			});
		}
		
		function groups_id_ajax(id) {
			var data = {
				'action': 'ajax_getLayersByGroupId',
				'id': id
			};
			$.ajax({
				  url:     '<?=admin_url('admin-ajax.php')?>',
				  type:    'POST',
				  data:    data,
				  success: function(data){
					map.removeControl(layerSelector);
					data = jQuery.parseJSON(data);
					
					baseLayers = {}
					$.each(data, function(idx, obj) {
						baseLayers[obj.name] = new L.TileLayer(obj.url, {maxZoom: 18, id: obj.lkey, token: obj.accesstoken, attribution: obj.attribution+mbAttribution});
					});
					
					layerSelector = L.control.layers(baseLayers, overlays)
					map.addControl(layerSelector);
					
					setTimeout(function(){
						$('.leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
							map.removeLayer(defaultLayer);
						});
					},200);
				  }
			});
		}
		
		jQuery(document).ready(function($) {
			//$ = jQuery;
			setTimeout(function(){
				$('.leaflet-control-layers form.leaflet-control-layers-list input[type=radio]').click(function(){
					map.removeLayer(defaultLayer);
				});
			},200);
			
			$("#layers_id").change(function(){
				layers_id_ajax($(this).val());
				return false;
			});
			
			$("#groups_id").change(function(){
				groups_id_ajax($(this).val());
				return false;
			});
			
			$("#layers_id, #groups_id").change();
		});
		
		
		
		
		
		
		
		
		
		/* IMAGE OVERLAYS */
		var progressBar = null;
		function createProgressBar() {
			var dialogInstance = new BootstrapDialog();
			dialogInstance.setTitle(null);
			dialogInstance.setMessage('\
				<div id="importProgressBar">\
					<div class="progress">\
						<div class="progress-bar progress-bar-striped active" role="progressbar"\
							aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">\
							0%\
						</div>\
					</div>\
				</div>\
			');
			dialogInstance.setType(BootstrapDialog.TYPE_SUCCESS);
			dialogInstance.setClosable(false);
			dialogInstance.open();
			
			dialogInstance.getModalHeader().hide();
			dialogInstance.getModalFooter().hide();
			
			return dialogInstance;
		}
		
		function updateProgressBar(dialogInstance, percentage) { // progress in percentage
			if(percentage == 100) {
				dialogInstance.close();
			}
			
			body = dialogInstance.getModalBody();
			obj  = body.find('#importProgressBar div.progress-bar.progress-bar-striped.active');
			
			obj.attr('aria-valuenow',percentage);
			obj.css('width',percentage+'%');
			obj.text(percentage+'% Completed');
		}
		
		var globalTempBoundsObj = null;
		var globalTempPopupcontentObj = null;
		var image_overlays_get_coordinatesObj = null;
		var image_overlays_lat_lng = [];
		
		function image_overlays_popupcontent_click(obj) {
			globalTempPopupcontentObj = obj;
			var content = '\
				<div class="table-responsive" id="image_overlays_modal">\
					<table class="table table-striped table-bordered table-hover">\
						<tr>\
							<td>\
								<textarea id="imageOverlayPopupContentInput"></textarea>\
							</td>\
						</tr>\
					</table>\
				</div>\
			';
			
			var dd = BootstrapDialog.show({
				title: 'Enter the Popup Content',
				message: content,
				closable: false,
				buttons: [{
					label: 'Save',
					icon: 'fa fa-check',
					cssClass: 'btn-primary',
					action: function(dialog) {
						con = jQuery(globalTempPopupcontentObj).parent().find('.image_overlays_popupcontent_input');
						jQuery(con).html(tinyMCE.get('imageOverlayPopupContentInput').getContent());
						dialog.close();
						jQuery("body").removeClass("modal-open");
					}
				}, {
					label: 'Cancel',
					icon: 'fa fa-remove',
					cssClass: '',
					action: function(dialog) {
						dialog.close();
						jQuery("body").removeClass("modal-open");
					}
				}]
			});
			dd.getModal().removeAttr('tabindex');
			
			setTimeout(function(){
				con = jQuery(globalTempPopupcontentObj).parent().find('.image_overlays_popupcontent_input').html();
				jQuery('#imageOverlayPopupContentInput').html(con);
				
				tinyMCEInit();
			}, 300);
		}
		
		function image_overlays_bounds_click(obj) {
			globalTempBoundsObj = obj;
			var bounds = '\
				<div class="table-responsive" id="image_overlays_modal">\
					<table class="table table-striped table-bordered table-hover">\
						<tr>\
							<th>\
								South West Coordinates\
							</th>\
							<td>\
								<input type="text" id="latitudeBL" placeholder="Latitude" class="form-control"/>\
							</td>\
							<td>\
								<input type="text" id="longitudeBL" placeholder="Longitude" class="form-control"/>\
							</td>\
							<td>\
								<a href="#" onClick="return false;" class="btn btn-info btn-xs image_overlays_get_coordinates">Populate Coordinates</a>\
							</td>\
						</tr>\
						<tr>\
							<th>\
								North East Coordinates\
							</th>\
							<td>\
								<input type="text" id="latitudeUR" placeholder="Latitude" class="form-control"/>\
							</td>\
							<td>\
								<input type="text" id="longitudeUR" placeholder="Longitude" class="form-control"/>\
							</td>\
							<td>\
								<a href="#" onClick="return false;" class="btn btn-info btn-xs image_overlays_get_coordinates">Populate Coordinates</a>\
							</td>\
						</tr>\
					</table>\
				</div>\
			';
			
			BootstrapDialog.show({
				title: 'Enter the Image Coordinates',
				message: bounds,
				closable: false,
				size: BootstrapDialog.SIZE_WIDE,
				buttons: [{
					label: 'Save',
					icon: 'fa fa-check',
					cssClass: 'btn-primary',
					action: function(dialog) {
						if(!parseFloat(jQuery('#latitudeUR').val()) ||
						!parseFloat(jQuery('#longitudeUR').val()) ||
						!parseFloat(jQuery('#latitudeBL').val()) ||
						!parseFloat(jQuery('#longitudeBL').val())) {
							Alert("Please Enter the correct Coordinates", "error");
						}
						else{
							bnds = [];
							bnds.push(new Array(parseFloat(jQuery('#latitudeBL').val()),parseFloat(jQuery('#longitudeBL').val())));
							bnds.push(new Array(parseFloat(jQuery('#latitudeUR').val()),parseFloat(jQuery('#longitudeUR').val())));
							
							jQuery(globalTempBoundsObj).parent().find('.image_overlays_bounds_input').val(JSON.stringify(bnds));
							dialog.close();
							jQuery("body").removeClass("modal-open");
						}
					}
				}, {
					label: 'Cancel',
					icon: 'fa fa-remove',
					cssClass: '',
					action: function(dialog) {
						dialog.close();
						jQuery("body").removeClass("modal-open");
					}
				}]
			});
			
			setTimeout(function(){
				val = jQuery(globalTempBoundsObj).parent().find('.image_overlays_bounds_input').val();
				if(val) {
					val = JSON.parse(val);
					jQuery('#latitudeUR').val(val[1][0]);
					jQuery('#longitudeUR').val(val[1][1]);
					
					jQuery('#latitudeBL').val(val[0][0]);
					jQuery('#longitudeBL').val(val[0][1]);
				}
				
				jQuery('.image_overlays_get_coordinates').click(function() {
					image_overlays_get_coordinatesObj = jQuery(this);
					BootstrapDialog.show({
						title: 'Enter the Address to get coordinates',
						message: '<input id="image_overlays_get_coordinates_get_coordinates" class="form-control"/>',
						closable: false,
						buttons: [{
							label: '',
							icon: 'fa fa-check',
							cssClass: 'btn-primary',
							action: function(dialog) {
								jQuery(jQuery(image_overlays_get_coordinatesObj).parent().parent().find('input')[0]).val(image_overlays_lat_lng[0]);
								jQuery(jQuery(image_overlays_get_coordinatesObj).parent().parent().find('input')[1]).val(image_overlays_lat_lng[1]);
								
								dialog.close();
								jQuery("body").removeClass("modal-open");
							}
						}, {
							label: 'Cancel',
							icon: 'fa fa-remove',
							cssClass: '',
							action: function(dialog) {
								dialog.close();
								jQuery("body").removeClass("modal-open");
							}
						}]
					});
					
					setTimeout(function(){
						autocomplete = new google.maps.places.Autocomplete((document.getElementById("image_overlays_get_coordinates_get_coordinates")),{ types: ["geocode"] });
						google.maps.event.addListener(autocomplete, "place_changed", function() {
							lat = autocomplete.getPlace().geometry.location.lat();
							lng = autocomplete.getPlace().geometry.location.lng();
							
							image_overlays_lat_lng = [];
							
							image_overlays_lat_lng.push(lat);
							image_overlays_lat_lng.push(lng);
						});
					}, 200);
				});
			}, 200);
			
			return false;
		}
		
		jQuery(document).ready(function($) {
			$("#edit_image_overlays").click(function(e) {
				e.preventDefault();
				
				var overlays = '\
					<div class="table-responsive" id="image_overlays_modal">\
						<table class="table table-striped table-bordered table-hover">\
							<thead>\
								<tr>\
									<th>\
										Overlay Name\
									</th>\
									<th>\
										Selected Image\
									</th>\
									<th>\
										Set Opacity\
									</th>\
									<th>\
										Bounds\
									</th>\
									<th>\
										Pop-Up Contents\
									</th>\
									<th>\
										Remove\
									</th>\
								</tr>\
							</thead>\
							<tbody>\
								\
							</tbody>\
						</table>\
						<button type="button" onClick="jQuery(\'#image_overlays_upload\').click(); return false;" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Overlay</button>\
						<div style="clear: both;"></div>\
						<form method="post" id="image-overlays-form" style="display:none;" enctype="multipart/form-data"><input type="hidden" name="action" value="ajax_uploadFile"><input type="file" name="image_overlays_file" id="image_overlays_upload" accept="image/*"/></form>\
					</div>\
				';
				
				BootstrapDialog.show({
					title: 'Add/Remove Image Overlays',
					message: overlays,
					closable: false,
					size: BootstrapDialog.SIZE_WIDE,
					buttons: [{
						label: 'Save',
						icon: 'fa fa-check',
						cssClass: 'btn-primary',
						action: function(dialog) {
							isOk = true;
							isOkOpacity = true;
							jQuery('#image_overlays_modal tbody tr').each(function(index, obj) {
								if(jQuery(this).find('.image_overlays_bounds_input').val() == '') {
									isOk = false;
									jQuery(this).css('boder','2px solid #f05050;');
								}
								else {
									jQuery(this).css('boder','');
								}
								
								if(parseFloat(jQuery(this).find('.image_overlays_opacity_input').val()) > 1 || parseFloat(jQuery(this).find('.image_overlays_opacity_input').val()) < 0) {
									isOkOpacity = false;
								}
							});
							
							if(!isOk) {
								Alert("Please Select the Coordinates for all the overlays", "error");
								return false;
							}
							if(!isOkOpacity) {
								Alert("Opacity should be between 0.0 and 1.0", "error");
								return false;
							}
							
							imageOverlays = [];
							jQuery('#image_overlays_modal tbody tr').each(function(index, obj) {
								temp = {};
								temp['name'] = jQuery(this).find('.image_overlays_name').val();
								temp['src'] = jQuery(this).find('.image_overlays_img').attr('src');
								temp['opacity'] = jQuery(this).find('.image_overlays_opacity_input').val();
								temp['bounds'] = jQuery(this).find('.image_overlays_bounds_input').val();
								temp['popupcontent'] = jQuery(this).find('.image_overlays_popupcontent_input').html();
								
								imageOverlays.push(temp);
							});
							
							imageOverlaysUpdate(true);
							dialog.close();
						}
					}, {
						label: 'Cancel',
						icon: 'fa fa-remove',
						cssClass: '',
						action: function(dialog) {
							dialog.close();
						}
					}]
				});
				
				setTimeout(function(){
					jQuery.each(imageOverlays, function(key, value) {
						jQuery('#image_overlays_modal tbody').append('\
							<tr>\
								<td>\
									<input type="text" class="form-control image_overlays_name" value="'+value.name+'"/>\
								</td>\
								<td>\
									<img src="'+value.src+'" class="image_overlays_img" style="height:60px;width:100px" alt="'+value.name+'" title="'+value.name+'"/>\
								</td>\
								<td>\
									<select class="image_overlays_opacity_input">\
										<option value="0.05" '+ ((value.opacity == "0.05") ? "selected" : "") +'>0.05</option>\
										<option value="0.10" '+ ((value.opacity == "0.10") ? "selected" : "") +'>0.10</option>\
										<option value="0.15" '+ ((value.opacity == "0.15") ? "selected" : "") +'>0.15</option>\
										<option value="0.20" '+ ((value.opacity == "0.20") ? "selected" : "") +'>0.20</option>\
										<option value="0.25" '+ ((value.opacity == "0.25") ? "selected" : "") +'>0.25</option>\
										<option value="0.30" '+ ((value.opacity == "0.30") ? "selected" : "") +'>0.30</option>\
										<option value="0.35" '+ ((value.opacity == "0.35") ? "selected" : "") +'>0.35</option>\
										<option value="0.40" '+ ((value.opacity == "0.40") ? "selected" : "") +'>0.40</option>\
										<option value="0.45" '+ ((value.opacity == "0.45") ? "selected" : "") +'>0.45</option>\
										<option value="0.50" '+ ((value.opacity == "0.50") ? "selected" : "") +'>0.50</option>\
										<option value="0.55" '+ ((value.opacity == "0.55") ? "selected" : "") +'>0.55</option>\
										<option value="0.60" '+ ((value.opacity == "0.60") ? "selected" : "") +'>0.60</option>\
										<option value="0.65" '+ ((value.opacity == "0.65") ? "selected" : "") +'>0.65</option>\
										<option value="0.70" '+ ((value.opacity == "0.70") ? "selected" : "") +'>0.70</option>\
										<option value="0.75" '+ ((value.opacity == "0.75") ? "selected" : "") +'>0.75</option>\
										<option value="0.80" '+ ((value.opacity == "0.80") ? "selected" : "") +'>0.80</option>\
										<option value="0.85" '+ ((value.opacity == "0.85") ? "selected" : "") +'>0.85</option>\
										<option value="0.90" '+ ((value.opacity == "0.90") ? "selected" : "") +'>0.90</option>\
										<option value="0.95" '+ ((value.opacity == "0.95") ? "selected" : "") +'>0.95</option>\
										<option value="1" '+ ((value.opacity == "1") ? "selected" : "") +'>1</option>\
									</select>\
								</td>\
								<td>\
									<a href="#" onClick="return image_overlays_bounds_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Image Coordinates</a>\
									<input type="hidden" class="image_overlays_bounds_input" value="'+value.bounds+'"/>\
								</td>\
								<td>\
									<a href="#" onClick="return image_overlays_popupcontent_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Pop-Up Content</a>\
									<div style="display:none;" class="image_overlays_popupcontent_input">'+value.popupcontent+'</div>\
								</td>\
								<td>\
									<button class="btn btn-danger" onClick="jQuery(this).parent().parent().remove();"><i class="fa fa-remove"></i></button>\
								</td>\
							</tr>\
						');
					});
					
					jQuery('#image_overlays_upload').change(function(){
						if(jQuery(this).val() != "") {
							progressBar = createProgressBar();
							var formData = new FormData(jQuery('form#image-overlays-form')[0]);
							jQuery.ajax({
								url: '<?PHP echo admin_url('admin-ajax.php')?>',  //Server script to process data
								type: 'POST',
								xhr: function() {  // Custom XMLHttpRequest
									var myXhr = jQuery.ajaxSettings.xhr();
									if(myXhr.upload){ // Check if upload property exists
										myXhr.upload.addEventListener('progress',function(e){
											if(e.lengthComputable){
												updateProgressBar(progressBar, Math.floor((e.loaded/e.total)*100));
											}
										}, false); // For handling the progress of the upload
									}
									return myXhr;
								},
								success: function(data) {
									data = JSON.parse(data);
									if(data.error) {
										Alert(data.error);
									}
									else {
										var name = data.url.split("/");
										name = name[name.length-1];
										
										jQuery('#image_overlays_modal tbody').append('\
											<tr>\
												<td>\
													<input type="text" class="form-control image_overlays_name" value="'+name+'"/>\
												</td>\
												<td>\
													<img src="'+data.url+'" class="image_overlays_img" style="height:60px;width:100px" alt="'+name+'" title="'+name+'"/>\
												</td>\
												<td>\
													<select class="image_overlays_opacity_input">\
														<option value="0.05" '+ ((data.opacity == "0.05") ? "selected" : "") +'>0.05</option>\
														<option value="0.10" '+ ((data.opacity == "0.10") ? "selected" : "") +'>0.10</option>\
														<option value="0.15" '+ ((data.opacity == "0.15") ? "selected" : "") +'>0.15</option>\
														<option value="0.20" '+ ((data.opacity == "0.20") ? "selected" : "") +'>0.20</option>\
														<option value="0.25" '+ ((data.opacity == "0.25") ? "selected" : "") +'>0.25</option>\
														<option value="0.30" '+ ((data.opacity == "0.30") ? "selected" : "") +'>0.30</option>\
														<option value="0.35" '+ ((data.opacity == "0.35") ? "selected" : "") +'>0.35</option>\
														<option value="0.40" '+ ((data.opacity == "0.40") ? "selected" : "") +'>0.40</option>\
														<option value="0.45" '+ ((data.opacity == "0.45") ? "selected" : "") +'>0.45</option>\
														<option value="0.50" '+ ((data.opacity == "0.50") ? "selected" : "") +'>0.50</option>\
														<option value="0.55" '+ ((data.opacity == "0.55") ? "selected" : "") +'>0.55</option>\
														<option value="0.60" '+ ((data.opacity == "0.60") ? "selected" : "") +'>0.60</option>\
														<option value="0.65" '+ ((data.opacity == "0.65") ? "selected" : "") +'>0.65</option>\
														<option value="0.70" '+ ((data.opacity == "0.70") ? "selected" : "") +'>0.70</option>\
														<option value="0.75" '+ ((data.opacity == "0.75") ? "selected" : "") +'>0.75</option>\
														<option value="0.80" '+ ((data.opacity == "0.80") ? "selected" : "") +'>0.80</option>\
														<option value="0.85" '+ ((data.opacity == "0.85") ? "selected" : "") +'>0.85</option>\
														<option value="0.90" '+ ((data.opacity == "0.90") ? "selected" : "") +'>0.90</option>\
														<option value="0.95" '+ ((data.opacity == "0.95") ? "selected" : "") +'>0.95</option>\
														<option value="1" '+ ((data.opacity == "1") ? "selected" : "") +'>1</option>\
													</select>\
												</td>\
												<td>\
													<a href="#" onClick="return image_overlays_bounds_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Image Coordinates</a>\
													<input type="hidden" class="image_overlays_bounds_input" value=""/>\
												</td>\
												<td>\
													<a href="#" onClick="return image_overlays_popupcontent_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Pop-Up Content</a>\
													<div style="display:none;" class="image_overlays_popupcontent_input"></div>\
												</td>\
												<td>\
													<button class="btn btn-danger" onClick="jQuery(this).parent().parent().remove();"><i class="fa fa-remove"></i></button>\
												</td>\
											</tr>\
										').hide().slideDown();
									}
								},
								error: function(e){
									Alert("Error While Uploading the file", "error");
									progressBar.close();
								},
								// Form data
								data: formData,
								//Options to tell jQuery not to process data or worry about content-type.
								cache: false,
								contentType: false,
								processData: false
							});
						}
						
						jQuery(this).val('');
					});
				}, 200);
			});
		});
		
		function tinyMCEInit(textarea) {
			if(textarea) {
				tinyMCE.remove('#'+textarea);
			}
			tinyMCE.remove('#imageOverlayPopupContentInput');
			tinyMCE.remove('#modalPropertyValue');
			tinyMCE.remove('#edit_overlay_content');
			tinyMCE.remove('#edit_legend_content');
			tinymce.init({
				selector: "textarea",
				theme: "modern",
				plugins: [
					"advlist autolink lists link charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern"
				],
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
				toolbar2: "print preview media | forecolor backcolor emoticons",
				image_advtab: true,
				relative_urls: false,
				remove_script_host : false,
				convert_urls : true,
				autosave_ask_before_unload: false,
				extended_valid_elements : "a[onclick|style|href|title|id|class|target]"
			});
		}

	</script>
	<?PHP } else { ?>
	<script>
		jQuery(document).ready(function($) {
			$("#edit_image_overlays").click(function(e) {
				e.preventDefault();
				
				var overlays = '\
					<div class="table-responsive" id="image_overlays_modal">\
						<table class="table table-striped table-bordered table-hover">\
							<thead>\
								<tr>\
									<th style="display: none;">\
										Overlay Name\
									</th>\
									<th>\
										Selected Image\
									</th>\
									<th>\
										Set Opacity\
									</th>\
									<th style="display: none;">\
										Bounds\
									</th>\
									<th style="display: none;">\
										Pop-Up Contents\
									</th>\
									<th style="display: none;">\
										Remove\
									</th>\
								</tr>\
							</thead>\
							<tbody>\
								\
							</tbody>\
						</table>\
						<div style="clear: both;"></div>\
					</div>\
				';
				
				BootstrapDialog.show({
					title: 'Add/Remove Image Overlays',
					message: overlays,
					closable: false,
					buttons: [{
						label: 'Save',
						icon: 'fa fa-check',
						cssClass: 'btn-primary',
						action: function(dialog) {
							
							imageOverlays = [];
							jQuery('#image_overlays_modal tbody tr').each(function(index, obj) {
								temp = {};
								temp['name'] = jQuery(this).find('.image_overlays_name').val();
								temp['src'] = jQuery(this).find('.image_overlays_img').attr('src');
								temp['opacity'] = jQuery(this).find('.image_overlays_opacity_input').val();
								temp['bounds'] = jQuery(this).find('.image_overlays_bounds_input').val();
								temp['popupcontent'] = jQuery(this).find('.image_overlays_popupcontent_input').html();
								
								imageOverlays.push(temp);
							});
							
							imageOverlaysUpdate(true);
							dialog.close();
						}
					}, {
						label: 'Cancel',
						icon: 'fa fa-remove',
						cssClass: '',
						action: function(dialog) {
							dialog.close();
						}
					}]
				});
				
				setTimeout(function(){
					jQuery.each(imageOverlays, function(key, value) {
						jQuery('#image_overlays_modal tbody').append('\
							<tr>\
								<td style="display: none;">\
									<input type="text" class="form-control image_overlays_name" value="'+value.name+'"/>\
								</td>\
								<td>\
									<img src="'+value.src+'" class="image_overlays_img" style="height:60px;width:100px" alt="'+value.name+'" title="'+value.name+'"/>\
								</td>\
								<td>\
									<select class="image_overlays_opacity_input">\
										<option value="0.05" '+ ((value.opacity == "0.05") ? "selected" : "") +'>0.05</option>\
										<option value="0.10" '+ ((value.opacity == "0.10") ? "selected" : "") +'>0.10</option>\
										<option value="0.15" '+ ((value.opacity == "0.15") ? "selected" : "") +'>0.15</option>\
										<option value="0.20" '+ ((value.opacity == "0.20") ? "selected" : "") +'>0.20</option>\
										<option value="0.25" '+ ((value.opacity == "0.25") ? "selected" : "") +'>0.25</option>\
										<option value="0.30" '+ ((value.opacity == "0.30") ? "selected" : "") +'>0.30</option>\
										<option value="0.35" '+ ((value.opacity == "0.35") ? "selected" : "") +'>0.35</option>\
										<option value="0.40" '+ ((value.opacity == "0.40") ? "selected" : "") +'>0.40</option>\
										<option value="0.45" '+ ((value.opacity == "0.45") ? "selected" : "") +'>0.45</option>\
										<option value="0.50" '+ ((value.opacity == "0.50") ? "selected" : "") +'>0.50</option>\
										<option value="0.55" '+ ((value.opacity == "0.55") ? "selected" : "") +'>0.55</option>\
										<option value="0.60" '+ ((value.opacity == "0.60") ? "selected" : "") +'>0.60</option>\
										<option value="0.65" '+ ((value.opacity == "0.65") ? "selected" : "") +'>0.65</option>\
										<option value="0.70" '+ ((value.opacity == "0.70") ? "selected" : "") +'>0.70</option>\
										<option value="0.75" '+ ((value.opacity == "0.75") ? "selected" : "") +'>0.75</option>\
										<option value="0.80" '+ ((value.opacity == "0.80") ? "selected" : "") +'>0.80</option>\
										<option value="0.85" '+ ((value.opacity == "0.85") ? "selected" : "") +'>0.85</option>\
										<option value="0.90" '+ ((value.opacity == "0.90") ? "selected" : "") +'>0.90</option>\
										<option value="0.95" '+ ((value.opacity == "0.95") ? "selected" : "") +'>0.95</option>\
										<option value="1" '+ ((value.opacity == "1") ? "selected" : "") +'>1</option>\
									</select>\
								</td>\
								<td style="display: none;">\
									<a href="#" onClick="return image_overlays_bounds_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Image Coordinates</a>\
									<input type="hidden" class="image_overlays_bounds_input" value="'+value.bounds+'"/>\
								</td>\
								<td style="display: none;">\
									<a href="#" onClick="return image_overlays_popupcontent_click(this)" class="btn btn-info"><i class="fa fa-edit"></i> Set Pop-Up Content</a>\
									<div style="display:none;" class="image_overlays_popupcontent_input">'+value.popupcontent+'</div>\
								</td>\
								<td style="display: none;">\
									<button class="btn btn-danger" onClick="jQuery(this).parent().parent().remove();"><i class="fa fa-remove"></i></button>\
								</td>\
							</tr>\
						');
					});
				}, 200);
			});
		});
	</script>
	<?PHP } ?>