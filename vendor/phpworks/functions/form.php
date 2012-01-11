<?php
// get value from object recursively
function get_object_property($obj, $props = array()) {
	$flash = Context::one()->flash;

	// 먼저 flash에 저장된 값을 반환한다.
	/*
	$old_params = get_array_value($flash->get('old_params'), $props);
	if (isset($old_params)) {
		return $old_params;
	}
	*/

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

