<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// init params
$params = array_merge($_GET, $_POST);

// connect db connection
$db = get_db();
$db->connect();

// init session
session_set_save_handler(
	array('DbSessionHandler', 'open'), array('DbSessionHandler', 'close'),
	array('DbSessionHandler', 'read'), array('DbSessionHandler', 'write'),
	array('DbSessionHandler', 'destroy'), array('DbSessionHandler', 'clean'));
session_start();

// init session
$session = new Session();

// init flash
$flash = new Flash();
$flash->load();

// routing
$path = parse_request_uri($_SERVER['PATH_INFO']);
$controller_path = empty($path[1]) ? DEFAULT_CONTROLLER : $path[1];
$action_path = empty($path[2]) ? DEFAULT_ACTION : $path[2];
require_once(HELP_DIR. '/' . $controller_path . '.php');
require_once(CNTR_DIR . '/' . $controller_path . '_controller.class.php');
$controller_name = filename_to_classname($controller_path . '_controller');
$controller = new $controller_name();

// make contents
ob_start();
try {
	call_user_func_array(array($controller, $action_path), array_slice($path, 3));
	if (file_exists(VIEW_DIR . '/' . $controller_path . '/' . $action_path . '.php')) {
		call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
	}
} catch (SkipProcessing $e) {
	// nothing to do
} catch (ValidationError $e) {
	echo $e->getMessage();
} catch (ProcessingError $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
$CONTENTS = ob_get_contents();
ob_end_clean();

require_once(VIEW_DIR . '/layout/' . $controller->layout . '.php');

// close flash
$flash->add('params', $params); // reserve this controller
$flash->clear();
$flash->save();

// close session
session_write_close();

// close db connection
$db->close();

