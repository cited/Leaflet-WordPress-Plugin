<?php 

//homepage view
function view_mf_mapcode($atts){
		global $wpdb;
		 $atts2 = (int)$atts['mapid'];
		 
		 $ThisMap = (array)$wpdb->get_row("SELECT * FROM ".MF_MAP_TABLE." WHERE mid = ".$atts2);
		 if($ThisMap) {
			 return '<iframe src="'.admin_url('admin-ajax.php?action=view_map&id='.$atts2).'" allowfullscreen="" style="border: 0; height: '.$ThisMap['height'].$ThisMap['height_parameter'].'; width: '.$ThisMap['width'].$ThisMap['width_parameter'].';"></iframe>';
		 }
		 else {
			return "Map not Found!"; 
		 }
}
add_shortcode(MF_PLUGIN_NAME_FORMATED, 'view_mf_mapcode');




add_action('media_buttons', 'add_mf_modal_button', 15);
add_action('wp_enqueue_media', 'include_mf_modal_js_file');
add_filter('admin_footer_text', 'mf_footer_admin', 1);
add_action('init','mf_add_thickbox');

function mf_add_thickbox() {
    add_thickbox();
}
    
function add_mf_modal_button() {
    echo '<a href="#" id="insert-mf-modal-map" class="button"><i class="fa fa-leaf fa-2"></i> Add '.MF_PLUGIN_NAME_FORMATED.' Map</a>';
}

function include_mf_modal_js_file() {
    wp_enqueue_script('media_button', plugins_url('js/mf-modal.js', __FILE__), array('jquery'), '1.0', true);
}

function mf_footer_admin($default){

					$file=dirname(__FILE__).'/shortcode/mf_admin_button.php';
					ob_start();
					include($file);
					$content = ob_get_clean();
					echo $content;
					
}
function add_mf_stylesheet() {
		wp_enqueue_style( 'mf-colorbox', plugins_url('css/colorbox.css', __FILE__) );
}




?>