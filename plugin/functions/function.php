<?php
/**
 * 배열 안에 배열이 있다면 해당 배열을 반환한다.
 * 아니라면 자신을 반환한다.
 */
function parse_array_args($args = array()) {
	if (sizeof($args) == 1 && is_array($args[0])) {
		return $args[0];
	}
	return $args;
}

