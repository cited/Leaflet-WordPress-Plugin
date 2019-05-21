<?php

function mapfig_premium_mf_menu() {
	add_menu_page(MF_PLUGIN_NAME_FORMATED, '<i class="fa fa-leaf fa-2"></i> '.MF_PLUGIN_NAME_FORMATED.' Leaflet', 'administrator', MF_PLUGIN_NAME, 'mf','dashicons-admin-mediaa');

	add_submenu_page( MF_PLUGIN_NAME, 'My Maps', '<i class="fa fa-globe"></i> My Maps', 'administrator', 'my-maps', 'mf_main_map' );
	add_submenu_page( MF_PLUGIN_NAME, 'Manage Map', '<i class="fa fa-location-arrow"></i> Add New Map<hr>', 'administrator', 'add-new-map', 'add_main_map' );

	add_submenu_page( MF_PLUGIN_NAME, 'My Base Maps', '<i class="fa fa-align-justify"></i> My Base Maps', 'administrator', 'layers', 'layers' );
	add_submenu_page( MF_PLUGIN_NAME, 'Add New Base Map', '<i class="fa fa-plus-square"></i> Add New Base Map', 'administrator', 'layers-add', 'layers_add' );
	add_submenu_page( MF_PLUGIN_NAME, 'Base Map Groups', '<i class="fa fa-group"></i> Base Map Groups', 'administrator', 'groups', 'groups' );
	add_submenu_page( MF_PLUGIN_NAME, 'Add New Group', '<i class="fa fa-plus-square"></i> Add New Group<hr>', 'administrator', 'groups-add', 'groups_add' );

	add_submenu_page( MF_PLUGIN_NAME, 'Social Share', '<i class="fa fa-share"></i> Social Share', 'administrator', 'social-share', 'social_share' );
	add_submenu_page( MF_PLUGIN_NAME, 'Social Share', '<i class="fa fa-cog"></i> Social Settings<hr>', 'administrator', 'social-share-settings', 'social_share_settings' );
	add_submenu_page( MF_PLUGIN_NAME, 'Widget', '<i class="fa fa-user-plus"></i> Widget<hr>', 'administrator', 'get_started_widget', 'get_started_widget' );

	add_submenu_page( MF_PLUGIN_NAME, 'Documentation', '<i class="fa fa-book"></i> Documentation', 'administrator', 'get-started', 'get_started' );
}

function get_started(){
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/get_started.php';
}

function mf(){
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/mf.php';
}

function get_started_widget(){
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/get_started_widget.php';
}

function social_share(){
	$result = mapfig_premium_model_mf_Table::getmf_map();
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/social_share.php';
}

function social_share_settings(){
	$msg = "";
	$err = "";

	if(isset($_POST['save'])) {
		foreach($_FILES as $index => $file) {
			if(in_array($index, array('default','facebook','twitter','email','linkedin','pinterest')) && $file['error'] == 0 && $file['size'] > 0) {
				$res = mapfig_premium_uploadShare($index);
				if($res != "") {
					$err .= $res.'<br>';
				}
				else {
					$msg .= $index.' image is Successfully uploaded<br>';
				}
			}
		}
	}
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/social_share_settings.php';
}


function layers($err='', $msg='') {
	if(isset($_GET['action']) && $_GET['action'] == "edit") { // If Request For Edit Layer
		$err ='';
		$msg ='';

		if(isset($_POST['submit'])){
			if(strlen($_POST['name'])<2) {
				$err = "Base Map Name Too Short.";
			}
			else if(strlen($_POST['url'])<10) {
				$err = "Base Map URL Too Short.";
			}
			else if(!mapfig_premium_model_mf_Table::editLayer($_POST['id'], $_POST['name'], $_POST['url'], $_POST['lkey'], $_POST['accesstoken'], $_POST['attribution'])){
				$err = "Something went wrong. Please refresh and try again!";
			}
			else {
				$msg = "Successfully Updated!";
			}
		}

		$id = (isset($_GET['id']))?(int)$_GET['id']:0;
		$row = mapfig_premium_model_mf_Table::getLayer($id);

		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/layers_edit.php';
	}
	else { // If Request For Delete/View Layer(s)
		if(isset($_GET['id'])) {
			mapfig_premium_model_mf_Table::deleteLayer((int)$_GET['id']);
		}

		if(isset($_GET['groupid'])) {
			$result = mapfig_premium_model_mf_Table::mapfig_premium_getLayersByGroupId((int)$_GET['groupid']);
		}
		else {
			$result = mapfig_premium_model_mf_Table::getLayers();
		}
		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/layers.php';
	}
}

