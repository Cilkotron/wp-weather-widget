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

define('WPWW_URL', plugin_dir_url(__FILE__));
define('WPWW_DIR', plugin_dir_path(__FILE__));

require_once 'includes/class/ww_settings_class.php';

class WPWeatherWidget
{
    /**
     * Class constructor
     */

    public function __construct()
    {

        $settings = new WPWeatherWidgetSettings();
        if (is_admin()) {
            add_action('admin_menu', array($settings, 'add_admin_menu'));
        }
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'actionLinks']);
    }

    public function actionLinks(array $links)
    {
        var_dump("Inside method");
        return array_merge([
            'settings'    =>    '<a href="' . menu_page_url('ww_settings', false) . '">' . __('Settings', 'weather-widget') . '</a>'
        ], $links);
    }
}


// Start the plugin
$weather_widget = new WPWeatherWidget;

register_activation_hook(__FILE__, [$weather_widget, 'enablePlugin']);
