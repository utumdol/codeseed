<?php
/**
 * 배열 내에 포함된 원소들이 모두 숫자인지 확인
 */
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

/**
 * notice 없이 배열 값 구하기.
 * key가 없다면 null을 반환한다.
 * @example $arr[a][b][c] = array_value($arr, 'a', 'b', 'c') or array_value($arr, array('a', 'b', 'c'))
 */
function array_value($arr, $props = array()) {
	if ($arr == null) {
		return null;
	}

	if (!is_array($props)) {
		$props = array_slice(func_get_args(), 1);
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

