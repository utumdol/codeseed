<?php
function get_value($obj, $props = array()) {
	global $flash;

	// 먼저 flash에 저장된 값을 반환한다.
	$old_params = get_value_from_array($flash->get('params'), $props);
	if (isset($old_params)) {
		return $old_params;
	}

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

function get_value_from_array($arr, $props = array()) {
	if ($arr == null) {
		return null;
	}

	foreach($props as $prop) {
		if (array_key_exists($prop, $arr)) {
			$arr = $arr[$prop];
		} else {
			return null;
		}
	}
	return $arr;
}

