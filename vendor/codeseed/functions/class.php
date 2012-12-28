<?php
/**
 * change underscore notation to camlecase notation
 */
function under_to_camel($filename) {
	$result = str_replace('_', ' ', $filename);
	$result = ucwords($result);
	return str_replace(' ', '', $result);
}

/**
 * change camelcase notation to underscore notation
 */
function camel_to_under($classname) {
	$arr = str_split($classname);
	$arr[0] = strtolower($arr[0]);
	$result = '';
	foreach($arr as $el) {
		if ($el >= 'A' and $el <= 'Z') {
			$result .= '_' . strtolower($el);
		} else {
			$result .= $el;
		}
	}
	return $result;
}

// get object property recursively
function get_object_property($obj, $props = array()) {
	if (empty($obj) || empty($props)) {
		return null;
	}

	if (!is_array($props)) {
		$props = array($props);
	}

	foreach($props as $prop) {
		if (is_object($obj) && property_exists($obj, $prop)) {
			$obj = $obj->$prop;
		} else {
			return null;
		}
	}
	return $obj;
}

