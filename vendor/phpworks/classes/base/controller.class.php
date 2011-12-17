<?php
class Controller {
	public $layout;
	
	protected $session;
	protected $flash;
	protected $params;

	public function __construct() {
		$this->session = Context::one()->session;
		$this->flash = Context::one()->flash;
		$this->params = Context::one()->params;
	}

	public function before_filter($action = '') {
		// the method which is called before excute actions
	}

	public function load_view($view) {
		require(Config::one()->view_dir . '/' . $view . '.php');
	}

	public function back() {
		if (!empty(Context::one()->server['HTTP_REFERER'])) {
			$this->redirect_to(Context::one()->server['HTTP_REFERER']);
		}
		echo '<script type="text/javascript">history.back();</script>';
		throw new SkipProcessing();
	}

	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
		throw new SkipProcessing();
	}

	public function after_filter($action = '') {
		// the method which is called after excute actions
	}
}

