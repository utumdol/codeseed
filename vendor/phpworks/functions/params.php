<?php
/**
 * alias of Context::_get(arg1, arg2, arg3, ...)
 */
function _get(/* arg1, arg2, arg3, ... */) {
	return Context::_get(func_get_args());
}

/**
 * alias of Context::_post(arg1, arg2, arg3, ...)
 */
function _post(/* arg1, arg2, arg3, ... */) {
	return Context::_post(func_get_args());
}

/**
 * alias of Context::_files(arg1, arg2, arg3, ...)
 */
function _files(/* arg1, arg2, arg3, ... */) {
	return Context::_files(func_get_args());
}

/**
 * alias of Context::_server(arg1, arg2, arg3, ...)
 */
function _server(/* arg1, arg2, arg3, ... */) {
	return Context::_server(func_get_args());
}

