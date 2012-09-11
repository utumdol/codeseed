<?php

/**
 * Return true when input string is null or whitespace string
 * @return bool
 */
function is_blank($str) {
	return (trim(strval($str)) == '');
}

/**
 * Tlanslate input array into csv string
 */
function csv($arr, $sep = ',') {
	return implode($sep, $arr);
}

/**
 * Return true when input string is started with $start
 * @return bool
 */
function is_start_with($str, $start) {
	$result = strpos($str, $start);
	if ($result === false) {
		return false;
	}
	return ($result == 0);
}

/**
 * Return true when input string is ended with $start
 * @return bool
 */
function is_end_with($str, $end) {
	return (strpos($str, $end) == strlen(str_replace($end, '', $str)));
}

/**
 * Break off UTF-8 input string
 */
function break_off($str, $length, $tail = '...') {
	if (mb_strlen($str, 'UTF-8') > $length) {
		return trim(mb_substr($str, 0, $length, 'UTF-8')) . $tail;
	}
	return $str;
}

function add_quotes($str = '', $quotes = "'") {
	return $quotes . $str . $quotes;
}

