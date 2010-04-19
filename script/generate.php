<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

if ($argc < 2) {
	echonl("Usage:");
	echonl("1. php script/generate model model_name");
	echonl("2. php script/generate controller controller_name action_name_1 action_name_2 ...");
	exit(0);
}

switch($argv[1]) {
	case 'model':
		echonl("I'will make model");
		// 1. mkdir app
		// 1. mkdir app/model
		// 2. generate model file
		// 3. mkdir db
		// 4. mkdir db/migrate
		// 5. generate model file
		break;
	case 'controller':
		echonl("I'will make controller");
		// 1. mkdir app
		// 2. mkdir app/controller
		// 3. generate controller file with actions
		// 4. mkdir app/view
		// 5. mkdir app/view/controller
		// 6. generate app/view/controller file
		break;
}
?>