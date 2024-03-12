<?php

// Weather api key 
$weather_key = get_option('ww_key');

// Wather location
$weather_maps_key = get_option('ww_maps_key');

// Weather text color 
$weather_text_color = get_option('ww_text_color');

// Weather background color 
$weather_background_color = get_option('ww_background_color');

// validate & save weather 
if (isset($_POST['ww_key']) || isset($_POST['ww_maps_key'])) {
	$api_key = sanitize_text_field($_POST['ww_key']);
	$maps_key = sanitize_text_field($_POST['ww_maps_key']);

	$weather_key = $api_key;
	$weather_maps_key = $maps_key;
	update_option('ww_key', $api_key);
	update_option('ww_maps_key', $maps_key);

?>
	<div class="notice notice-success">
		<p>Weather general widget settings are updated.</p>
	</div>
<?php
}

// Weather widget style settings
if (isset($_POST['ww_text_color']) || isset($_POST['ww_background_color'])) {
	$text_color = sanitize_hex_color($_POST['ww_text_color']);
	$background_color = sanitize_hex_color(($_POST['ww_background_color']));

	$weather_text_color = $text_color;
	$weather_background_color = $background_color;

	update_option('ww_text_color', $text_color);
	update_option('ww_background_color', $background_color);
?>
	<div class="notice notice-success">
		<p>Weather widget style settings are updated.</p>
	</div>
<?php
}
?>

<?php if (!$weather_key) {
	echo '<div class="notice notice-error"><p>OpenWeather API ID not found. </p></div>';
}
if(!$weather_maps_key) {
	echo '<div class="notice notice-error"><p>Google maps API key not found. </p></div>';
}
?>


<div class="wrap">
	<h1 class="wp-heading-inline">Weather Widget</h1>
	<hr class="wp-header-end">

	<h3 class="wp-heading-inline">General settings</h3>

	<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">

		<table class="form-table">
			<tr>
				<th><label for="ww_key">OpenWeather API ID*</label></th>
				<td>
					<input type="text" name="ww_key" class="regular-text" id="ww_key" value="<?php echo esc_attr($weather_key ?: ''); ?>" pattern="[a-z0-9]{32}" title="Please enter a 32-character string containing only lowercase letters and numbers" required />
					<p class="description">Please go to <a href="https://openweathermap.org/price" target="_blank">https://openweathermap.org/price</a> & pick your subscription</p>
				</td>
			</tr>
			<tr>
				<th><label for="ww_maps_key">Google Maps Key*</label></th>
				<td>
					<input type="text" name="ww_maps_key" class="regular-text" id="ww_maps_key" value="<?php echo esc_attr($weather_maps_key ?: ''); ?>" required />
					<p class="description">In order to display user location on a widget you need to set up Google Maps API Key</p>
				</td>
			</tr>
			<tr>
				<th class="ww-py-0"></th>
				<td class="ww-py-0">
					<p class="ww-py-0 submit">
						<input type="submit" name="ww_general_settings_submit" id="ww_general_settings_submit" class="button button-primary" value="Save WW general settings" />
					</p>
				</td>
			</tr>
		</table>

	</form>

	<h3 class="wp-header-inline">Style settings</h3>
	<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
		<table class="form-table">
			<tr>
				<th><label for="ww_text_color">Pick text color</label></th>
				<td>
					<input id="ww_text_color" name="ww_text_color" type="color" class="regular-text" value="<?php echo esc_attr($weather_text_color ?: '#000000'); ?>">
				</td>
			</tr>
			<tr>
				<th><label for="ww_background_color">Pick background color</label></th>
				<td>
					<input id="ww_background_color" name="ww_background_color" type="color" class="regular-text" value="<?php echo esc_attr($weather_background_color ?: '#ffffff'); ?>">
				</td>
			</tr>
			<tr>
				<th class="ww-py-0"></th>
				<td class="ww-py-0">
					<p class="ww-py-0 submit">
						<input type="submit" name="ww_style_settings_submit" id="ww_style_settings_submit" class="button button-primary" value="Save WW style settings" />
					</p>
				</td>
			</tr>
		</table>
	</form>
</div>