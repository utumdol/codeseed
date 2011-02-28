<?php
// include system init
require_once(dirname(__FILE__) . '/../vendor/phpworks/classes/base/context.class.php');

// init context
Context::init();


// connect db connection
$db = get_db();
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

