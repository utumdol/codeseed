<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/init.php');

// connect db connection
$db = Context::get()->db;
$db->connect();

// init log dir
if (!file_exists(Config::get()->log_dir)) {
	$migration = new CreateLogDirectory();
	$migration->up();
}

// init table
$tables = $db->get_tables();

// init sessions table
if (!in_array('sessions', $tables)) {
	$migration = new CreateSessions();
	$migration->up();
}

// init version table
if (!in_array('schema_version', $tables)) {
	$migration = new CreateSchemaVersion();
	$migration->up();
}

// close db connection
$db->close();

