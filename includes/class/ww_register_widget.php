<?php

class Custom_Weather_Widget extends WP_Widget
{
    // Widget constructor
    public function __construct()
    {
        parent::__construct(
            'custom_weather_widget', // Widget ID
            'Custom Weather Widget',  // Widget name
            array(
                'description' => 'Weather widget',
            )
        );
        wp_enqueue_style('ww-style', WPWW_URL . 'assets/css/widget.css', [], '1.0');
    }

    // Widget output
    public function widget($args, $instance)
    {
        $weather_data = $this->get_weather_data();
        $location = get_option('user_location'); 
        $timezone = get_option('timezone_string'); 
        $text_color = get_option('ww_text_color') ?: '#000000'; 
        $background_color = get_option('ww_background_color') ?: '#ffffff'; 
        if(!isset($location)) {
            $user_location = $timezone; 
        } else {
            $user_location = $location; 
        } 
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        echo '<div class="weather-widget" style="color: ' . $text_color . '; background-color: ' . $background_color . '">';
        if (!$weather_data) {
            echo '<div class="temperature">No weather data</div>';
            echo '<div class="description">Please check plugin settings</div>';
        } else {
            echo '<div class="location">' . $user_location . '</div>';
            echo '<div class="temperature">' . round($weather_data->main->temp - 273.15) . '°C </div>';
            if($weather_data->weather[0]->main == 'Clouds') {
                echo '<div class="main-weather"><i class="fas fa-cloud"></i> ' . $weather_data->weather[0]->main . '</div>';
            } elseif($weather_data->weather[0]->main == 'Clear') {
                echo '<div class="main-weather"><i class="fas fa-sun"></i> ' . $weather_data->weather[0]->main . '</div>';
            } elseif($weather_data->weather[0]->main == 'Rain') {
                echo '<div class="main-weather"><i class="fas fa-cloud-rain"></i> ' . $weather_data->weather[0]->main . '</div>';
            } else {
                echo '<div class="main-weather">' . $weather_data->weather[0]->main;
            }
            echo '<span class="description">min:' . round($weather_data->main->temp_min - 273.15) .  '°C max:' . round($weather_data->main->temp_max - 273.15) . '°C </span>';
     
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    // Widget form
    public function form($instance)
    {
        // Widget form code here
    }

    // Widget update
    public function update($new_instance, $old_instance)
    {
        // Widget update code here
    }
    public function get_weather_data()
    {
        $ww_key = get_option('ww_key');
        $lat = get_option('user_latitude'); 
        $lng = get_option('user_longitude');
        if(!$ww_key) {
            return; 
        }
        if (isset($ww_key)) {
            // Make OpenWeather Api request if api key provided
            $weather_data = wp_remote_get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lng . '&appid=' . $ww_key);
            if (is_wp_error($weather_data)) {
                $weather_data = null;
            } else {
                $weather_data = wp_remote_retrieve_body($weather_data);
                $weather_data = json_decode($weather_data);
            }
            return $weather_data;
        }
        
    }
}

















