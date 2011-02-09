<?php

/**
 * is user logged in?
 */
function is_user_login() {
	global $session;
	return (!is_null(get_user_id()));
}

/**
 * get user id logged in
 */
function get_user_id() {
	global $session;
	return $session->get('user_id');
}