function layers_add() {
	$err ='';
	$msg ='';

	if(isset($_POST['submit'])){
		if(strlen($_POST['name'])<2) {
			$err = "Base Map Name Too Short.";
		}
		else if(strlen($_POST['url'])<10) {
			$err = "Base Map URL Too Short.";
		}
		else if(!mapfig_premium_model_mf_Table::addLayer($_POST['name'], $_POST['url'], $_POST['lkey'], $_POST['accesstoken'], $_POST['attribution'])){
			$err = "Something went wrong. Please refresh and try again!";
		}
		else {
			$msg = "Successfully Added!";
		}
	}

	if($msg == ""){
		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/layers_add.php';
	}
	else {
		layers($err, $msg);
	}
}

function groups($err='', $msg='') {
	if(isset($_GET['action']) && $_GET['action'] == "edit") { // If Request For Edit Layer
		$err ='';
		$msg ='';

		if(isset($_POST['submit'])){
			if(strlen($_POST['name'])<2) {
				$err = "Group Name Too Short.";
			}
			else if(!mapfig_premium_model_mf_Table::editGroup($_POST['id'], $_POST['name'])){
				$err = "Something went wrong. Please refresh and try again!";
			}
			else {
				$msg = "Successfully Updated!";
			}
		}

		$id = (isset($_GET['id']))?(int)$_GET['id']:0;
		$row = mapfig_premium_model_mf_Table::getGroup($id);

		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/groups_edit.php';
	}
	else if (isset($_GET['action']) && $_GET['action'] == "groups_has_layers" && isset($_GET['id']) && (int)$_GET['id'] > 0){
		$group = mapfig_premium_model_mf_Table::getGroup((int)$_GET['id']);
		if($group) {
			if(isset($_POST['submit'])) { // form submitted
				mapfig_premium_model_mf_Table::addGroupHasLayers((int)$_POST['id'], isset($_POST['assigned']) ? $_POST['assigned'] : array());
			}

			$layers = mapfig_premium_model_mf_Table::getLayers();
			$groupHasLayers = mapfig_premium_model_mf_Table::getGroupHasLayersByGroupId((isset($_GET['id']))?(int)$_GET['id']:0);

			$assignedLayers = array();
			foreach($groupHasLayers as $ghl){
				$assignedLayers[] = $ghl->layers_id;
			}

			include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/groups_has_layers.php';
		}
	}
	else { // If Request For Delete/View Layer(s)
		if(isset($_GET['id'])) {
			mapfig_premium_model_mf_Table::deleteGroup((int)$_GET['id']);
		}
		$result = mapfig_premium_model_mf_Table::getGroups();
		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/groups.php';
	}
}

function groups_add() {
	$err ='';
	$msg ='';

	if(isset($_POST['submit'])){
		if(strlen($_POST['name'])<2) {
			$err = "Group Name Too Short.";
		}
		else if(!mapfig_premium_model_mf_Table::addGroup($_POST['name'])){
			$err = "Something went wrong. Please refresh and try again!";
		}
		else {
			$msg = "Successfully Added!";
		}
	}

	if($msg == ""){
		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/groups_add.php';
	}
	else {
		groups($err, $msg);
	}
}

function groups_has_layers($msg='') {
	$result = mapfig_premium_model_mf_Table::getmf_GroupsHasLayers();
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/groups_has_layers.php';
}


