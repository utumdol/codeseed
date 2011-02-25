<?php
function get_db() {
	$dbms = Config::get()->db;
	$db = new $dbms(Config::get()->db_host, Config::get()->db_user, Config::get()->db_password, Config::get()->db_name);
	return $db;
}

function quotes_to_string($type, $value) {
	if (stristr($type, 'char') || stristr($type, 'text')) {
		return '\'' . $value . '\'';
	}
	return $value;
}

