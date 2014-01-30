# CMB Field Type: Google Maps

## Description

Google Maps field type for [Custom Metaboxes and Fields for WordPress](https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress).

The `pw_map` field stores the latitude/longitude values which you can then use to display a map in your theme.

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