function mf_main_map($msg=''){
	if(isset($_REQUEST['mapid']) && isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
		$delete = mapfig_premium_model_mf_Table::map_delete((int)$_REQUEST['mapid']);
		if($delete){
			$msg = "Map successfully deleted.";
		}
	}

	$result = mapfig_premium_model_mf_Table::getmf_map();
	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/main_map.php';
}


function add_main_map() {
	$post = $_POST;

	$err ='';
	$msg ='';

	if(isset($post['submit'])){
		if(!isset($post['title']) || strlen($post['title']) == 0){
			$err= "Map Title is required";
		}
		else if(strlen($post['title']) < 4){
			$err = "Map Title Should be atleast 4 character long";
		}
		else if(empty($post['width'])){
			$err = 'Map Width is required';
		}
		else if(empty($post['height'])){
			$err = 'Map height is required and should ';
		}
		else if(empty($post['zoom'])){
			$err = 'Map zoom is required';
		}
		else{
			$height = (!$post['height'] || (int)$post['height'] == 0) ? 500 : (int)$post['height'];
			$width  = (!$post['width'] || (int)$post['width'] == 0) ? 500 : (int)$post['width'];
			$zoom   = (!$post['zoom'] || (int)$post['zoom'] == 0) ? 8 : (int)$post['zoom'];

			$lat    = (float)$post['lat'];
			$lng    = (float)$post['lng'];
			$data   = str_replace("\n", "<br>", str_replace("\r", "", $post['geo_json_str']));
			$image_olverlays   = str_replace("\n", "<br>", str_replace("\r", "", $post['geo_image_olverlays']));

			$id     = isset($post['id']) ? (int)$post['id'] : 0;

			if(!isset($post['show_sidebar'])) {
				$post['show_sidebar'] = 0;
			}

			global $wpdb;
			$table_name = MF_MAP_TABLE;

			if($id == 0) {
				$wpdb->insert( $table_name, array( 'title' => $post['title'],'width' => (int)$width, 'height' => (int)$height, 'width_parameter' => $post['width_parameter'], 'height_parameter' => $post['height_parameter'], 'show_sidebar' =>(int)mapfig_premium__post('show_sidebar'), 'show_search' =>(int)mapfig_premium__post('show_search'), 'show_measure' =>(int)mapfig_premium__post('show_measure'), 'show_minimap' =>(int)mapfig_premium__post('show_minimap'), 'show_svg' =>(int)mapfig_premium__post('show_svg'), 'show_export' =>(int)mapfig_premium__post('show_export'), 'lat' => $lat, 'lng' => $lng, 'zoom' => (int)$zoom, 'data' => $data, 'image_olverlays' => $image_olverlays, 'layers_id' => (int)$post['layers_id'], 'groups_id' => (int)$post['groups_id']));

				$mapId = $wpdb->insert_id;
				if(!$mapId){
					$err .= 'Database Error. Can\'t create Map!';
				}
				else {
					$msg = 'Map Successfully Created!';
				}
			}
			else {
				$wpdb->update(
					$table_name,
					array('title' => $post['title'],'width' => (int)$width, 'height' => (int)$height, 'width_parameter' => $post['width_parameter'], 'height_parameter' => $post['height_parameter'], 'show_sidebar' =>(int)mapfig_premium__post('show_sidebar'), 'show_search' =>(int)mapfig_premium__post('show_search'), 'show_measure' =>(int)mapfig_premium__post('show_measure'), 'show_minimap' =>(int)mapfig_premium__post('show_minimap'), 'show_svg' =>(int)mapfig_premium__post('show_svg'), 'show_export' =>(int)mapfig_premium__post('show_export'), 'lat' => $lat, 'lng' => $lng, 'zoom' => (int)$zoom, 'data' => $data, 'image_olverlays' => $image_olverlays, 'layers_id' => (int)$post['layers_id'], 'groups_id' => (int)$post['groups_id']),
					array( 'mid' => $id )
				);

				$msg = 'Map Successfully Updated!';
			}

		}
	}
	$PAGE = "addMap";

	wp_enqueue_script( 'tinymcejs' );
	wp_enqueue_script( 'mf_custom_js' );
	wp_enqueue_script( 'mf_marker_preview_js' );


	$layers = mapfig_premium_model_mf_Table::getLayers();
	$groups = mapfig_premium_model_mf_Table::getGroups();

	$defaultLayer = mapfig_premium_model_mf_Table::mapfig_premium_getDefaultLayer();
	$defaultLayer = "L.tileLayer('".$defaultLayer->url."', {maxZoom: 18, id: '".$defaultLayer->lkey."', attribution: '".$defaultLayer->lkey."'+mbAttribution})";

	$baseLayers = array();
	$rows = mapfig_premium_model_mf_Table::mapfig_premium_getLayersByGroupId(0);
	foreach($rows as $row) {
		$baseLayers[] = "'".$row->name."': L.tileLayer('".$row->url."', {maxZoom: 18, id: '".$row->lkey."', attribution: '".$row->lkey."'+mbAttribution})";
	}
	$baseLayers = implode(",", $baseLayers);

	if($msg != "") {
		$result = mapfig_premium_model_mf_Table::getmf_map();
		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/main_map.php';
	}
	else {
		wp_enqueue_script('leaflet-fullscreen-js');
		wp_enqueue_style('leaflet-fullscreen-css');

		wp_enqueue_script('leaflet-controle-locate-js');
		wp_enqueue_style('leaflet-controle-locate-css');

		wp_enqueue_script('leaflet-draw-js');
		wp_enqueue_style('leaflet-draw-css');

		wp_enqueue_script('leaflet-measurecontrol-js');
		wp_enqueue_style('leaflet-measurecontrol-css');

		wp_enqueue_script('leaflet-minimap-js');
		wp_enqueue_style('leaflet-minimap-css');

		wp_enqueue_script('leaflet-search-js');

		wp_enqueue_script('leaflet-export-js');

		wp_enqueue_script('google-maps-api-js');

		wp_enqueue_script('helper-js');

		wp_enqueue_script('colpick-js');
		wp_enqueue_style('colpick-css');

		wp_enqueue_script('mf-js');

		include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/map_add.php';
	}
}


