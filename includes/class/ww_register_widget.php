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
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        echo '<div class="weather-widget">';
        if (!$weather_data) {
            echo '<div class="temperature">No weather data</div>';
            echo '<div class="description">Please check plugin settings</div>';
        } else {
            echo '<div class="temperature">' . round($weather_data->main->temp - 273.15) . '°C</div>';
            //echo '<div class="location">New York, USA</div>';
            echo '<div class="location">' . $weather_data->weather[0]->main . '</div>';
            // echo '<div class="description"><b>MIN: </b>' . round($weather_data->main->temp_min - 273.15) .  '°C <b>MAX: </b> ' . round($weather_data->main->temp_max - 273.15) . '°C </div>'; 
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
        //var_dump($ww_key); 
        $lat = '43.32472';
        $lng = '21.90333';
        if ($ww_key) {
            // Make OpenWeather Api request if api key provided
            $weather_data = wp_remote_get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lng . '&appid=' . $ww_key);
            if (is_wp_error($weather_data)) {
                $weather_data = null;
            } else {
                $weather_data = wp_remote_retrieve_body($weather_data);
                $weather_data = json_decode($weather_data);
            }
        }
        return $weather_data;
    }
}
