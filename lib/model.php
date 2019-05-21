<?php
class mapfig_premium_model_mf_Table {


	
		public static function getmf_map() {
		global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM  ".MF_MAP_TABLE);
        return $result;

		}
		public static function mf_map_id($mapid) {
		global $wpdb;
        $row = $wpdb->get_row("SELECT * FROM  ".MF_MAP_TABLE." WHERE mid=".$mapid );
        return $row;

		}
		
		public static function map_delete($id){
			global $wpdb;
			$wpdb->query("DELETE FROM ".MF_MAP_TABLE." where mid =".$id);
			return true;
		} 
		
		public static function map_update($row){
			global $wpdb;
			$updateid=$row['mapid'];

			$update=array( 
			'title' => $row['title'],
			'width' => (int)$row['width'],
			'height' => (int)$row['height'],
			'set_marker' =>(int)$row['set_marker'],
			'show_sidebar' =>(int)$row['show_sidebar'],
			'zoom' => (int)$row['zoom'],
			'groups_id' =>(int)$row['groups_id'],
			'layers_id' =>(int)$row['layers_id']
			);

			if(count($update)){
			return $wpdb->update(MF_MAP_TABLE,$update,array('mid'=>$updateid));

			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public static function mapfig_premium_getLayersByGroupId($groupId = 0) {
			global $wpdb;
			$groupId = (int)$groupId;
			
			$result = $wpdb->get_results("SELECT * FROM  ".MF_LAYERS_TABLE." WHERE id IN (SELECT layers_id FROM ".MF_GROUPS_HAS_LAYERS_TABLE." WHERE groups_id = $groupId) ORDER BY id DESC");
			return $result;
		}
		
		public static function getLayers() {
			global $wpdb;
			
			$result = $wpdb->get_results("SELECT * FROM  ".MF_LAYERS_TABLE." WHERE hidden <> 1 ORDER BY id DESC");
			return $result;
		}
		
		public static function getGroups() {
			global $wpdb;
			
			$result = $wpdb->get_results("SELECT * FROM  ".MF_GROUPS_TABLE." WHERE hidden <> 1 ORDER BY id DESC");
			return $result;
		}
		
		public static function getLayer($id) {
			global $wpdb;
			$row = $wpdb->get_row("SELECT * FROM  ".MF_LAYERS_TABLE." WHERE id=".(int)$id);
			return $row;
		}
		
		public static function getGroup($id) {
			global $wpdb;
			$row = $wpdb->get_row("SELECT * FROM  ".MF_GROUPS_TABLE." WHERE id=".(int)$id." AND hidden <> 1");
			return $row;
		}
		
		public static function getGroupHasLayersByGroupId($groupId) {
			global $wpdb;
			$results = $wpdb->get_results("SELECT * FROM ".MF_GROUPS_HAS_LAYERS_TABLE." WHERE groups_id = $groupId");
			return $results;
		}
		
		public static function mapfig_premium_getDefaultLayer() {
			global $wpdb;
			$row = $wpdb->get_row("SELECT * FROM  ".MF_LAYERS_TABLE." WHERE hidden = 1 LIMIT 1");
			return $row;
		}
		
		public static function getDefaultGroup() {
			global $wpdb;
			$row = $wpdb->get_row("SELECT * FROM  ".MF_GROUPS_TABLE." WHERE hidden = 1 LIMIT 1");
			return $row;
		}
		
		public static function deleteLayer($id) {
			global $wpdb;
			$wpdb->query("DELETE FROM  ".MF_LAYERS_TABLE." WHERE id=".(int)$id." AND hidden <> 1");
		}
		
		public static function deleteGroup($id) {
			global $wpdb;
			$wpdb->query("DELETE FROM  ".MF_GROUPS_TABLE." WHERE id=".(int)$id." AND hidden <> 1");
		}
		
		public static function editLayer($id, $name, $url, $lkey, $accesstoken, $attribution){
			global $wpdb;
			$updateid=(int)$id;

			$update=array( 
				'name' => $name,
				'url' => $url,
				'lkey' => $lkey,
				'accesstoken' => $accesstoken,
				'attribution' => $attribution
			);

			if(count($update)){
				return $wpdb->update(MF_LAYERS_TABLE,$update,array('id'=>$updateid));
			}
		}
		
		public static function editGroup($id, $name){
			global $wpdb;
			$updateid=(int)$id;

			$update=array( 
				'name' => $name
			);

			if(count($update)){
				return $wpdb->update(MF_GROUPS_TABLE,$update,array('id'=>$updateid));
			}
		}
		
		public static function addLayer($name, $url, $lkey, $accesstoken, $attribution){
			global $wpdb;
			
			return $wpdb->insert( MF_LAYERS_TABLE, array( 'name' => $name, 'url' => $url, 'lkey' => $lkey, 'accesstoken' => $accesstoken, 'attribution' => $attribution ) );
		}
		
		public static function addGroup($name){
			global $wpdb;
			return $wpdb->insert( MF_GROUPS_TABLE, array( 'name' => $name ) );
		}
		
		
		public static function addGroupHasLayers($groupId, $layersList){
			global $wpdb;
			
			if(!is_array($layersList) || count($layersList) == 0){
				$layersList = array();
			}
			for($i=0;$i<count($layersList);$i++){
				$layersList[$i] = (int)$layersList[$i];
			}
			$groupId = (int)$groupId;
			if($groupId == 0)
				return false;
			
			$wpdb->query("DELETE FROM ".MF_GROUPS_HAS_LAYERS_TABLE." WHERE groups_id = $groupId");
			
			$query = "INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (groups_id, layers_id) VALUES ";
			$values = array();
			
			foreach($layersList as $key => $val){
				if($val == 0){
					unset($layersList[$key]);
				}
				else{
					$values[] = "(".(int)$groupId.", ".(int)$val.")";
				}
			}
			
			if(count($values) > 0){
				$wpdb->query($query. implode(',', $values));
			}
			
			return true;
		}
 }
?>