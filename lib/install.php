<?php
function mapfig_premium_tb_mf_install() {
	global $wpdb;
	
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta("
	CREATE TABLE IF NOT EXISTS ".MF_MAP_TABLE." (
	  `mid` int(11) NOT NULL AUTO_INCREMENT,
	  `title` varchar(255) DEFAULT NULL,
	  `width` varchar(255) DEFAULT NULL,
	  `height` varchar(255) DEFAULT NULL,
	  `show_sidebar` int(1) NOT NULL DEFAULT '0',
	  `show_search` int(1) NOT NULL DEFAULT '0',
	  `show_measure` int(1) NOT NULL DEFAULT '0',
	  `show_minimap` int(1) NOT NULL DEFAULT '0',
	  `show_svg` int(1) NOT NULL DEFAULT '0',
	  `show_export` int(1) NOT NULL DEFAULT '0',
	  `show_gpx` int(1) NOT NULL DEFAULT '0',
	  `lat` varchar(20) NOT NULL,
	  `lng` varchar(20) NOT NULL,
	  `zoom` varchar(255) DEFAULT NULL,
	  `layers_id` int(11) unsigned NOT NULL DEFAULT '1',
	  `groups_id` int(11) NOT NULL DEFAULT '0',
	  `data` text NOT NULL,
	  `data_gpx` longtext NOT NULL,
	  UNIQUE KEY `id` (`mid`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");

	dbDelta("
	CREATE TABLE IF NOT EXISTS ".MF_GROUPS_TABLE." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");

	dbDelta("
	CREATE TABLE IF NOT EXISTS ".MF_LAYERS_TABLE." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `url` varchar(500) NOT NULL,
	  `lkey` varchar(100) NOT NULL,
	  `accesstoken` varchar(255) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `attribution` varchar(500),
	  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");

	dbDelta("
	CREATE TABLE IF NOT EXISTS ".MF_GROUPS_HAS_LAYERS_TABLE." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `groups_id` int(11) unsigned DEFAULT NULL,
	  `layers_id` int(11) unsigned NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");
	
	
	
	/* Default Hidden layer/group Start */
	$groups_id = (int)$wpdb->get_var("SELECT id FROM ".MF_GROUPS_TABLE." WHERE `hidden` = 1");
	
	if($groups_id == 0) {
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('Hidden Layers Group', 1)");
		$groups_id = $wpdb->insert_id;
	}

	$layers_id = (int)$wpdb->get_var("SELECT id FROM ".MF_LAYERS_TABLE." WHERE `hidden` = 1");
	if($layers_id == 0) {
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', '', 'Hidden Open Street Map', '', 1)");
		$layers_id = $wpdb->insert_id;
	}

	$group_has_layer_id = (int)$wpdb->get_var("SELECT id FROM ".MF_GROUPS_HAS_LAYERS_TABLE." WHERE `groups_id` = $groups_id AND `layers_id` = $layers_id");
	if($group_has_layer_id == 0) {
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`id`, `groups_id`, `layers_id`) VALUES (NULL, $groups_id, $layers_id)");
	}
	/* Default Hidden layer/group End */


	/* Default layer/group Start */
	if(!$group_has_layer_id) {
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://tile.waymarkedtrails.org/cycling/{z}/{x}/{y}.png', '', 'Loniva Biking', '<a href=\"http://cycling.waymarkedtrails.org/\" target=\"_blank\">OpenStreetMap</a>', 0)");
		$layers_id_1  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://tile.waymarkedtrails.org/hiking/{z}/{x}/{y}.png', '', 'Loniva Hiking', '<a href=\"https://openpistemap.org\" target=\"_blank\">OpenStreetMap</a>', 0)");
		$layers_id_2  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', '', 'OpenCycleMap', '<a href=\"http://thunderforest.com/\" target=\"_blank\">Thunderforest</a>', 0)");
		$layers_id_3  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://a.tile.stamen.com/toner/{z}/{x}/{y}.png', '', 'Stamen.Toner', 'Map tiles by <a href=\"http://stamen.com\">Stamen Design</a>, under <a href=\"http://creativecommons.org/licenses/by/3.0\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>, under <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">ODbL</a>.', 0)");
		$layers_id_4  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.jpg', '', 'Stamen.Watercolor', 'Map tiles by <a href=\"http://stamen.com\" target=\"_blank\">Stamen Design</a>, under <a href=\"http://creativecommons.org/licenses/by/3.0\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>, under <a href=\"http://creativecommons.org/licenses/by-sa/3.0\" target=\"_blank\">CC BY SA</a>.', 0)");
		$layers_id_5  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', 'examples.map-i875mjb7', 'MapBox', '<a href=\"http://mapbox.com\" target=\"_blank\">Mapbox</a>', 0)");
		$layers_id_6  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', '', 'CartoDB Light', 'Map tiles by <a href=\"http://cartodb.com/attributions#basemaps\" target=\"_blank\">CartoDB</a>, under <a href=\"https://creativecommons.org/licenses/by/3.0/\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://www.openstreetmap.org/\" target=\"_blank\">OpenStreetMap</a>, under ODbL.', 0)");
		$layers_id_7  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png', '', 'CartoDB Dark', 'Map tiles by <a href=\"http://cartodb.com/attributions#basemaps\" target=\"_blank\">CartoDB</a>, under <a href=\"https://creativecommons.org/licenses/by/3.0/\" target=\"_blank\">CC BY 3.0</a>. Data by <a href=\"http://www.openstreetmap.org/\" target=\"_blank\">OpenStreetMap</a>, under ODbL.', 0)");
		$layers_id_8  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', '', 'Esri World Imagery', 'Attribution: <a href=\"http://www.esri.com/\" target=\"_blank\">ESRI</a>', 0)");
		$layers_id_9  = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://otile3-s.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', '', 'MapQuest', '<a href=\"https://openstreetmap.org\" target=\"_blank\">OpenStreetMap. </a> Tiles Courtesy of <a href=\"http://www.mapquest.com/\" target=\"_blank\">MapQuest</a>', 0)");
		$layers_id_10 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', '', 'OpenStreetMap', '<a href=\"https://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>', 0)");
		$layers_id_11 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', '', 'Google Maps', '<a href=\"http://www.google.com/intl/en-GB_US/help/terms_maps.html\" target=\"_blank\">Google - Terms of Use</a>', 0)");
		$layers_id_12 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://otile1.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png', '', 'MapQuest Sat', '<a href=\"https://openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>', 0)");
		$layers_id_13 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tile.thunderforest.com/mapfig-bluewaters/{z}/{x}/{y}.png', '', 'MapFig Bluewaters', '&copy; <a href=\"http://mapfig.org\" target=\"_blank\">MapFig </a> Bluewaters by <a href=\"http://thunderforest.com\" target=\"_blank\">Thunderforest,</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>.', 0)");
		$layers_id_14 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tile.thunderforest.com/mapfig-2a6/{z}/{x}/{y}.png', '', 'MapFig Greenwaters', '&copy; <a href=\"http://mapfig.org\" target=\"_blank\">MapFig </a> Greenwaters by <a href=\"http://thunderforest.com\" target=\"_blank\">Thunderforest,</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>.', 0)");
		$layers_id_15 = $wpdb->insert_id;
		$wpdb->query("INSERT INTO ".MF_LAYERS_TABLE." (`url`, `lkey`, `name`, `attribution`, `hidden`) VALUES ('https://{s}.tile.thunderforest.com/mapfig-darkwaters/{z}/{x}/{y}.png', '', 'MapFig Darkwaters', '&copy; <a href=\"http://mapfig.org\" target=\"_blank\">MapFig </a> Darkwaters by <a href=\"http://thunderforest.com\" target=\"_blank\">Thunderforest,</a> Data by <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a>.', 0)");
		$layers_id_16 = $wpdb->insert_id;

		
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('My First Group', 0)");
		$groups_id = $wpdb->insert_id;
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_1)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_2)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_3)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_4)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_5)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_6)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_7)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_8)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_9)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_10)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_11)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_12)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_13)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_14)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_15)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_16)");
		
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('SSL Maps', 0)");
		$groups_id = $wpdb->insert_id;
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_10)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_11)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_14)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_16)");
		
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('Style Maps', 0)");
		$groups_id = $wpdb->insert_id;
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_4)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_5)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_7)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_8)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_13)");
		
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('Outdoor Maps', 0)");
		$groups_id = $wpdb->insert_id;
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_1)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_2)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_3)");
		
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_TABLE." (`name`, `hidden`) VALUES ('Satellite Maps', 0)");
		$groups_id = $wpdb->insert_id;
		
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_9)");
		$wpdb->query("INSERT INTO ".MF_GROUPS_HAS_LAYERS_TABLE." (`groups_id`, `layers_id`) VALUES ($groups_id, $layers_id_12)");
	}
	/* Default layer/group End */
}
function mapfig_premium_tb_mf_uninstall() {
	$tab  = MF_MAP_TABLE;
	$tab3 = MF_GROUPS_TABLE;
	$tab4 = MF_LAYERS_TABLE;
	$tab5 = MF_GROUPS_HAS_LAYERS_TABLE;

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	dbDelta("DROP TABLE IF EXISTS ".MF_MAP_TABLE);
	dbDelta("DROP TABLE IF EXISTS ".MF_GROUPS_TABLE);
	dbDelta("DROP TABLE IF EXISTS ".MF_LAYERS_TABLE);
	dbDelta("DROP TABLE IF EXISTS ".MF_GROUPS_HAS_LAYERS_TABLE);
}
?>