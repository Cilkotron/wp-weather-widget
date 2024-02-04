<?php

class WPWeatherWidgetSettings {

	function add_admin_menu() {
        add_menu_page(
            'Weather Widget Settings',
            'Weather Widget',
            'manage_options',
            'ww_settings',
            [$this, 'render_setting_page'],
            'dashicons-cloud', 
            30
        );
	}

	function render_setting_page() {
		require_once WPWW_DIR . '/includes/view/ww_settings_view.php';
	}
    
}