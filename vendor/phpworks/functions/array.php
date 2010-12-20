<?php
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

