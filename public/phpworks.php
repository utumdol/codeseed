<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/init.php');

// connect db connection
$db = Context::get('db');
$db->connect();

session_start();

// init session
$session = Context::get('session');

// init flash
$flash = Context::get('flash');
$flash->load();

// routing
Log::debug(_server('REQUEST_METHOD') . ' ' . _server('PATH_INFO'));
$path = parse_request_uri(_server('PATH_INFO'));
if (empty($path[1])) { $path[1] = Config::get('default_controller'); }
if (empty($path[2])) { $path[2] = Config::get('default_action'); }
$controller_path = $path[1];
$action_path = $path[2];
require_once(Config::get('help_dir') . '/' . $controller_path . '.php');
// include controller by __autoload function
//require_once(Config::get('ctrl_dir') . '/' . $controller_path . '_controller.class.php');
$controller_name = filename_to_classname($controller_path . '_controller');
$controller = new $controller_name();

// make contents
ob_start();
try {
	call_user_func_array(array($controller, 'before_filter'), array_slice($path, 2));
	call_user_func_array(array($controller, $action_path), array_slice($path, 3));
	call_user_func_array(array($controller, 'after_filter'), array_slice($path, 2));
	if (file_exists(Config::get('view_dir') . '/' . $controller_path . '/' . $action_path . '.php')) {
		call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
	}
} catch (SkipProcessing $e) {
	// nothing to do
} catch (ProcessingError $e) {
	Log::error($e->getMessage());
} catch (Exception $e) {
	Log::error($e->getMessage());
}
$CONTENTS = ob_get_contents();
ob_end_clean();

require_once(Config::get('view_dir') . '/layout/' . $controller->layout . '.php');

// close flash
$flash->add('old_params', array_merge($_GET, $_POST)); // reserve params for history back
$flash->clear();
$flash->save();

// close session
session_write_close();

// close db connection
$db->close();

