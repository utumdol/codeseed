<?php
$start_microtime = microtime(true);

// include system init
require_once(dirname(__FILE__) . '/../config/init.php');

// connect db connection
$db = Context::get('db');
$db->connect();

// ie8 and safari session problem
//header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
//header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
session_start();

// init session
//$session = Context::get('session');

// init flash
$flash = Context::get('flash');
$flash->load();

// routing
Log::debug(_server('REQUEST_METHOD') . ' ' . _server('PATH_INFO'));
// parse path
$path = parse_request_uri(_server('PATH_INFO'));
if (empty($path[1])) { $path[1] = Config::get('default_controller'); }
if (empty($path[2])) { $path[2] = Config::get('default_action'); }
$controller_path = $path[1];
$action_path = $path[2];
if (file_exists(Config::get('help_dir') . '/' . $controller_path . '.php')) {
	require_once(Config::get('help_dir') . '/' . $controller_path . '.php');
}

$controller_name = under_to_camel($controller_path . '_controller');
$controller = new $controller_name();
// set action name
$controller->controller_name = $controller_name;
$controller->action_name = $action_path;

// make contents
ob_start();
try {
	// execute request
	call_user_func(array($controller, 'before_filter'));
	call_user_func_array(array($controller, $action_path), refine_params(array_slice($path, 3)));
	call_user_func(array($controller, 'after_filter'));
	if (file_exists(Config::get('view_dir') . '/' . $controller_path . '/' . $action_path . '.php')) {
		call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
	}
} catch (Skip $e) {
} catch (DbError $e) {
	Log::error($e->getMessage());
	// TODO replace below
	//echobn("db errro occurs. refers to the application log.");
	echobn($e->getMessage());
} catch (Exception $e) {
	Log::error($e->getMessage());
	// TODO replace below
	//echobn("errro occurs. refers to the application log.");
	echobn($e->getMessage());
}
Context::get('db')->rollback();
$CONTENTS = ob_get_contents();
ob_end_clean();

require_once(Config::get('view_dir') . '/layout/' . $controller->layout . '.php');

// close flash
if ($controller->save_old_params) { // reserve old params
	$flash->add('_old_params', array_merge($_GET, $_POST)); // reserve params for history back
}
$flash->clear();
$flash->save();

// close session
session_write_close();

// close db connection
$db->close();
$end_microtime = microtime(true);
Log::debug('TOTAL EXECUTION TIME: ' . ($end_microtime - $start_microtime) . 's');

