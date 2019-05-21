<?php

add_action( 'widgets_init', 'map_widget' );

function map_widget() {
	register_widget( 'MAP_Widget' );
}

class MAP_Widget extends WP_Widget {

	function MAP_Widget() {
		$widget_ops = array( 'classname' => 'mf', 'description' => __('', 'mf') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'mf-widget' );
		
		parent::__construct( 'mf-widget', __(MF_PLUGIN_NAME_FORMATED.' Widget', MF_PLUGIN_NAME), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title  = apply_filters('widget_title', $instance['title'] );
		$mapid  = (int)$instance['mapid'];
		$width  = (int)$instance['mapwidth'];
		$height = (int)$instance['mapheight'];
		
		$show_map = isset( $instance['show_map'] ) ? $instance['show_map'] : false;

		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title;
		
		if ($show_map) {
			global $_GLOBAL_HEIGHT;
			global $_GLOBAL_WIDTH;
			global $_WIDGET_MAPID;
			global $CALLED_FROM_WIDGET;
			
			$CALLED_FROM_WIDGET = true;
			
			$_GLOBAL_HEIGHT = ($height == 0)? '300px' : $height.'px';
			$_GLOBAL_WIDTH  = ($width  == 0)? '100%' : $width.'px';
			$_WIDGET_MAPID  = $mapid;
			
			echo '<iframe src="'.admin_url('admin-ajax.php?action=view_map&id='.$_WIDGET_MAPID.'&height='.$_GLOBAL_HEIGHT.'&width='.$_GLOBAL_WIDTH).'" allowfullscreen="" height="'.$_GLOBAL_HEIGHT.'" width="'.$_GLOBAL_WIDTH.'"></iframe>';
		}

		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and apikey to remove HTML 
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['mapid']     = (int)$new_instance['mapid'];
		$instance['mapheight'] = ((int)$new_instance['mapheight'] == 0)? '' : (int)$new_instance['mapheight'];
		$instance['mapwidth']  = ((int)$new_instance['mapwidth'] == 0)? '' : (int)$new_instance['mapwidth'];
		$instance['show_map']  = isset($new_instance['show_map']);

		return $instance;
	}

	
	function form( $instance ) {
		//Set up some default widget settings.
		global $wpdb;
		$map=$wpdb->get_results( "SELECT * FROM ".MF_MAP_TABLE );
		
		$defaults = array( 'title' => __(MF_PLUGIN_NAME_FORMATED, 'mf'), 'show_map' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'mf'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mapid' ); ?>"><?php _e('Select Map:', 'mf'); ?></label>
			<select id="<?php echo $this->get_field_id( 'mapid' ); ?>" name="<?php echo $this->get_field_name( 'mapid' ); ?>" style="width:100%;">
				<?php foreach($map as $maps){ ?>
					<option value="<?php echo $maps->mid;?>" <?php selected($instance['mapid'], $maps->mid);?>><?php echo $maps->title;?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mapheight' ); ?>"><?php _e('Map Height (in px) - Default 300px:', 'mf'); ?></label>
			<input type="number" id="<?php echo $this->get_field_id( 'mapheight' ); ?>" name="<?php echo $this->get_field_name( 'mapheight' ); ?>" value="<?php echo $instance['mapheight']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'mapwidth' ); ?>"><?php _e('Map Width (in px) - Default 100%:', 'mf'); ?></label>
			<input type="number" id="<?php echo $this->get_field_id( 'mapwidth' ); ?>" name="<?php echo $this->get_field_name( 'mapwidth' ); ?>" value="<?php echo $instance['mapwidth']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_map'], true ); ?> id="<?php echo $this->get_field_id( 'show_map' ); ?>" name="<?php echo $this->get_field_name( 'show_map' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_map' ); ?>"><?php _e('Display Map publicly?', 'mf'); ?></label>
		</p>
	<?php
	}
}

?>