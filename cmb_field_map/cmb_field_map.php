<?php
	
	/*
		Plugin Name: Google Maps CMB Field Type
		Plugin URI: http://www.philwylie.co.uk/
		Description: Google Maps field type for Custom Metaboxes and Fields for WordPress
		Version: 1.0
		Author: Phil Wylie
		Author URI: http://www.philwylie.co.uk/
	*/
	
	
	
	function cmb_field_google_map($field, $meta) {
		wp_register_script('google_maps_api', "http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places");
		wp_register_script('google_map_js', plugin_dir_url(__FILE__) . "js/script.js");
		wp_register_style('google_map_css', plugin_dir_url(__FILE__) . "css/style.css");
		
		wp_enqueue_script('google_maps_api');
		wp_enqueue_script('google_map_js');
		wp_enqueue_style('google_map_css');
		
		echo '<div id="google_maps_search">';
		echo '	<input type="text" id="'. $field['id'] .'" />';
		echo '</div>';
		echo '<input type="hidden" id="latitude" name="'. $field['id'] .'[latitude]" value="'. $meta['latitude'] .'" />';
		echo '<input type="hidden" id="longitude" name="'. $field['id'] .'[longitude]" value="'. $meta['longitude'] .'" />';
		echo '<div id="map_canvas"></div>';

		if(!empty($field['desc'])) echo '<p class="cmb_metabox_description">'. $field['desc'] .'</p>';
	}
	add_filter('cmb_render_google_map', 'cmb_field_google_map', 10, 2);
	
	