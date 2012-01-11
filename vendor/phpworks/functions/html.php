<?php
function h($str) {
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function break_off($str, $length, $tail = '...') {
	if (mb_strlen($str, 'UTF-8') > $length) {
		return trim(mb_substr($str, 0, $length, 'UTF-8')) . $tail;
	}
	return $str;
}

