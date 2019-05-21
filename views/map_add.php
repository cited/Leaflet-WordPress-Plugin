<?PHP
	global $_POST;
	
	if(!isset($_POST['submit'])) {
		global $wpdb;
		$MAP_ID = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
		$ThisMap = $wpdb->get_row("SELECT * FROM ".MF_MAP_TABLE." WHERE mid = ".$MAP_ID);
		
		if($ThisMap) {
			$_POST = (array)$ThisMap;
		}
		else {
			$_POST = array(
				"mid" => 0,
				"title" => "",
				"height" => 500,
				"width"  => 500,
				"height_parameter" => "px",
				"width_parameter" => "px",
				"show_sidebar"   => 1,
				"show_search"   => 0,
				"show_measure"   => 0,
				"show_minimap"   => 0,
				"show_svg"   => 0,
				"show_export"   => 0,
				"show_gpx"   => 0,
				"zoom"   => 6,
				"lat"    => 0,
				"lng"    => 0,
				"data"   => "[]",
				"data_gpx"   => "[]",
				"image_olverlays"   => "[]",
				"layers_id" => 1,
				"groups_id" => 1,
			);
		}
	}
	
	$title = isset($_GET['id']) ? "Update Map" : "Add New Map"; 

echo '
	<ol class="breadcrumb breadcrumb-arrow" style="margin: 10px 15px 0 0;">
		<li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
		<li><a href="#"><i class="fa fa-leaf"></i> '.MF_PLUGIN_NAME_FORMATED.'</a></li>
		<li class="active"><span><i class="fa fa-plus"></i> '.$title.'</span></li>
		<li class="active pull-right help"><span><a href="'.MF_HELP_URL.'" title="Help?" target="_blank"><img src="'.plugins_url('../images/question-mark.png', __FILE__).'" style="height:30px;width:30px;"></a></span></li>
	</ol>
	';

echo '
<form action="" method="post" id="save_map_form">
	<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>
	<div class="col-md-12">
		<h2>'.$title.'</h2>';
		if(isset($msg) && $msg!=''):
			echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$msg.'
			</div>';
		elseif(isset($err) && $err!=''):
			echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$err.'
			</div>';
		endif;
