<?php
function refine_params($params) {
	$result = array();
	foreach($params as $param) {
		$result[] = preg_replace('/[^\w]/', '', $param);
	}
	return $result;
}

