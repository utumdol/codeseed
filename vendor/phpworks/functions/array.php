<?php
function is_numeric_array($arr) {
	if (!is_array($arr)) {
		return false;
	}

	$arr = array_values($arr);
	foreach ($arr as $a) {
		if (!is_numeric($a)) {
			return false;
		}
	}
	return true;
}

// get value from array recursively
function get_array_value($arr, $props = array()) {
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