?>
		
		
		<div class="col-md-4">
			<div class="wrap">
				<div class="settingContent">
						<script type="text/javascript">
							$(document).ready(function(){
								setTimeout(function() {
									var zoom_slider = $("#zoom-slider").slider({
										min	:0,
										max	:18,
										value   : <?=(isset($_POST['zoom']) && $_POST['zoom']!='') ? $_POST['zoom'] : "5"?>,
										step	:1,
										change	: function( event, ui ) { $('#zoom').val(ui.value); map.setZoom(ui.value) },
										slide	: function( event, ui ) { $('#zoom').val(ui.value); }
									});
									$("#height-slider").slider({
										min	:200,
										max	:2000,
										value   : <?=(isset($_POST['height']) && $_POST['height']!='') ? $_POST['height'] : "500"?>,
										step	:1,
										change	: function( event, ui ) { $('#height').val(ui.value); },
										slide	: function( event, ui ) { $('#height').val(ui.value); }
									});
									$("#width-slider").slider({
										min	:200,
										max	:2000,
										value   : <?=(isset($_POST['width']) && $_POST['width']!='') ? $_POST['width'] : "500"?>,
										step	:1,
										change	: function( event, ui ) { $('#width').val(ui.value); },
										slide	: function( event, ui ) { $('#width').val(ui.value); }
									});
									
									map.setZoom($('#zoom').val());
									
									
									
									$('select[name=width_parameter]').change(function() {
										val = $(this).val();
										if(val == "px") {
											$("#width-slider").slider( "option", "min", 200);
											$("#width-slider").slider( "option", "max", 2000);
											$("#width-slider").slider( "option", "value", <?=(isset($_POST['width']) && $_POST['width']!='') ? $_POST['width'] : "500"?>);
										}
										else if(val == "%") {
											$("#width-slider").slider( "option", "min", 0);
											$("#width-slider").slider( "option", "max", 100);
											$("#width-slider").slider( "option", "value", <?=(isset($_POST['width']) && $_POST['width']!='') ? $_POST['width'] : "100"?>);
										}
										
									});
									$('select[name=height_parameter]').change(function() {
										val = $(this).val();
										if(val == "px") {
											$("#height-slider").slider( "option", "min", 200);
											$("#height-slider").slider( "option", "max", 2000);
											$("#height-slider").slider( "option", "value", <?=(isset($_POST['height']) && $_POST['height']!='') ? $_POST['height'] : "500"?>);
										}
										else if(val == "%") {
											$("#height-slider").slider( "option", "min", 0);
											$("#height-slider").slider( "option", "max", 100);
											$("#height-slider").slider( "option", "value", <?=(isset($_POST['height']) && $_POST['height']!='') ? $_POST['height'] : "100"?>);
										}
										
									});
									
									$('select[name=height_parameter]').change();
									$('select[name=width_parameter]').change();
								} , 300);
							});
						</script>

						<div>
						<label>Map Title</label>
						<br>
						<input type="text" class="form-control" required="required" name="title" value="<?php if(isset($_POST['title']) && $_POST['title']!='') echo $_POST['title']; ?>">
						</div>

						<div>
						<label>Width</label>
						<div class="clear"></div>
						<div id="width-slider" class="col-md-7" style="margin: 10px 10px 0 0;"></div>
						<div class="input-group" class="col-md-5">
							<input type="text" id="width" name="width" class="form-control" readonly value="<?=(isset($_POST['width']) && $_POST['width']!='') ? $_POST['width'] : "500"?>" aria-describedby="width-addon">
							<div class="input-group-btn">
								<select name="width_parameter" class="btn" style="height: 34px;">
									<option value="px" <?PHP if($_POST['width_parameter'] == "px") echo "selected"; ?>>px</option>
									<option value="%" <?PHP if($_POST['width_parameter'] == "%") echo "selected"; ?>>%</option>
								</select>
							</div>
						</div>
						</div>


						<div>
						<br>
						<label>Height</label>
						<div class="clear"></div>
						<div id="height-slider" class="col-md-7" style="margin: 10px 10px 0 0;"></div>
						<div class="input-group" class="col-md-5">
							<input type="text" id="height" name="height" class="form-control" readonly value="<?=(isset($_POST['height']) && $_POST['height']!='') ? $_POST['height'] : "500"?>" aria-describedby="height-addon">
							<div class="input-group-btn">
								<select name="height_parameter" class="btn" style="height: 34px;">
									<option value="px" <?PHP if($_POST['height_parameter'] == "px") echo "selected"; ?>>px</option>
									<option value="%" <?PHP if($_POST['height_parameter'] == "%") echo "selected"; ?>>%</option>
								</select>
							</div>
						</div>
						</div>
						<br>
						
						

						<div class="checkbox">
							<label for="show_sidebar" id="label_show_sidebar"><input type="checkbox" id="show_sidebar" name="show_sidebar" value="1" <?=($_POST['show_sidebar'] == 1) ? "checked" : ""?>> Show Sidebar</label>
						</div>
						<div class="checkbox">
							<label for="show_search" id="label_show_search"><input type="checkbox" id="show_search" name="show_search" value="1" <?=($_POST['show_search'] == 1) ? "checked" : ""?>> Show Search</label>
						</div>
						<div class="checkbox">
							<label for="show_measure" id="label_show_measure"><input type="checkbox" id="show_measure" name="show_measure" value="1" <?=($_POST['show_measure'] == 1) ? "checked" : ""?>> Show Measure</label>
						</div>
						<div class="checkbox">
							<label for="show_minimap" id="label_show_minimap"><input type="checkbox" id="show_minimap" name="show_minimap" value="1" <?=($_POST['show_minimap'] == 1) ? "checked" : ""?>> Show MiniMap</label>
						</div>
						<div class="checkbox">
							<label for="show_export" id="label_show_export"><input type="checkbox" id="show_export" name="show_export" value="1" <?=($_POST['show_export'] == 1) ? "checked" : ""?>> Show Export</label>
						</div>
						
						
						
						<div>
						<label>Zoom Level</label>
						<div class="clear"></div>
						<div id="zoom-slider" class="col-md-8" style="margin: 10px 10px 0 0;"></div>
						<div class="input-group" class="col-md-4">
							<input type="text" id="zoom" name="zoom" class="form-control" readonly value="<?=(isset($_POST['zoom']) && $_POST['zoom']!='') ? $_POST['zoom'] : "5"?>" aria-describedby="zoom-addon">
							<span class="input-group-addon" id="zoom-addon"><i class="fa fa-search"></i></span>
						</div>
						</div>
						<br>
						
						
						<div>
						<label>Base Map</label>
						<br>
							<select name="layers_id" id="layers_id" class="selecter_3" data-selecter-options="{&quot;cover&quot;:&quot;true&quot;}">
								<option value="1">[ Select ]</option>
								<?PHP
									foreach($layers as $layer) {
										if($_POST['layers_id'] == $layer->id) {
											echo '<option value="'.$layer->id.'" selected>'.$layer->name.'</option>';
										}
										else {
											echo '<option value="'.$layer->id.'">'.$layer->name.'</option>';
										}
									}
								?>
							</select>
						</div>
						
						
						<div>
						<label>Base Map Group</label>
						<br>
							<select name="groups_id" id="groups_id" class="selecter_3" data-selecter-options="{&quot;cover&quot;:&quot;true&quot;}">
								<option value="0">[ Select ]</option>
								<?PHP
									foreach($groups as $group) {
										if($_POST['groups_id'] == $group->id) {
											echo '<option value="'.$group->id.'" selected>'.$group->name.'</option>';
										}
										else {
											echo '<option value="'.$group->id.'">'.$group->name.'</option>';
										}
									}
								?>
							</select>
						</div>
						
						
						<div>
						<label></label>
						<br>
							<input type="hidden" value="<?=$_POST['mid']?>" name="id">
							<input type="hidden" value="<?=$_POST['lat']?>" id="lat" name="lat">
							<input type="hidden" value="<?=$_POST['lng']?>" id="lng" name="lng">
							<input type="hidden" id="geo_json_str" name="geo_json_str">
							
							<input type="hidden" name="geo_image_olverlays">
							
							<input type="submit" class="btn btn-primary" name="submit" id="geo_json" value="Save">
						</div>
						
				</div>
			</div>
		</div>
		
		<div class="col-md-8">
			<?PHP
				global $_HEIGHT;
				global $_WIDTH;
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
				$_WIDTH = $_POST['width'];
				$_ZOOM = $_POST['zoom'];
				$_LAT  = $_POST['lat'];
				$_LNG  = $_POST['lng'];
				$_DEFAULT_LAYER = "L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18, id: '', attribution:'<a href=\"https://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>' + mbAttribution})";
				$_BASE_LAYERS   = "{}";
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
				$_IS_DRAW = true;
			?>
			<?PHP include MAPFIG_PREMIUM_EMP_DOCROOT . '/views/map.preview.tpl'; ?>
		</div>
	</div>
</section>


<div style="clear:both;"></div>

<?PHP
	echo '<section id="social plugin" class="wrap" >
	<!-- this ludacris display is how WP renders an icon -->
	<div id="icon-themes" class="icon32"><br></div>';
?>
</section>

</form>

<?php include 'include/footer-small.php';?>