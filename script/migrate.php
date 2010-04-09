<?php
// include genesis system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// init
$VERSION = strlen($argv[1]) ? $argv[1] : '99991231235959';

// connect db connection
$DATABASE->connect();

// init version table
$tables = $DATABASE->get_tables();
if (!in_array('version', $tables)) {
	$migration = new CreateSchemaMigrations($DATABASE);
	$migration->up();
}

$version = new Version();
if ($version->get_total() == 0) {
	$version->version_id = 0;
	$version->register();
}
$version = $version->get();

// read migration files...
$files = get_files(MIGR_DIR);
if ($VERSION >= $version->version_id) {
	sort($files);
	$direction = 'UP';
} else {
	rsort($files);
	$direction = 'DOWN';
}

for($i = 0; $i < count($files); $i++) {
	$file = $files[$i];
	echobn($file);
	$matches = parse_migration_filename($file);
	if (!empty($matches)) {
		$version_id = $matches[1];
		$filename = $matches[2];
		$classname = filename_to_classname($filename);

		if ($direction == 'UP' && $version_id > $version->version_id && $version_id <= $VERSION) {
			require_once($file);
			$migration = new $classname;
			$migration->up();
			$version->version_id = $version_id;
			$version->update();
		}

		if ($direction == 'DOWN' && $version_id > $VERSION) {
			require_once($file);
			$migration = new $classname;
			$migration->down();
			if ($i == count($files) - 1) {
				$down_version_id = 0;
			} else {
				$matches = parse_migration_filename($files[$i + 1]);
				if (!empty($matches)) {
					$down_version_id = $matches[1];
				}
			}
			$version->version_id = $down_version_id;
			$version->update();
		}
	}
}

// close db connection
$DATABASE->close();
?>
