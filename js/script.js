(function ($) {

    var maps = [];

    $('.cmb-type-pw-map').each(function() {
        setup_pw_map($(this));
    });

    function setup_pw_map(thisObj) {
        var searchInput = $('.pw-map-search', thisObj).get(0);
        var mapCanvas = $('.pw-map', thisObj).get(0);
        var latitude = $('.pw-map-latitude', thisObj);
        var longitude = $('.pw-map-longitude', thisObj);
        var latLng = new google.maps.LatLng(54.800685, -4.130859);
        var zoom = 5;

        // If we have saved values, let's set the position and zoom level
        if (latitude.val().length > 0 && longitude.val().length > 0) {
            latLng = new google.maps.LatLng(latitude.val(), longitude.val());
            zoom = 17;
        }

        // Map
        var mapOptions = {
            center: latLng,
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);

        // Marker
        var markerOptions = {
            map: map,
            draggable: true,
            title: 'Drag to set the exact location'
        };
        var marker = new google.maps.Marker(markerOptions);

        if (latitude.val().length > 0 && longitude.val().length > 0) {
            marker.setPosition(latLng);
        }

        // Search
        var autocomplete = new google.maps.places.Autocomplete(searchInput);
        autocomplete.bindTo('bounds', map);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            marker.setPosition(place.geometry.location);

            latitude.val(place.geometry.location.lat());
            longitude.val(place.geometry.location.lng());
        });

        $(searchInput).keypress(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        // Allow marker to be repositioned
        google.maps.event.addListener(marker, 'drag', function() {
            latitude.val(marker.getPosition().lat());
            longitude.val(marker.getPosition().lng());
        });

        maps.push(map);
    }

    // Resize map when meta box is opened
    postboxes.pbshow = function() {
        var arrayLength = maps.length;
        for (var i = 0; i < arrayLength; i++) {
            var newlat = maps[i].getCenter();
            google.maps.event.trigger(maps[i], "resize");
            maps[i].setCenter(newlat);
        }
    };

    // When a new row is added, reinitialize Google Maps
    $('.cmb-repeatable-group').on('cmb2_add_row', function(event, newRow) {
        var groupWrap = $(newRow).closest('.cmb-repeatable-group');
        groupWrap.find('.cmb-type-pw-map').each(function() {
            setup_pw_map($(this));
        });
    });

}(jQuery));