function mapfig_premium_addMFMenuIcon() {
	echo '<style type="text/css">
			body, html {
				overflow-y: auto !important;
			}
			.wp-menu-name > .fa.fa-leaf {
				margin-left: -25px;
			}
			#toplevel_page_'.MF_PLUGIN_NAME.' li hr {
				margin: 11px 0 0 0;
			}
		</style>
		<script>
			var MF_PLUGIN_NAME_FORMATED = \''.MF_PLUGIN_NAME_FORMATED.'\';
			var MF_PLUGIN_NAME = \''.MF_PLUGIN_NAME.'\';
			var MF_MAIN_DOMAIN = \''.MF_MAIN_DOMAIN.'\';
		</script>';
}
add_action('admin_head', 'mapfig_premium_addMFMenuIcon');

function ajax_getLayer(){
	echo json_encode(mapfig_premium_getDefaultLayer((int)$_REQUEST['id']));
	exit;
}
add_action( 'wp_ajax_ajax_getLayer', 'ajax_getLayer' );

function ajax_getLayersByGroupId(){
	echo json_encode(mapfig_premium_getLayersByGroupId((int)$_REQUEST['id']));
	exit;
}
add_action( 'wp_ajax_ajax_getLayersByGroupId', 'ajax_getLayersByGroupId' );




function ajax_download_map($mapid = 0){
	ob_start();

	if($mapid == 0){
		$MAP_ID = (isset($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
	}
	else {
		$MAP_ID = (int)$mapid;
	}
	echo '
	<html>
		<head>
			<title>Map</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<script src='.plugins_url( '../js/jquery.min.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../font-awesome/css/font-awesome.css' , __FILE__ ).' rel="stylesheet" />
			<script src='.plugins_url( '../leaflet/dist/leaflet.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../leaflet/dist/leaflet.css' , __FILE__ ).' rel="stylesheet" />
			<script src='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.css' , __FILE__ ).' rel="stylesheet" />
		</head>
		<style>
			#sidebar-button-reorder i.fa, #edit_image_overlays i.fa {
				padding-top: 8px;
			}
			ul.list-unstyled.leaflet-sidebar {
				padding: 0;
			}
			.modal-dialog {
				z-index: 1050;
			}
		</style>
		<body>';
		render_html($MAP_ID);
		echo'</body>
	</html>';

	$content = ob_get_contents();
	header("Content-Disposition: attachment; filename=map.html");
	header("Content-Length: ".strlen($content));

	exit;
}
add_action( 'wp_ajax_download_map', 'ajax_download_map' );
add_action( 'wp_ajax_nopriv_download_map', 'ajax_download_map' );



