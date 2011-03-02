<?php
class Controller {
	public $layout = 'default';
	
	protected $session;
	protected $flash;
	protected $params;

	public function __construct() {
		$this->session = Context::get()->session;
		$this->flash = Context::get()->flash;
		$this->params = Context::get()->params;

		$this->init();
	}

	public function before_filter($action = '') {
		// the method which is called before excute actions
	}

	public function init() {
		// the method which is called after __construct()
	}

	public function load_view($view) {
		require(Config::get()->view_dir . '/' . $view . '.php');
	}

	public function back() {
		if (!empty(Context::get()->server['HTTP_REFERER'])) {
			$this->redirect_to(Context::get()->server['HTTP_REFERER']);
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

