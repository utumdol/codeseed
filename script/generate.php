<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');
//require_once(dirname(__FILE__) . '/../vendor/phpworks/classes/generator/generator.class.php');

//validation if there are enough parameters
if ($argc < 3) {
	echonl("Example:");
	echonl("\t`php script/generate.php model user`");
	echonl("\t`php script/generate.php migration add_price`");
	echonl("\t`php script/generate.php controller login login logout`");
	exit(0);
}

//	 validation if there is generator class file
$generator_name = $argv[1];
if (!file_exists(SYS_CLASSES . '/generator/' . $generator_name . '_generator.class.php')) {
	echonl("No " . $generator_name . ' generator exist.');
	exit(0);
}

try {
	$generator_classname = filename_to_classname($argv[1]) . 'Generator';
	$generator = new $generator_classname($argv[2]);
	$generator->generate();
} catch (ValidationError $e) {
	echonl($e->getMessage());
} catch (ProcessingError $e) {
	echonl($e->getMessage());
} catch (Exception $e) {
	echonl($e->getMessage());
}
?>
