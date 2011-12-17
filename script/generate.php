<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/init.php');

//validation if there are enough parameters
if ($argc < 3) {
	echonl("Usage:");
	echonl("\t`php script/generate.php model model_name`");
	echonl("\t`php script/generate.php migration migration_name`");
	echonl("\t`php script/generate.php controller controller_name action_name1 action_name2 ...`");
	echonl("Example:");
	echonl("\t`php script/generate.php model user`");
	echonl("\t`php script/generate.php migration add_price`");
	echonl("\t`php script/generate.php controller login logout`");
	exit(0);
}

// init
array_shift($argv);
$kind = $argv[0];
array_shift($argv);
$name = $argv[0];
array_shift($argv);
$params = $argv;

if (!file_exists(Config::one()->sys_classes. '/generator/' . $kind . '_generator.class.php')) {
	echonl("No " . $kind . ' generator exist.');
	exit(0);
}

try {
	$classname = filename_to_classname($kind) . 'Generator';
	$generator = new $classname($name, $params);
	$generator->generate();
} catch (ProcessingError $e) {
	echonl($e->getMessage());
} catch (Exception $e) {
	echonl($e->getMessage());
}

