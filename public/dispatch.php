<?php
// include genesis system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// connect db connection
$DATABASE->connect();

// routing
$path = parse_request_uri($_SERVER['REQUEST_URI']);
$controller_path = empty($path[1]) ? DEFAULT_CONTROLLER : $path[1];
$action_path = empty($path[2]) ? DEFAULT_ACTION : $path[2];
require_once(CNTR_DIR . '/' . $controller_path . '_controller.class.php');
$controller_name = filename_to_classname($controller_path . '_controller');
$controller = new $controller_name;

// make contents
ob_start();
try {
	call_user_func_array(array($controller, $action_path), array_slice($path, 3));
} catch (ValidationError $e) {
	back_with_message($e->getMessage());
} catch (ProcessingError $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
$contents = ob_get_contents();
ob_end_clean();

// make layout
ob_start();
require_once(VIEW_DIR . '/layout/' . $controller->layout . '.php');
$layout = ob_get_contents();
ob_end_clean();

echo str_replace('[BODY]', $contents, $layout);

// close db connection
$DATABASE->close();
?>