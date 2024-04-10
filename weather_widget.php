<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Weather Widget
 * Description:       Adds weather widget to page header or footer based on user browser location
 * Plugin URI:        
 * Author:            Sanja Budic
 * Author URI:       
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0 or higher 
 * License:           GPLv2 or later
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
require_once 'includes/class/ww_register_widget.php';
require_once 'includes/ajax/ajax_handler.php';


class WPWeatherWidget
{

    private static $instance;
    /**
     * Class constructor
     */

    private function __construct()
    {

        $settings = new WPWeatherWidgetSettings();
        if (is_admin()) {
            add_action('admin_menu', array($settings, 'add_admin_menu'));
        }
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'actionLinks']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'localize_ajax_url']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_font_awesome']);
        add_action('widgets_init', [$this, 'register_custom_widget']);
     
    }
        // Method to get the singleton instance
    public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
    }

    public function actionLinks(array $links)
    {
        return array_merge([
            'settings'    =>    '<a href="' . menu_page_url('ww_settings', false) . '">' . __('Settings', 'weather-widget') . '</a>'
        ], $links);
    }

    public function register_custom_widget()
    {
        register_widget('Custom_Weather_Widget');
    }
    // Enqueue the JavaScript file
    public function enqueue_custom_scripts()
    {
        wp_enqueue_script('custom-script', WPWW_URL . '/assets/js/get_location.js', array('jquery'), '1.0', true);
    }
    public function enqueue_font_awesome()
    {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');
    }
    // Localize the AJAX URL
    public function localize_ajax_url()
    {
        $google_maps_key = get_option('ww_maps_key');
        wp_localize_script('custom-script', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'google_maps_key' => $google_maps_key
        ));
    }

}


// Start the plugin
$weather_widget = WPWeatherWidget::getInstance();
