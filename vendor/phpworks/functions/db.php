<?php
function get_db() {
	$dbms = Config::get_instance()->db;
	$db = new $dbms(Config::get_instance()->db_host, Config::get_instance()->db_user, Config::get_instance()->db_password, Config::get_instance()->db_name);
	return $db;
}

function quotes_to_string($type, $value) {
	if (stristr($type, 'char') || stristr($type, 'text')) {
		return '\'' . $value . '\'';
	}
	return $value;
}

