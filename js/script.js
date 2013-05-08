jQuery(document).ready(function ($) {
	if($('#map_canvas').length != 0) {
		var latitude = $("#latitude").val();
		var longitude = $("#longitude").val();
		var zoom = 5;
		
		if(latitude.length > 0 && longitude.length > 0) {
			latlng = new google.maps.LatLng(latitude, longitude);
			zoom = 17;
		} else {
			latlng = new google.maps.LatLng(54.800685, -4.130859);
		}
		
		var mapOptions = {
			center: latlng,
			zoom: zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map($('#map_canvas').get(0), mapOptions);

		var input = $('#google_maps_search input').get(0);
		var autocomplete = new google.maps.places.Autocomplete(input);

		autocomplete.bindTo('bounds', map);

		var marker = new google.maps.Marker({
			map: map,
			draggable: true
		});

		if(latitude.length > 0 && longitude.length > 0) {
			marker.setPosition(latlng);
		}

		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}

			marker.setPosition(place.geometry.location);
		
			$("#latitude").val(place.geometry.location.lat());
			$("#longitude").val(place.geometry.location.lng());
		});

		google.maps.event.addListener(marker, 'drag', function() {
			$('#latitude').val(marker.getPosition().lat());
			$('#longitude').val(marker.getPosition().lng());
		});
		
		$(input).keypress(function(event) {
			if(event.keyCode == 13) {
				event.preventDefault();
			}
		});
	}
});