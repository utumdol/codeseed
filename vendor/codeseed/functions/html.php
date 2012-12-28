<?php
/**
 * encoding html tags
 */
function h($str) {
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

/**
 * make new line characters to space
 */
function plain_nl($str = '') {
	return str_replace(array("\r\n", "\n"), " ", $str);
}
