<?php
function is_valid_email($email = '') {
	if (blank($email)) {
		return true;
	}

	// refers to http://www.ars-informatica.ca/article.php?article=46
	if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email)) {
		return true;
	}
	return false;
}

function is_valid_url($url = '') {
	if (blank($url)) {
		return true;
	}

	// refers to http://php.net/manual/en/function.preg-match.php
	$pattern = "/^((https?|ftp)\:\/\/)?";
	$pattern .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
	$pattern .= "([a-z0-9-.]*)\.([a-z]{2,3})";
	$pattern .= "(\:[0-9]{2,5})?";
	$pattern .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
	$pattern .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
	$pattern .= "(#[a-z_.-][a-z0-9+\$_.-]*)?$/i";

	if (preg_match($pattern, $url)) {
		return true;
	}
	return false;
}

function is_valid_password($password) {
	// 대소문자, 숫자, 그리고 특수문자 8자 이상
	return false;
}

