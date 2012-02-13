<?php
function underscore_to_camelcase($filename) {
	$result = str_replace('_', ' ', $filename);
	$result = ucwords($result);
	return str_replace(' ', '', $result);
}

function camelcase_to_underscore($classname) {
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

// get value from object recursively
function get_object_property($obj, $props = array()) {
	if (empty($obj) || empty($props)) {
		return null;
	}

	if (!is_array($props)) {
		$props = array($props);
	}

	foreach($props as $prop) {
		if (property_exists($obj, $prop)) {
			$obj = $obj->$prop;
		} else {
			return null;
		}
	}
	return $obj;
}

