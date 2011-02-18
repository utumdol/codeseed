<?php

/**
 * is user logged in?
 */
function is_user_logged() {
	global $session;
	return (!is_null(get_login_id()));
}

/**
 * get user id logged in
 */
function get_login_id() {
	global $session;
	return $session->get('user_id');
}

