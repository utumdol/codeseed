<?php

/**
 * @return bool
 */
function is_blank($str) {
	return (trim(strval($str)) == '');
}

/**
 * tlanslate input array into csv string
 */
function csv($arr, $sep = ',') {
	return implode($sep, $arr);
}


/**
 * @return bool
 */
function is_start_with($str, $start) {
	return (strpos($str, $start) === 0);
}

