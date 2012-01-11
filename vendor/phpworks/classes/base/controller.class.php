<?php
class Controller {
	public $layout;
	
	protected $session;
	protected $flash;

	public function __construct() {
		$this->session = Context::one()->session;
		$this->flash = Context::one()->flash;
	}

	public function before_filter($action = '') {
		// the method which is called before excute actions
	}

	public function load_view($view) {
		require(Config::one()->view_dir . '/' . $view . '.php');
	}

	public function back() {
		$http_referer = _server('HTTP_REFERER');
		if (!empty($http_referer)) {
			$this->redirect_to($http_referer);
		}
		echo '<script type="text/javascript">history.back();</script>';
		$this->skip_processing();
	}

	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
		$this->skip_processing();
	}

	// TODO how about rename skip_view to exit
	public function skip_processing() {
		throw new SkipProcessing();
	}

	public function after_filter($action = '') {
		// the method which is called after excute actions
	}
}

