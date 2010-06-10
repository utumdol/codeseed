<?php
function get_database() {
	$dbms = DBMS;
	$database = new $dbms(DBHOST, DBUSER, DBPASSWD, DBNAME);
	return $database;
}

function quotes_to_string($type, $value) {
	if (stristr($type, 'char') || stristr($type, 'text')) {
		return '\'' . $value . '\'';
	}
	return $value;
}
?>
