<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

if ($argc < 3) {
	echonl("Example:");
	if (empty($argv[1]) || $argv[1] == 'model') {
		echonl("\t`php script/generate.php model user`");
	}
	if (empty($argv[1]) || $argv[1] == 'controller') {
		echonl("\t`php script/generate.php controller login login logout`");
	}
	exit(0);
}

$generator = new MigrationGenerator($argv[2]);
$generator->generatePath();

/*
switch($argv[1]) {
	case 'model':
		if (file_exists(MODEL_DIR)) {
			echonl("\texist app/models");
		}

		if (file_exists(filename_to_classname($argv[2]))) {
			echonl("\texist app/models");
		}
		
		// 1. mkdir app
		// 2. mkdir app/model
		// 3. generate model file
		// 4. mkdir db
		// 5. mkdir db/migrate
		// 6. generate model file
		break;
	case 'controller':
		echonl("I'will make controller");
		if (file_exists(CNTR_DIR)) {
			echonl("\texist app/controller");
		}

		// 1. mkdir app
		// 2. mkdir app/controller
		// 3. generate controller file with actions
		// 4. mkdir app/view
		// 5. mkdir app/view/controller
		// 6. generate app/view/controller file
		break;
}
*/
?>
