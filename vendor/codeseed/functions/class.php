<?php
/**
 * change notation from underscore to camlecase
 */
function under_to_camel($filename) {
	$result = str_replace('_', ' ', $filename);
	$result = ucwords($result);
	return str_replace(' ', '', $result);
}

/**
 * change notation from camlecase to underscore
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

/**
 * get object propery without undefined variable notice
 */
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

/**
 * get property from objects array without undefined variable notice
 * @return array
 */
function extract_property($objs, $prop = 'id') {
	$results = array();

	if (empty($objs)) {
		return $results;
	}

	foreach($objs as $obj) {
		$results[] = $obj->$prop;
	}
	return $results;
}

