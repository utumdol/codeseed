<?php
class Controller {
	public $layout;
	
	protected $session;
	protected $flash;

	public function __construct() {
		$this->session = Context::get('session');
		$this->flash = Context::get('flash');
	}

	public function before_filter($action = '') {
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
		$this->skip_after();
	}

	/**
	 * redirect<br/>
	 * ex) $this->redirect_to('/blog/index');
	 */
	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
		$this->skip_after();
	}

	/**
	 * forward<br/>
	 * ex) $this->forward_to('/blog/index/1');
	 */
	public function forward_to($where) {
		$path = parse_request_uri($where);
		$controller_path = $path[1];
		$action_path = $path[2];
		require_once(Config::get('help_dir') . '/' . $controller_path . '.php');
		$controller_name = underscore_to_camelcase($controller_path . '_controller');
		$controller = new $controller_name();
		
		call_user_func_array(array($controller, 'before_filter'), array_slice($path, 2));
		call_user_func_array(array($controller, $action_path), array_slice($path, 3));
		call_user_func_array(array($controller, 'after_filter'), array_slice($path, 2));
		if (file_exists(Config::get('view_dir') . '/' . $controller_path . '/' . $action_path . '.php')) {
			call_user_func_array(array($controller, 'load_view'), array($controller_path . '/' . $action_path));
		}
		$this->skip_after();
	}

	/**
	 * skip after processing and display view.
	 * but 'return' keyword in the action will display view.
	 */
	public function skip_after() {
		throw new SkipAfter();
	}

	public function after_filter($action = '') {
		// the method which is called after excute actions
	}
}

