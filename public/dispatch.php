<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// init params
$params = array_merge($_GET, $_POST);

// init session
session_start();

// init flash
$flash = new Flash();
$flash->load();

// connect db connection
$db->connect();

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
	call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
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
$flash->clear();
$flash->save();

// close db connection
$db->close();

