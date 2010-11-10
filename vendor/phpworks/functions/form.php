<?php
function get_value($obj, $props = array()) {
	global $flash;

	if (empty($obj) || empty($props)) {
		return null;
	}

	if (!is_array($props)) {
		$props = array($props);
	}

	if (!property_exists($obj, $props[0])) {
		return get_value_from_array($flash->get('params'), $props);
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

function get_value_from_array($arr, $props = array()) {
	foreach($props as $prop) {
		if (array_key_exists($prop, $arr)) {
			$arr = $arr[$prop];
		} else {
			return null;
		}
	}
	return $arr;
}

