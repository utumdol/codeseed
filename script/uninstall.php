<?php
// include system init
require_once(dirname(__FILE__) . '/../config/init.php');

// connect db connection
$db = Context::get('db');
$db->connect();

// init table
$tables = $db->get_tables();

// remove sessions table
if (in_array('sessions', $tables)) {
	$migration = new CreateSessions();
	$migration->down();
}

// remove version table
if (in_array('schema_version', $tables)) {
	$migration = new CreateSchemaVersion();
	$migration->down();
}

// remove upload dir
if (file_exists(Config::get('upload_dir'))) {
	$migration = new CreateUploadDirectory();
	$migration->down();
}

/*
// remove log dir
if (file_exists(Config::get('log_dir'))) {
	$migration = new CreateLogDirectory();
	$migration->down();
}

// remove tmp dir
 if (file_exists(Config::get('tmp_dir'))) {
$migration = new CreateTmpDirectory();
$migration->down();
}
*/

// close db connection
$db->close();

