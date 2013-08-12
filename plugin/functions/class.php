<?php

/**
 * undercase를 camelcase로 변경
 * @example hello_world :=> HelloWorld
 */
function under_to_camel($filename) {
	$result = str_replace('_', ' ', $filename);
	$result = ucwords($result);
	return str_replace(' ', '', $result);
}

/**
 * camelcase를 undercase로 변경
 * @example HelloWorld :=> hello_world
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
 * notice 없이 배열 값 구하기.
 * key가 없다면 null을 반환한다.
 * @example $obj->a->b->c := object_value($arr, array('a', 'b', 'c'))
 */
function object_value($obj, $props = array()) {
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
 * 객체들 배열에서 특정 property만 뽑아내어 배열로 반환.
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

