<?PHP
function mapfig_premium_upgrade_plugin() 
{
    $v = 'mapfig_premium_db_version';
    $update_option = null;
    // Upgrade to version 1
	if ( 1 !== (int)get_option( $v ) ) 
    {
        if ( 1 > (int)get_option( $v ) )
        {
            // Callback function must return true on success
            $update_option = custom_upgrade_database_v1();
 
            // Only update option if it was an success
            if ( $update_option )
                update_option( $v, 1 );
        }
    }
	
	if ( 2 !== (int)get_option( $v ) ) 
    {
        if ( 2 > (int)get_option( $v ) )
        {
            // Callback function must return true on success
            $update_option = custom_upgrade_database_v2();
 
            // Only update option if it was an success
            if ( $update_option )
                update_option( $v, 2 );
        }
    }
    
    // Return the result from the custom update, so we can test for success/fail/error
    if ( $update_option )
        return $update_option;
 
	return false;
}
add_action('admin_init', 'mapfig_premium_upgrade_plugin' );




function custom_upgrade_database_v1() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE ".MF_MAP_TABLE." ADD  `width_parameter` ENUM(  'px',  '%' ) NOT NULL DEFAULT  'px';");
	$wpdb->query("ALTER TABLE ".MF_MAP_TABLE." ADD  `height_parameter` ENUM(  'px',  '%' ) NOT NULL DEFAULT  'px';");
	
	return true;
}

function custom_upgrade_database_v2() {
	global $wpdb;
	
	$wpdb->query("ALTER TABLE ".MF_MAP_TABLE." ADD `image_olverlays` LONGTEXT NOT NULL");
	return true;
}
?>