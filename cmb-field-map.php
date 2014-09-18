<?php
/*
Plugin Name: CMB Field Type: Google Maps
Plugin URI: https://github.com/mustardBees/cmb_field_map
Description: Google Maps field type for Custom Metaboxes and Fields for WordPress.
Version: 2.0.3
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+
*/

// Useful global constants
define( 'PW_GOOGLE_MAPS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Render field
 */
function pw_map_field( $field, $meta ) {
	wp_enqueue_script( 'pw_google_maps_api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places', array(), null );
	wp_enqueue_script( 'pw_google_maps_init', PW_GOOGLE_MAPS_URL . 'js/script.js', array( 'pw_google_maps_api' ), null );
	wp_enqueue_style( 'pw_google_maps_css', PW_GOOGLE_MAPS_URL . 'css/style.css', array(), null );

	echo '<input type="text" class="large-text map-search" id="' . $field->args( 'id' ) . '" />';
	echo '<div class="map"></div>';
	echo '<input type="hidden" class="latitude" name="' . $field->args( 'id' ) . '[latitude]" value="' . ( isset( $meta['latitude'] ) ? $meta['latitude'] : '' ) . '" />';
	echo '<input type="hidden" class="longitude" name="' . $field->args( 'id' ) . '[longitude]" value="' . ( isset( $meta['longitude'] ) ? $meta['longitude'] : '' ) . '" />';

	$desc = $field->args('desc');
	if ( ! empty( $desc ) ) echo '<p class="cmb2-metabox-description">' . $desc . '</p>';
}
add_filter( 'cmb2_render_pw_map', 'pw_map_field', 10, 2 );

/**
 * Split latitude/longitude values into two meta fields
 */
function pw_map_sanitise( $meta_value, $field ) {
	$latitude = $meta_value['latitude'];
	$longitude = $meta_value['longitude'];

	if ( ! empty( $latitude ) ) {
		update_post_meta( get_the_ID(), $field['id'] . '_latitude', $latitude );
	}

	if ( ! empty( $longitude ) ) {
		update_post_meta( get_the_ID(), $field['id'] . '_longitude', $longitude );
	}

	return $meta_value;
}
