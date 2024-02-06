// get_location.js
document.addEventListener('DOMContentLoaded', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var nearestLocationName;
            if (ajax_object.google_maps_key) {
                // Send a request to the Google Maps Geocoding API
                var geocodingUrl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&key=' + ajax_object.google_maps_key;
                fetch(geocodingUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'OK') {
                            nearestLocationName = `${data.results[0].address_components[2].long_name}, ${data.results[0].address_components[4].short_name}`
                            console.log('Nearest Location: ' + nearestLocationName);
                            // Send location data to the server via AJAX
                            jQuery.ajax({
                                url: ajax_object.ajax_url,
                                type: 'POST',
                                data: {
                                    action: 'get_user_location',
                                    latitude: latitude,
                                    longitude: longitude,
                                    location: nearestLocationName,
                                },
                                success: function (response) {
                                    console.log('Location sent successfully.');
                                }
                            });

                        } else {
                            console.log('Error occurred while fetching location data.');
                        }
                    })
                    .catch(error => {
                        console.error('Error occurred:', error);
                    });
            } else {
                // Send location data to the server via AJAX
                jQuery.ajax({
                    url: ajax_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'get_user_location',
                        latitude: latitude,
                        longitude: longitude,
                    },
                    success: function (response) {
                        console.log('Location sent successfully.');
                    }
                });
            }
        });
    } else {
        console.log('Geolocation is not supported by this browser.');
    }
});








