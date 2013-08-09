<?php
/**
 * 배열 안에 배열이 있다면 해당 배열을 반환한다.
 * 아니라면 자신을 반환한다.
 */
function uncover_array($arr = array()) {
	if (sizeof($arr) == 1 && is_array($arr[0])) {
		return $arr[0];
	}
	return $arr;
}

