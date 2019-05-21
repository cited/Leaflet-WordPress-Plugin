var layerProperties=new Array();var shapeStyles=new Array();var shapeCustomProperties=new Array();var publicLayer=null;var editMode=false;var currentLayer='';var getShapes=function(drawnItems){var shapes=[];drawnItems.eachLayer(function(layer){if(layer instanceof L.Polyline||layer instanceof L.Rectangle||layer instanceof L.Circle||layer instanceof L.Marker){shapes.push(layer);}});return shapes;};function setPropertiesByLayer(layer,properties){for(i=0;i<layerProperties.length;i++){if(layerProperties[i][0]==layer){layerProperties[i][1]=properties;return;}}}

function getPropertiesByLayer(layer){for(i=0;i<layerProperties.length;i++){if(layerProperties[i][0]==layer){return layerProperties[i][1];}}

return{};}

function bindPopup(layer){popupContent=getPopupContent(layer)

layer.bindPopup(popupContent);}

function getPopupContent(layer){popupContent="";properties=getPropertiesByLayer(layer);customProperties=getCustomPropertiesByLayer(layer);jQuery.each(properties,function(index,property){if(!customProperties.hide_label){var label=property.name;if(property.name=="Name"){label="Location";}

popupContent+='<b>'+label+'</b> : ';}

if(customProperties.show_address_on_popup){if(property.name=="Name"){popupContent+='<b>'+property.value+'</b><br/>';return true;}}

if(property.name != "Name") {popupContent+=property.value+'<br/>';}});if(customProperties.get_direction){jQuery.each(properties,function(index,property){if(property.name=="Name"){address=property.value;popupContent+='<a href="https://www.google.com/maps/dir//'+address+'" target="_blank">Get Directions</a>';return false;}});}

return popupContent;}

function getCustomPropertiesByLayer(layer){for(i=0;i<layerProperties.length;i++){if(layerProperties[i][0]==layer){return shapeCustomProperties[i];}}

return{};}

function getLayerIndex(layer){for(i=0;i<layerProperties.length;i++){if(layerProperties[i][0]==layer){return i;}}}

function getLayers(){layers=new Array();for(i=0;i<layerProperties.length;i++){layers.push(layerProperties[i][0]);}

return layers;}

function clickOnSidebarAddress(obj){var layers=getLayers();index=jQuery(obj).parent().index();setTimeout(function(){layers[index].openPopup();openPopup(layers[index]);},50);}

function openPopup(layer){
	if(show_svg) {
		layer.openPopup();
	}
	mapClosePopup();
	index = getLayerIndex(layer);
	
	if(shapeCustomProperties[index].bootstrap_popup) {
		setTimeout(function(){
			map.closePopup();
			mapOpenPopup(layer);
		}, 50);
	}
}

function mapClosePopup() {
	$('#static-popup').fadeOut();
}
function mapOpenPopup(layer) {
	popupContent = getPopupContent(layer)
	$('#static-popup-content').html(popupContent);
	$('#static-popup').fadeIn();
}

function mapfigOpenPopup(layer){popupContent=getPopupContent(layer)

jQuery('.mapfig-modal-body').html(popupContent);jQuery('#mapfig-myModal').addClass('mapfig-in').fadeIn(0);mapfigPopupCentralized();}

function staticSidebarPopupResize() {
	m_height = $("#map_canvas").height();
	height = m_height-40;
	
	$('#static-popup').css('max-height',height).css('min-width',150);
}
$(document).ready(function(){staticSidebarPopupResize()})