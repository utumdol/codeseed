<?php
function get_request_protocol() {
	return (!is_blank(_server('HTTPS')) && _server('HTTPS') != 'off') ? 'https' : 'http';
}

function get_request_host() {
	return get_request_protocol() . '://' . _server('HTTP_HOST');
}

function get_request_url() {
	return get_request_host() . '://' . _server('PATH_INFO');
}

