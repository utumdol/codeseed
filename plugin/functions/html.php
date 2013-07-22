<?php
/**
 * encoding html tags
 */
function h($str) {
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

/**
 * new line character들을 모두 space로 변경한다.
 */
function plain_nl($str = '') {
	return str_replace(array("\r\n", "\n"), " ", $str);
}
