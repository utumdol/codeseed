<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

//validation if there are enough parameters
if ($argc < 3) {
	echonl("Example:");
	echonl("\t`php script/generate.php model user`");
	echonl("\t`php script/generate.php migration add_price`");
	echonl("\t`php script/generate.php controller login login logout`");
	exit(0);
}

// validation if there is generator class file
$generator_name = $argv[1];
if (!file_exists(SYS_CLASSES . '/generator/' . $generator_name . '_generator.class.php')) {
	echonl("No " . $generator_name . ' generator exist.');
	exit(0);
}

$generator_classname = filename_to_classname($argv[1]) . 'Generator';
$generator = new $generator_classname($argv[2]);
$generator->generate();

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
