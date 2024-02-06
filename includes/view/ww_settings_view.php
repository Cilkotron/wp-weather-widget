<?php

// Weather api key 
$weather_key = get_option('ww_key');

// Wather location
$weather_maps_key = get_option('ww_maps_key');


// validate & save weather 
if (isset($_POST['ww_key']) || isset($_POST['ww_maps_key'])) {
	$api_key = sanitize_text_field($_POST['ww_key']);
	$maps_key= sanitize_text_field($_POST['ww_maps_key']);

	if (is_wp_error($api_key)) {
		echo wp_kses('<div class="notice notice-error"><p>' . $api_key->get_error_message() . '</p></div>', 'post');
	} else {
		$weather_key = $api_key;
		$weather_maps_key = $maps_key;
		update_option('ww_key', $api_key);
		update_option('ww_maps_key', $maps_key);
?>
		<div class="notice notice-success">
			<p>Weather widget settings are updated.</p>
		</div>
<?php
	}
}
?>

<div class="wrap">
	<h1 class="wp-heading-inline">Weather Widget</h1>
	<hr class="wp-header-end">

	<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">

		<table class="form-table">
			<tr>
				<th><label for="ww_key">OpenWeather API ID</label></th>
				<td>
					<input type="text" name="ww_key" class="regular-text" id="ww_key" value="<?php echo esc_attr($weather_key ?: ''); ?>" />
					<p class="description">Go to https://openweathermap.org/price & subscribe for free</p>
				</td>
			</tr>
			<tr>
				<th><label for="ww_maps_key">Google Maps Key (optional)</label></th>
				<td>
					<input type="text" name="ww_maps_key" class="regular-text" id="ww_maps_key" value="<?php echo esc_attr($weather_maps_key ?: ''); ?>" />
					<p class="description">In order to display user location on a widget you need to set up Google Maps API Key</p>
				</td>
			</tr>
			<tr>
				<th class="ww-py-0"></th>
				<td class="ww-py-0">
					<p class="ww-py-0 submit">
						<input type="submit" name="ww_submit" id="ww_submit" class="button button-primary" value="Save Weather Widget settings" />
					</p>
				</td>
			</tr>
		</table>

	</form>
</div>