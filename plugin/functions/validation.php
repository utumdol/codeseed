<?php

/**
 * 이메일 정상 여부 체크
 * @see http://www.ars-informatica.ca/article.php?article=46
 */
function validate_email($email = '') {
	return (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email));
}

/**
 * url 정상 여부 체크
 * @see http://php.net/manual/en/function.preg-match.php
 */
function validate_url($url = '') {
	$pattern = "/^((https?|ftp)\:\/\/)?";
	$pattern .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
	$pattern .= "([a-z0-9-.]*)\.([a-z]{2,3})";
	$pattern .= "(\:[0-9]{2,5})?";
	$pattern .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
	$pattern .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
	$pattern .= "(#[a-z_.-][a-z0-9+\$_.-]*)?$/i";

	return (preg_match($pattern, $url));
}

/**
 * text id 정상 여부 체크
 */
function validate_text_id($text_id) {
	return (preg_match("/^\w{5,12}$/", $text_id));
}

/**
 * password 정상 여부 체크.
 * 대소문자, 숫자, 그리고 특수문자 4자 이상 16자 이하.
 */
function validate_password($password) {
	return (preg_match("/^[0-9A-Za-z!@#$%*^()]{4,16}$/", $password));
}

/**
 * 휴대폰 번호 정상 여부 체크
 */
function validate_mobile($number = '') {
	$number = preg_replace('/[^0-9]+/', '', $number);
	return (preg_match('/^01[016789][0-9]{7,8}$/', $number));
}

