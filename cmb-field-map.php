<?php
/*
Plugin Name: CMB2 Field Type: Google Maps
Plugin URI: https://github.com/mustardBees/cmb_field_map
GitHub Plugin URI: https://github.com/mustardBees/cmb_field_map
Description: Google Maps field type for CMB2.
Version: 2.3.0
Author: Phil Wylie
Author URI: https://www.philwylie.co.uk/
License: GPLv2+
*/

/**
 * Class PW_CMB2_Field_Google_Maps.
 */
class PW_CMB2_Field_Google_Maps {

	/**
	 * Current version number.
	 */
	const VERSION = '2.3.0';

	/**
	 * Initialize the plugin by hooking into CMB2.
	 */
	public function __construct() {
		add_filter( 'cmb2_render_pw_map', array( $this, 'render_pw_map' ), 10, 5 );
		add_filter( 'cmb2_sanitize_pw_map', array( $this, 'sanitize_pw_map' ), 10, 4 );
		add_filter( 'pw_google_api_key', array( $this, 'google_api_key_constant' ) );
	}

	/**
	 * Render field.
	 */
	public function render_pw_map( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

		// Get the Google API key from the field's parameters.
		$api_key = $field->args( 'api_key' );

		// Allow a custom hook to specify the key.
		$api_key = apply_filters( 'pw_google_api_key', $api_key );

		$this->setup_admin_scripts( $api_key );

		echo '<input type="text" class="large-text pw-map-search" id="' . $field->args( 'id' ) . '" />';

		echo '<div class="pw-map"></div>';

		echo '<button type="button" class="button pw-map-reset">Reset Location</button>';

		$field_type_object->_desc( true, true );

		echo $field_type_object->input( array(
			'type'  => 'hidden',
			'name'  => $field->args( '_name' ) . '[latitude]',
			'value' => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'id'    => $field->args( 'id' ) . '_latitude',
			'class' => 'pw-map-latitude',
			'desc'  => '',
		) );

		echo $field_type_object->input( array(
			'type'  => 'hidden',
			'name'  => $field->args( '_name' ) . '[longitude]',
			'value' => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'id'    => $field->args( 'id' ) . '_longitude',
			'class' => 'pw-map-longitude',
			'desc'  => '',
		) );
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields.
	 */
	public function sanitize_pw_map( $override_value, $value, $object_id, $field_args ) {
		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( ! empty( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', sanitize_text_field( ( (float) $value['latitude'] ) ) );
			}

			if ( ! empty( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', sanitize_text_field( (float) $value['longitude'] ) );
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function setup_admin_scripts($api_key) {
		wp_register_script( 'pw-google-maps-api', "https://maps.googleapis.com/maps/api/js?key={$api_key}&libraries=places", null, null );
		wp_enqueue_script( 'pw-google-maps', plugins_url( 'js/script.js', __FILE__ ), array( 'pw-google-maps-api', 'jquery' ), self::VERSION );
		wp_enqueue_style( 'pw-google-maps', plugins_url( 'css/style.css', __FILE__ ), array(), self::VERSION );
		wp_localize_script( 'pw-google-maps', 'pw_google_maps', array(
			'default_zoom'     => apply_filters( 'pw_map_default_zoom', 5 ),
			'default_lat'      => apply_filters( 'pw_map_default_lat', '54.800685' ),
			'default_lng'      => apply_filters( 'pw_map_default_lng', '-4.130859' ),
			'marker_zoom'      => apply_filters( 'pw_map_marker_zoom', 15 ),
			'marker_draggable' => apply_filters( 'pw_map_marker_draggable', 'true' ),
			'marker_title'     => apply_filters( 'pw_map_marker_title', 'Drag to set the exact location' )
		) );
	}

	/**
	 * Default filter to return a Google API key constant if defined.
	 */
	public function google_api_key_constant( $google_api_key = null ) {

		// Allow the field's 'api_key' parameter or a custom hook to take precedence.
		if ( ! empty( $google_api_key ) ) {
			return $google_api_key;
		}

		if ( defined( 'PW_GOOGLE_API_KEY' ) ) {
			$google_api_key = PW_GOOGLE_API_KEY;
		}

		return $google_api_key;
	}
}
$pw_cmb2_field_google_maps = new PW_CMB2_Field_Google_Maps();
