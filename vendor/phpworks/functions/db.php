<?php
function get_db() {
	$dbms = DBMS;
	$db = new $dbms(DBHOST, DBUSER, DBPASSWD, DBNAME);
	return $db;
}

function quotes_to_string($type, $value) {
	if (stristr($type, 'char') || stristr($type, 'text')) {
		return '\'' . $value . '\'';
	}
	return $value;
}

