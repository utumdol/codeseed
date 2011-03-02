<?php

/**
 * is user logged in?
 */
function is_user_logged() {
	return (!is_null(get_login_id()));
}

/**
 * get user id logged in
 */
function get_login_id() {
	return Context::get()->session->get('user_id');
}

