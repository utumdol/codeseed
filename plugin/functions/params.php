<?php
/**
 * url 형태로 전달되는 parameter들을 정제한다.
 * 대문자, 소문자, 언더바(_), 숫자 외에는 모두 제거한다.
 */
function refine_params($params) {
	$result = array();
	foreach($params as $param) {
		$result[] = preg_replace('/[^\w]/', '', $param);
	}
	return $result;
}

