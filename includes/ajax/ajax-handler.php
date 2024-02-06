<?php

// Handle AJAX request to get user location
function get_user_location_callback()
{
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    if(isset($_POST['location'])) {
        $location = $_POST['location']; 
        update_option('user_location', $location); 
    }

    // Here you can do whatever you want with the latitude and longitude
    // For example, you can save it to the WordPress options table
    update_option('user_latitude', $latitude);
    update_option('user_longitude', $longitude);

    wp_die(); // This is required to terminate immediately and return a proper response
}
add_action('wp_ajax_get_user_location', 'get_user_location_callback');
add_action('wp_ajax_nopriv_get_user_location', 'get_user_location_callback'); // Allow non-logged-in users to access ajax request


