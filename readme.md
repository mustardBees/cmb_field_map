# CMB Field Type: Google Maps

## Description

Google Maps field type for [Custom Metaboxes and Fields for WordPress](https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress).

The `pw_map` field stores the latitude/longitude values which you can then use to display a map in your theme.

## Installation

You can install this field type as you would a WordPress plugin:

1. Download the plugin ([running an older version of CMB?](https://github.com/mustardBees/cmb_field_map/releases))
2. Place the plugin folder in your `/wp-content/plugins/` directory
3. Activate the plugin in the Plugin dashboard

Alternatively, you can place the plugin folder in with your theme/plugin. After you call CMB:

```php
require_once 'init.php';
```

Add another line to include the `cmb-field-map.php` file. Something like:

```php
require_once 'cmb_field_map/cmb-field-map.php';
```

## Usage

`pw_map` - Save a location on a map. Example:

```php
array(
	'name' => 'Location',
	'desc' => 'Drag the marker to set the exact location',
	'id' => $prefix . 'location',
	'type' => 'pw_map',
	'sanitization_cb' => 'pw_map_sanitise',
),
```

## Screenshot

![Image](screenshot-1.png?raw=true)