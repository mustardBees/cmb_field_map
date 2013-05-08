<?php
/*
Plugin Name: CMB Field Type: Google Maps
Plugin URI: https://github.com/mustardBees/cmb_field_map
Description: Google Maps field type for Custom Metaboxes and Fields for WordPress
Version: 1.1.1
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+
*/

// Useful global constants
define( 'PW_GOOGLE_MAPS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Render field
 */
function pw_google_maps_field( $field, $meta ) {
	wp_enqueue_script( 'pw_google_maps_api', 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', array(), null );
	wp_enqueue_script( 'pw_google_maps_init', PW_GOOGLE_MAPS_URL . 'js/script.js', array( 'pw_google_maps_api' ), null );
	wp_enqueue_style( 'pw_google_maps_css', PW_GOOGLE_MAPS_URL . 'css/style.css', array(), null );
	
	echo '<div id="google_maps_search">';
	echo '	<input type="text" id="' . $field['id'] . '" />';
	echo '</div>';
	echo '<input type="hidden" id="latitude" name="' . $field['id'] . '[latitude]" value="' . ( isset( $meta['latitude'] ) ? $meta['latitude'] : '' ) . '" />';
	echo '<input type="hidden" id="longitude" name="' . $field['id'] . '[longitude]" value="' . ( isset( $meta['longitude'] ) ? $meta['longitude'] : '' ) . '" />';
	echo '<div id="map_canvas"></div>';
	
	if ( ! empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';
}
add_filter( 'cmb_render_pw_google_map', 'pw_google_maps_field', 10, 2 );

/**
 * Split latitude/longitude values into two meta fields
 */
function pw_google_maps_field_validation( $new, $post_id, $field ) {
	$latitude = $new['latitude'];
	$longitude = $new['longitude'];
	
	if ( '' !== $latitude ) {
		update_post_meta( $post_id, $field['id'] . '_latitude', $latitude );
	}
	
	if ( '' !== $longitude ) {
		update_post_meta( $post_id, $field['id'] . '_longitude', $longitude );
	}
	
	return $new;
}
add_filter( 'cmb_validate_pw_google_map', 'pw_google_maps_field_validation', 10, 3 );