function ajax_view_map(){
	$MAP_ID = (isset($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
	echo '
	<html>
		<head>
			<title>Map</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<script src='.plugins_url( '../js/jquery.min.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../font-awesome/css/font-awesome.css' , __FILE__ ).' rel="stylesheet" />
			<script src='.plugins_url( '../leaflet/dist/leaflet.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../leaflet/dist/leaflet.css' , __FILE__ ).' rel="stylesheet" />
			<script src='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.js' , __FILE__ ).'></script>
			<link href='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.css' , __FILE__ ).' rel="stylesheet" />
		</head>
		<style>
			#sidebar-button-reorder i.fa, #edit_image_overlays i.fa {
				padding-top: 8px;
			}
			ul.list-unstyled.leaflet-sidebar {
				padding: 0;
			}
			.leaflet-control-search a {
				padding-top: 7px !important;
			}
			.modal-dialog {
				z-index: 1050;
			}
		</style>
		<body>';
		render_html($MAP_ID);
		echo'</body>
	</html>';
	exit;
}
add_action( 'wp_ajax_view_map', 'ajax_view_map' );
add_action( 'wp_ajax_nopriv_view_map', 'ajax_view_map' );






function ajax_download_json($mapid = 0) {
	global $wpdb;
	if($mapid == 0){
		$MAP_ID = (isset($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
	}
	else {
		$MAP_ID = (int)$mapid;
	}
	$ThisMap = $wpdb->get_row("SELECT * FROM ".MF_MAP_TABLE." WHERE mid = ".$MAP_ID);
	if(!$ThisMap) {
		die("Map not Found!");
	}
	$data = stripslashes($ThisMap->data);
	$data = array (
				"type"     => "FeatureCollection",
				"features" => (array) json_decode($data)
			);

	foreach($data['features'] as &$d) {
		$prop = array();
		foreach ($d->properties as &$property) {
			$prop [$property->name] = $property->value;
		}

		$d->properties = $prop;

		unset($d->customProperties);
		unset($d->style);
	}
	$data = json_encode($data);

	header("Content-Disposition: attachment; filename=map.json");
	header("Content-Length: ".strlen($data));
	echo $data;

	exit;
}
add_action( 'wp_ajax_download_json', 'ajax_download_json' );
add_action( 'wp_ajax_nopriv_download_json', 'ajax_download_json' );






function ajax_download_webapp(){
	$templateName = "bootstrap";
	$folderName = generateRandomString(16);

	$content_fig = WP_CONTENT_DIR.'/mapfig-temp';
	@mkdir($content_fig);
	$path = $content_fig.'/'.$folderName.'/';

	$id = (int)$_GET['id'];

	ob_start();

	$MAP_ID = (isset($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
	echo '
		<script src='.plugins_url( '../js/jquery.min.js' , __FILE__ ).'></script>
		<link href='.plugins_url( '../font-awesome/css/font-awesome.css' , __FILE__ ).' rel="stylesheet" />
		<script src='.plugins_url( '../leaflet/dist/leaflet.js' , __FILE__ ).'></script>
		<link href='.plugins_url( '../leaflet/dist/leaflet.css' , __FILE__ ).' rel="stylesheet" />
		<script src='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.js' , __FILE__ ).'></script>
		<link href='.plugins_url( '../leaflet/dist/leaflet.awesome-markers.css' , __FILE__ ).' rel="stylesheet" />
		<script>
			$(document).ready(function(){
				$(\'#map_canvas\').height($(window).height()-50);
				$(\'#map_canvas\').css("width", "100%").css("margin-top", "50px");
			});
		</script>
		<style>
			#sidebar-button-reorder i.fa, #edit_image_overlays i.fa {
				padding-top: 8px;
			}
			ul.list-unstyled.leaflet-sidebar {
				padding: 0;
			}
			.modal-dialog {
				z-index: 1050;
			}
		</style>
		';
		render_html($MAP_ID);

	$content = file_get_contents(MAPFIG_PREMIUM_EMP_DOCROOT.'/views/template/html-template/'.$templateName.'/index.html');
	$map_content = str_replace("[#MAP_VIEW#]", ob_get_contents(), $content);

	if(mkdir($path)){
		shell_exec("cp -r ".MAPFIG_PREMIUM_EMP_DOCROOT."/views/template/html-template/$templateName/ $path 2>&1");
		file_put_contents($path.$templateName."/index.html", $map_content);

		shell_exec("
			cd $path
			zip -r $templateName $templateName/ 2>&1
		");
		$zipFile = file_get_contents("$path$templateName.zip");
		shell_exec("rm -r $path");

		header("Content-Disposition: attachment; filename=$templateName.zip");
		header("Content-Length: ".strlen($zipFile));
		echo $zipFile;
	}
	exit;
}
add_action( 'wp_ajax_download_webapp', 'ajax_download_webapp' );
add_action( 'wp_ajax_nopriv_download_webapp', 'ajax_download_webapp' );





function ajax_getFormats(){
	echo '{"types":["geojson","html","iframe"],"titles":["GeoJSON","HTML","Embed"]}';
	exit;
}
add_action( 'wp_ajax_ajax_getFormats', 'ajax_getFormats' );
add_action( 'wp_ajax_nopriv_ajax_getFormats', 'ajax_getFormats' );





function ajax_uploadFile(){
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['image_overlays_file'];
	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides);
	echo json_encode($movefile);
	exit;
}
add_action( 'wp_ajax_ajax_uploadFile', 'ajax_uploadFile' );





function ajax_mapExport() {
	$format = $_GET['format'];
	$mapid  = (int)$_GET['mapid'];

	switch ($format) {
		case 'geojson':
			ajax_download_json($mapid);
			break;
		case 'html':
			ajax_download_map($mapid);
			break;
		case 'iframe':
			global $wpdb;
			$map = (array)$wpdb->get_row("SELECT * FROM ".MF_MAP_TABLE." WHERE mid = ".$mapid);

			$content = '<iframe src="'. admin_url('admin-ajax.php?action=view_map&id='.$mapid) .'" height="'.$map['height'].'" width="'.$map['width'].'"></iframe>';
			header("Content-Disposition: attachment; filename=map.".$format);
			header("Content-Length: ".strlen($content));

			echo $content;
			break;
		default:
			die("Invalid Request");
	}
	exit;
}
add_action( 'wp_ajax_ajax_mapExport', 'ajax_mapExport' );
add_action( 'wp_ajax_nopriv_ajax_mapExport', 'ajax_mapExport' );




function render_html($MAP_ID = 0) {
	global $wpdb;

	$ThisMap = $wpdb->get_row("SELECT * FROM ".MF_MAP_TABLE." WHERE mid = ".$MAP_ID);

	if(!$ThisMap) {
		die("Map not Found!");
	}
	$_POST = (array)$ThisMap;

	$defaulLayer = mapfig_premium_getDefaultLayer((int)$_POST['layers_id']);
	$defaulLayer = "L.tileLayer('".$defaulLayer['url']."', {maxZoom: 18, id: '".$defaulLayer['lkey']."', token: '".$defaulLayer['accesstoken']."', attribution: '".$defaulLayer['attribution']."'+mbAttribution})";

	$baseLayers  = array();
	foreach(mapfig_premium_getLayersByGroupId((int)$_POST['groups_id']) as $data) {
		$baseLayers[] = "'".$data['name']."': L.tileLayer('".$data['url']."', {maxZoom: 18, id: '".$data['lkey']."', token: '".$data['accesstoken']."', attribution: '".$data['attribution']."'+mbAttribution})";
	}
	$baseLayers = '{'.implode(",", $baseLayers).'}';

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
	global $_DATA_GPX;
	global $_SHOW_SIDEBAR;
	global $_SHOW_MEASURE;
	global $_SHOW_SEARCH;
	global $_SHOW_MINIMAP;
	global $_SHOW_SVG;
	global $_SHOW_EXPORT;
	global $_SHOW_GPX;
	global $_IMAGE_OVERLAYS;

	global $_IS_DRAW;

	$_HEIGHT = $_POST['height'];
	$_WIDTH = ($_REQUEST['action'] == "download_webapp") ? "1500" : $_POST['width'];
	$_HEIGHT_PARAMETER = $_POST['height_parameter'];
	$_WIDTH_PARAMETER = $_POST['width_parameter'];

	$_ZOOM = $_POST['zoom'];
	$_LAT  = $_POST['lat'];
	$_LNG  = $_POST['lng'];
	$_DEFAULT_LAYER = $defaulLayer;
	$_BASE_LAYERS   = $baseLayers;
	$_DATA = $_POST['data'];
	$_DATA_GPX = $_POST['data_gpx'];
	$_SHOW_SIDEBAR = ($_POST['show_sidebar']==1) ? "true" : "false";
	$_SHOW_SEARCH= ($_POST['show_search']==1) ? "true" : "false";
	$_SHOW_MEASURE= ($_POST['show_measure']==1) ? "true" : "false";
	$_SHOW_MINIMAP= ($_POST['show_minimap']==1) ? "true" : "false";
	$_SHOW_SVG= ($_POST['show_svg']==1) ? "true" : "false";
	$_SHOW_EXPORT= ($_POST['show_export']==1) ? "true" : "false";
	$_SHOW_GPX= ($_POST['show_gpx']==1) ? "true" : "false";
	$_IMAGE_OVERLAYS= ($_POST['image_olverlays'] == "") ? "[]" : $_POST['image_olverlays'];
	$_IS_DRAW = false;


	echo '
		<script src="'.plugins_url('../external/Leaflet.fullscreen.min.js', __FILE__).'"></script>
		<link href="'.plugins_url('../external/leaflet.fullscreen.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('../external/L.Control.Locate.js', __FILE__).'"></script>
		<link href="'.plugins_url('../external/L.Control.Locate.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('/../js/leaflet.draw.js', __FILE__).'"></script>
		<link href="'.plugins_url('/../css/leaflet.draw.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('../external/leaflet.measurecontrol.js', __FILE__).'"></script>
		<link href="'.plugins_url('../external/leaflet.measurecontrol.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('../external/Control.MiniMap.js', __FILE__).'"></script>
		<link href="'.plugins_url('../external/Control.MiniMap.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('../external/Leaflet.Search.js', __FILE__).'"></script>

		<script src="'.plugins_url('../external/ExportControl.js', __FILE__).'"></script>

		<script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&libraries=places"></script>

		<script src="'.plugins_url('/../js/helper.js', __FILE__).'"></script>
	';


	if($_IS_DRAW) {
		echo'
		<script src="'.plugins_url('/../colorpicker/js/colpick.js', __FILE__).'"></script>
		<link href="'.plugins_url('/../colorpicker/css/colpick.css', __FILE__).'" rel="stylesheet" />

		<script src="'.plugins_url('/../js/mf.js', __FILE__).'"></script>
		';
	} else {
		echo '<link href="'.plugins_url('../bootflat/css/site.min.css' , __FILE__).'" rel="stylesheet" />';

		echo '<script src="'.plugins_url('../js/smodal.js', __FILE__).'"></script>
		<script src="'.plugins_url('../bootstrap3-dialog/js/bootstrap-dialog.min.js', __FILE__).'"></script>
		<link href="'.plugins_url('../bootstrap3-dialog/css/bootstrap-dialog.min.css', __FILE__).'" rel="stylesheet" />';
	}

	include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/map.preview.tpl';
}






function generateRandomString($length = 8) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
	$charactersLength = strlen($characters);
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}
?>
