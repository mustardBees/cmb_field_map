(function( $ ) {
	'use strict';

	var maps = [];

	$( '.cmb-type-pw-map' ).each( function() {
		initializeMap( $( this ) );
	});

	function initializeMap( mapInstance ) {
		var searchInput = mapInstance.find( '.pw-map-search' );
		var mapCanvas = mapInstance.find( '.pw-map' );
		var latitude = mapInstance.find( '.pw-map-latitude' );
		var longitude = mapInstance.find( '.pw-map-longitude' );
		var resetBtn = mapInstance.find('.pw-map-reset');
		var defaultLatLng = new google.maps.LatLng( pw_google_maps.default_lat, pw_google_maps.default_lng );
		var defaultZoom = Number( pw_google_maps.default_zoom );
		var latLng = defaultLatLng;
		var zoom = defaultZoom;

		// If we have saved values, let's set the position and zoom level
		if ( latitude.val().length > 0 && longitude.val().length > 0 ) {
			latLng = new google.maps.LatLng( latitude.val(), longitude.val() );
			zoom = Number( pw_google_maps.marker_zoom );
		}

		// Map
		var mapOptions = {
			center: latLng,
			zoom: zoom
		};
		var map = new google.maps.Map( mapCanvas[0], mapOptions );

		// Marker
		var markerOptions = {
			map: map,
			draggable: ( pw_google_maps.marker_draggable === "true" ),
			title: pw_google_maps.marker_title
		};
		var marker = new google.maps.Marker( markerOptions );

		if ( latitude.length && latitude.val().length > 0 && longitude.length && longitude.val().length > 0 ) {
			marker.setPosition( latLng );
		}

		// Search
		var autocomplete = new google.maps.places.Autocomplete( searchInput[0] );
		autocomplete.bindTo( 'bounds', map );

		google.maps.event.addListener( autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			if ( ! place.geometry ) {
				return;
			}

			if ( place.geometry.viewport ) {
				map.fitBounds( place.geometry.viewport );
			} else {
				map.setCenter( place.geometry.location );
				map.setZoom( Number( pw_google_maps.marker_zoom ) );
			}

			// Ensure marker is on the map (it may have been removed by reset)
			if ( ! marker.getMap() ) {
				marker.setMap( map );
			}
			marker.setPosition( place.geometry.location );

			latitude.val( place.geometry.location.lat() );
			longitude.val( place.geometry.location.lng() );
		});

		$( searchInput ).keypress( function( event ) {
			if ( 13 === event.keyCode ) {
				event.preventDefault();
			}
		});

		// Allow marker to be repositioned
		google.maps.event.addListener( marker, 'drag', function() {
			latitude.val( marker.getPosition().lat() );
			longitude.val( marker.getPosition().lng() );
		});

		// Reset button handler
		resetBtn.on('click', function(e) {
			e.preventDefault();
			marker.setMap(null);
			map.setCenter(defaultLatLng);
			map.setZoom(defaultZoom);
			latitude.val('');
			longitude.val('');
		});

		maps.push( map );
	}

	// Resize map when meta box is opened
	if ( typeof postboxes !== 'undefined' ) {
		postboxes.pbshow = function () {
			var arrayLength = maps.length;
			for (var i = 0; i < arrayLength; i++) {
				var mapCenter = maps[i].getCenter();
				google.maps.event.trigger(maps[i], 'resize');
				maps[i].setCenter(mapCenter);
			}
		};
	}

	// When a new row in a group is added, reinitialize Google Maps
	$( '.cmb-repeatable-group' ).on( 'cmb2_add_row', function( event, newRow ) {
		var groupWrap = $( newRow ).closest( '.cmb-repeatable-group' );
		groupWrap.find( '.cmb-row.cmb-repeatable-grouping' ).each( function() {
			initializeMap( $( this ) );
		});
	});

})( jQuery );
