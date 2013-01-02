<?php
/**
 * alias of $_SERVER[arg1][arg2][arg3][...]
 */
function _server(/* arg1, arg2, arg3, ... */) {
	return get_array_value($_SERVER, parse_array_args(func_get_args()));
}

/**
 * alias of $_GET[arg1][arg2][arg3][...]
 */
function _get(/* arg1, arg2, arg3, ... */) {
	return get_array_value($_GET, parse_array_args(func_get_args()));
}

/**
 * alias of $_POST[arg1][arg2][arg3][...]
 */
function _post(/* arg1, arg2, arg3, ... */) {
	return get_array_value($_POST, parse_array_args(func_get_args()));
}

/**
 * alias of $_FILES[arg1][arg2][arg3][...]
 */
function _files(/* arg1, arg2, arg3, ... */) {
	return get_array_value($_FILES, parse_array_args(func_get_args()));
}

/**
 * alias of $_COOKIE[key] or $_COOKIE[key] = value
 */
function _cookie(/* key[, value] */) {
	$args = func_get_args();
	if (func_num_args() >= 2) {
		$_COOKIE[$args[0]] = $args[1];
		return;
	}
	return get_array_value($_COOKIE, parse_array_args(func_get_args()));
}

/**
 * alias of $_SESSION[key] or $_SESSION[key] = value
 */
function _session(/* key[, value] */) {
	$args = func_get_args();
	if (func_num_args() >= 2) {
		$_SESSION[$args[0]] = $args[1];
		return;
	}
	return get_array_value($_SESSION, parse_array_args(func_get_args()));
}

/**
 * alias of $_REQUEST[arg1][arg2][arg3][...]
 */
function _request(/* arg1, arg2, arg3, ... */) {
	return get_array_value($_REQUEST, parse_array_args(func_get_args()));
}

