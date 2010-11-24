<?php

/**
 * @return bool
 */
function is_blank($str) {
	return (trim(strval($str)) == '');
}

function csv($arr, $sep = ',') {
	return implode($sep, $arr);
}

