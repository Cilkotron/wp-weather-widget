<?php

// Weather api key 
$weather_key = get_option('ww_key');

// Wather location
$weather_maps_key = get_option('ww_maps_key');

// Weather transient
$weather_transient = get_option('ww_transient');

// Weather text color 
$weather_text_color = get_option('ww_text_color');

// Weather background color 
$weather_background_color = get_option('ww_background_color');

// Weather widget padding
$weather_padding = get_option('ww_padding');

// validate & save weather 
if (isset($_POST['ww_key']) || isset($_POST['ww_maps_key']) || isset($_POST['ww_transient'])) {
	$api_key = sanitize_text_field($_POST['ww_key']);
	$maps_key = sanitize_text_field($_POST['ww_maps_key']);
	$transient_expiration = (int) $_POST['ww_transient'];
	if (isset($_POST['ww_transient'])) {
		delete_transient('weather');
	}

	$weather_key = $api_key;
	$weather_maps_key = $maps_key;
	$weather_transient = $transient_expiration;
	update_option('ww_key', $api_key);
	update_option('ww_maps_key', $maps_key);
	update_option('ww_transient', $transient_expiration);

?>
	<div class="notice notice-success">
		<p>Weather general widget settings are updated.</p>
	</div>
<?php
}

// Weather widget style settings
if (
	isset($_POST['ww_text_color']) ||
	isset($_POST['ww_background_color']) ||
	isset($_POST['ww_padding_value_top']) ||
	isset($_POST['ww_padding_value_right']) ||
	isset($_POST['ww_padding_value_bottom']) ||
	isset($_POST['ww_padding_value_left']) ||
	isset($_POST['ww_padding_unit'])
) {
	$text_color = sanitize_hex_color($_POST['ww_text_color']);
	$background_color = sanitize_hex_color($_POST['ww_background_color']);
	$top = (float) $_POST['ww_padding_value_top'];
	$right = (float) $_POST['ww_padding_value_right'];
	$bottom = (float) $_POST['ww_padding_value_bottom'];
	$left = (float) $_POST['ww_padding_value_left'];
	$unit =  sanitize_text_field($_POST['ww_padding_unit']);
	$padding = array(
		'unit' => $unit,
		'top' => $top,
		'right' => $right,
		'bottom' => $bottom,
		'left' =>  $left
	);

	$weather_text_color = $text_color;
	$weather_background_color = $background_color;
	$weather_padding = $padding;

	update_option('ww_text_color', $text_color);
	update_option('ww_background_color', $background_color);
	update_option('ww_padding', $padding);
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
?>
<?php
if (!$weather_maps_key) {
	echo '<div class="notice notice-error"><p>Google maps API key not found. </p></div>';
} ?>
<?php
$weather_padding_top = 0;
$weather_padding_right = 0;
$weather_padding_bottom = 0;
$weather_padding_left = 0;
$weather_padding_unit = 'px';

if (is_array($weather_padding)) {
	$weather_padding_top = $weather_padding['top'];
	$weather_padding_right = $weather_padding['right'];
	$weather_padding_bottom = $weather_padding['bottom'];
	$weather_padding_left = $weather_padding['left'];
	$weather_padding_unit = $weather_padding['unit'];
}


//Get the active tab from the $_GET param
$default_tab = 'general';
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>


<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
	<!-- Print the page title -->
	<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	<!-- Here are our tabs -->
	<nav class="nav-tab-wrapper">
		<a href="?page=ww_settings" class="nav-tab <?php if ($tab === 'general') : ?>nav-tab-active<?php endif; ?>">General Settings</a>
		<a href="?page=ww_settings&tab=style" class="nav-tab <?php if ($tab === 'style') : ?>nav-tab-active<?php endif; ?>">Style Settings</a>
	</nav>

	<div class="tab-content">
		<?php switch ($tab):
			case 'style':
				echo
				'<div class="wrap">
					<h3 class="wp-header-inline">Style settings</h3>
					<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">
						<table class="form-table">
							<tr>
								<th><label for="ww_text_color">Pick text color</label></th>
								<td>
									<input id="ww_text_color" name="ww_text_color" type="color" class="regular-text" value="' . esc_attr($weather_text_color ?: '#000000') . '">
								</td>
							</tr>
							<tr>
								<th><label for="ww_background_color">Pick background color</label></th>
								<td>
									<input id="ww_background_color" name="ww_background_color" type="color" class="regular-text" value="' . esc_attr($weather_background_color ?: '#ffffff') . '">
								</td>
							</tr>
							<tr>
								<th><label for="ww_padding">Set widget padding</label></th>
								<td>
									<label for="ww_padding_value_top">T</label>
									<input id="ww_padding_value_top" class="small-text" name="ww_padding_value_top" type="number" step="0.1" min="0" value="' . $weather_padding_top . '">
									<label for="ww_padding_value_right">R</label>
									<input id="ww_padding_value_right" class="small-text" name="ww_padding_value_right" type="number" step="0.1" min="0" value="' . $weather_padding_right . '">
									<label for="ww_padding_value_bottom">B</label>
									<input id="ww_padding_value_bottom" class="small-text" name="ww_padding_value_bottom" type="number" step="0.1" min="0" value="' . $weather_padding_bottom . '">
									<label for="ww_padding_value_left">L</label>
									<input id="ww_padding_value_left" class="small-text" name="ww_padding_value_left" type="number" step="0.1" min="0" value="' . $weather_padding_left . '">

									<select id="ww_padding_unit" name="ww_padding_unit">
										<option value="px" ' . selected($weather_padding_unit, 'px', false ) . '>px</option>
										<option value="em" ' . selected($weather_padding_unit, 'em', false ) . '>em</option>
										<option value="rem" ' . selected($weather_padding_unit, 'rem', false ) . '>rem</option>
									</select>
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
				</div>';
				break;
			case 'general':
				echo '
				<div class="wrap">
					<h3 class="wp-heading-inline">General settings</h3>

					<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">

						<table class="form-table">
							<tr>
								<th><label for="ww_key">OpenWeather API ID*</label></th>
								<td>
									<input type="text" name="ww_key" class="regular-text" id="ww_key" value="' . esc_attr($weather_key ?: '') . '" pattern="[a-z0-9]{32}" title="Please enter a 32-character string containing only lowercase letters and numbers" required />
									<p class="description">Please go to <a href="https://openweathermap.org/price" target="_blank">https://openweathermap.org/price</a> & pick your subscription</p>
								</td>
							</tr>
							<tr>
								<th><label for="ww_maps_key">Google Maps Key*</label></th>
								<td>
									<input type="text" name="ww_maps_key" class="regular-text" id="ww_maps_key" value="' . esc_attr($weather_maps_key ?: '') . '" required />
									<p class="description">In order to display user location on a widget you need to set up Google Maps API Key</p>
								</td>
							</tr>
							<tr>
								<th><label for="ww_transient">OpenWeather API transient</label></th>
								<td>
									<select id="ww_transient" name="ww_transient" class="regular-text">
										<option value="1" ' . selected($weather_transient, 1, false ) . '>1 hour</option>
										<option value="2" ' . selected($weather_transient, 2, false ) . '>2 hours</option>
										<option value="6" ' . selected($weather_transient, 6, false ) . '>6 hours</option>
										<option value="12" ' . selected($weather_transient, 12, false ) . '>12 hours</option>
										<option value="24" ' . selected($weather_transient, 24, false ) . '>24 hours</option>
									</select>
									<p class="description">Set up OpenWeather API transient to cut the costs</p>
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

				</div>
				';
				break;
		endswitch; ?>
	</div>
</div>