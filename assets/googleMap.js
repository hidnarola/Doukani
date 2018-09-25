function initAutocomplete() {

    $('[data-type="googleMap"]').each(function () {

        var currentThis = $(this);
        var latestPosition = {lat: $(this).data('lat'), lng: $(this).data('lang')};
        var map = new google.maps.Map(document.getElementById($(this).data('map_id')), {
            center: latestPosition,
            zoom: (typeof $(this).data('zoom') !== 'undefined' ? $(this).data('zoom') : 10),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        });

        new google.maps.Marker({
            position: latestPosition,
            map: map,
            label: '',
            title: '',
        });

        var input = document.getElementById($(this).data('input_id'));

        var searchBox = new google.maps.places.SearchBox(input);
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });
       
        var markers = [];
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }

            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {

                markers.push(new google.maps.Marker({
                    map: map,
                    title: '',
                    position: place.geometry.location,
                    label: '',
                }));
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                $('[data-type="' + currentThis.data('latitude') + '"]').val(place.geometry.location.lat());
                $('[data-type="' + currentThis.data('longitude') + '"]').val(place.geometry.location.lng());
            });
            map.fitBounds(bounds);
        });
        
        google.maps.event.addDomListener(window, 'resize', function() {            
            var center = map.getCenter();
            map.setCenter(center);
        });
        google.maps.event.trigger(map, "resize");
        
    });
}

$(document).ready(function () {
    $(document).on('change', '[data-type="reloadMap"]', initAutocomplete);
});