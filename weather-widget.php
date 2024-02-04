<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Weather Widget
 * Description:       Adds weather widget to page header or footer based on user browser location
 * Plugin URI:        
 * Author:            Sanja Budic
 * Author URI:       
 * Version:           1.0.0
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       weather-widget
 */

/**
 * Exit if entering directly.
 */
if (!defined('ABSPATH')) {
    exit;
}

class WPWeatherWidget
{


    /**
     * Class constructor
     */

    private function __construct()
    {
        

    }

    /**
     * Initializes a singleton instance.
     *
     * @return \WPWeatherWidget
     */
    public static function init()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }
}

/**
 * Initialize the main plugin.
 *
 * @return \WPWeatherWidget
 */
function location_weather_widget()
{
    return WPWeatherWidget::init();
}

/**
 * Launch the plugin.
 *
 * @param object The plugin object.
 */
if (!(is_plugin_active('wp-weather-widget/weather-widget.php') || is_plugin_active_for_network('wp-weather-widget/weather-widget.php'))) {
    location_weather_widget();
}
