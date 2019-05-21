<?PHP
	$pluginStatus = null;
	
	function mapfig_premium__post($key) {
		if(isset($_POST[$key])) {
			return $_POST[$key];
		}
		else {
			return "";
		}
	}
	function mapfig_premium__get($key) {
		if(isset($_GET[$key])) {
			return $_GET[$key];
		}
		else {
			return "";
		}
	}
	
	function mapfig_premium_uploadShare($name) {
		$target_dir = MAPFIG_PREMIUM_EMP_DOCROOT."/images/share/";
		$target_file = $target_dir . $name . '.png';
		
		$imageFileType = pathinfo(basename($_FILES[$name]["name"]),PATHINFO_EXTENSION);
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES[$name]["tmp_name"]);
		if($check !== false) {
			
		} else {
			return $name." File is not an image.";
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			@unlink($target_file);
		}
		
		// Check file size
		if ($_FILES[$name]["size"] > 300000) {
			return "Sorry, your file ".$name." is too large. Max allowed size is : 300kb";
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			return "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ".$name." is not an image";
		}
		
		if (file_put_contents($target_file, file_get_contents($_FILES[$name]["tmp_name"]))) {
			return ""; //success
		} else {
			return "Sorry, there was an error uploading your file ".$name;
		}
	}
	
	function mapfig_premium_my_script_enqueuer() { 
	   
		wp_register_style('datatable_css', plugins_url( '../datatable/jquery.dataTables.css' , __FILE__ ));
		wp_register_style('validate_css', plugins_url( '../validate/validate.css' , __FILE__ ));
		wp_register_style('leaflet_css', plugins_url( '../leaflet/dist/leaflet.css' , __FILE__ ));
		wp_register_style('my_css', plugins_url( '/css/custom.css' , __FILE__ ));
		wp_register_style('font_awesome', plugins_url( '../font-awesome/css/font-awesome.css' , __FILE__ ));
		wp_register_style('markers_css', plugins_url( '../leaflet/dist/leaflet.awesome-markers.css' , __FILE__ ));
		
		wp_register_style('bootflat_css', plugins_url('../bootflat/css/site.min.css' , __FILE__));
		wp_register_style('bootstrap_slider_css', plugins_url('../bootstrap/css/bootstrap-slider.css' , __FILE__));
		wp_register_script('datatable_script',plugins_url( '../datatable/jquery.dataTables.js' , __FILE__ ), array( 'jquery' ),'',true);
		wp_register_script('validate_script',plugins_url( '../validate/jquery.validate.min.js' , __FILE__ ), array( 'jquery' ),'',true);
		
		wp_register_script('bootflat_js',plugins_url( '../bootflat/js/site.min.js' , __FILE__ ), array( 'jquery' ),'','');
		wp_register_script('leafletjs',plugins_url( '../leaflet/dist/leaflet.js' , __FILE__ ), array( 'jquery' ),'','');
		wp_register_script('leaflet_awesome',plugins_url( '../leaflet/dist/leaflet.awesome-markers.js' , __FILE__ ), array( 'jquery' ),'','');
		wp_register_script('tinymcejs',plugins_url( '../tinymce/js/tinymce/tinymce.min.js' , __FILE__ ), array( 'jquery' ),'','');
		wp_register_style ('mf_colorbox', plugins_url('../css/colorbox.css', __FILE__) );
		
		wp_register_style( 'mf_user_main', plugins_url('../css/main.css', __FILE__) );
		wp_register_script( 'mf_colorbox_js', plugins_url('../js/jquery.colorbox-min.js', __FILE__), array(), '1.0.0', true );
		wp_register_script( 'jquery-scrollto_js', plugins_url('../js/jquery-scrollto.js', __FILE__), array(), '1.0.0', true );
		wp_register_script( 'mf_selecttag_js', plugins_url('../js/jquery.SelectTag.js', __FILE__), array(), '1.0.0', true );
		wp_register_script( 'jquery_migrate_js', plugins_url('../js/jquery-migrate-1.2.1.js', __FILE__), array(), '1.0.0', true );
		wp_register_script( 'mf_custom_js', plugins_url('../js/custom.js', __FILE__), array(), '1.0.0', true ); 
		wp_register_script( 'mf_marker_preview_js', plugins_url('../js/marker_preview.js', __FILE__), array(), '1.0.0', true ); 
		
		wp_register_style('jquery_ui_css', plugins_url('../css/jquery-ui.css', __FILE__));
	   
		wp_register_script('bootstrap_alert_js', plugins_url('../bootstrap3-dialog/js/bootstrap-dialog.min.js', __FILE__));
		wp_register_style('bootstrap_alert_css', plugins_url('../bootstrap3-dialog/css/bootstrap-dialog.min.css', __FILE__));
		
		wp_register_script('bootstrap-js', plugins_url('../bootstrap/js/bootstrap.js', __FILE__));
		wp_register_style('bootstrap-css', plugins_url('../bootstrap/css/bootstrap.css', __FILE__));
		
		wp_register_script('leaflet-fullscreen-js', plugins_url('../external/Leaflet.fullscreen.min.js', __FILE__));
		wp_register_style('leaflet-fullscreen-css', plugins_url('../external/leaflet.fullscreen.css', __FILE__));
		
		wp_register_script('leaflet-controle-locate-js', plugins_url('../external/L.Control.Locate.js', __FILE__));
		wp_register_style('leaflet-controle-locate-css', plugins_url('../external/L.Control.Locate.css', __FILE__));
		
		wp_register_script('google-maps-api-js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places');
		
		wp_register_style('google-font-roboto-css', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500');
		wp_register_style('google-font-lato-css', 'https://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic');
		wp_register_style('google-font-montserrat-css', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
		
		wp_register_script('leaflet-draw-js', plugins_url('/../js/leaflet.draw.js', __FILE__));
		wp_register_style('leaflet-draw-css', plugins_url('/../css/leaflet.draw.css', __FILE__));
		
		wp_register_script('leaflet-measurecontrol-js', plugins_url('../external/leaflet.measurecontrol.js', __FILE__));
		wp_register_style('leaflet-measurecontrol-css', plugins_url('../external/leaflet.measurecontrol.css', __FILE__));
		
		wp_register_script('leaflet-minimap-js', plugins_url('../external/Control.MiniMap.js', __FILE__));
		wp_register_style('leaflet-minimap-css', plugins_url('../external/Control.MiniMap.css', __FILE__));
		
		wp_register_script('leaflet-search-js', plugins_url('../external/Leaflet.Search.js', __FILE__));
		
		wp_register_script('leaflet-export-js', plugins_url('../external/ExportControl.js', __FILE__));
		
		wp_register_script('colpick-js', plugins_url('/../colorpicker/js/colpick.js', __FILE__));
		wp_register_style('colpick-css', plugins_url('/../colorpicker/css/colpick.css', __FILE__));
		
		wp_register_script('helper-js', plugins_url('/../js/helper.js', __FILE__));
		wp_register_script('mf-js', plugins_url('/../js/mf.js', __FILE__));
		
		
		
		wp_enqueue_script('jquery');
		wp_enqueue_style('font_awesome');
		wp_enqueue_style('leaflet_css');
		wp_enqueue_style('markers_css');
		
		wp_enqueue_style('google-font-lato-css');
		wp_enqueue_style('google-font-montserrat-css');
		
		wp_enqueue_script('leafletjs');
		wp_enqueue_script('leaflet_awesome');
		
		
		$pluginPages = array(MF_PLUGIN_NAME,"my-maps","add-new-map","get-started","get_started_widget","map-edit","map-delete","layers","layers-edit","layers-add","groups","groups-edit","groups-add","social-share","social-share-settings");
		if(!isset($_GET['page']) || !in_array($_GET['page'], $pluginPages)){
			return;
		}
		
	   
		wp_enqueue_style('datatable_css');   
		wp_enqueue_style('validate_css');  
		wp_enqueue_style('bootflat_css');
		wp_enqueue_style('bootstrap_slider_css');
		
		wp_enqueue_script( 'datatable_script' );
		wp_enqueue_script( 'validate_script' );
		wp_enqueue_script( 'bootflat_js' );
		
		wp_enqueue_style('mf_colorbox');
		wp_enqueue_style('mf_user_main');
		wp_enqueue_script( 'mf_colorbox_js' );
		wp_enqueue_script( 'jquery-scrollto_js' );
		wp_enqueue_script( 'mf_selecttag_js' );
		wp_enqueue_script( 'jquery_migrate_js' );
		
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_style('jquery_ui_css');
		
		wp_enqueue_script('bootstrap_alert_js');
		wp_enqueue_style('bootstrap_alert_css');
	}
	
	function mapfig_premium_getLayersByGroupId($id){
		$baseLayers = array();
		
		$layers = mapfig_premium_model_mf_Table::mapfig_premium_getLayersByGroupId($id);
		
		foreach($layers as $layer) {
			$baseLayers[] = array('name' => $layer->name, 'url' => $layer->url, 'lkey' => $layer->lkey, 'accesstoken' => $layer->accesstoken, 'attribution' => $layer->attribution);
		}
		
		return $baseLayers;
	}
	
	function mapfig_premium_getDefaultLayer($id) {
		$layer = mapfig_premium_model_mf_Table::getLayer($id);
		if(!$layer) {
			$layer = mapfig_premium_model_mf_Table::mapfig_premium_getDefaultLayer();
		}
		
		$defaulLayer = array('url' => $layer->url, 'lkey' => $layer->lkey, 'accesstoken' => $layer->accesstoken, 'attribution' => $layer->attribution);
		return $defaulLayer;
	}
?>