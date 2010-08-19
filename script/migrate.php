<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// init
$INTEND_VERSION = isset($argv[1]) ? $argv[1] : '99991231235959';

// functions
function print_migration_status($direction, $classname, $version) {
	echonl($classname . '.'. strtolower($direction) . '() is executed.');
	echonl('Schema version is ' . $version . ' now.');
	echonl('================================================================================');
}

// connect db connection
$db->connect();

// init version table
$tables = $db->get_tables();
if (!in_array('schema_version', $tables)) {
	$migration = new CreateSchemaVersion();
	$migration->up();
}

$schema_version = new SchemaVersion();
if ($schema_version->count() == 0) {
	$schema_version->version = 0;
	$schema_version->save();
}
$schema_version = $schema_version->find();

// read migration files...
$files = get_files(MIGR_DIR);
if ($INTEND_VERSION >= $schema_version->version) {
	sort($files);
	$direction = 'UP';
} else {
	rsort($files);
	$direction = 'DOWN';
}

for($i = 0; $i < count($files); $i++) {
	$file = $files[$i];
	$matches = parse_migration_filename($file);
	if (!empty($matches)) {
		$version = $matches[1];
		$filename = $matches[2];
		$classname = filename_to_classname($filename);

		if ($direction == 'UP' && $version > $schema_version->version && $version <= $INTEND_VERSION) {
			require_once($file);
			$migration = new $classname;
			$migration->up();
			$schema_version->version = $version;
			$schema_version->update();

			print_migration_status($direction, $classname, $version);
		}

		if ($direction == 'DOWN' && $version <= $schema_version->version && $version > $INTEND_VERSION) {
			require_once($file);
			$migration = new $classname;
			$migration->down();
			if ($i == count($files) - 1) {
				$down_version = 0;
			} else {
				$matches = parse_migration_filename($files[$i + 1]);
				if (!empty($matches)) {
					$down_version = $matches[1];
				}
			}
			$schema_version->version = $down_version;
			$schema_version->update();

			print_migration_status($direction, $classname, $down_version);
		}
	}
}

// close db connection
$db->close();

