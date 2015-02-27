# CMB2 Field Type: Google Maps

## Description

Google Maps field type for [CMB2](https://github.com/WebDevStudios/CMB2).

The `pw_map` field stores the latitude/longitude values which you can then use to display a map in your theme.

## Installation

You can install this field type as you would a WordPress plugin:

1. Download the plugin
2. Place the plugin folder in your `/wp-content/plugins/` directory
3. Activate the plugin in the Plugin dashboard

## Usage

### `pw_map`

Save a location on a map. Example:

```php
array(
	'name' => 'Location',
	'desc' => 'Drag the marker to set the exact location',
	'id' => $prefix . 'location',
	'type' => 'pw_map',
	// 'split_values' => true, // Save latitude and longitude as two separate fields
),
```

#### Extra Parameters:

* `split_values` Save the latitude/longitude values into two custom fields, they will be stored as `$id . '_latitude'` and `$id . '_longitude'`.

## Screenshot

![Image](screenshot-1.png?raw=true)