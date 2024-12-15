(function($) {
    'use strict';

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/osm_locations_widget.default', function($scope) {
            var $widget = $scope.find('.elementor-osm-locations-widget');
            var $mapContainer = $widget.find('#osm-map');
            var $locationItems = $widget.find('.location-item');
            var map, markers = [];

            function initMap() {
                map = L.map('osm-map').setView([0, 0], 2);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            }

            function addMarkers() {
                $locationItems.each(function() {
                    var lat = $(this).data('lat');
                    var lng = $(this).data('lng');
                    var name = $(this).find('h3').text();
                    var marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(name);
                    markers.push(marker);
                });
            }

            function fitMapToBounds() {
                var group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }

            function updateMap(lat, lng) {
                map.setView([lat, lng], 15);
                markers.forEach(function(marker) {
                    if (marker.getLatLng().lat == lat && marker.getLatLng().lng == lng) {
                        marker.openPopup();
                    }
                });
            }

            $locationItems.on('click', function() {
                var lat = $(this).data('lat');
                var lng = $(this).data('lng');
                updateMap(lat, lng);
                $locationItems.removeClass('active');
                $(this).addClass('active');
            });

            initMap();
            addMarkers();
            fitMapToBounds();

            // Initialize with the first location
            if ($locationItems.length > 0) {
                $locationItems.first().trigger('click');
            }
        });
    });
})(jQuery);