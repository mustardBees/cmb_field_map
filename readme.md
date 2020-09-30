# CMB2 Field Type: Google Maps

## Description

Google Maps field type for [CMB2](https://github.com/WebDevStudios/CMB2).

The `pw_map` field stores the latitude/longitude values which you can then use to display a map in your theme.

## Installation

You can install this field type as you would a WordPress plugin:

1. Download the plugin
2. Place the plugin folder in your `/wp-content/plugins/` directory
3. Activate the plugin in the Plugin dashboard

Or you can use WP-CLI to install from GitHub.

```
wp plugin install --activate https://github.com/mustardBees/cmb_field_map/archive/master.zip
```

## Google API Key

You'll need to [generate a Google API key](https://cloud.google.com/maps-platform/#get-started) with both "Maps JavaScript API" and "Places API" enabled.

There are three options for specifying the Google API key:

1. [Pass the `api_key` field parameter](https://gist.github.com/mustardBees/11d42baed64d85cd8e40a4bbde6a4999). Not recommended as you'll have to do this for each map field.
2. [Define the key in your `wp-config.php` file](https://gist.github.com/mustardBees/ed763f9daa8be25821420abd4a5de7cd).
3. [Hook in your own key retrieval logic using the `pw_google_api_key` filter](https://gist.github.com/mustardBees/e9e3805a64c8a211f749f38d7cc5e4cb).   

## Usage

### `pw_map`

Save a location on a map. Example:

```php
$cmb->add_field( array(
	'name' => 'Location',
	'desc' => 'Drag the marker to set the exact location',
	'id' => $prefix . 'location',
	'type' => 'pw_map',
	// 'split_values' => true, // Save latitude and longitude as two separate fields
) );
```

#### Extra Parameters:

* `split_values` Save the latitude/longitude values into two custom fields, they will be stored as `$id . '_latitude'` and `$id . '_longitude'`.

## Screenshot

![Image](screenshot-1.png?raw=true)
