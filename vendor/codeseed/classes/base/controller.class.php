<?php
class Controller {
	public $layout;
	public $controller_name; // $controller_name is automatically set in the router(codeseed.php) or forward_to method.
	public $action_name; // $action_name is automatically set in the router(codeseed.php) or forward_to method.
	public $save_old_params = true;

	protected $session;
	protected $flash;

	public function __construct() {
		$this->session = Context::get('session');
		$this->flash = Context::get('flash');
	}

	public function before_filter() {
		// the method which is called before excute actions
	}

	public function load_view($view) {
		require(Config::get('view_dir') . '/' . $view . '.php');
	}

	public function back() {
		$http_referer = _server('HTTP_REFERER');
		if (!empty($http_referer)) {
			$this->redirect_to($http_referer);
		}
		echo '<script type="text/javascript">history.back();</script>';
		$this->skip();
	}

	/**
	 * redirect<br/>
	 * ex) $this->redirect_to('/main/index');
	 */
	public function redirect_to($where) {
		$this->layout = 'blank';
		echo '<script type="text/javascript">window.location.href="' . $where . '"</script>';
		//echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
		$this->skip();
	}

	/**
	 * forward<br/>
	 * ex) $this->forward_to('/main/index/1');
	 */
	public function forward_to($where) {
		// parse path
		$path = parse_request_uri($where);
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

		// execute request
		call_user_func(array($controller, 'before_filter'));
		call_user_func_array(array($controller, $action_path), refine_params(array_slice($path, 3)));
		call_user_func(array($controller, 'after_filter'));
		if (file_exists(Config::get('view_dir') . '/' . $controller_path . '/' . $action_path . '.php')) {
			call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
		}
		$this->skip();
	}

	/**
	 * skip after processing and display view.
	 * but 'return' keyword in the action will display view.
	 */
	public function skip() {
		throw new Skip();
	}

	public function after_filter() {
		// the method which is called after excute actions
	}
}

