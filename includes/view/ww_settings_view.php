<?php

// Weather api key 
$weather_key = get_option('ww_key');

// Wather location
$weather_location = get_option('ww_location');


// validate & save weather 
if (isset($_POST['ww_key']) || isset($_POST['ww_location'])) {
	$key = sanitize_text_field($_POST['ww_key']);
	$location = sanitize_text_field($_POST['ww_location']);

	if (is_wp_error($key)) {
		echo wp_kses('<div class="notice notice-error"><p>' . $key->get_error_message() . '</p></div>', 'post');
	} else {
		$weather_key = $key;
		$weather_location = $location;
		update_option('ww_key', $key);
		update_option('ww_location', $location);
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
				<th><label for="ww_location">Waether Location</label></th>
				<td>
					<input type="text" name="ww_location" class="regular-text" id="ww_location" value="<?php echo esc_attr($weather_location ?: ''); ?>" />
					<p class="description">Add your location</p>
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